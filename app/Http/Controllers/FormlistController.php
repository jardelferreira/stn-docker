<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Base;
use App\Models\Formlist;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Models\FormlistBaseEmployee;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreFormlistRequest;
use App\Http\Requests\UpdateFormlistRequest;

class FormlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.formlists.index',[
            'formlists' => Formlist::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.formlists.create',[
            'bases' => Base::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormlistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormlistRequest $request)
    {
        Formlist::create($request->all());

        return redirect()->route('dashboard.formlists');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function show(Formlist $formlist)
    {
        return view('dashboard.formlists.show',[
            'formlist' => $formlist
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Formlist $formlist)
    {
        return view('dashboard.formlists.edit',[
            'bases' => Base::all(),
            'formlist' => $formlist
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormlistRequest  $request
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormlistRequest $request, Formlist $formlist)
    {
        $formlist->update($request->all());

        return redirect()->route('dashboard.formlists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formlist  $formlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formlist $formlist)
    {
        $formlist->delete();

        return redirect()->route('dashboard.formlists');
    }

    public function downloadManyFormlistsPdf( Request $request)
    {    
        
        // return response()->json($request->all());
        $formlist_files = [];
        $formlists = FormlistBaseEmployee::whereIn("id",$request->formlists)->get();

        foreach ($formlists as $key => $formlist_employee) {
            $pdf = Pdf::loadView('formlistPdf',[
                'formlist' => $formlist_employee,
                'fields' => $formlist_employee->fields()->get(),
                'documents' => $formlist_employee->documentsFromFormlist()->get(),
                'documentable' => boolval($request->documentable)
            ]);
            
            $fileName = "{$formlist_employee->formlist->name}-{$formlist_employee->employee->user->name}.pdf";
            $path = storage_path('app/public/'.$fileName);
            Storage::put('public/'.$fileName, $pdf->output());
            $formlist_files[] = $path;

        }
        $zipFileName = 'meus_pdfs_'.time().'.zip';
        $zipFilePath = storage_path('app/public/'.$zipFileName);

        $zip = new ZipArchive;
        $names = [];
        
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($formlist_files as $pdfFile) {
                // Adicionar cada PDF ao arquivo ZIP
                $zip->addFile($pdfFile, basename($pdfFile));
            }
            $zip->close();
        }
        // Deletar os PDFs gerados, se não precisar mais deles
        foreach ($formlist_files as $pdfFile) {
            unlink($pdfFile);
        }

        // Retornar o arquivo ZIP para download
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
        // $html = view('formlistPdf', [
        //     'formlist' => $formlist_employee,
        //     'fields' => $formlist_employee->fields()->get(),
        //     'documents' => $formlist_employee->documentsFromFormlist()->get(),
        //     'documentable' => boolval($request->documentable)
        // ]);
        // $pdf = Pdf::loadHTML($html);
        

        // Salvar o PDF no sistema de arquivos
        return $pdf->stream($fileName);
    }

    public function generateAndDownloadZip(Request $request)
    {
        $pdfFiles = [];
        $formlists = FormlistBaseEmployee::whereIn("id",$request->formlists)->get();

        foreach ($formlists as $key => $formlist_employee) {
            $pdf = Pdf::loadView('formlistPdf',[
                'formlist' => $formlist_employee,
                'fields' => $formlist_employee->fields()->get(),
                'documents' => $formlist_employee->documentsFromFormlist()->get(),
                'documentable' => boolval($request->documentable)
            ]);
            
            $fileName = "{$formlist_employee->formlist->name}-{$formlist_employee->employee->user->name}.pdf";
            $path = storage_path('app/public/'.$fileName);
            Storage::put('public/'.$fileName, $pdf->output());
            $pdfFiles[] = $path;

        }

        // Nome do arquivo ZIP
        $zipFileName = 'meus_pdfs_' . time() . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName); // Caminho correto para salvar o arquivo ZIP

        // Criar um novo arquivo ZIP
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($pdfFiles as $pdfFile) {
                // Adicionar cada PDF ao arquivo ZIP
                $zip->addFile($pdfFile, basename($pdfFile));
            }
            $zip->close();

            // Deletar os PDFs gerados, se não precisar mais deles
            foreach ($pdfFiles as $pdfFile) {
                unlink($pdfFile);
            }

            // Retornar o arquivo ZIP para download
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            // Log de erro se não conseguir abrir o arquivo ZIP
            Log::error('Não foi possível abrir o arquivo ZIP em: ' . $zipFilePath);
            return response()->json(['error' => 'Não foi possível criar o arquivo ZIP'], 500);
        }
    }
}

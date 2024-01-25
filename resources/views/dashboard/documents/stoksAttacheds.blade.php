@extends('adminlte::page')

@section('title', 'Desvincular documento')

@section('content_header')
    <h1>Desvincular, <span class="font-weight-bold">{{ $document->name }}</span> ao estoque do setor - <span
            class="font-weight-bold">{{ $sector->name }} </span></h1>
@stop
@section('css')
    <style>
        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(2);
            /* IE */
            -moz-transform: scale(2);
            /* FF */
            -webkit-transform: scale(2);
            /* Safari and Chrome */
            -o-transform: scale(2);
            /* Opera */
            transform: scale(2);
            padding: 10px;
        }
    </style>
@endsection
@section('content')
    @if ($stoks->count())
        <form action="{{route('dashboard.documents.detachDocumentToStoks',$document)}}" method="POST">
            @csrf
            @method("POST")
            <h4>Selecione os item que deseja Desvincular e clique no botão <button type="submit" class="btn btn-danger">Desvincular
                    marcados</button></h4>
            <hr>
            <table class="table table-striped table-inverse table-responsive" id="stok">
                <thead class="thead-inverse thead-dark">
                    <tr class="border border-light text-center">
                        <th class="border border-light">#</th>
                        <th class="border border-light">Produto</th>
                        <th class="border border-light">Descrição</th>
                        <th class="border border-light">NF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stoks as $stok)
                        <tr>
                            <td scope="row" class="text-center"><input type="checkbox" name="stok_id[]"
                                    id="stok{{ $loop->index }}" value="{{$stok->id}}"></td>
                            <td scope="row">{{ $stok->invoiceProduct->name }}</td>
                            <td scope="row">{{ $stok->invoiceProduct->description }} @isset($stok->invoiceProduct->ca_number)
                                    - CA: {{ $stok->invoiceProduct->ca_number }}
                                @endisset
                            </td>
                            <td scope="row"><a
                                    href="{{ route('dashboard.invoices.show', $stok->invoiceProduct->invoice->id) }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="text-bold">{{ $stok->invoiceProduct->invoice->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Não há Itens para listagem</p>
    @endif
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(() => {

            $.ajax({
                url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                success: function(result) {
                    $('#stok').DataTable({
                        "language": result,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'Tudo'],
                        ],
                    });
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
    </script>
@endsection

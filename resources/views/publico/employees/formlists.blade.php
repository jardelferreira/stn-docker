@extends('publico.page')

@section('title','Formulários')

@section('content')
<div class="bg-light">
<h1>Meus Formulários</h1>
@if (count($employee->formlists()->get()))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Formulários</th>
                <th>Revisão</th> 
                <th>Área</th> 
                <th>Base</th> 
                {{-- <th>Ações</th> --}}
            </tr>
            </thead>
            <tbody>
               @foreach ($employee->formlistsFromEmployee()->get() as $item)
               <tr>
                   <td scope="row">{{$item->formlist->name}}</td>
                   <td scope="row">Rev-{{$item->formlist->revision}}</td>
                   <td scope="row">{{$item->formlist->area}}</td>
                   <td scope="row">{{$item->base->name}}</td>
                   <td class="btn-group" role="group">
                    <a href="{{route('public.employees.formlists.show',$item->id)}}" class="btn btn-sm btn-info">Ver Formulário</a>
                    </td>
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há Formulários para listagem</p>
               @endif
@endsection
</div>
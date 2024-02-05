@extends('adminlte::page')

@section('title','Formulários')

@section('content_header')
    <h1>Listagem de Formulários - {{$employee->user->name}} - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.formlists.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($employee->formlists()->get()))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Formulários</th>
                <th>Revisão</th> 
                <th>Área</th> 
                <th>Base</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($employee->formlistsFromEmployee()->get() as $item)
               <tr>
                   <td scope="row">{{$item->formlist->name}}</td>
                   <td scope="row">Rev-{{$item->formlist->revision}}</td>
                   <td scope="row">{{$item->formlist->area}}</td>
                   <td scope="row">{{$item->formlist->base->name}}</td>
                   <td class="btn-group" role="group">
                    <a href="{{route('dashboard.bases.employees.formlists.fields',
                    ['base' => $item->base,'employee' => $employee, 'formlist_employee' => $item->id])}}" class="btn btn-sm btn-info">Ver</a>
                    </td>
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há Formulários para listagem</p>
               @endif
@endsection

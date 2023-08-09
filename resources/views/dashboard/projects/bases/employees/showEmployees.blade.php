@extends('adminlte::page')

@section('title','Colaboradores')

@section('content_header')
    <h1> Colaboradores da base - {{$base->name}} <a class="btn btn-success" href="{{route('dashboard.employees.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($employees))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Colaboradores</th>
                <th>Profissão</th> 
                <th>CPF</th> 
                <th>Ações</th> 
            </tr>
            </thead>
            <tbody>
               @foreach ($employees as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">Rev-{{$item->profession->name}}</td>
                   <td scope="row">{{$item->cpf}}</td>
                   <td scope="row">Ações</td>
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há Colaboradores para listagem</p>
               @endif
@endsection

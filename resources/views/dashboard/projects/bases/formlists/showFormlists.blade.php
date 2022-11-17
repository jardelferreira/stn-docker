@extends('adminlte::page')

@section('title','Formulários')

@section('content_header')
    <h1> Formulários da base - {{$base->name}} <a class="btn btn-primary" href="{{route('dashboard.bases.formlists',$base)}}" role="button">Vincular novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($formlists))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Formulários</th>
                <th>Revisão</th> 
                <th>Área</th> 
                <th>Descrição</th> 
            </tr>
            </thead>
            <tbody>
               @foreach ($formlists as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">Rev-{{$item->revision}}</td>
                   <td scope="row">{{$item->area}}</td>
                   <td scope="row">{{$item->description}}</td>
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há Formulários para listagem</p>
               @endif
@endsection

@extends('adminlte::page')

@section('title','profissões')

@section('content_header')
    <h1>Listagem de profissões  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.professions.create')}}" role="button">Criar nova - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($professions))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>profissões</th>
                <th>Descrição</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($professions as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">{{$item->description}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.professions.edit',$item->id)}}" >Editar</a>
                       <a class="btn btn-warning btn-sm mr-1" href="{{route('dashboard.professions.projects',$item)}}" >Vincular</a>
                        <form action="{{route('dashboard.professions.destroy',['id' => $item->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Deletar</button>
                        </form>
                    </td>
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há profissões para listagem</p>
               @endif
@endsection

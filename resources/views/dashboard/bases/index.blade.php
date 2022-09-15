@extends('adminlte::page')

@section('title','Bases')

@section('content_header')
    <h1>Listagem de Bases  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.bases.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($bases))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Bases</th>
                <th>Local</th>  
                <th>Projeto</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($bases as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">{{$item->place}}</td>
                   <td scope="row">{{$item->project->name}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.bases.edit',['base' => $item])}}" >Editar</a>
                        <form action="{{route('dashboard.bases.destroy',['base' => $item->id])}}" method="POST">
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
                   <p>Não há Bases para listagem</p>
               @endif
@endsection

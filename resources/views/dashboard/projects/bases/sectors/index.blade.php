@extends('adminlte::page')

@section('title','Setores')

@section('content_header')
    <h1>Listagem de Setores  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.sectors.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($sectors))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Setores</th>
                <th>Descrição</th>
                <th>Local</th>  
                <th>Projeto</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($sectors as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">{{$item->description}}</td>
                   <td scope="row">{{$item->base->place}}</td>
                   <td scope="row">{{$item->project->name}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-warning btn-sm mr-1" href="{{route('dashboard.sectors.stoks.index',['sector' => $item->id])}}" ><i class="fa fa-cubes" aria-hidden="true"></i></a>
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.sectors.edit',['sector' => $item])}}" >Editar</a>
                        <form action="{{route('dashboard.sectors.destroy',['sector' => $item->id])}}" method="POST">
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
                   <p>Não há Setores para listagem</p>
               @endif
@endsection

@extends('adminlte::page')

@section('title','Departamentos de custo')

@section('content_header')
    <h1>Listagem de Departamento de custo  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.costs_departaments.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($departaments))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Departamento de custo</th>
                <th>Setor de custo</th> 
                <th>Centro de custo</th> 
                <th>Projeto</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($departaments as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">{{$item->sectorCost->name}}</td>
                   <td scope="row">{{$item->sectorCost->cost->name}}</td>
                   <td scope="row">{{$item->sectorCost->cost->project->name}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.costs_departaments.edit',$item)}}" >Editar</a>
                        <form action="{{route('dashboard.costs_departaments.destroy',['id' => $item->id])}}" method="POST">
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
                   <p>Não há Departamento de custo para listagem</p>
               @endif
@endsection

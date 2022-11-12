@extends('adminlte::page')

@section('title','Formulários')

@section('content_header')
    <h1>Listagem de Formulários  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.formlists.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
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
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($formlists as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">Rev-{{$item->revision}}</td>
                   <td scope="row">{{$item->area}}</td>
                   <td scope="row">{{$item->description}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.formlists.edit',['formlist' => $item])}}" >Editar</a>
                        <form action="{{route('dashboard.formlists.destroy',['formlist' => $item->id])}}" method="POST">
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
                   <p>Não há Formulários para listagem</p>
               @endif
@endsection

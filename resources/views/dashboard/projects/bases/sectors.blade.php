@extends('adminlte::page')

@section('title','Setores')

@section('content_header')
              <h1>Listagem de Setores da base / {{$base->name}} -  <a class="btn btn-success"  data-toggle="modal" data-target="#sectorModal" data-whatever="{{$base->name}}">Cadastrar Setor</a> </h1>
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


               <div class="modal fade" id="sectorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Cadastrar novo Setor</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{route('dashboard.sectors.store')}}" method="post" autocomplete="off">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                          <label for="name">Nome do setor:</label>
                          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da Setores">
                          <small id="helpName" class="form-text text-muted">Insira o nome do setor</small>
                        </div>
                        <div class="form-group">
                          <label for="description">Descrição do setor:</label>
                          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="nome da Setores">
                          <small id="description" class="form-text text-muted">Descreva este setores</small>
                        </div>
                        <input type="hidden" name="base_id" value="{{$base->id}}">
              
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
@endsection
@section('css')
    <style>
      div.list-group-item > a:hover{
        font-weight: bold
      }
      .list-group-item > .btn-success, .btn-primary {
        color: black
      }

      .list-group-item > .btn-success:hover{
        color: #fff;
      }
    </style>
@endsection
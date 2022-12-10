@extends('adminlte::page')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="page-header">
      <h1>
        Base <small>{{$base->project->initials}}/{{$base->name}}</small> <a class="btn btn-sm btn-success" href="{{route('dashboard.bases.stoks',$base)}}"> Ver estoque</a>
      </h1>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="list-group">
           <a class="list-group-item list-group-item-action active bg-primary" data-toggle="collapse" href="#collapseEmployees"
            role="button" aria-expanded="false" aria-controls="collapseEmployees">Gerenciamento de Funcionários  
            - <i class="fa fa-user-alt" aria-hidden="true"> </i></a>
          <div class="list-group-item collapse" id="collapseEmployees">

            <a class="list-group-item btn btn-primary"  href="{{route('dashboard.bases.employees',$base)}}">Vincular</a>
              <a class="list-group-item btn btn-primary"  href="{{route('dashboard.bases.employees.linked',$base)}}">Listar</a>
              <a class="list-group-item btn btn-primary"  href="#">Terceira opção</a>

            @foreach ($sectors as $item)
            <p class="list-group-item-text">
              {{$loop->index +1}} - 
              <a href="#">{{$item->name}}</a>
            </p>
            @endforeach
          </div>
          <div class="list-group-item justify-content-between">
            Pendências <span class="badge badge-danger badge-pill">14</span>
          </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
            Solicitações - <span class="badge badge-light badge-pill">156</span></a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="list-group">
           <a class="list-group-item list-group-item-action bg-success active" data-toggle="collapse" href="#collapseFormlists"
            role="button" aria-expanded="false" aria-controls="collapseFormlists">Gerenciamento de Fichas  
            - <i class="fa fa-archive" aria-hidden="true"></i></a>
          <div class="list-group-item collapse" id="collapseFormlists">
            <a class="list-group-item btn btn-success"  href="{{route('dashboard.bases.formlists',$base)}}">Cadastrar</a>
            <a class="list-group-item btn btn-success"  href="{{route('dashboard.bases.formlists.show',$base)}}">Listar</a>

            @foreach ($sectors as $item)
            <p class="list-group-item-text">
              {{$loop->index +1}} - 
              <a href="#">{{$item->name}}</a>
            </p>
            @endforeach
          </div>
          <div class="list-group-item justify-content-between">
            Pendências <span class="badge badge-danger badge-pill">14</span>
          </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
            Solicitações - <span class="badge badge-light badge-pill">156</span></a> 
        </div>
      </div>
      <div class="col-md-4">
        <div class="list-group">
           <a class="list-group-item list-group-item-action active bg-warning" data-toggle="collapse" href="#collapseSectors"
            role="button" aria-expanded="false" aria-controls="collapseSectors">Gerenciamento de Setores 
            - <i class="fa-solid fa-diagram-project"></i></a>
          <div class="list-group-item collapse" id="collapseSectors">

              <a class="list-group-item btn btn-warning"  data-toggle="modal" data-target="#sectorModal" data-whatever="{{$base->name}}">Cadastrar Setor</a>
              <a class="list-group-item btn btn-warning"  href="{{route('dashboard.bases.sectors',$base)}}">Listar</a>
              <a class="list-group-item btn btn-warning"  href="#">Terceira opção</a>
            @foreach ($sectors as $item)
            <p class="list-group-item-text">
              {{$loop->index +1}} - 
              <a href="#">{{$item->name}}</a>
            </p>
            @endforeach
          </div>
          <div class="list-group-item justify-content-between">
            Pendências <span class="badge badge-danger badge-pill">14</span>
          </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
            Solicitações - <span class="badge badge-light badge-pill">156</span></a>
        </div>
      </div>

    </div>
  </div>
</div>
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sectorModal" data-whatever="{{$base->name}}">Open modal for {{$base->name}}</button> --}}

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
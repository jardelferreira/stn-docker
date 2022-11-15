@extends('adminlte::page')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="page-header">
      <h1>
        Base <small>{{$base->project->initials}}/{{$base->name}}</small>
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

              <a class="list-group-item btn btn-warning"  href="#">Cadastrar</a>
              <a class="list-group-item btn btn-warning"  href="#">Listar</a>
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
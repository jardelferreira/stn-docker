@extends('adminlte::page')

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
@section('content')
<div class="d-block py-1 alert alert-secondary align-items-center">
  <h2 class="row">Projeto - {{$project->name}}</h2>
  <h6 class="row"><small>{{$project->description}}</small></h6>
  {{-- <div class="row align-items-end ">

    <form method="post" class="ml-1" action="{{route('dashboard.projects.destroy',['id' => $project->id])}}">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Deletar</button>
    </form>
  </div>
  <div class="row align-items-end ml-1">
    <a class="btn btn-primary" href="{{route('dashboard.projects.edit',$project->id)}}">Editar</a>
  </div> --}}

</div>
<div class="grey-bg container-fluid">
  {{-- <section id="minimal-statistics">

    <div class="row">
      <div class="col-xl-3 col-sm-6 col-12"> 
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-pencil primary font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3>278</h3>
                  <span>New Posts</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-speech warning font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3>156</h3>
                  <span>New Comments</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-graph success font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3>64.89 %</h3>
                  <span>Bounce Rate</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-pointer danger font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <h3>423</h3>
                  <span>Total Visits</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <div class="row">
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="danger">278</h3>
                  <span>New Projects</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-rocket danger font-large-2 float-right"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">156</h3>
                  <span>New Clients</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-user success font-large-2 float-right"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="warning">64.89 %</h3>
                  <span>Conversion Rate</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-pie-chart warning font-large-2 float-right"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="primary">423</h3>
                  <span>Support Tickets</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-support primary font-large-2 float-right"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <div class="row">
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="primary">278</h3>
                  <span>New Posts</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-book-open primary font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress mt-1 mb-0" style="height: 7px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="warning">156</h3>
                  <span>New Comments</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-bubbles warning font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress mt-1 mb-0" style="height: 7px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="success">64.89 %</h3>
                  <span>Bounce Rate</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-cup success font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress mt-1 mb-0" style="height: 7px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="danger">423</h3>
                  <span>Total Visits</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-direction danger font-large-2 float-right"></i>
                </div>
              </div>
              <div class="progress mt-1 mb-0" style="height: 7px;">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
   --}}
  <section id="stats-subtitle">
  {{-- <div class="row">
    <div class="col-xl-6 col-md-12">
      <div class="card overflow-hidden">
        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <i class="icon-pencil primary font-large-2 mr-2"></i>
              </div>
              <div class="media-body">
                <h4>Total Posts</h4>
                <span>Monthly blog posts</span>
              </div>
              <div class="align-self-center">
                <h1>18,000</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <i class="icon-speech warning font-large-2 mr-2"></i>
              </div>
              <div class="media-body">
                <h4>Total Comments</h4>
                <span>Monthly blog comments</span>
              </div>
              <div class="align-self-center"> 
                <h1>84,695</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> --}}

  <div class="row">
    <div class="col-xl-6 col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <h1 class="mr-2">$76.456.590,00</h1>
              </div>
              <div class="media-body">
                <h4>Valor</h4>
                <span><a href="#"> Medi????es</a></span>
              </div>
              <div class="align-self-center">
                <i class="icon-heart danger font-large-2"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <h1 class="mr-2">$36,000.00</h1>
              </div>
              <div class="media-body">
                <h4>Custo Total</h4>
                <span><a href="#">Centros de custo</a></span>
              </div>
              <div class="align-self-center">
                <i class="icon-wallet success font-large-2"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>

<a name="provider" id="provider" class="btn btn-primary" href="{{route('dashboard.projects.providers',$project)}}" role="button">Vincular Fornecedores</a>
{{-- <button class="btn btn-success"  data-toggle="modal" data-target="#baseModal" data-whatever="{{$project->id}}">Cadastrar Base</button> --}}
<button class="btn btn-warning"  data-toggle="modal" data-target="#costModal" data-whatever="{{$project->id}}">Cadastrar Centro de custo</button>

<div class="teste">
  <div class="modal fade" id="costModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cadastrar novo centro de custo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
          <form action="{{route('dashboard.costs.store')}}" method="post" autocomplete="off">
            @csrf
            @method('POST')
            <input type="hidden" name="project_id" value="{{$project->id}}" >
              <div class="form-group">
                <label for="name">Nome do Centro de custo</label>
                <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da centro de custo">
                <small id="helpName" class="form-text text-muted">Insira o nome do Centro de custo</small>
              </div>
              <div class="form-group">
                <label for="description">Descri????o do Centro de custo</label>
                <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="nome da centro de custo">
                <small id="description" class="form-text text-muted">Descreva este centro de custo</small>
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="row my-1">
  <div class="col-md-3 my-1">
    <div class="list-group">
       <a class="list-group-item list-group-item-action active bg-primary" data-toggle="collapse" href="#collapseEmployees"
        role="button" aria-expanded="false" aria-controls="collapseEmployees"> Funcion??rios  
        - <i class="fa fa-user-alt" aria-hidden="true"> </i></a>
      <div class="list-group-item collapse" id="collapseEmployees">

        <a class="list-group-item btn btn-primary" href="{{ route('dashboard.projects.listEmployees',$project) }}">Vincular</a>
          <a class="list-group-item btn btn-primary"  href="{{route('dashboard.projects.employees',$project)}}">Listar</a>
          <a class="list-group-item btn btn-primary"  href="#">Terceira op????o</a>
      </div>
      <div class="list-group-item justify-content-between">
        Pend??ncias <span class="badge badge-danger badge-pill">14</span>
      </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
        Solicita????es - <span class="badge badge-light badge-pill">156</span></a>
    </div>
  </div>
  <div class="col-md-3 my-1">
    <div class="list-group">
       <a class="list-group-item list-group-item-action bg-dark active" data-toggle="collapse" href="#collapseBases"
        role="button" aria-expanded="false" aria-controls="collapseBases"> Bases  
        - <i class="fa fa-archive" aria-hidden="true"></i></a>
      <div class="list-group-item collapse" id="collapseBases">
        <a class="list-group-item btn "  data-toggle="modal" data-target="#baseModal" data-whatever="{{$project->id}}">Cadastrar</a>
        <a class="list-group-item btn "  href="#">Listar</a>

        @foreach ($project->bases as $item)
        <p class="list-group-item-text">
          {{$loop->index +1}} - 
          <a href="#">{{$item->name}}</a>
        </p>
        @endforeach
      </div>
      <div class="list-group-item justify-content-between">
        Pend??ncias <span class="badge badge-danger badge-pill">14</span>
      </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
        Solicita????es - <span class="badge badge-light badge-pill">156</span></a> 
    </div>
  </div>
  <div class="col-md-3 my-1">
    <div class="list-group">
       <a class="list-group-item list-group-item-action bg-success active" data-toggle="collapse" href="#collapseProviders"
        role="button" aria-expanded="false" aria-controls="collapseProviders"> Fornecedores
        - <i class="fa fa-archive" aria-hidden="true"></i></a>
      <div class="list-group-item collapse" id="collapseProviders">
        <a class="list-group-item btn btn-success"  href="#">Cadastrar</a>
        <a class="list-group-item btn btn-success"  href="#">Listar</a>

        @foreach ($project->providers as $item)
        <p class="list-group-item-text">
          {{$loop->index +1}} - 
          <a href="#">{{$item->fantasy_name}}</a>
        </p>
        @endforeach
      </div>
      <div class="list-group-item justify-content-between">
        Pend??ncias <span class="badge badge-danger badge-pill">14</span>
      </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
        Solicita????es - <span class="badge badge-light badge-pill">156</span></a> 
    </div>
  </div>
  <div class="col-md-3 my-1">
    <div class="list-group">
       <a class="list-group-item list-group-item-action active bg-warning" data-toggle="collapse" href="#collapseSectors"
        role="button" aria-expanded="false" aria-controls="collapseSectors"> Setores 
        - <i class="fa-solid fa-diagram-project"></i></a>
      <div class="list-group-item collapse" id="collapseSectors">

          <a class="list-group-item btn btn-warning"  data-toggle="modal" data-target="#sectorModal" data-whatever="{{$project->name}}">Cadastrar Setor</a>
          <a class="list-group-item btn btn-warning"  href="#">Listar</a>
          <a class="list-group-item btn btn-warning"  href="#">Terceira op????o</a>
        @foreach ($project->sectors as $item)
        <p class="list-group-item-text">
          {{$loop->index +1}} - 
          <a href="#">{{$item->name}}</a>
        </p>
        @endforeach
      </div>
      <div class="list-group-item justify-content-between">
        Pend??ncias <span class="badge badge-danger badge-pill">14</span>
      </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
        Solicita????es - <span class="badge badge-light badge-pill">156</span></a>
    </div>
  </div>

</div>
<div class="modal fade" id="baseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cadastrar nova base</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('dashboard.bases.store')}}" method="post" autocomplete="off">
          @csrf
          @method('POST')
          <input type="hidden" name="project_id" value="{{$project->id}}" >
          <div class="form-group">
            <label for="name">Nome do Base</label>
            <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da Bases">
            <small id="helpName" class="form-text text-muted">Insira o nome do Base</small>
          </div>
          <div class="form-group">
            <label for="place">Local da Base</label>
            <input type="text" autocomplete="off" class="form-control" name="place" id="place" aria-describedby="place" placeholder="nome da Bases">
            <small id="place" class="form-text text-muted">Insira o local do Base</small>
          </div>
          <div class="form-group">
            <label for="description">Descri????o do Base</label>
            <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="nome da Bases">
            <small id="description" class="form-text text-muted">Descreva este Bases</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('css')
    
@endsection


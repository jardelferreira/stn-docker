<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projectos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

</head>

<body class="bg-light content">
  <div class="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">
        <a class="navbar-brand" href="#">SGLT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{route('public.projects')}}">Publico <span class="sr-only">(current)</span></a>
            </li>
            @if (Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/home') }}">Dashboard</a>
            </li>
                
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Cadastro</a>
            </li>
            @endif                

            {{-- <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li> --}}
          </ul>
          {{-- <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form> --}}
        </div>
      </nav>
  </div>
<h1>Listagem de Projetos</h1>
<hr>
    @if (count($projects))
        <table class="table table-striped table-sm table-dark" id="projects" >
            <thead class="thead-inverse">
                <tr>
                    <th>Projetos</th>
                    {{-- <th>Descrição</th> --}}
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $item)
                    <tr>
                        <td scope="row"><small>{{ $item->name }}</small></td>
                        {{-- <td scope="row">{{ $item->description }}</td> --}}
                        <td class="btn-group" role="group">
                            <a class="btn btn-warning btn-sm mx-1" href="{{route('public.projects.bases',$item)}}"><small>Ver Bases</small></a>
                            <a class="btn btn-primary btn-sm mx-1" href="{{route('public.projects.stoks',$item)}}"><small>Consultar Estoque</small></a>
                            {{-- <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.projects.bases',['project' => $item->id])}}">Ver Bases</a> --}}
                            {{-- <a class="btn btn-warning btn-sm mr-1" href="{{route('dashboard.projects.stok',['project' => $item->id])}}">Ver Estoque</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Projetos para listagem</p>
    @endif
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
    $('#projects').DataTable();
});
</script>
</html>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estoque do projeto - {{$project->name}}</title>
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
          </ul>

        </div>
      </nav>
  </div>
<h1>Listagem de estoque do projeto - <small>{{$project->name}}</small></h1>
<hr>
    @if (count($project->bases()->get()))
        <table class="table table-striped table-sm table-dark" id="stok" >
            <thead class="thead-inverse">
                <tr>
                    <th>Base</th>
                    <th>Setor</th>
                    <th>Item</th>
                    <th>Qtd</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($project->bases()->get() as $base)
                 @foreach ($base->sectors()->get() as $sector)
                 @foreach ($sector->stoks()->get() as $stok)
                     
                 <tr>
                     <td scope="row"><small>{{ $base->name }}</small></td>
                     <td scope="row">{{ $sector->name }}</td>
                     <td scope="row">{{ $stok->invoiceProduct->name }}</td>
                     <td scope="row">{{ $stok->qtd}}</td>
                     <td scope="row">{{ $stok->invoiceProduct->description}}</td>
                    </tr>
                    
                    @endforeach
                 @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Produtos para listagem</p>
    @endif
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
    $('#stok').DataTable();
});
</script>
</html>

@extends('adminlte::page')

@section('title','Fornecedores')

@section('content_header')
    <h1>Listagem de Fornecedores - <a name="" id="" class="btn btn-success" href="{{route('dashboard.providers.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($providers))
    <table class="table table-striped table-inverse table-responsive" id="providers">
        <thead class="thead-inverse">
            <tr>
                <th>Razão Social</th>
                <th>Nome Fantasia</th>
                <th>CNPJ</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($providers as $item)
               <tr>
                   <td scope="row">{{$item->corporate_name}}</td>
                   <td scope="row">{{$item->fantasy_name}}</td>
                   <td scope="row">{{$item->cnpj}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.providers.edit',$item)}}" >Editar</a>
                       <a class="btn btn-warning btn-sm mr-1" href="{{route('dashboard.providers.projects',$item)}}" >Vincular a projetos</a>
                        <form action="{{route('dashboard.providers.destroy',['id' => $item->id])}}" method="POST">
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
                   <p>Não há Fornecedores para listagem</p>
               @endif
@endsection
@section('js')
@section('plugins.Datatables', true)
<script>
    var lang = "";
    $(document).ready(function() {
        $.ajax({
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#providers').DataTable({
                    responsive: true,
                    order: [0,'desc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });

    });
</script>
@endsection
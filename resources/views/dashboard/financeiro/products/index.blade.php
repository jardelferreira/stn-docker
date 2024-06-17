@extends('adminlte::page')

@section('title','Produtos')

@section('content_header')
    <h1>Listagem de Produtos  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.financeiro.products.create')}}" role="button">Criar nova - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($products))
    <table class="table table-striped table-inverse table-responsive" id="products">
        <thead class="thead-inverse">
            <tr>
                <th>Produtos</th>
                <th>Tamanho</th> 
                <th>Material</th> 
                <th>Característica</th> 
                <th>Categoria</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($products as $item)
               <tr>
                   <td scope="row">{{$item->description}}</td>
                   <td scope="row">{{$item->size}}</td>
                   <td scope="row">{{$item->material}}</td>
                   <td scope="row">{{$item->characteristics}}</td>
                   <td scope="row">{{$item->category->name}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.financeiro.products.edit',$item->id)}}" >Editar</a>
                       {{-- <a class="btn btn-warning btn-sm mr-1" href="{{route('dashboard.products.projects',$item)}}" >Vincular a projetos</a> --}}
                        <form action="{{route('dashboard.financeiro.products.destroy',$item)}}" method="POST">
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
                   <p>Não há Produtos para listagem</p>
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
                $('#products').DataTable({
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
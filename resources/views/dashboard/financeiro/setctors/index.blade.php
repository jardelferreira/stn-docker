@extends('adminlte::page')

@section('title','Centros de custo')

@section('content_header')
    <h1>Listagem de Setores de custo  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.costs_sectors.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($sectors))
    <table class="table table-striped table-inverse table-responsive" id="sectors">
        <thead class="thead-inverse">
            <tr>
                <th>Setores de custo</th>
                <th>Centros de custo</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($sectors as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">{{$item->cost->name}} - {{$item->cost->project->name}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.costs_sectors.edit',$item)}}" >Editar</a>
                        <form action="{{route('dashboard.costs_sectors.destroy',['id' => $item->id])}}" method="POST">
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
                   <p>Não há Setores de custo para listagem</p>
               @endif
@endsection
@section('js')
<script>
    $.ajax({
        url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
        success: function(result) {
            $('#sectors').DataTable({
                "language": result,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'Tudo'],
                ],
            });
        }
    });
</script>
@endsection
@extends('adminlte::page')

@section('title', 'Centros de custo')

@section('content_header')
    <h1>Listagem de Centros de custo - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.costs.create') }}" role="button">Criar novo - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($costs))
        <table class="table table-striped table-inverse table-responsive" id="costs_table">
            <thead class="thead-inverse"> 
                <tr>
                    <th>Centros de custo</th>
                    <th>Descrição</th>
                    <th>Projeto</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($costs as $item)
                    <tr>
                        <td scope="row">{{ $item->name }}</td>
                        <td scope="row">{{ $item->description }}</td>
                        <td scope="row">{{ $item->project->name }}</td>
                        <td class="btn-group" role="group">
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm mr-1 dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $item }}" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Setores
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item }}">
                                    <a class="dropdown-item" href="{{route("dashboard.costs_sectors.index")}}">Listar </a>
                                    <a class="dropdown-item" href="{{route('dashboard.costs.createSector',$item)}}">Cadastrar</a>
                                    {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
                                </div>
                            </div>
                            <a class="btn btn-info btn-sm mr-1" href="{{ route('dashboard.costs.edit', $item) }}">Editar</a>
                            <form action="{{ route('dashboard.costs.destroy') }}" method="POST">
                                <input type="hidden" name="cost_id" value="{{ $item->id }}">
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
        <p>Não há Centros de custo para listagem</p>
    @endif

@endsection
@section('js')
    <script>
        $.ajax({
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#costs_table').DataTable({
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
    

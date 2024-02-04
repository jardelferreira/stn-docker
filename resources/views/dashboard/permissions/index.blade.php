@extends('adminlte::page')

@section('title', 'permissões')

@section('content_header')
    <h1>Listagem de permissões - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.permissions.create') }}" role="button">Criar nova - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($permissions))
        <table class="table table-striped table-inverse table-responsive" id="permissions">
            <thead class="thead-inverse">
                <tr>
                    <th>Nome</th>
                    <th>Permissão</th>
                    <th>Recurso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $item)
                    <tr>
                        <td scope="row">{{ $item->name }}</td>
                        <td scope="row">{{ $item->slug }}</td>
                        <td scope="row">{{ $item->resource }}</td>
                        <td class="btn-group" role="group">
                            <a class="btn btn-info btn-sm mr-1"
                                href="{{ route('dashboard.permissions.edit', ['id' => $item->id]) }}">Editar</a>
                            <a class="btn btn-warning btn-sm mr-1"
                                href="{{ route('dashboard.permissions.roles', ['permission' => $item->id]) }}">Vincular à
                                função</a>
                            <form action="{{ route('dashboard.permissions.destroy', ['id' => $item->id]) }}" method="POST">
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
        <p>Não há permissões para listagem</p>
    @endif
@endsection
@section('js')
    <script>
        $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#permissions').DataTable({
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

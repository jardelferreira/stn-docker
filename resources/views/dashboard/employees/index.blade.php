@extends('adminlte::page')

@section('title', 'Colaboradores')

@section('content_header')
    <h1>Listagem de Colaboradores - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.employees.create') }}" role="button">Criar novo - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($employees))
        <table class="table table-striped text-nowrap table-responsive" id="employees">
            <thead>
                <tr>
                    <th>Empregado</th>
                    <th>Profissão</th>
                    <th>CPF</th>
                    <th>Matrícula</th>
                    <th>Adimissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $item)
                    <tr>
                        <td scope="row">{{ $item->user->name }}</td>
                        <td scope="row">{{ $item->profession->name }}</td>
                        <td scope="row">{{ $item->cpf }}</td>
                        <td scope="row">{{ $item->registration }}</td>
                        <td scope="row">{{ date('d/m/Y', strtotime($item->admission)) }}</td>
                        <td scope="row">
                            <div class="dropdown show">
                                <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opções
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">Projetos</a>
                                    <a class="dropdown-item"
                                        href="{{ route('dashboard.employees.formlists', $item) }}">Formulários</a>
                                    <a class="dropdown-item"
                                        href="{{ route('dashboard.employees.projects', $item) }}">Vincular</a>
                                    <a class="dropdown-item" href="{{ route('dashboard.employees.show', $item) }}"
                                        target="_blank">Visualizar</a>
                                    <a class="dropdown-item"
                                        href="{{ route('dashboard.employees.edit', $item) }}">Editar</a>
                                    <form action="{{ route('dashboard.employees.destroy', ['id' => $item]) }}"
                                        method="POST" id="{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class=" dropdown-item bg-danger" type="submit">Deletar</button>
                                    </form>

                                </div>
                            </div>
                        </td>
                        {{-- <a href="#" class="btn btn-sm mr-1 btn-secondary">Projetos</a>
                            <a href="{{route('dashboard.employees.formlists',$item)}}" class="btn btn-sm mr-1 btn-success">Fichas</a>
                            <a class="btn btn-info btn-sm mr-1 btn-sm" href="{{ route('dashboard.employees.edit', $item) }}">Editar</a>
                            <a class="btn btn-warning btn-sm mr-1 btn-sm" href="{{ route('dashboard.employees.projects', $item) }}">Vincular</a>
                            <a href="{{ route('dashboard.employees.show', $item) }}" target="_blank" class="mr-1 btn btn-success btn-sm">Visualizar</a>
                            <form action="{{ route('dashboard.employees.destroy',['id' => $item]) }}" method="POST"
                                id="{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm mr-1" type="submit">Deletar</button>
                            </form> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Colaboradores para listagem</p>
    @endif
@endsection
@section('js')
@section('plugins.Datatables', true)
<script>
    var lang = "";
    $(document).ready(function() {
        $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#employees').DataTable({
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

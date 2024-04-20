@extends('adminlte::page')

@section('title', 'Colaboradores')

@section('content_header')
    <h1>Listagem de Colaboradores - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.employees.create') }}" role="button">Criar novo - <i class="fa fa-plus"
                aria-hidden="true"></i></a>
        <button onclick="searchEmployeeByUserId()" style="border: none; margin: 0; padding: 0;"
            class="border border-dark rounded ml-1"><img style="height: 35px;" class="ml-2"
                src="{{ asset('images/finger-search.svg') }}" alt=""></button>
    </h1>
@stop
@section('css')
    <style>
        .dropdown-item:hover {
            background-color: #3B71CA;
            color: #fff;
            text-decoration: none;
        }

        .dropdown-item {
            border-bottom: solid 1px slategray;
        }
    </style>
@endsection
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
                            <div class="dropdown show drop-show">
                                <a class="btn btn-sm btn-secondary dropdown-toggle link-drop" href="#" role="button"
                                    id="dropdownMenuLink-{{$loop->index}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opções
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-{{$loop->index}}">
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
<script src="{{ asset('js/fingertechweb.js') }}"></script>
<script>
    var lang = "";
    $(document).ready(function() {

        $(".drop-show").on("hidden.bs.dropdown", (d) => {
            $(d.currentTarget).parent().parent().removeClass("bg-info")
            if (employees.rows.length < 6) {
                employees.style.height = ""
            }
        })
        $(".drop-show").on("show.bs.dropdown", (d) => {
            $(d.currentTarget).parent().parent().addClass("bg-info")
            if (employees.rows.length < 6) {
                employees.style.height = "220px"
            }
        })

        $('.link-drop').on('show.bs.dropdown', function() {
            this.parentElement.parentElement.parentElement.classList.toggle("bg-info")
        })
        $('.link-drop').on('hide.bs.dropdown', function() {
            this.parentElement.parentElement.parentElement.classList.toggle("bg-info")
        })

        $.ajax({
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#employees').DataTable({
                    "language": result,
                    "ordering": false,
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

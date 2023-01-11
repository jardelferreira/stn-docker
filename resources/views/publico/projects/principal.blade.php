@extends('publico.page')

@section('title_prefix', 'SGLT - ')
@section('title', 'Lista de projetos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('sidebar-list')

@endsection

@section('content')
    <div class="bg-light mt-1">
        <h2 class="ms-2">Listagem de Projetos</h2>
        @include('publico.components.breadcrumb', ['breadcrumb' => [], 'current' => 'Projetos'])
        <hr>
        @if (count($projects))
        <div class="table-responsive">
                <table class="table table-striped table-sm " style="width: 100%" id="projects">
                    <thead class="">
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
                                <td class="btn-group" role="group">
                                    <a class="btn btn-warning btn-sm mx-1"
                                        href="{{ route('public.projects.bases', $item) }}"><small>Ver Bases</small></a>
                                    <a class="btn btn-primary btn-sm mx-1"
                                        href="{{ route('public.projects.stoks', $item) }}"><small>Consultar
                                            Estoque</small></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Não há Projetos para listagem</p>
            @endif
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        var lang = "";

        $(document).ready(function() {
            $.ajax({
                url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                success: function(result) {
                    $('#projects').DataTable({
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

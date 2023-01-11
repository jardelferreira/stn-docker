@extends('publico.page')
@section('title', 'Bases')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="bg-light mt-1">
        <h2 class="ms-2">Listagem de Bases do Projeto - <small>{{ $project->name }}</small></h2>
        @include('publico.components.breadcrumb',array('breadcrumb' => array(
            ['url' => 'public.projects', 'name' => 'Projetos']
    ), 'current' => 'Bases'))
        @if (count($bases))
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="bases">
                <thead class="thead-inverse">
                    <tr>
                        <th>Bases</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bases as $item)
                        <tr>
                            <td scope="row"><small>{{ $item->name }}</small></td>
                            <td class="btn-group" role="group">
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('public.projects.bases.stoks', $item) }}"><small>consultar
                                        estoque</small></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p>Não há Projetos para listagem</p>
        @endif
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var lang = "";

            $(document).ready(function() {
                $.ajax({
                    url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                    success: function(result) {
                        $('#bases').DataTable({
                            "language": result,
                            lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'Tudo'],
                            ],
                        });
                    }
                });

            });
        });
    </script>
@endsection

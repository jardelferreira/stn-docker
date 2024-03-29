@extends('publico.page')
@section('title', "Estoque do projeto {{ $project->name }}")
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

@endsection

@section('sidebar-list')

@endsection
@section('content')
    <div class="bg-light mt-1">
        <h1 class="ms-2">Listagem de estoque do projeto - <small>{{ $project->name }}</small></h1>
        @include('publico.components.breadcrumb', [
            'breadcrumb' => [['url' => 'public.projects', 'name' => 'Projetos']],
            'current' => 'Estoque',
        ])
        @if (count($project->bases()->get()))
            <div class="table-responsive">
                <table class=" table table-striped table-sm" id="stok">
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
                                        <td scope="row">{{ $stok->qtd }}</td>
                                        <td scope="row">{{ $stok->invoiceProduct->description }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Não há Produtos para listagem</p>
        @endif
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        var lang = "";

        $(document).ready(function() {
            $.ajax({
                url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                success: function(result) {
                    $('#stok').DataTable({
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

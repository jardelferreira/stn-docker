@extends('publico.page')
@section('title', 'Estoque Global')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('sidebar-list')

@endsection
@section('content')
    <div class="bg-light mt-1">
        <h1 class="ms-2">Listagem de estoque - Global</h1>
        @if (count($stoks))
            <div class="table-responsive">
                <table class=" table table-striped table-sm" id="stok">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Projeto</th>
                            <th>Base</th>
                            <th>Setor</th>
                            <th>Item</th>
                            <th>Qtd</th>
                            <th>Alocado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stoks as $stok)
                            @if (count($stok->fields) || $stok->qtd > 0)
                                <tr>
                                    <td scope="row"><small>{{ $stok->project->name }}</small></td>
                                    <td scope="row"><small>{{ $stok->base->name }}</small></td>
                                    <td scope="row">{{ $stok->sector->name }}</td>
                                    <td scope="row">{{ $stok->invoiceProduct->name }}</td>
                                    <td scope="row">{{ $stok->qtd }}</td>
                                    <td scope="row">
                                        @if (count($stok->fields))
                                            Fichas
                                            @if ($stok->invoiceProduct->qtd > $stok->qtd)
                                                / Saidas
                                            @endif
                                        @else
                                            @if ($stok->qtd > 0)
                                                / Estoque
                                            @endif
                                            @if ($stok->invoiceProduct->qtd > $stok->qtd)
                                                / Saidas
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
                url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
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

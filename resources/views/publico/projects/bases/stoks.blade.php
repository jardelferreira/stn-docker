@extends('publico.page')
@section('title',"Estoque da base")
    @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    @endsection
@section('content')
    <div class="bg-light mt-1">
        <h2 class="ms-2">Listagem de estoque da Base - <small>{{ $base->name }}</small> - {{ $base->project->name }}</h2>
        @include('publico.components.breadcrumb',array('breadcrumb' => array(
            ['url' => 'public.projects', 'name' => 'Projetos'],
            ['url' => 'public.projects.bases', 'name' => "{$base->project->name} - Bases", 'id' => $base->project->id],
    ), 'current' => 'Bases'))

    @if (count($base->sectors()->get()))
    <div class="table-responsive">
        <table class="table table-striped table-sm" id="stok">
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
    $(document).ready(function() {
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
    });
</script>
@endsection


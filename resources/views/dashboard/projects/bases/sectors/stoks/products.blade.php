@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Listagem de Produtos - {{ $sector->base->name }} - {{ $sector->name }}</h1>
@stop

@section('content')
    @if (count($products))
        <table class="table table-striped table-inverse table-responsive" id="products">
            <thead class="thead-inverse">
                <tr>
                    <th>Produto</th>
                    <th>Qtd. estoque</th>
                    <th>Estoque mín</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td scope="row">{{ $product->name }}</td>
                        <td scope="row">{{ $product->qtd_total }}</td>
                        <td scope="row">{{ $product->stokMin()->first()->stok_min ?? "Não Definido" }}</td>
                        <td class="btn-group" role="group">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#productModal"
                                data-whatever="{{ $product->id }}" data-product="{{$product->name}}">Estoque mín.</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Produtos para listagem</p>
    @endif

    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Estoque mínimo de produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                            <input type="hidden" class="form-control" id="product_id">
                            <input type="hidden" value="{{$sector->id}}" class="form-control" id="sector_id">
                        <div class="form-group">
                          <label for="qtd_min">Defina a quantidade mínima:</label>
                          <input type="number"
                            class="form-control" name="stok_min" id="qtd_min" aria-describedby="helpQtd_min" placeholder="150">
                          <small id="helpQtd_min" class="form-text text-muted">Defina a quantidade mínima</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <a name="" id="" class="btn btn-primary" href="{{route('dashboard.sectors.stoks.products.defineStokMin',[$sector,1])}}" role="button">Teste</a>
                    <button type="button" onclick="sendStockMin()" class="btn btn-primary">Definir</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@section('plugins.Datatables', true)
<script>
    var lang = "";
    $(document).ready(function() {
        $.ajax({
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#products').DataTable({
                    responsive: true,
                    order: [0, 'desc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });
        $('#productModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var product = button.data('product') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').html(`<div>Definir estoque mínimo para: </div><p>${product}</p>`)
            modal.find('.modal-body #product_id').val(recipient)
        })

    });
</script>
@endsection

<div class="container">
    <div class="modal fade list-invoice-products-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" id="listInvoiceProductsModal">
        <div class="modal-dialog modal-xl container">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title mx-auto" id="exampleModalLongTitle">Listagem de produtos da nota. 
                        <span id="invoice-products-header" class="text-primary"></span>
                    </h5>
                    <button type="button" class="btn btn-primary text-light" onclick="addProductsToList()">Adicionar Produtos</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="btn btn-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                    <table class="table table-striped table-inverse table-responsive"  id="listInvoiceProducts">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Nota</th>
                                <th>Item</th>
                                <th>Qtd</th>
                                <th>Disponível</th>
                                <th>Valor Unitário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

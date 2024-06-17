<div class="container">
    <div class="modal fade list-invoice-products-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" id="listInvoiceProductsModal">
        <div class="modal-dialog modal-xl container">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title mx-auto" id="exampleModalLongTitle">Listagem de produtos da nota.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 85vh; overflow-y: auto;">
                    <table class="table table-striped table-inverse table-responsive">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Qtd</th>
                                <th>Und.</th>
                                <th>Valor Unitário</th>
                            </tr>
                        </thead>
                        <tbody id="listInvoiceProducts">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

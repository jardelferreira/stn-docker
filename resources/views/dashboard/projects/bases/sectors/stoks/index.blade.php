@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
    <h1>Estoque do setor -{{ $sector->name }} <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.sectors.stoks.create', $sector) }}" role="button">Adicionar ao estoque - <i
                class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($stoks))
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Qtd</th>
                    {{-- <th>Certificado</th> --}}
                    <th>NF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stoks as $item)
                    <tr>
                        <td scope="row" class="text-nowrap">{{ $item->invoiceProduct->name }}</td>
                        <td scope="row" class="text-nowrap">{{ $item->invoiceProduct->description }}</td>
                        <td scope="row" class="text-nowrap">{{ $item->qtd }}</td>
                        {{-- <td scope="row" class="text-nowrap">{{ $item->invoiceProduct->ca_number }}</td> --}}
                        <td scope="row" class="text-nowrap">{{ $item->invoiceProduct->invoice->name }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rmModal"
                                data-id="{{ $item->id }}" data-name="{{ $item->invoiceProduct->name }}"
                                data-qtd="{{ $item->qtd }}">Retirar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Itens para listagem</p>
    @endif
@endsection

{{-- modal start --}}

<div class="modal fade" style="display: none" id="rmModal" tabindex="-1" aria-labelledby="rmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rmModalLabel">Retirada de estoque.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name" class="col-form-label">Item: <span id="qtd-available"></span> und
                            disponíveis</label>
                        <input type="text" class="form-control" readonly id="name">
                    </div>
                    <input type="hidden" class="form-control" id="id">
                    <div class="row">
                        <label for="qtd" class="col-form-label col-6">Quantidade à retirar:</label>
                        <input type="number" step="1" class="form-control col-3" id="qtd">
                        <div class="col-3">
                            <div class="bg-success btn ">+</div>
                            <div class="bg-danger btn ml-1 ">-</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="remove" class="btn btn-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>
{{-- modal end --}}
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>

<script>
    $(document).ready(() => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#rmModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var qtd = button.data('qtd');
            var name = button.data('name');
            var modal = $(this);

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #qtd').val(qtd);
            modal.find(".modal-body > form > div:nth-child(1) > label #qtd-available").text(qtd);
        });

    })

    $("#remove").on('click', () => {
       
        $("#rmModal").modal('hide');
        Swal.fire({
            title: 'Digite sua senha.',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                required: true,
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            showLoaderOnConfirm: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (!value) {
                        resolve('Você precisa informar a senha')
                    }
                    resolve()
                })
            },
            preConfirm: (pass) => {
                if (!pass) {
                    Swal.showValidationMessage("O campo Senha é Obrigatório!")
                }

                // requisição
                return $.ajax({
                    method: "POST",
                    url: `${window.location.href}/retirar`,
                    data: {
                        pass: pass,
                         qtd: $("#qtd").val(),
                          id: $("#id").val()
                        }
                }).done(function(response) {
                    return response
                }).fail(function(jqXHR, textStatus) {
                    Swal.showValidationMessage(
                        `Request failed: ${textStatus}`
                    )
                    Swal.close()
                });
                // fim requisição
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: result.value.type,
                    title: result.value.message,
                    text: result.value.event,
                    footer: result.value.footer,
                    didDestroy: () => {
                        location.reload()
                    }
                })

            }
        })
    });
</script>

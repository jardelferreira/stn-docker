@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
    <h1>Estoque do setor -{{ $sector->name }} <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.sectors.stoks.create', $sector) }}" role="button">Adicionar ao estoque - <i
                class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
<input type="search" name="search" style="display: none">
    @if (count($stoks))
        <table class="table table-striped table-inverse table-responsive" id="stok">
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
                        <td scope="row">{{ $item->invoiceProduct->name }}</td>
                        <td scope="row">{{ $item->invoiceProduct->description }} @isset($item->invoiceProduct->ca_number)
                            - CA: {{$item->invoiceProduct->ca_number}}
                        @endisset 
                    </td>
                        <td scope="row">{{ $item->qtd }}</td>
                        {{-- <td scope="row">{{ $item->invoiceProduct->ca_number }}</td> --}}
                        <td scope="row"><a href="{{ route('dashboard.invoices.show', $item->invoiceProduct->invoice->id)}}" target="_blank" rel="noopener noreferrer" class="text-bold">{{ $item->invoiceProduct->invoice->name }}</a></td>
                        <td scope="row" class="btn-group" >
                            <a target="_blank" name="document-{{$item->id}}" id="document-{{$item->id}}" class="btn btn-sm mx-1 btn-info" href="{{route("dashboard.sectors.stoks.documents",[$sector->id,$item->id])}}" role="button" >Documentos</a>
                            {{-- <a name="view-{{$item->id}}" id="view-{{$item->id}}" class="btn btn-info mx-1 rounded" href="#" role="button">Ver</a> --}}
                            {{-- <a href="{{ route('dashboard.invoices.show', $item->invoiceProduct->invoice->id)}}" target="_blank" type="button" class="btn btn-danger ml-1 btn-sm"><i class="fa fa-file-pdf fa-xl" aria-hidden="true"></i></a> --}}
                            <button type="button" class="btn btn-danger btn-sm ml-1" data-toggle="modal" data-target="#rmModal"
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
                            <div class="bg-success btn " id="btn-plus">+</div>
                            <div class="bg-danger btn ml-1 " id="btn-minus">-</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button  id="remove" class="btn btn-danger">Confirmar</button>
            </div>
        </div>
    </div>
</div>
{{-- modal end --}}
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>

<script>
    $(document).ready(() => {

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

    $("#btn-plus").on("click",() =>{
        val = parseFloat($("#qtd").val());
        val++
        if(!(val > qtd.value)){
        $('#qtd').val(val);
        }
    })
    $("#btn-minus").on("click",() =>{
        val = parseFloat($("#qtd").val());
        val--
        if((val > 0)){
        $('#qtd').val(val);
        }
    })
</script>

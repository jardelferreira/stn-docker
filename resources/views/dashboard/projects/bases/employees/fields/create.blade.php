@extends('adminlte::page')

@section('title', 'Cadastro de registro')

@section('content_header')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1> Adicionar registro a - {{ $base->name }} / {{ $employee->user->name }} <a class="btn btn-primary"
            href="{{ route('dashboard.bases.employees.list.formlists', ['base' => $base, 'employee' => $employee]) }}"
            role="button">Vincular novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
    <form action="{{ route('dashboard.fields.salveFieldAfterAssign', $formlist) }}" method="post" class="form">
        @csrf
        @method('POST')
        <input type="hidden" name="signature_delivered" value="{{ old('signature_delivered') ?? '' }}"
            id="signature_delivered">
        <div class="form-row">
            <div class="form-group col-lg-6 ">
                <label for="setor_id">Selecione um Setor</label>
                <select class="form-control" name="setor_id" id="setor_id">
                </select>
                <small id="sector_id" class="form-text text-muted">Lista de Setores</small>
            </div>
            <div class="form-group col-lg-6 ">
                <label for="stok_id">Selecione um Produto</label>
                <select class="form-control" name="stok_id" id="stok_id">
                </select>
                @error('stok_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="stok_id" class="form-text text-muted">Lista de Produtos</small>
            </div>
        </div>
        <div class="form row">
            <div class="form-group col-lg-6  col-md-6">
                <label for="qtd_delivered">Quantidade disponível: <span class="text-danger" id="qtd_available">0</span>
                    und</label>
                <input type="number" class="form-control" name="qtd_delivered" id="qtd_delivered">
                @error('qtd_delivered')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="qtd_delivered" class="form-text text-muted">Informe a quantidade entregue</small>
            </div>
            <div class="form-group col-lg-6  col-md-6">
                <label for="ca_second">C.A Opcional:</label>
                <input type="text" class="form-control" name="ca_second" id="ca_second" aria-describedby="ca_second"
                    placeholder="CA2560.89-NBR">
                <small id="ca_second" class="form-text text-muted">Certificado de Aprovação Opcional</small>
            </div>
        </div>
        <div class="form-group col-12">
            <label for="observation">Observações:</label>
            <textarea class="form-control" name="observation" id="observation" rows="3"></textarea>
        </div>
        <button type="button" id="add" class="ml-1 mb-3 btn btn-primary">Adicionar a ficha</button>
    </form>
@endsection
@section('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            var $url = window.location.href

            $("#setor_id").select2({
                ajax: {
                    url: `${$url.replace("adicionar","sectors")}`,
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                        };
                    },
                    processResults: function(response) {
                        let sectors = response.map(function(e) {
                            return {
                                "id": e.id,
                                "text": e.name
                            }
                        })
                        return {
                            results: sectors
                        };
                    },
                    cache: true
                }
            });
            $("#setor_id").on('change', (e) => {
                $("#stok_id").select2({
                    ajax: {
                        url: `${$url.replace("adicionar","sectors")}/${$("#setor_id").val()}`,
                        type: "GET",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                            };
                        },
                        processResults: function(response) {
                            console.log(response)
                            let stoks = response.map(function(e) {
                                return {
                                    "id": e.id,
                                    "text": e.name,
                                    "qtd": e.qtd
                                }
                            })
                            return {
                                results: stoks
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    var qtd_available = e.params.data.qtd;
                    $("#qtd_available").text(qtd_available)

                })
            })

        });
        $("#stok_id").on("change", (e) => {

        })
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        function signatureCanvas() {
            Swal.fire({
                title: "Assinatura Digital",
                html: ""
            })
        }
        $("#add").on("click", (e) => {

            if ($("#stok_id").val() != null && $("#qtd_delivered").val() != null && $("#qtd_delivered").val() !=
                '') {

                var url = window.location.href;

                Swal.fire({
                    title: 'Digite a senha do funcionário.',
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
                            url: url.replace("adicionar", 'signatureField'),
                            data: {
                                pass: pass,
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
                        if (result.value.success) {
                            var signature = result.value.signature_id;
                        }
                        Swal.fire({
                            icon: result.value.type,
                            title: result.value.message,
                            text: result.value.event,
                            footer: result.value.footer,
                            didOpen: (element) => {
                                $("#signature_delivered").val(signature);
                                $("form").submit();
                            }
                        })

                    }
                })
            } else {
                if ($("#stok_id").val() == null) {
                    Swal.fire(
                        'Dados incompletos!',
                        'Você precisa selecionar um item para adicionar a ficha!',
                        'error'
                    )
                    $("#stok_id").addClass("is-invalid");
                } else {
                    Swal.fire(
                        'Dados incompletos!',
                        'Você precisa informar a quantidade a ser adicionarda!',
                        'error'
                    )
                    $("#qtd_delivered").addClass("is-invalid");
                }

            }
        })
    </script>
@stop

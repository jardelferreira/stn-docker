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
@section('css')
    <style>
        #swal2-input {
            -webkit-text-security: square;
        }

        .swal-wide {
            width: 650px !important;
            height: auto;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('dashboard.fields.salveFieldAfterAssign', $formlist) }}" method="post" class="form">
        @csrf
        @method('POST')
        <input type="hidden" name="signature_delivered" value="{{ old('signature_delivered') ?? '' }}"
            id="signature_delivered">
        <input type="hidden" name="location" value="{{ old('location') ?? '' }}" id="location">
        <div class="form-row">
            <div class="form-group col-lg-4 col-md-12 col-sm-12">
                <label for="setor_id">Selecione um Setor</label>
                <select class="form-control" name="setor_id" id="setor_id">
                </select>
                <small name="setor_id" class="form-text text-muted">Lista de Setores</small>
            </div>
            <div class="form-group col-lg-8 col-md-12 col-sm-12">
                <label for="stok_id">Selecione um Produto</label>
                <select class="form-control" name="stok_id" id="stok_id">
                </select>
                @error('stok_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small name="stok_id" class="form-text text-muted">Lista de Produtos</small>
            </div>
        </div>
        <div class="form row">
            <div class="form-group col-lg-2 col-md-3 col-sm-6">
                <label for="qtd_delivered">Qtd. disp.: <span class="text-danger" id="qtd_available">0</span>
                    und</label>
                <input type="number" class="form-control" required min="1" max="" name="qtd_delivered"
                    id="qtd_delivered">
                @error('qtd_delivered')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="qtd_delivered" class="form-text text-muted">Informe a quantidade entregue</small>
            </div>
            <div class="form-group col-lg-2  col-md-3 col-sm-6">
                <label for="ca_second">C.A Opcional:</label>
                <input type="text" class="form-control" name="ca_second" id="ca_second" aria-describedby="ca_second"
                    placeholder="CA2560.89-NBR">
                <small id="ca_second" class="form-text text-muted">Certificado de Aprovação Opcional</small>
            </div>
            <div class="form-group col-lg-8 col-md-6 col-sm-12">
                <label for="observation">Observações:</label>
                <textarea class="form-control" name="observation" id="observation" rows="3"></textarea>
            </div>
        </div>
        <button type="button" onclick="addToField({{ $employee->id }})" class="ml-1 mb-3 btn btn-primary">Adicionar
            a ficha</button>
    </form>
@endsection
@section('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/fingertechweb.js') }}"></script>
    <script>
        $(document).ready(function() {
            getGeolocation()
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
                            let stoks = response.map(function(e) {
                                return {
                                    "id": e.id,
                                    "text": `${e.name} - CA: ${e.ca}`,
                                    "qtd": e.qtd,
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
                    $("#qtd_delivered").val(1)
                })
            })

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addToField(employee_id) {

            if ($("#stok_id").val() != null && $("#qtd_delivered").val() != null && $("#qtd_delivered").val() !=
                '') {
                console.log(employee_id)
                var url = window.location.href;

                Swal.fire({
                    title: 'Digite a senha do Colaborador.',
                    input: 'text',
                    html: `<div class="form-group col-12">
                            <button onclick="addWithBiometry(${employee_id})" style="border: none; margin: 0; padding: 0;"><img style="height: 70px;"
                            class="ml-1" src="{{ asset('images/finger-ok.svg') }}"
                            alt=""></button>
                        </div>`,
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
                                location: localStorage.geolocation.replaceAll('"', "")
                            }
                        }).done(function(response) {
                            console.log(response);
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
                            Swal.fire({
                                icon: result.value.type,
                                title: result.value.message,
                                text: result.value.event,
                                footer: result.value.footer,
                                didOpen: (element) => {
                                    $("#signature_delivered").val(result.value.signature_id);
                                    $("#location").val(localStorage.geolocation.replaceAll('"',
                                        ""))
                                    $("form").submit();
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: result.value.type,
                                title: result.value.message,
                                text: result.value.event,
                                footer: result.value.footer,
                            })
                        }

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
        }

        function addWithBiometry(employee_id) {
            if ($("#stok_id").val() != null && $("#qtd_delivered").val() != null && $("#qtd_delivered").val() != '') {
                Swal.fire({
                    title: "Adicionar com biometria",
                    text: "Resgatando a biometria da base de dados",
                    showCancelButton: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        $.get(`${window.location.origin}/dashboard/biometria/colaborador/${employee_id}`).then((
                            response) => {
                            if (response.success) {
                                matchOneOnOne2(response.template).then((finger) => {
                                    if (finger.success) {
                                        $.ajax({
                                            method: "POST",
                                            url: window.location.href.replace(
                                                "adicionar",
                                                'signatureField'),
                                            data: {
                                                pass: null,
                                                template: response.template,
                                                location: localStorage.geolocation
                                                    .replaceAll('"', "")
                                            },
                                            success: function(responseSignature) {
                                                if (responseSignature.success) {

                                                    Swal.fire({
                                                        icon: responseSignature
                                                            .type,
                                                        title: responseSignature
                                                            .message,
                                                        text: responseSignature
                                                            .event,
                                                        footer: responseSignature
                                                            .footer,
                                                        didOpen: (
                                                            element) => {
                                                                $("#signature_delivered")
                                                                    .val(
                                                                        responseSignature
                                                                        .signature_id
                                                                    );
                                                                $("#location")
                                                                    .val(
                                                                        localStorage
                                                                        .geolocation
                                                                        .replaceAll(
                                                                            '"',
                                                                            ""
                                                                            )
                                                                        )
                                                                $("form")
                                                                    .submit();
                                                            }
                                                    })
                                                } else {
                                                    Swal.fire({
                                                        icon: responseSignature
                                                            .type,
                                                        title: responseSignature
                                                            .message,
                                                        text: responseSignature
                                                            .event,
                                                        footer: responseSignature
                                                            .footer,
                                                    })
                                                }
                                            }
                                        })
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: "Devolução com biometria",
                                    text: "O usiário não possui uma Biometria cadastrada.",
                                    icon: "error"
                                })
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
        }
    </script>
@stop

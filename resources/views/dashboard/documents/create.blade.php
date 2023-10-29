@extends('adminlte::page')

@section('title', 'Documentos')

@section('content_header')
    <h1 class="mb-1">Cadastro de Documentos</h1>
@stop
@section('content')
    <div>
        <form action="{{ route('dashboard.documents.store') }}" method="POST" enctype="multipart/form-data" id="myform" name="myform"
            class="form border mb-1">
            @csrf
            @method('post')
            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="type">Tipo:</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="">Selecione...</option>
                        @foreach ($types as $type => $value)
                            <option value="{{ $type }}">{{ $value['name'] }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="Nome do documento" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-3">
                    <label for="status">Status:</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="">Selecione...</option>
                        @foreach ($statuses as $status => $value)
                            <option value="{{ $status }}">{{ $value['name'] }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                    placeholder="descreva detalhes aqui" name="description" value="{{ old('description') }}" required>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="expiration">Data de expiração:</label>
                    <input type="date" class="form-control @error('expiration') is-invalid @enderror" id="expiration"
                        name="expiration" value="{{ old('expiration') }}" required>
                    @error('expiration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-lg-3">
                    <label for="serie">Número de série:</label>
                    <input type="text" class="form-control @error('serie') is-invalid @enderror" id="serie"
                        placeholder="42158" name="serie" value="{{ old('serie') }}" required>
                    @error('serie')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6">
                    <label for="arquive">Arquivo</label>
                    <input type="file" class="form-control-file @error('arquive') is-invalid @enderror" id="arquive"
                        name="arquive" required>
                    @error('arquive')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="complements" value="[]" id="complements">
            <div class="row mt-2">
                <div class="form-group mb-2 col-3">
                    <label for="parameter">Parametro</label>
                    <input type="text" class="form-control" id="parameter" placeholder="Registro Técnico">
                </div>
                <div class="form-group mx-sm-3 mb-2 col-5">
                    <label for="value">Valor</label>
                    <input type="text" class="form-control" id="value" placeholder="XXX-548316-BR">
                </div>
                <div class="form-group col-3">
                    <label for="add"><small>Adicione vários (parametros: valores)</small></label>
                    <button type="button" class="btn btn-success mb-0 form-control" id="add">Adicionar
                        Complemento</button>
                </div>
                <hr>
            </div>
            <input type="hidden" name="complements" value="" id="complements">
            <button type="submit" class="btn btn-primary ml-1" id="submit">Cadastrar</button>
            <button type="button" onclick="clearTable()" class="ml-2 btn btn-info ml-1" id="clear">Limpar Comlementos</button>
        </form>
        <table class="table table-striped table-light mt-1 border border-dark" id="table-complements">
            <thead class="">
                <tr>
                    <th>#</th>
                    <th>Parametros</th>
                    <th>valores</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@section('js')
    <script>
        function isEmpty(obj) {
            for (const prop in obj) {
                if (Object.hasOwn(obj, prop)) {
                    return false;
                }
            }

            return true;
        }
        var data_complements = [];
        var js = {
            "RegistroCA": "42049",
            "DataValidade": "04/02/2027",
            "Situacao": "VÁLIDO",
            "NRProcesso": "19964113160202352",
            "CNPJ": "02912985000157",
            "RazaoSocial": "JV SETE UNIFORMES LTDA",
            "Natureza": "Nacional",
            "NomeEquipamento": "VESTIMENTA TIPO CAMISA",
            "DescricaoEquipamento": "Camisa de segurança confeccionado de tecido Júpiter FR, sarja 3x1, composto de 88% algodão e 12% poliamida, ATPV 11 cal/cm², fabricado pela empresa Cia de Fiação e Tecidos Cedro Cachoeira, com gramatura nominal de  7,7 oz/yd² (260 g/m²).",
            "MarcaCA": "Na etiqueta.",
            "Referencia": "CAMISA JUPITER FR",
            "Cor": null,
            "AprovadoParaLaudo": "PROTEÇÃO  DO TRONCO E MEMBROS SUPERIORES DO USUÁRIO CONTRA AGENTES TÉRMICOS PROVENIENTES DE ARCO ELÉTRICO E FOGO REPENTINO.",
            "RestricaoLaudo": null,
            "ObservacaoAnaliseLaudo": "A seleção e o uso deste equipamento devem ser precedidos de análise de risco da atividade que considere demais equipamentos necessários para proteção completa do usuário.  ",
            "CNPJLaboratorio": "03851105000142",
            "RazaoSocialLaboratorio": "SENAI CETIQT",
            "NRLaudo": "309-23-1/2; 980-23-1/2; 1341-23-1/2; 408-22; 412-22; 417-22; 420-22; 4",
            "Norma": "ASTM F2621-19"
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        type = document.getElementById("type");

        type.addEventListener("change", (e) => {
            if (e.target.value == 'caepi') {
                Swal.fire({
                    title: 'Deseja consultar a API de CA do MTE?',
                    input: 'text',
                    inputLabel: "Informe o número do CA:",
                    inputPlaceholder: "42049",
                    inputAttributes: {
                        autocapitalize: 'off',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Consultar',
                    showLoaderOnConfirm: true,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Informe o número do CA!'
                        }
                    },
                    preConfirm: (ca) => {
                        local = "http://localhost:8000"
                        if (window.location.host != "localhost") {
                            local = "https://apica.jfwebsystem.com.br"
                        }
                        $.get(`${local}/consulta/${ca}`)
                            .then(response => {
                                if (!isEmpty(response)) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'CA localizado com sucesso!'
                                    })
                                    response = "RegistroCA" in response ? response : response.data
                                    insertFormValues(response)
                                    for (key in response) {
                                        insertComplements({
                                            "parameter": key,
                                            "value": response[key]
                                        })
                                    }
                                    $.get(`${local}/`)
                                } else {
                                    throw new Error(response.statusText)
                                }
                            }).catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(result)
                    }
                })
            }
        })

        const table = document.getElementById('table-complements')

        function insertComplements(new_complement = null) {

            if (new_complement === null)
                new_complement = {
                    parameter: $("#parameter").val(),
                    value: $("#value").val(),
                };

            data_complements.push(new_complement);
            $("#complements").val(JSON.stringify(data_complements))
            row = table.insertRow()
            cell = row.insertCell()
            cell.innerText = data_complements.length
            cell = row.insertCell()
            cell.innerText = new_complement.parameter;
            cell = row.insertCell()
            cell.innerText = new_complement.value || "N/A";
            cell = row.insertCell()
            icon = document.createElement('i')
            icon.classList.add("fa")
            icon.classList.add("fa-trash")
            icon.classList.add("text-danger")
            icon.setAttribute('aria-hidden', true)
            icon.setAttribute('complement', data_complements.length - 1)
            icon.addEventListener("click", (e) => {
                clearTable()
                data_complements.splice(e.target.getAttribute("complement"), 1)
                loadTable()
            })
            cell.append(icon)
        }
        // table loads 
        $("#add").on("click", () => insertComplements())

        function removeItem(index_p) {
            clearTable()
            data_complements.splice(index_p, 1)
            loadTable()
            $("#complements").val(JSON.stringify(data_complements))

        }

        function clearTable() {
            while (table.rows.length > 1) {
                table.deleteRow(1)
            }

        }

        function loadTable() {
            data_complements.forEach((element, i2) => {
                row = table.insertRow()
                cell = row.insertCell()
                cell.innerText = i2 + 1

                cell = row.insertCell()
                cell.innerText = element.parameter;
                cell = row.insertCell()
                cell.innerText = element.value;

                cell = row.insertCell()
                icon = document.createElement('i')
                icon.classList.add("fa")
                icon.classList.add("fa-trash")
                icon.classList.add("text-danger")
                icon.setAttribute('aria-hidden', true)
                icon.setAttribute('complement', i2)
                icon.addEventListener("click", () => {
                    removeItem(icon.getAttribute('complement'), 1)
                })

                cell.append(icon)
            });
            $("#complements").val(JSON.stringify(data_complements))
        }

        function insertFormValues(data) {
            if ("RegistroCA" in data) {
                dta = data.DataValidade.split("/")

                $("#name").val(`CA-${data.RegistroCA}`)
                $("#description").val(`Certificado de aprovação Nº ${data.RegistroCA}`)
                $("#expiration").val(`${dta[2]}-${dta[1]}-${dta[0]}`);
                data.Situacao == 'VÁLIDO' ? $("#status").val('valid') : $("#status").val('invalid');
                $("#serie").val(data.RegistroCA)

            } else {
                dta = data.data_validade.split(" ")
                dta = dta[0].split("/")

                $("#name").val(`CA-${data.numero_ca}`)
                $("#description").val(`Certificado de aprovação Nº ${data.numero_ca}`)
                $("#expiration").val(`${dta[2]}-${dta[1]}-${dta[0]}`);
                data.situacao == 'VÁLIDO' ? $("#status").val('valid') : $("#status").val('invalid');
                $("#serie").val(data.numero_ca)
            }
        }
    </script>
@endsection
@endsection

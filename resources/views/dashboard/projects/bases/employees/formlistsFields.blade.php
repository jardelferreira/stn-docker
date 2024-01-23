@extends('adminlte::page')

<title>{{ $formlist->name }}-{{ $employee->user->name }}</title>

@section('content_header')
    <div class="btn-group">
        <a name="add" id="add" class="btn ml-1 rounded btn-success btn-sm"
            href="{{ route('dashboard.fields.create', $formlist_employee) }}" role="button">Adicionar Novo item</a>
        <a class="btn ml-1 rounded btn-primary btn-sm"
            href="{{ route('dashboard.bases.employees.list.formlists', ['base' => $base, 'employee' => $employee]) }}"
            role="button">Vincular novo - <i class="fa fa-plus" aria-hidden="true"></i></a>
        {{-- <a name="del" id="del" class="btn ml-1 rounded btn-danger" href="#" role="button">Excluir formulário</a> --}}
        <a id="del" class="btn ml-1 rounded btn-outline-danger btn-sm" href="#" role="button"
            onclick="DownloadFile('{{ $formlist->name }}-{{ $employee->user->name }}.pdf','{{ route('formlistPdf', $formlist_employee) }}')">
            Salvar PDF - <i class="fa fa-file-pdf " aria-hidden="true"></i>
        </a>
        <a class="ml-1 rounded btn btn-primary btn-sm" onclick="window.print()" href="#">imprimir ficha<i
                class="fas fa-print fa-fw"></i></a>
        <button class="btn btn-info ml-1" onclick="signatureCanvas()">Assinatura Digital<i class="fa fa-pencil ml-1"
                aria-hidden="true"></i> </button>
    </div>
@stop

@section('content')
    <!-- Content -->

    <div class="table-responsive text-nowrap">
        <table class="table table-sm table-bordered">
            <thead class="">
                <tr>
                    <th class="border border-dark text-center" colspan="3" id="img_logo" style="width: 130px;">
                        <img src="{{ asset('images/stnlogo.png') }}" alt="Logo da empresa">
                    </th>
                    <th class="border border-dark text-center text-uppercase" colspan="3">{{ $formlist->description }}
                    </th>
                    <th class="border border-dark text-center" colspan="2" rowspan="2">
                        <img class="image-fuid mx-auto rounded"
                            src="https://img.freepik.com/premium-vector/white-man-icon-app-web-isolated-white-background-color-icon_599062-393.jpg?w=740"
                            height="120px;" alt="">
                    </th>
                </tr>
                <tr>
                    <th class="border border-dark" colspan="6"><span>Unidade (Obra):</span><span
                            style="font-weight: normal">
                            {{ $base->name }}({{ $base->project->name }})</span> </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-dark" colspan="3"><span>Matricula:</span> {{ $employee->registration }}
                    </td>
                    <td class="border border-dark" colspan="2"><span>Nome:</span> {{ $employee->user->name }}</td>
                    <td class="border border-dark" colspan="2">
                        <span>Admissão:</span> {{ date('d/m/Y', strtotime($employee->admission)) }}
                    </td>
                    <td class="border border-dark">
                        <span>Status: </span> Ativo
                    </td>

                </tr>
                <tr>
                    <td class="border border-dark" colspan="4"><span>Responsável Técnico:</span> Marcos Athie Trevisan
                    </td>
                    <td class="border border-dark" colspan="2"><span>Form Nº
                        </span>{{ str_repeat('0', strlen($formlist->id) < 5 ? 4 - strlen($formlist->id) : 0) }}{{ $formlist->id }}
                    </td>
                    <td class="border border-dark" colspan="2"><span>Rev: </span>{{ $formlist->revision }}</td>
                </tr>
                {{-- <tr>
                    <td class="border border-dark" colspan="8"><span>Unidade (Obra):</span>{{ $base->name }} </td>
                    <td class="border border-dark" colspan="7"><span>Área:</span>
                        <div class="form-check d-inline ml-2">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="area" value="area" checked>
                                Civil
                            </label>
                        </div>
                        <div class="form-check d-inline ml-2">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="area" value="area">
                                Elétrica
                            </label>
                        </div>
                        <div class="form-check d-inline ml-2">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="area" value="area">
                                Eletromecânica
                            </label>
                        </div>
                        <div class="form-check d-inline ml-2">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="area" value="area">
                                Engenharia
                            </label>
                        </div>
                        <div class="form-check d-inline ml-2">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="area" value="area">
                                Ti
                            </label>
                        </div>
                    </td>
                    <td class="border border-dark" colspan="2">
                        <span>Admissão:</span> {{ date('d/m/Y', strtotime($employee->admission)) }}
                    </td>
                </tr> --}}
                <tr>
                    <td class="border border-dark text-center font-weight-bold" colspan="4">Fornecimento</td>
                    <td class="border border-dark text-center font-weight-bold" colspan="2">Entrega</td>
                    <td class="border border-dark text-center font-weight-bold" colspan="2">Devolução</td>
                </tr>
            </tbody>
            <tfoot class="table table-bordered table-sm table-striped">
                <thead class="thead-dark text-center">
                    <th class="border border-dark text-center" width="25px">#</th>
                    <th class="border border-dark text-center" width="20px">Qtd.</th>
                    {{-- <th class="border border-dark text-center">Cód</th> --}}
                    <th class="border border-dark text-center">C.A.</th>
                    <th class="border border-dark text-center">Descrição</th>
                    <th class="border border-dark text-center">Data</th>
                    <th class="border border-dark text-center">Assinatura</th>
                    <th class="border border-dark text-center">Data</th>
                    <th class="border border-dark text-center">Assinatura</th>
                </thead>
                <tbody id="list">
                    @foreach ($fields as $key => $field)
                        <tr>
                            <td class="border text-center border-dark p-0 m-0">
                                <p id="index" style="font-size: 0.8em;">{{ $key + 1 }}</p>
                                <div class="dropdown" id="dropdownMenu" with="5px" style="max-height: 10px;"
                                    padding="0" margin="0">
                                    <button class="btn btn-warning btn-sm dropdown-toggle" style="height: 25px"
                                        type="button" id="dropdownMenu{{ $key }}" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu{{ $key }}">
                                        @if (!$field->date_returned)
                                            <button class="dropdown-item bg-secondary"
                                                onclick="lowering({{ $field->id }})" type="button">Baixa</button>
                                        @endif
                                        @if (!$field->date_returned)
                                            <button class="dropdown-item bg-info"
                                                onclick="devolutionField({{ $field->id }})"
                                                type="button">Devolução</button>
                                            <button class="dropdown-item bg-success"
                                                onclick="replacementField({{ $field->stok_id }},{{ $field->id }},{{ $formlist_employee }})"
                                                type="button">Troca</button>
                                        @endif
                                        <button class="dropdown-item bg-danger"
                                            onclick="removeField({{ $field->id }})" type="button">Excluir</button>
                                    </div>
                                </div>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->qtd_delivered }}</p>
                            </td>
                            {{-- <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->stoks->id }}</p>
                            </td> --}}
                            <td class="border border-dark text-center p-0">
                                <p style=" margin: 0; font-size: 1em;">
                                    {{ $field->ca_first ?? $field->ca_second ?? "N/A"}}
                                    {{-- <i class="fa fa-certificate text-success ml-1 mr-1" aria-hidden="true"></i> --}}
                                    {{-- <i class="fa fa-id-card fa-lg text-danger" aria-hidden="true"></i> --}}
                                    {{-- <i class="fa fa-newspaper-o fa-lg text-danger ml-2" aria-hidden="true"></i> --}}
                                    @if ($field->stoks->documents()->exists())
                                        
                                    <a href="{{route('dashboard.bases.employees.formlists.documents',[$base,$employee,$formlist_employee,$field->stoks])}}" target="_blank"><i class="fa fa-book fa-lg text-danger fa-lg ml-2 mt-1" aria-hidden="true"></i></a>
                                    @endif
                                </p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.8em;" colspan="2">
                                    {{ $field->stoks->invoiceProduct->description }}</p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.8em;">
                                    {{ date('d/m/y', strtotime($field->date_delivered)) }}</p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.8em;">
                                    @if ($field->signature_delivered)
                                        Assinado digitalmente
                                    @else
                                        Falha na assinatura
                                    @endif
                                </p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.8em;">
                                    @if ($field->date_returned)
                                        {{ date('d/m/y', strtotime($field->date_returned)) }}
                                </p>
                    @endif
                    </td>
                    <td class="border border-dark text-center">
                        <p style="padding: 0; margin: 0; font-size: 0.8em;">
                            @if ($field->signature_returned)
                                Assinado
                            @endif
                        </p>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </tfoot>
        </table>
        
        <div class=" mt-1">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCA">
                CA-42049
            </button>
        </div>

        <div class="modal fade" id="modalCA" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header m-0" id="modalHeader">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="close btn btn-light border bordered rounded" data-dismiss="modal"
                            aria-label="Fechar">
                            <span aria-hidden="true" class="m-0">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="modal-list">

                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // Função para preencher as informações no modal
            function preencherInformacoes() {
                const json_apica = {
                    "numero_ca": "Número CA",
                    "data_validade": "Validade",
                    "processo": "Número do Processo",
                    "situacao": "Situação",
                    "cnpj": "CNPJ",
                    "razao_social": "Razão Social",
                    "natureza": "Natureza",
                    "equipamento": "Equipamento",
                    "descricao": "Descrição",
                    "marcacao_ca": "Marcação do CA",
                    "referencia": "Referência",
                    "tamanho": "Tamanho",
                    "laudo": "Laudo",
                    "obs_laudo": "Observação do Laudo",
                    "numero_laudo": "Número do Laudo",
                    "cnpj_laboratorio": "CNPJ Laboratório",
                    "razao_social_laboratorio": "Razão Social Laboratório",
                    "norma_tecnica": "Norma Técnica",
                    "historico_alteracoes": "Histórico de Alterações"
                }
                const json_caepi = {
                    "RegistroCA": "Número CA",
                    "DataValidade": "Validade",
                    "NRProcesso": "Número do Processo",
                    "Situacao": "Situação",
                    "CNPJ": "CNPJ",
                    "RazaoSocial": "Razão Social",
                    "Natureza": "Natureza",
                    "NomeEquipamento": "Equipamento",
                    "DescricaoEquipamento": "Descrição",
                    "MarcaCA": "Marcação do CA",
                    "Referencia": "Referência",
                    "Tamanho": "Tamanho",
                    "AprovadoParaLaudo": "Laudo",
                    "RestricaoLaudo": "Observação do Laudo",
                    "ObservacaoAnaliseLaudo": "Número do Laudo",
                    "CNPJLaboratorio": "CNPJ Laboratório",
                    "RazaoSocialLaboratorio": "Razão Social Laboratório",
                    "NRLaudo": "Norma Técnica",
                    "Norma": "Histórico de Alterações"
                }
                const jsonData = {
                    "numero_ca": "42049",
                    "data_validade": "04/02/2027 00:00:00",
                    "situacao": "VÁLIDO",
                    "processo": "19964113160202352",
                    "cnpj": "02.912.985/0001-57",
                    "razao_social": "JV SETE UNIFORMES LTDA",
                    "natureza": "Nacional",
                    "equipamento": "VESTIMENTA TIPO CAMISA",
                    "marcacao_ca": "Na etiqueta.",
                    "referencia": "CAMISA JUPITER FR",
                    "tamanho": "PP ao EXGG",
                    "descricao": "Camisa de segurança confeccionado de tecido Júpiter FR, sarja 3x1, composto de 88% algodão e 12% poliamida, ATPV 11 cal/cm², fabricado pela empresa Cia de Fiação e Tecidos Cedro Cachoeira, com gramatura nominal de 7,7 oz/yd² (260 g/m²).",
                    "numero_laudo": "86.219; 87.588; 87.589",
                    "laudo": "PROTEÇÃO DO TRONCO E MEMBROS SUPERIORES DO USUÁRIO CONTRA AGENTES TÉRMICOS PROVENIENTES DE ARCO ELÉTRICO E FOGO REPENTINO.",
                    "obs_laudo": "A seleção e o uso deste equipamento devem ser precedidos de análise de risco da atividade que considere demais equipamentos necessários para proteção completa do usuário.",
                    "razao_social_laboratorio": "IEE/USP",
                    "cnpj_laboratorio": "63.025.530/0042-82",
                    "norma_tecnica": "ASTM F 1506-10a",
                    "historico_alteracoes": "Data da Alteração (Ordem Crescente) Ocorrência CA\n21/09/2018 Expedido\n21/05/2021 Expedido\n12/06/2023 CA Vencido\n19/06/2023 CA Válido\n26/07/2023 Expedido"
                };
                const ul_dados = document.getElementById("modal-list")
                document.getElementById("modalTitle").textContent = `CA: ${jsonData.numero_ca}`
                ul_dados.innerHTML =
                    `<div class="alert alert-danger" role="alert">Documento disponível: <a href="#" class="alert-link"> Baixar</a></div>`
                for (data in jsonData) {
                    li = document.createElement("li")
                    li.id = data

                    strong = document.createElement("strong")
                    span = document.createElement("span")
                    if (data != 'historico_alteracoes') {

                        strong.textContent = `${json_apica[data]}:`
                        span.textContent = `${jsonData[data]}`

                        li.appendChild(strong)
                        li.appendChild(span)
                        ul_dados.appendChild(li)

                    }
                    if (data == 'historico_alteracoes') {
                        strong.textContent = `${json_apica[data]}:`
                        li.appendChild(strong)
                        ul_dados.appendChild(li)
                        ul = document.createElement("ul")
                        jsonData[data].split('\n').forEach(item => {
                            const listItem = document.createElement('li');
                            listItem.textContent = item;
                            ul.appendChild(listItem);
                        });
                        ul_dados.appendChild(ul)
                    }
                }
                if (jsonData.situacao == "VÁLIDO") {
                    document.getElementById("modalHeader").classList.add("valid")
                } else {
                    document.getElementById("modalHeader").classList.add("invalid")

                }
            }

            // Chamar a função de preenchimento após o carregamento da página
            window.onload = preencherInformacoes();
        </script>

    </div>
    
@endsection

@section('js')
    <script>
        $(document).ready(() => {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            window.mobileAndTabletCheck = function() {
                let check = false;
                (function(a) {
                    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i
                        .test(a) ||
                        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
                        .test(a.substr(0, 4))) check = true;
                })(navigator.userAgent || navigator.vendor || window.opera);
                return check;
            };
            window.signatureHtml = () => {
                return `<div class="container">
		<div class="row">
			<div class="col-md-12">
		 		<canvas id="sig-canvas" width="480" height="160">
		 			Get a better browser, bro.
		 		</canvas>
		 	</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-primary" id="sig-submitBtn">Assinar</button>
				<button class="btn btn-default" id="sig-clearBtn">Apagar assinatura</button>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-12">
				<textarea id="sig-dataUrl" class="form-control" rows="5">Data URL for your signature will go here!</textarea>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-12">
				<img id="sig-image" src="" alt="A foto da assinatura aparece aqui"/>
			</div>
		</div>
	</div>`
            }
        })
        $("#device").on("click", (e) => {
            if (!mobileAndTabletCheck()) {
                Swal.fire(
                    'Tipo de Dispositvo!',
                    'Dispositivo Desktop!',
                    'info'
                )
            } else {
                Swal.fire(
                    'Tipo de Dispositvo!',
                    'Dispositivo MOBILE!!',
                    'info'
                )
            }
        })

        $("input:checkbox").on('click', function() {
            // in the handler, 'this' refers to the box clicked on
            var $box = $(this);
            if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var products = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the products/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(products).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });

        function DownloadFile(fileName, url) {
            var popupTextElement = "";
            $.ajax({
                url: url,
                cache: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 2) {
                            if (xhr.status == 200) {
                                xhr.responseType = "blob";
                                popupTextElement.innerHTML = popupTextElement.innerHTML +
                                    `<br/>
                                        <div class="alert alert-success" role="alert">
                                        Processando...
                                        </div>`
                            } else {
                                xhr.responseType = "text";
                            }
                        }
                    };

                    swal.fire({
                        title: "<span id='save-popup-title'>Gerando PDF para ficha...</span>",
                        html: "<div id='save-popup-icon'></div><span id='save-popup-message'></span>",
                        confirmButtonColor: "#1a7bb9",
                        confirmButtonText: "Ok",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                            popupTextElement = document.getElementById(
                                "save-popup-message");
                            popupTextElement.innerHTML = popupTextElement.innerHTML +
                                `<br/>
                                        <div class="alert alert-success" role="alert">
                                        Enviando...
                                        </div>`;
                        }
                    });
                    return xhr;
                },
                success: function(data) {
                    //Convert the Byte Data to BLOB object.
                    popupTextElement.innerHTML = popupTextElement.innerHTML +
                        `<br/>
                            <div class="alert alert-success" role="alert">
                            Gerando pdf...
                            </div>`

                    var blob = mobileAndTabletCheck() ? new Blob([data], {
                        type: 'application/pdf'
                    }) : new Blob([data], {
                        type: "application/octetstream"
                    });
                    //Check the Browser type and download the File.
                    var isIE = false || !!document.documentMode;
                    if (isIE) {
                        window.navigator.msSaveBlob(blob, fileName);
                    } else {
                        popupTextElement.innerHTML = popupTextElement.innerHTML +
                            `<br/>
                                        <div class="alert alert-success" role="alert">
                                        Preparando seu download...
                                        </div>`
                        var url = window.URL || window.webkitURL;
                        link = url.createObjectURL(blob);
                        var a = $("<a />");
                        Swal.fire({
                            icon: 'success',
                            title: 'Tudo pronto, baixando!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        a.attr("download", fileName);
                        a.attr("href", link);
                        $("body").append(a);
                        a[0].click();
                        $("body").remove(a);
                    }
                }
            });
        };

        function removeField(id) {
            Swal.fire({
                title: 'Digite sua senha. para excluir o item',
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
                    $(".swal2-cancel").hide() // oculta o botão de cancelar durante o carregamento
                    // requisição
                    return $.ajax({
                        method: "POST",
                        url: `${window.location.href}/remove`,
                        data: {
                            pass: pass,
                            id: id
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
        }

        function devolutionField(id) {
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
                    $(".swal2-cancel").hide() // oculta o botão de cancelar durante o carregamento
                    // requisição
                    return $.ajax({
                        method: "POST",
                        url: `${window.location.href}/devolver`,
                        data: {
                            pass: pass,
                            id: id
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
        }

        function replacementField(stok_id, field_id, formlist_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Buscando item similar no estoque",
                didOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                        url: `${window.location.href}/similar/${stok_id}`,
                        success: async function(result) {
                            window.products_html = `<div class="list-group list-group-light">`
                            result.forEach(element => {
                                window.products_html += `
                               <li class="list-group-item">
                                        <input class="form-check-input" name="product_id" type="checkbox" value="${element.id}" id="${element.id}" />
                                        <label class="form-check-label" for="${element.id}">${element.invoice_product.name} - CA: ${element.invoice_product.ca_number}</label>
                                    </li> `
                            });
                            window.products_html += `</div>`
                            Swal.close()
                            const {
                                value: product
                            } = await Swal.fire({
                                title: 'Selecione um produto da lista',
                                customClass: 'swal-wide',
                                showCancelButton: true,
                                html: window.products_html,
                                focusConfirm: false,
                                didOpen: () => {
                                    $(".list-group-item .form-check-input:checkbox").on(
                                        'click',
                                        function() {

                                            var $box_products = $(this);
                                            if ($box_products.is(":checked")) {
                                                var group =
                                                    "input:checkbox[name='" +
                                                    $box_products.attr("name") +
                                                    "']";
                                                $(group).prop("checked", false);
                                                $box_products.prop("checked", true);
                                            } else {
                                                $box_products.prop("checked",
                                                    false);
                                            }
                                        });
                                },
                                preConfirm: () => {
                                    return {
                                        stok_id: document.querySelector(
                                            '.list-group-item .form-check-input:checked'
                                        ).value,
                                        stok_name: document.querySelector(
                                            '.list-group-item .form-check-input:checked'
                                        ).innerText,
                                        id: field_id,
                                        formlist_employee: formlist_id
                                    }
                                }
                            })

                            if (product) {
                                loweringAndAdd(product);
                            }
                        }
                    })
                }
            })
        }

        function addOnreplacement() {

        }
        async function loweringAndAdd(params) {

            const {
                value: data_replacements
            } = await Swal.fire({
                title: "informe as senhas para prosseguir!",
                showCancelButton: true,
                html: `<div class="row container">
                            <div class="form-group col-12">
                            <label for="user_pass">Sua senha:</label>
                            <input type="password"
                                class="form-control" name="user_pass" id="user_pass" aria-describedby="userId" placeholder="Senha do Usuário">
                            <small id="userId" class="form-text text-muted">informe sua senha</small>
                            </div>
                            <div class="form-group col-12">
                            <label for="employee_pass">Senha do Funcionário</label>
                            <input type="password"
                                class="form-control" name="employee_pass" id="employee_pass" aria-describedby="employeeId" placeholder="senha do funcionário">
                            <small id="employeeId" class="form-text text-muted">senha do funcionário</small>
                            </div>
                        </div>`,
                preConfirm: () => {
                    user_pass = document.querySelector("#user_pass").value;
                    employee_pass = document.querySelector("#employee_pass").value;
                    if (((typeof user_pass) === null || (typeof user_pass) === undefined) ||
                        ((typeof params.stok_id) === null || (typeof params.stok_id) === undefined) ||
                        ((typeof params.id) === null || (typeof params.id) === undefined) ||
                        ((typeof employee_pass) === null && (typeof employee_pass) === undefined)) {
                        return false;
                    }
                    return {
                        user_pass: user_pass,
                        pass: employee_pass,
                        formlist_employee: params.formlist_employee,
                        stok_id: params.stok_id,
                        id: params.id,
                        qtd_delivered: 1,
                    }
                }
            })
            if (data_replacements) {
                console.log(data_replacements)
                Swal.fire({
                    title: "Realizando troca.",
                    html: `<div id="panel">
                            <p id="lowering">Enviando informações...<p>
                            </div>`,
                    didOpen: () => {
                        Swal.showLoading();
                        panel = document.querySelector("#panel")
                        //preparação
                        $.ajax({
                            url: `${window.location.href}/baixa`,
                            method: 'POST',
                            data: data_replacements,
                            success: function(response1) {
                                console.log(response1);
                                if (response1.success) {
                                    parag = document.createElement("p")
                                    parag.innerText = response1.message
                                    panel.append(parag)

                                    parag = document.createElement("p")
                                    parag.innerText = "Gerando assinatura..."
                                    panel.append(parag)

                                    $.ajax({
                                        url: `${window.location.href.substring(0,window.location.href.indexOf('base'))}ficheiros/${data_replacements.formlist_employee}/signatureField`,
                                        method: 'POST',
                                        data: data_replacements,
                                        success: function(response2) {
                                            console.log(response2);
                                            if (response2.success) {
                                                panel = document.querySelector(
                                                    "#panel")
                                                parag = document.createElement("p")
                                                parag.innerText = response2.message
                                                panel.append(parag)
                                                data_replacements.signature_id =
                                                    response2.signature_id

                                                $.ajax({
                                                    url: `${window.location.href.substring(0,window.location.href.indexOf('base'))}ficheiros/${data_replacements.formlist_employee}/ajaxSalveFieldAfterAssign`,
                                                    method: 'POST',
                                                    data: data_replacements,
                                                    success: function(
                                                        response3) {
                                                        Swal.fire({
                                                            icon: response3
                                                                .type,
                                                            title: response3
                                                                .message,
                                                            text: response3
                                                                .event,
                                                            footer: response3
                                                                .footer
                                                        })
                                                        window.location
                                                            .reload()
                                                        // Continua com outras ações após as requisições
                                                    },
                                                    error: function(erro) {
                                                        console.error(
                                                            erro);
                                                    }
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: response2.type,
                                                    title: response2
                                                        .message,
                                                    text: response2.event,
                                                    footer: response2.footer
                                                })
                                            }
                                        },
                                        error: function(erro) {
                                            console.error(erro);
                                        }
                                    });

                                } else {

                                    Swal.fire({
                                        icon: response1.type,
                                        title: response1.message,
                                        text: response1.event,
                                        footer: response1.footer
                                    })
                                }

                            },
                            error: function(erro) {
                                console.error(erro);
                            }
                        });
                    }
                })
            }
        }

        function lowering(field_id) {
            Swal.fire({
                title: 'Digite a sua senha.',
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
                        url: `${window.location.href}/baixa`,
                        data: {
                            user_pass: pass,
                            id: field_id
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
                    })
                    window.location.reload()
                }
            })
        }
    </script>

    {{-- canvas --}}
    <script>
        function signatureCanvas() {

            Swal.fire({
                title: "Assine o documento no campo abaixo",
                html: signatureHtml(),
                width: 580,
                showCancelButton: true,
            })

            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            var canvas = document.getElementById("sig-canvas");
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#222222";
            ctx.lineWidth = 4;
            // ctx.moveTo(60,100);
            // ctx.lineTo(500,100)
            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;

            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);

            canvas.addEventListener("mouseup", function(e) {
                drawing = false;
            }, false);

            canvas.addEventListener("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Add touch event support for mobile
            canvas.addEventListener("touchstart", function(e) {

            }, false);

            canvas.addEventListener("touchmove", function(e) {
                var touch = e.touches[0];
                var me = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchstart", function(e) {
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var me = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchend", function(e) {
                var me = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(me);
            }, false);

            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                }
            }

            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                }
            }

            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                sigText.innerHTML = "Data URL for your signature will go here!";
                sigImage.setAttribute("src", "");
            }, false);
            submitBtn.addEventListener("click", function(e) {
                var dataUrl = canvas.toDataURL();
                sigText.innerHTML = dataUrl;
                sigImage.setAttribute("src", dataUrl);
            }, false);

        };
    </script>
@endsection

@section('css')
    <style>
        .swal-wide {
            width: 850px !important;
        }

        .modal-header {
            border-bottom: none;
            padding: 15px;
            background-color: #f7f7f7;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .modal-header.valid {
            background-color: #007bff;
            color: #f7f7f7;
        }

        .modal-header.invalid {
            background-color: #e53935;
            color: #fff;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-body ul {
            list-style-type: none;
            padding-left: 0;
        }

        .modal-body li {
            margin-bottom: 10px;
        }

        .modal-body strong {
            color: black;
        }

        .modal-footer {
            border-top: none;
        }

        li span {
            margin-left: 5px;
        }
    </style>
    <style>
        #index {
            visibility: hidden;
            display: none;
        }

        td>span {
            font-weight: bold;
        }

        .list-group-item .form-check-input:hover {
            background-color: #A9BCF5;
        }
    </style>
    <style type="text/css" media="print">
        @media print {
            #dropdownMenu {
                display: none;
                visibility: hidden;
            }

            #index {
                display: inline;
                visibility: visible;
                text-align: center;
            }
        }
    </style>
    <style>
        @page {
            size: landscape;
        }

        #list tr:nth-child(even) {
            background-color: #A9BCF5;
        }

        #img_logo {}

        #img_logo img {
            max-width: 150px;
        }

        #sig-canvas {
            border: 2px dotted #CCCCCC;
            border-radius: 15px;
            cursor: crosshair;
        }

        /* #img_logo {
                                                                                                                            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAADMCAYAAACFiFH+AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2xpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQwIDc5LjE2MDQ1MSwgMjAxNy8wNS8wNi0wMTowODoyMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpGODdGMTE3NDA3MjA2ODExQjZEMEI2NEUxNTY5QzhGMCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRTkxRjMwMzJCMTMxMUVBOUFFMEJDMUUyODJBRkI5NyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRTkxRjMwMjJCMTMxMUVBOUFFMEJDMUUyODJBRkI5NyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBJbkRlc2lnbiAxNC4wIChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InV1aWQ6NjA5ZmQ3M2MtYmVjMi1hOTQ2LWIwZWYtMTIyMGM1MThkOTczIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuaWQ6YTY2Nzc0YWQtMWIxMy00ZWMzLWI1OTItMGE5MmJkYjdhYmFiIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+ILew0AAAdu5JREFUeNrsfQd8VFX2/6vTazIJ6QTSgEDoHRHFjqLiWlHXin3t6+p/ddW1rFtcf5a1665lbWtDsWABUZDeIZBGOimT6e31/70voJnJhBIyM29m7vfDCL5JZt675XzPOfcUXJIkDAEBAQEBASG5gSNCR0BAQEBASEFCZxgGSx6SxwkM3K3IMxJOkBh8gWtoVhEQEBAQUhoURcmvQxL6CSecgNXW1ibFAxG0xpIx4dKlwY4dbzL2muW8v7tJEgUMJ8FD4iSacQQEBASElMQdd9whv8JIPvKHWltbsba2tmSx0MVAITOFNEw9TqDKXYyrcXWoc/cnfHft15gYbEFTjoCAgICQinA6nf2t9sgLNE0nzQPhFC1RuNBDEVIBpTNaNIZJC8yFkxaIjNfDuhp/DHbs+h/TU7tcYLztaPoREBAQEFIFJEkentCVzeAEgUmiePB/JZ71MY6G7+nCGZdLfAiTBOYA0WtMmuxxCzTDqgC5e7yss3FVsBOSe903AuNpQ0sBAQEBASHVkDSEbpt37hLO4+h0b/7h0z6XJcDifL8flsS+5G7U5AByz5HJ3cM4G1eGunZ/DMj9WyHkbkVLAAEBAQEhFUAo3yrHcdvxZ1814uYnXjSOmnx8f6OdUh/y9yG58wwGLXhouWtzxi3MqLro9exZv9ueOfGyT3X5U64iNeZCtBQQEBAQEJCFHkMUL3no31knX3Q5LmGYJm9EZeT7nLdjG2DtxUf0YQfJvddytwLLfSEkeIHxulhn449BYLkHO3a8LwmsHy0NBAQEBARE6ENG5g//JxuQOR/wYqRah0kCx0T+DOtqXTuovPlwcrcAcj9Lmzv+LG7kvPsYe91yQO6fsK7G1eA7A2iZICAgICAgQh8E1MMKy4Zfff/z5glz5/N+z69v4DCsD8dhMZlfLhGk6pi/sA+5UzpbKV2cU6ovmnkjH+huCNlrvgp17vqQdTWtlkSBQUsGAQEBAQER+hGReVF5+b0vLNcUlA0X/O5frovAODeUjZ9FmTNyeHfP/j6/MqSl4SSRl1/wYwG5jzQW59xoKJp9I+/vguT+Zahr90esq3kN+JkQWj4ICAgICIjQo0BXPHrKyN/9/X1N3ghA5q5wrgZGOa5S63AivNYd62nbIAR6WkmtpQBWiRtCau9D7mCg9FkjjcbcmwzDZ9/E+7vrQvbaL0LQLe9uXofc8ggICAgIiNAPIPP4c64pXvLQ8zhgbCHoi254S9A3/mseunyJZ7wSNN9jXMM9gtxLAbn/zjB81u94v70m1FPzVaireinravoZkTsCAgICQtoSug2S+Q2PvCzxPCbyDDYgOeM4rNNOR1wjwMW4lrcLc8vrbeVGY065oQiQe8BeJ5+5A8ud6an/Di0vBAQEBIR4IaF56JCcCy+7+/+GX/ugTObRasT8SqICRpssatPY6Sf3e4vxdsixcnFHr1seHqfD+4MBdcbiuTfbpi751jZtySrDiLl3U4bsSrTMEBAQEBBS1kLHSZIacfMT79rmnbOI97rlSPPD/xKB4yq1NpLpYflXdWbpNAnjEjiU4Wfu6oyS4zSZZceJJSc9wnpa1wOr/dNQ957PeL99L1p2CAgICAgpQeiUwWwruvr+F21zFy7iPc6jo02+fy76gUboioIksHIaHEYQKkDucwC5zxFLT3mMdbesg6VnQ917l/EBRO4ICAgICElK6NrCsvGldz+7VJNTVMT73EfJkhJMayuLQujKLZAjSX3JnVZnls7R2MrniFzgCdbdukYmd3vNl7y/G5E7AgICAkJyEDok8/J7X/yazswZJgSPvrqqJAiYcdSkuZHXBcbdIh2Jy15R5E5SgNznarIq5ops4C+A3H8Ode9eGuqu+Yr3d1WjpYmAgICAoEhCN46ZeuKIGx97m84cNkwMQTIfXBCbJPD9DspZR8N3B6POMUxKjpE/SO6CbLmr1Zkl8zS2snliafAx1tOyHqbByW55f/cetEyTHzhO0pQxZwIM3iRpXbY6s2z+kSihOPh5sLZZGH8hiQILkzoExtsphFzNaFQRENIYUeRHXAg9+9TFtxdd+f+elAQOE0MB7JhyxiPy0HulHkEl98SEueU16gxguWeWzxXLQo8FO3d+AAPqGEfDCpH129EqThJNWZdZqrIMn0NqzHlqW+kCgtZn0vrsit6lj/dmWh5RD4JeJdU4ct49vf8PCJ31usSQp0lgPJ2ss3GlKDB+pqf+KyHoaISkr/SxIVT6LILSmpNG+U56uS9wQAFsGorPIjWmApxQaYZ+7nAMpv2mkApPkFrLcDxG8V2iKMF95AD/dMSV0LNPW3z78Cv/+KTI9qZ2HQuZSzyLaQrLxqlsucWsfX9jX/MHjB/Wa+4m++7rQ+44rtLlT16sy5u8WAg5OyCphzp3fcQ46r8TuaATQ1AUaGNulSarYoEma/Q54N9TcEpNwP0se4/gvML1f4DED2ZDHK3QwzABI2idhVQZLTRegGlzxp0CNXVgxIu8r7Na4PxdjL1mGfTuQCteiYWOjCOO/6NxxLybUfXkeNAKhXG+jpquNc+MOUIN8pCwjrvgv8DgmC0Nsd4IFdxA++b/Ond+eBVYz1zSjztJa7OmXvsTUOhzhraCaS/c/hCmL5zxMPjnQ3EhdKDE6YuuvO852/Hn/vZXMj9WTVPEKL3JTGj0xr7XhYCjVvB3N8DyrIMTlAomd743qJ9UG3MAuV8MyP1iIejsYhx13wY7d/2Pde5bicg9gdYmmBd93uSrNMPGnEUb86YStIY8mL74y5HK0C2IgxsBO+iu//XzcYI25VXSOFGpzRp9glgWfEwIupvlKoaduz5mXU0/Kcd6JwjwB77QAorDUIPX0Ml5qCHAuZOGdu4ksJD1RTMvZV0tG/0ta/8vRca+d6xi4YmCBmyUDRQTQidUal3J7f/82DrjlJN5r2soFMMwUo88RweE5hJZfw9myB6ZqvtSVogOKEWkxpitK5h2ia5g6iVAmekGFvvyUOfuDxnnvh9ELuBAUiwu1vgEw4i5v9fYyk8j1SYrFEhykSEumKgV8ovV3+vdIVSU3lZqNObcbCiadTMf6Kn3t65/KdS9Zxnv69qVeE1VGlK5gDDwUGNDGTEsl9+OzdzBvWMZfdbfOF/HNniUlAJjH7Ox6v3M/h885ISuyswZPvyaB16yTJ1/8tHmmB+ZYkJAKz2jXzI6Ed/yr4ohd7UpC5D7Yl3+lMXAcm9nHA3fHjhzh+TegyTaECurtDbDWHLSg/qiGdfjpIqGVrgiXccyZ/bpP6DLLLGMOusJsfTkP4e6dv0v2LlrabBz5/9k0wgBQRmCDQg0mrZUnvN8z4bXThIYTxsalKPDkBK6vnTczNK7nv1UZc3KEvr2MR9CIUVodJhp3MxT/XXb14S9xbO+9FTAgTzmfyH3PH3B1Mt1+ZMvP0Du3wOh/XGou/pTJLiPHbq8SVeYyk/9M6m1Fsju9CQ6A/6liiGOq7R5ky4Bz3IJ42zc4Nu36olg166PsaTI+0RIeXkmcJjKVDjKVHH6P5zb37sIjchRGhxDSeZl9zz/BW2xZQmh+MfhhHr2Lkv2YPehIHe5rjwgG1JjytMVTrs0Y/wlHxK0Pgst9cEDEHgJGMf3rOMveh0oTQVyXEOyuosPxGXAJkgqy/CpGZMu/1/W9BvWa3PGnY/FumUhAsIRQOQCmD5/8oXm8tOfRKORAELPPvXi2wCZL6MMFovIxP4MURKjdHFJqWi4IRkjmdiFkKslGVKZFGyVX5U144ZVuryJF0AiTKVl1utlkIl9csaEy97PmnHjWkDsF6JZR0g4qYO1aRgx9za1rex0NBpxJPTcc5b8qfjah/5J6oxWkY1DQBCwMCij1RZ5GccpFTIwIsYEpqy429ZJfBAFyg0C+sLpN1urLnyVVBnzUjnFqjcaXyb2aRkTL3vXOu6Ct2ljThVaAQiJW5S9oZ0ZVRe9Q6oNOWhA4kDokMwLFt/5IB/wwaYpWDwIVeI4zDR2+qmR1zlf1y4gmERE6v00HRINwqDI/EZL5aJn+nbQS3kZesBih9kT0A1vKD7ubrQSEBK2HsG+I1QGs7Xq4g+xdD9PjSWhA2vcUnLbkx/nX/S7B+UyrvGOp4kSwMN62jcDK0NEfN6f0dEYHC2ZT7sJkPlzmFwQJv1ixeRgP4JSW8Ys/Ktt6rUrKUN2JVoVCIlSMjW28lnGkfMeQKMRA0IntQZz6V3PfJ45d+E5IstErcQae82tf5UaXE5bQ9wVZUeg2IKjJfOx5z0rW+bpHPgNq89xIUxtKzs+e+Yt63X5k65EqwMhEYABnKby0+5XZ5acgkZjCAldkzdiTOndzy4zVc2aPdQFY46cnwQgZHLz1dn5IyMMUQK5Zfoj2F29FI3CEZJ5wdTrLZWAzIX0tMyjW+sMPLXRWcdd+Jp13Plv4yStQ6OCEOdVCFkdyxh/8dukxjIcjccQELqxctrJox95Zy34e3ZMcsyP2HAQMNqcaVVZhxWGXecCPULQUY+OjCMFcnrm5x8tKH3WKHPFGX+Ta6kiMg9fQ7AKnsDBuIJLMiddsVxWnhEQ4iz3SbXJZqk85yWcVBnQiBwDoQMSP6n0rmc+IbR6oxgKKGJyo5R/dfKBnjoMyZpwxKjbT2oNEaXOmLD4E5zWGWLRSCFlrCTYEQuWjZVQzVaE+AO63rU5VaeYR535DBqNQRI6jGQvvevZT0i1TiexjHKEMEWrokhmGk1puG0lm1YIh1ZYS096lDYVVEgoXX/g/UbSGOdpq3PXfnU3hvqeIiSK1GHRmYJpl+vypyxBo3GUhF5w8e1/L7zs9w8StEovckohcwnDaTVmnjh3YTTbHU3pr4a5EHTZWVfTj2g0BgbsW64vnH49zMNGGGgx9fZkd+3+5DqJZzxoQBASaaOA/xDmitP/Shmyx6IBOQyhw8h1XKMzF1x615O5591wJ+93KzJQGldptJHXQl17P0PHe2H6jSiJPGKqQzCVefTCFwmVXo90wUMICUqH+Rp/ehb2BkCjgZB4scbDtsXmjHEXvoOOFA9B6JC4VZnD8orvem5l7jlLbhf8XoXWrMZhsFc/ogLWgwtNaVTzCiEK1BkjTtRkVZyIrPNDrB5ShTGO2g3e+u9RHjCCckhdLllcONYy5pxX0WgMZKED2V9y25MfGEZNntAbya7MozKooamzCkqAchaunRGkGuWi951POaYADcgAMAyfc6fs0UEnwgOoggQUnH7Xzo+uhkGnaEQQlARY711fOO232pzxi9FoRLPQeQ5jutoalF6LBN6nvmTsdJyi1GETzHjaJZHjEYf1VnyV67iLfBAt8/4gtdaRKmvxHDEBMYOwXAIMMsPB8iVo7YAvaB3LPyeXV4j/mobf76n79lHO17kDrRgE5RGBJL+sYxe9QmkzStCARPRDlzhWJnTcVo5hCo/4PZC2FmZbsa7m1SLr8+O0zoyle2YNsK6EkKsJdaGLDl3exMtJjdkIo2bjNR8EIEiY0837uvYBi7cTEOVeztu+aSCVTGOrOJOgNUac1mbR+qwS6HCRDhTZiHV6nexq76ld62tc9ThaLQiK5QGwF3BKo7FOXLzUvvb5yVIqd1E6WkIHFi8Waq/fLZXOAu8Qyu75LIqiJES4EmRTBp0Zh48HQjRobKMWSmIcrHOwHAlgiQshr8fXuvGdUNfuTxhX45ojiRb3N//89AFyNVA6W4naVnqGylQwmTblTaR0mSPh9MJnGHJyh652geVduz9dEqN1ScJYpkTHM/WWrZZiPP1kQh2G8jhDN08qkzowPtXmojGmitOfdO/5/OZ0rtlMRU5+sLl2m8gDnqRUSiZzjDSYjSpb7nCms6UuTHoiEutrZqG8/CiArUFpc97YmB8tycJcwrwNPzzla1r9tBB07hukwPIBS34bfB3Q09S0uXCmdtiYRZrsynNpQ3aBXHt+iI4PYFS7e/dH98fK1S7BIlBBV4eU4AQMnNZmgLFUxZDUJYHxdCeUYGD6KuNpT/U9DZN5jCNPuIEPOOr9Tav/gQhdttBpjLXvbw+1N+zVlldVSJwyo3+hRaKyZpm1hWXj+hK6JITcnKdtA2woIQnpnYYEZQjrqP8O0XcUQjflTSFIFR3TjD65tQCBOXd8cE2gbdOrQ7v+eYZ17lsJX976FQ+rbeWn6Qum3aDOLJkFdVqZ2AfJITitwQJt6z/yNa/5Z6yGxrtvxcPexlWPJToaMWPS5V9pMsuPi0lBoV4vB2Pf8PIcQKhtCVRbsN7Kfql+BilBRREzl536IOdp3wz2xoq0J3S4CHmf28N5ejqBtV6h5BUA3WXAwuIjiJ6VNw/KRZcXuBB0NKBx6A+VuWj2IDsHH6EMxWGEuAjIfMlQk3k/y4QL2IP7t74FX5qsUWfqC2fcqLIOn0eqDFoRpuMdhRyHzi0h4Oxw7/3iNkmMXS4f3KeKCNKRpJjHl0g84wMKVgDtuvgYMQSlNljGnP0cUKSOF1l/d7qNARFF+8e8O9cux6kkyNeP1rsVudz7jAVyuUdZHmrYiCWWsYIw+M1VvfSOWJN5JELdez7v2fzvM7rXPT/V1/zz60DCsXh4IsihLTmcxDx7l90jhNwt6bIc4rDgUOGTOALqirS5YLR59MIX0vH5o5opnKOrDRYZU/ZWxDHT+DkLEKEPPD5ImERVclSA0MfEqjIcXH6sq3mHv2Xdc4l6RNhAxbXro6t6Nv37DNbR8GNv+tuhY2Jg4B6w8j8J7N/2BlokCEltqXNBTJc7YZGh+Lh70p7QCVqN+as3rhD8HkHpfECbMoZFXmN76pYjLicxPuBo53z7t6HtHTk2sNhO7FytkDhDXdWfKCFdkHHUf9e97oW5ji1vLGJdTRsIWhdVx4NKCB9y9bj3fH4LWiEIKUHqkoCZSk96QGWBx2vpbKHD82eO8XFueI6u7LNoke8ftSeE3E2ItXCgpYa8Ihuwo60dDlVG8XGkxpIJN3xMxl1gMMbV+JOSnjnYuetj+/qXj3fvWfYAPFfEKU3YPcOXY+t/fyMwnla0QhBSAqIAAzx11rHnv4mTQJNNV0LHYTVVNtgTaqndjis5dU0SMcpgygD3G+5iR+VffzFFMdSpJpr3QgX+g8duWQoYH3TUK2+7cEFvw/d/7l7/0vHBzp1LCUjqOInBv337Vj0NI+bR6kBIKSudZzHaMGxExoTFH+NEXy02nSz0Awg0125Xco0W2M5VXzp+NqkzWiIm0SeJPKqOhgLiBtrmMY8NwTHlnlXx/u5qx+b/nOvc+b8bMJF3s572Wm/9939C6wIhNQ11BtMOqzpFXzz7rnR43gEDyIJNezZjCne5RyvYwLqafxaCzi5Ka8mLdXlM5ZI5gQkBew0WkehbmaMdx/IiW2tn9qKtHjs6TwIXn+hvWfdCyF7zFbBctCIfQl0KEVKX1LkAZilf8GfO076Jsdd+mZYWOqwYx7ntPkUHxkkAvTXdw+Yv7SkFzBnrblnbW1DiV9wwM+vm72+s+KEiSzMabfPYGP8ErcHUGSUnJcPtAsW3EVrsaOIQUnxjykFy1srzXqK0GaVpSeiso6tVDPpDSnW7wxR0ymDW6opHTY58Jhy5m6PWb56Yp5tckKketvbWUesvn5x5JdrosTAHRCzdImsREBRP6SKPUXpbgWnUgv9L5fN0YmA3BRP01Wz9kVCpFTpDwBrSGlTq7MLS8MsCy/k6tstNEdKXznuDvyLAixKPcSJmUhGGVy4c/tp1M2zXEziGctWHlM85TJ1ZOo+g9VloNBAQFLQ3YX563sQzDCOOvy9Vn5E6lAnMuR2dpFYf6blVDEi1Nqoqxgd6anFaOz89Y91xuSEDF+jvShXE3lwthgfKEGDyFy4sfn7uSOOJl73TeLEYkzwuZfouYmwKYKTKYDGPPvNp5/b3LsESXbAcAQGhD6kHMFPJifdwnrZNoe49n6YPoQN0fPzig57tqz/DRIUeS5MkFmys3h552d+y9jnGXvsZJqVjUBwu98xmHQ3f971q1pCWbAOVfbAAIPw7FBSwS6bazldROPmHZW331PcwdSk/PLBzSa+GGjNih+UndflTLxICPXWeuu/+hGFS2sd1ICAoY/+DrU9SKvPohU9xvs5tMI4kbQid8zg63VtWfZFsD8X7unbCF1q9v6LYqh5Rka0p5YRfDUb4r2CQx34zMWPR1EL9zLNfq1uwbX9wSyqPA+NoWiWEXA5SZcyMpVNC4oOYqfz0P5Ja6wjXro+vkUQ+hFYhAoIydHrKkF1sGXPOyz2bXj85lZ4NFR5JEwiAvYQByvMHgaVeaFHl/nhzxY83zcq6NbUVdJ6NlxMcuvd0BVMWZ828eYMuf8pVMEUMrUQEBAXIAS6IabJGn2QeddbziNARkg6Ayw/p9mU4EdNShP7ZRUVP3Xpc9h0UgadqkxsYN+mNVzXB3mpVOWMzqi58NWvmTRt0eZOvINXGHLQiERASLAhEFjOOmHu9JrvyvFR5psMKbVhaldSZrIqWz36PUxJ/rSID0xJwSmOWc4jSsQysKHCRxUK0NK6F4WCHim+E7nhoxT+1aPg/Tiw1nXzRmw2LgrwYTKlNLLB+1tX4E23MKZbiVFBQEjn5RRtzK63jL3xdZLyOQNvm/4S6q5eyrua1yB2PgPCL9O6NW41H2AkQhkBUYtaqC97qXvP0Dj7QU5PyhK4tLK0q/+PrK+XmUQqLdofNY0Se5/c+sHgS093eePA6qTEX2aZeuwInaSMmpVeQMUw/BySx2b7x1Xl9r58+yrRApSZl9/phLHksFOSxheMsp628sfzHWz5uvnl9S2BtKo0RH3Q1JkaZ6K2BBJTNDOPIebcbiufczvk693Ke9q0w4pZx1H8Lm6cgoY6QrmQOrOagJAosqdKb41LpUxJgPwONterCN+0bXp0vCYwvpQkdI4CJrjcZlUvoXG+/0L4CG2haIh/00lprngK6WMad0AlaY4m8TpP4ERfbkYPlQgI2rdgw+fOry5ad9VrdgnXN/pQh9VDXrv8BQr0LjJYmIVllwProNcpx2DyigjblV+gKplwohNw9jKPhO97TviXYvedz3teJAjsR0kh4AULnGY+3YcVD5lFn/hMIeHU8OEcSWFjdcZqp5MSH3TVf3pHShB5qqd8RaK6p0RWWlYs8o6y7B5MtAQtdEng2ynui7LZJt4wh6EaKYuUJInbU6i4k9QwdlfHt9eXfPfLN/sefWNHxSCoMEeft2A6s9E5abxueWIVP6m2bfuAeCFqXqcubeAGeN+kCQ8mJfxYCjlrGue9bztO2hbHXfoPamyKkvkGiMgRaN74E9kKWefTCh4Asi8v3wgBWY+n821l3y7pg5873UpbQRY4J8R5HN0YQ5UokL0KlITS5xaPYns6WcGUvPcu/wjruIXtNv1RDvYrQD+bzWF7ENCSu+8tZBX+mCJz468qOxzlB4pJ9nBj73s9UxpybFeXBgTooUJql3nmkaGPOaJW5YDSsKwCsdxfv69rN9NQt47ztWxln40/QmkEUgJByMozSZvgaf/wLbS6arsutOgNWeIsLqQNL3TJ20b9gfwPO17k9GcfuiKLcPTvXLcdp5fVGl+Tyr3pCN6JyauR7fNDRgKVvO3ApXLnB8JPLTadL3ODcVzBYjmEE7JEF+Q99eU3ZtyYNaU728Qm0bngZlmlVbNCk1Gu9Q9c8JHlgsVjUmaWzzKMWPJo5+cpl2TNv3p4xYfGn+vwpV5MacyGW3rWOEVKK0XESnqN79n5+K++3t+JEnBJuRAEjVcYM8+iFz+HgHylL6FzP/maJB2ygxEYtUPD177iGMa7GVYruFBe73SCH+fdzxRxjGpocLBcSsPkVprkrbyhfOW+kcX4yjxLn79rF2utW4JQqOW4YWu/AgoDWilwYQ5c5XJs7fqG16sJXsmfftitrxk0bTKUn/5k25U9FjICQCuADjjrnro+uk8VZnIwzqEBrsirmWMf95q2UJXTf3i2rxFAQV2rntWh90dPV5S5JgiRygZ5oes9QmP3wXH1igX7Cp1eVfHpiqfGkZB4o776VjyZrUiOMAIaWOxRA0JpQmQsmmspO+WPWjBvWA+t9i7Fk/oO0MW8SogWEZAZjr/kCkPptcbPSsd4mLtqcqoX6opm3pSShC0Gfm7W3N+Kk8mqNSMA4N42beXp/Q5Wg0m71Ay0WkDnP9NR/F0nmhyssczQIMoJ8Jr/06tLPHj4177GkFRaOfd/7m9e+QVDq5J532XrneiPngdZFmwommMtP+xMg9k2Zk6/8Wpc/5RpSbcpH9ICQjPA3//x/wY4dn8d1n4I9Za444wnakDM+5Qid97l7GHvbPiUSOmQrymi19RfWDd9LcvB7OvZcC3eljM3RVpVmqotYYehSQFhewlQ4rrn/9Lx7/3JG/t9pAk9Cj4gkeeq/u1/kQgyWMsczklzERj57B0JJkzXqlIyqC18eNuf2akvluS/SxpxxiCIQkg3OHe9dxPm6GqN0hY4RnwswBViVMfHSpeA79ckyTkd8MOHbu3U1rtAgM2Cd9DtDFxlPm5SeTa76aTCZespm0BA6cYhzOvkDHdvumZ9758obK37MNlDDkm2whJC72bnzw6vlmDI81ZQ/qffcHVrupMpoKJq1JGvmzZtt05as1mSPPhvRBELSrGSB8zt3vH+pxIeC8VK+DzRxKbJWnvt6yhE609lSq8ygOBEjtAYjodaGa1HwDB1Py47o/Vhb7oMeo/oMUEeALvhZIw3TYb76aRWmBck2YMGObW/7W9e9kdK9U34pZoNR6oySWZmTrvgEEPsPgNjPQXSBkAxgXc2rPXXfPhzPhA4Yp6IrmHq+Ln/KtSlF6P66bat5jyMIq7MpCbBSnLagpEKTVzwqXH7xIWCdBNPJ5Q7DBjh32zqR8bb3I/RYk2JIwMblaCs/vrL0k4WVlnOTbexcuz6+EpD6u0l/nn4EGhi02g9Ux5oLiP1j25SrV1D6rNGIMhCUDpifHty/7ROcjp/yDQuqWSoXvUgbcyemDKHDc3Qh6PdjhALd7tBMlML9yUKgp47ztG9R5Ll/7CgdapRe6WDR8AM4pdx0GkbEXrEJsiJG4Rj17mUj3vvbmQVPJhnRie7qz27k/PY2gk6PLqe/ELutfF72zFs2mivO+AdO0noMAUHJynf1p9dx7tY9cVO+JRHDcQK3jr/oHSAbMlKC0IWAz+2r3/EzQSvTgpEEgUdLHcOiFRjJNdK58XJUwCI0JIbTd52Ue/urFxa/nmeiC5Jl6EQu6LRvePm4QNvm93tJPT28O5DUMYLUGUeecEfW9BvWUjpbBdpICIrdp6y/y1299CZgOQfiFdcFA01VpvwKU/np/1BysM2RjwawgFl7e5MiOYwgMNqaldf/OqlKx/UeeYEXpbgqO7AFazDAY1fNzLri2+vKVwy3qkYky+AJQec+x7Z3Lva3bniHoDRY2lQbPHDGTpvyx2bPumWDLm/C5Yg6EJQKmMXk3P7elbhspceHX2F+uqF49hWm0vmKTdU9Kmnl273hO6WdoUN3O06rMVPl9JMj32LdbRvwNCr/igPFMdi957MoVnNCaq9DUh+doyn9ekn58rMrzYuSid2AsFjs2P7uNZDj8TTSC6G1DgvVWMae/x9T6cmPYnj61k9GUDaCnTvf9+774V94HONeRC6EGUbMu12TVXFm0hM6272/kfO6FHmOLolCv8Avzrt/a7pFuktcyNX3/ykSp8uzNaNgZZlEIMCIWIVNXfrRFaUfLhpnOT+ZhjLQtvHV7rXPz2JdTZug0EiXUsK9DWskzFxx+n3WsRe8jUgdQanw7P3qLs7dsjtuSjc8TydptWXMOS8QKoPi0nSPaqMG2xp2816XT3mCDY9azz0tXe54eM12NYmrx+dpJ4iClKCZAeuGEzGCJrBkTGnjPK3ru9e9MBNY7FcLXNApn62nQx8UScIE1o/pC6deZB13/ttpenyFoHjlkws6tr61UOKZUPzy01mM0tnyM6oueDepCR36dHl3T4fS3O4wqFtfNn42HqFp9NZzT7dc9PAUNRj/r4h2p4KI1dqZmmSVGoG2Ta91r3l6gqfu279KfKAHEns6VBeG54b6wpkX6Qpn3oroA0GJ4AOOeteuD6+VHUlx8sjKTVxsFfOMJfP/nLSELvEs46/ftQ5XWKQ7LNOnzi4YKR8i9wHrbd8MBp5PC7c7WMw84/Gwjn0rwxa7KHFigkvm4fIcSdgP9b7vk3mIYVU5T81X93SteWaip+67v/P+7r04qcZ69cbUXWNAncEso854TJ1ZcjKiDwQlIrB/21v+lvVvxNORBI+mTCXz71NbR8xLTgsdINhauwNTYIaYxHNsZC46ELh7JIHh08ZKl0RRgn7SPijL1FRYdbQpQR73A54SDAtxEssKIpMKwwyIvcVT8+XdXcBid25/53LW1bwedm+DUfEp2eQP6oM4QVlGn/0cqbEUIfpAUCJcuz++inW37JKzU+KxLeR9gRPWCRd/oJT89KMm9EDj3s2YKCluMnGKonBapQ4nEihdifTyuUcEMI3K0oy26mmDkMA5U1EEVtfDNG1tD25JLZ7jQ4H2LW92r/3XdPCa7N77xf2sq2kdtNp/IfcUsdzhsRZtLigzlZ3yV0QdCMpcpJLg3P7eRXzA3hqv4zBopZNqi806/uL3cUptSjpCZzqaakLdre1KskQkYJxrcoYX6UrGTouc4QMhu2lC5kQ/BuFEicOkxCpg8I4aney+VB56zrt/m7dhxSPda5+fYd/48mm+ptUvs87GtZiECfJ5ewqQO3S9a3OrzqUN2ZWIPRAUuQ99XTtduz+5CYtjsyVJYDDtsHHzTSUnPph0hM77XHbe53YpLtIdJ4FBHl7nVWB9Hay7aXVKukH7cTmF8d79WyTw0GFjEIc67ocFhWPrmn0/p4tQYey1XwOhsgRGx3evfXaSa8/n97HOpg2YKEkwvUa23pMxoA4ohgRJq8yjF76QPhV3EJINoe69Sz01Xz5I0Lr4KbusHzOMPOF2Xe74yw6K5ISI2sH8km/3+m8NZVVjME5J0yhBS52JEECCBCvrp4NxDuQrrHIW+byZeioz0dY5x4rYro7QjrS0GLwd2+HL17DycUpnK1dZimbRpvyJGlvZGZQ+q/SXVBuRhyEQGIZJin4eUeAwlbV4BmUYNo73dWxD9IGgRPiafvqbyjp8ljZ7zCnxoQAJbg7MVLHgr6ynfSPvt+9JBKkPitA5Z3cbbHqipMYnOEVj2qKKCb69W34Mt1xpjWxMpLhBIZdwj9Kt4Mwx5nMwEsfoBIUSyF4vsNZ3dQR3pLuQ4QP2GvjC2jf/20NQ99DG3PEq64gTaHP+BJW5cBapsRQCCxiqphgMPJUU4FyJZqXjtJYyFM24xbX7k2sQdSAoEZLABcD6vE5lKthAqHQ2mAkV8+8ESjmlteaYx5z9vGPzG2dKsAB8MhC6e9tPXzBdbff2Zjkrw6IggeWgLSwd10/58HXuVFtHThWFFDfUwYKFndYiL3sYwePy8a4QmxhyoIAi0e3nnX5W9CMxE7b5Q6y7ZR189SqelJo2F0ynTXkT1Jbi2cCSn0fqMrJxWDQJzu2B6m0KEZaYOrP0VJxUGSKPeBAQlAIh6Gp0bH/3Utu0JV9hcfJ+9eanlx9vGb3webjHk4LQg237du+886wSHMMVI2SgKShGutwhoe398k5fww+PKN2VOQQDAIU+G3n1tk9abvj95223SglSvGBpgBAnhgKcGEAi5pAEz7DOxlXw5W9a8zRBaSyqzJITVab8KZqsUQtoQ04VjAWRZNe8kNh9B76f0tsKVJbCmUxP/Tdo9hCUCqan7mtPzdePmCtO/yMskhSXvQzEsDZ3/KW9R77xNaQG5zOXRFHwexxJIyu5gCNdF7SPFX0YK6KdnWQAyr0r1LnrI/jy1H37gMpcAIh99EJNVsVZtGHYWAwW0EiYW16Sj3i0OeMuQoSOoHR4G1Y8rMksOUmVWTpDitd5OjR2cSzukeMoUhUBIQnMd9bVvNZT+/V9XT8/OwFGz/ub1/4HZnEkKmIeFtWgdFmobzpCUph0PVveWsB59tfAGhHxUnoTAUToCAjJJZwE1t2y1rXroyu6Vj811lX96Z180NnYW1s+fgaBJPEYZcgaQ6rNBWhSEJQO6KV1V396o8iHfKncPHDwqj0OhoVWa5Ul7GBcIRPsd6dypHuK138Fjx4tCENLE3COEvLs8Et5WIxWkBgMIRZCqsfX+NOTgdaNr+kKpi4xFM+5ldJm5ol8MB7rDQNKhBWPV51NBIRjBONo+M5b982jljFnPy7F6Tw9aQidNttyK+5/dTWh0qh782cTC5wkMc7tcNT8+cqZQijwS7Q3QamNtmlLfiZog1WRaUBD8ezAMhOCzjb7hldm9w2Ms+mprJXXl68xqkk9n4CgOK2KxD7f5fpmyf+afovESQyJnQ+5fI0//hWet5sqTn9MlzfpfFjVLQ4rTyJU+mws2FOHZgEhGQD2yV9oU95EfcG0C+KzR5KE0Hmvs5t3OzpNVbOnC4wSBgbH1NmFuYaKSXPd235aFkZ3GstwUmXQpzKhY6KIR1riJ5Ya51cW6kpFVkxIdiGpJrEcI5WDxEh8wAcddY6tb1/A+7sfM5bMv1dOg43VxPda6Lg6c+RJrLt5DRp9hGQBzHyijXnjaWNOBextjggd7meB59iejibw93SJV0jJOJUaIzR6Y5j1IrBe6GrR5YxfGO8UgnhCihKEYVQTZvg3wycmQEMrStiyas9SJELiLLBql99Hqk1FusJpi2Me1ZuqWjJCykJgPK3u6k9usE299mu5/4WUOllAxxQd4N6++iuMVFCAAezFwrPhKhdgcZH121O6Jzos+xpyNWIRfc8FCeMTmn4PhrzHz9uRCIk/XNVLr+MD9nYsGWvGIyDEGIxj3wpX9We/j2e9d8UTOufsahWZEKckslRlDCvs/5SUOpUXJ8wJ5lwtayRYwqvvY+OJy2IgwZc7vbxvR0dwe1JuDFqbQWqtI5J1TUgC6/c3/fw0kQaNiRAQBgN/y/rn/M1r3ibI1KGHYxL4/vqd63ivK6iczmsSZqqaeWrkVWChd6X86pRbp4ZjwSjLQmimJ2RhAR3PzwihZhfblHRDSalNmZOu+DJrxo0/U4bsMcm6JDhP2wZJ4HksxRM8EBAGqfVyzp3/+y3rbauGXRDTntAlnueYjuYaJTVpkQShX/9zpmfvMklK7WppeJQesSY1aU6YhU4R2Jom308sn3wpa8YR8+5X28qmkSrjsKzpN/yoL5x2QzKuCdbTukFg3C4cdTpFQBiAMCTBsfWd3wCjz4unwPHUMe10mPMdat9XjdNKcevJjSz4aOZrii9K2Mlrb+RlIYEBS/AUpt3DtQlJFjRlHDH3/xlL598lsgFYYAr2Ls+wjDn3X5ax5/2boHWZybUwcGSaIyAcBry/a7e75su75e2S5FvmmInOV7t1NbCKlcFrHIvpiiomknqTNYLPqVTmdMiZjKtxVb+FKkp8wm5KlLAv93iWJdM4qqwj5pkqFjzSG4rQe1QhN0MB42sonPHb7Fm3bFWZC2cmz8KAaR0xT1hESgNC0iPQuuFF8HqLIJO7TtIxsxzT2VKrlBaqUH7RGdn5hFqjC9fAuneLIXdPKrse8YhDoCw9lVWRpRnFC4mbm2Ryt9Om/CmZEy55D4MOhcjjGbC+YRE+UmstsE1bssJYetKDOEnrFb+5aV0mTtCqGNeVTvU2hghpAlf1Z9czzn1b8CSOoT5mhgs07tnMdrd14AqJppXP0CN6hQpBV5PI+l2pa6XLNWXCLCWrlswotKgKBDH+8lZF4ti+HqZ9c3tgU1KMHmC+jAmXfEhqTNmHqlUgW+44oTaXn/Yn25Srv9HYyk5TtMfBVDCNVJvNMYkfge2K+ZAE21MiKkBIBcDMENfuT64TGV+PcgK940zoQtDv4X1uF0YohCxhLnpkYFyvy51MzWWIy9GJUkQFEREalWJiIgGh3uQI8E4fI3iUT+aU2lp14TuULqsoSjv5KOtLxGBfZZW1eGbmlGu+tIw550VKm1GixGdTZ486GyyDWG42XOQZN6IChFQBzAxx13z5x16HZ/KdJh07C0ui6N2z8XvZs5dwLhcx0mhWGcrHz45uXqUgnQNdhfN11nDe/VvDFqYgcYk6CSEoAvuuzrdclJTujsVxQOYf6PImLJSEozsdgMsJvgzDZy/JmnXLZvOoBU+SalO+cqzz/Km6vIkXxWzZA61NZPzdYNx8iAYQUgmB1g0vAFJ/BPb0Sj9CB2Dt+5sUUT4P1pdWqcl+xWVgG7Keuq/xVK2aBaO2Ivyq04frZ2rUBJ4oUmcFSfFFkvWF028GpHeWOOjOS71n60CbNxlLTrzdNv26H/UFU68D6yyxXQjBDZgrz30FJ2gqVvsSFjPiA/YagfHuRxSAkGrwNqx8JNS9d02y5acPCaF7qzeukKCXWwkh/9DlznFsf0dCivbLOyhdI1BqU5dRNI5Lcb8VDBM4CVu+1/OVkodMlz9liaXy3KfFoah1Dt3wbACjtBkjrOMueCFrxo0bAME/QGqtxXHf0CpDTkbVhf9VmYuqYtl4AgcTzXn3b0GiHyElIQqMc/u7F4ic35tM5ZOHhNB5d08H5+zuVsoxNaENb9By4GqKmuc4rF/vjbwKXe6JcHhDQg+yItvt4zqVOmKULrPcPOrMJ2XrdQgtWJjiBi122phbaa5Y8FD2zFu2mEcvfFqdWXYS0PRjHhWvHTb2gqyZN63X5U08/2iPEAYDxtX0E5L8CKkKgfG2Obe9exFUXpMlQ2poXO49nS2so7MD9iRPuIHO85h54tyzogjbUErSORjzkL3my35KVoJy0NUkge3pDtbstYf2KJPMbeWZU676mqA0ekjAMVmDkNi5ACwhazEWH3eLberV38Acdsvos59TZ5aeDOvED6EGRWqyRy+0jrvg7YyJl75HaSyFYqw7rMnNgNxu1tH4AxL7CKkMIFu/8Das/GeUytrKNFaG6oP8dTvWGMonjgN6uwLUlP6uAsa+53Np5An39kYuplrqbP9qbAVmVWFCHhMMb7OTbZSUGRCHWyrPfY0yDCuW4nECA13xsh6JQ0WilC7OKdUXTb8RZsewzqYfRNbXHequ/lQSRZ51N//c+8Py+pQkMdxfLpf2lc0ECYPBd5Qxb6wmq/wc2pg7Xm0tniTJyiwbl7UNbyXU1bgS3H8nhoCQ4vDUfHUH2GNz1NaRU0VB2aU1hozQmc7WekwhLnfYqz1dLPQD0r7fPM4baTwxIY1ZKBxbtc+3UnlDRNKWynNeUdvKZktxD6eQeivOyR4BHBZ8sWhzq86G7+iHz7oGxn0IgZ4OCdaaldMQBRjEuRw7aGoTJA0s+1PBNNPws4CFbwWkbpAO6HIxt8j7DyYW7Nz5IYaKyiCkCRzb/rsoe8YtWwiN0abkhKkhI3Tvno0rxaAXk/PRxcRFvMMytGpb3gjKaLHxXpc9zKyQDZwUa9Ii94APuSIvJ8LlDm1LUZCkACv6lTZMhuLZv9cPn3M5sCoTPWEH5iychEmtJafvSBqNuddFKKS/8Kd0oHJdQhQjoLQLfvt+xl77JRLzCOkCIeRpdVV/epN1/EVvgk2gUiqPDNlJP+9xdIlMMJToSHcYba/Ozi+izZk5fa+LjK9DZLw9KVUtrrdaFxay1/aLKBcS0F6OAPfDMiL+fZ33WyUNkza78jfG0pP/CM+1FauXiUKfV29wXd9Xr4UvHCjPnjhhAtN4/M0/PwvG0o7EPEI6Idi5833P3i/vI2itYu9xyNiNdXS2+PdVbyToxNfBhVZ6ZNc1IeRq4oM9jTiRkuVfw1yfFi1ptekoqxjnJHQ4tB1ersPLiIqpEKe2Fh9nnXDJOzjsupDiLXTjYZ3zwDr3t6x/Do0GQjrC37L2abD+P8AVSupDx27AIox2dp1I8RNVIqWorO37P+VZmoqyLE0xG+czdIrCsT3doT1dPq5LMYSeVbGQVJsoSURkPjTW+ZpnRD6Eyr0ipCWAoch59i67jfd17lNiobIhNVc92376IuGcCcu/avWYqWpW/8YZKdluDe9H6AJQrRLRlAUeAWxtD25W0uh461c85K5e+qjsmUnhbnuxV48pjA847P7WDS+g0UBIZwiMt9257b3LZLGrsP7pQ6picM7uNviAOJlYzQVXqTBKb+qX68v01H+jziipOlRHreSymGiMc7XsFIKuxghexUkS7w2YjhOvy98DvnNXR2iHojRqgfV56r75oxByNlnGnv+SHJAmchjC0SmNcE97ar64U+SCTjQeCOkO1t282lW99Hbr2EX/VFIR0iFlXs/uDd+H2urbSI1en0jShGkFQijQr3qaEHQ2wjaqqZLBhgs0xoecjZLIh60oXpD4Hh/v4mB3lDgROlRUcUbg2z1sqxLHyt+68WVgYdZbKhe9ShtzilO5EvCQzy2lxvwt698JtG99A40GAsIBmdKy9hl15siTtDlVCyReGfnpQ0roMNJ9970XjIOl8hKZoAq/X2RC/Vg70LbplWDHjrdTKX1WilLubEdHaHvZEztHxvteoP7gDgkupY4V42j43r7xlRNMZac9pi+cdrFM6ihQ7rBkzvs6Gl27P7kajQYCQl/hKwqunR9erjIXVpMaS3YseyckhNBl4zjgdSp3/PlQSheYOeiJECXeGRSQazTa2ARdjc7t717Cedq3mUpPehgQlkoJG1GRZE6qMCHgaHVsefNMSUAuDQSEfkYMF3T0bH7jTNuUq7+CJZ1jVU76SIGihBDSEr7GVU90r3t+Outo+BmnNChgLhqZB51t9o2vnsb5unahEUFAiA7O07bBU/vVA70B4YkNkkNSDCF9N6J3/9bu9S/N8exZ9kdJFIIErUGDcpDMQ852+6bXTuP93YjMERAOA1ibwdf88+sErUvofcQiHB0nVBpFZN2LHAtLbIl97ozE5RFPkTB32DpV5LnIsG0NTWiJOKqKcoA7gROcIHIMLzHJNYaS6N238tFQT82XxpEn3KfNGX8eWB+Ykus1x3RFURpYV76tB5K5r2snEtUICEcGT81Xd9HG3HFqa/EUMUFBckNO6JDMKx54fQ1tzc6WElZnBsdwmsbq/nbzwsC+3RsPXiVVOlvmpCu/I9T6jFQoNEIA4euuXvqHwP5fo49pEqe/WVL2w4gMVQHLxyf4jyJwzBUS3AterTulxcW2JKW17mnf7Nj69m90ebt/ayg+7i6VuXBsb6nVNCF2HMcIYJkzrsaNzh0fXInIHAHhaA3IoMNVvfTmrKnXfIMRtDERAbfU0D8UG2K6WuqNY6aNF4KJaoTRS+g4FV6HVmB8nQIX6FFZh1cmfyAUAclG5Dyt6yPfyTPR+fkWVa4QJ0KHOe+4k1V1+fiuZN+UgfYt/wl27HhPm1N1ASR22lwwDktxYof1DKCbxdey7j+uXR9fgyU6sgcBIUnBuVvXuao/uyNj/CUvJ6J3xNC73IHpy3a3N8ImKYm00OWiKjzHRbk//pcmF0kthSXoFg6JXMgRprSIkgDd3qIgYfEq/aqhCOz7Ou830OWeCpsSZkIE2je/EezY/r42d/wlhuFzblWZC6pgi3dZEZRSJO0RJ2QvD+frrPfs/eI+2HwCiWQEhGM0Cto2vwbkxTTDiLnXimx8ST0mQXHu7T9/lVglX4LWOWaqnD6/vwwjVallXuFhtXbH5+kmFVlVOVwc67jDAHGYfy5KWEoldcvE3rbpte61z05zbH/vmlB39dfypqG14Jnp5CZy8AwSz7i8dd/+zb7u+bmIzBEQhk5yeGq/uZd1Nu3A40w3ManRyrt7OsSAL4CTtE5KUOEOWLZdZcsdHnmdcTau0tjK56SEjSWzSni+VbaBztarCW2Qic+4y5F3QHlY2+xfk7rbU2ACbRtfhS+VpWimJnv0WRpbxQLaVFAFK+T96vGRFL5cKNm9LoQ8Tm/T6td9zT8/KwSd+5AARkAYWohcoMe+8fVTh825dSdB6+OWnx4TQg+21u1g7fs7NPkjR0pc4s6qJZ7tF2rIB+x7E50rODTCmYT5j7uAERlWmQ263OPOK0B3qLWHatJho7Ku5p/hC2jgD2iHVZ6ryR5zNm3MnUDrsypxUt3btxwqsQqpQCfnxkInjiTBtV8X6tr9ua95zVNC0NWExC4CQgzFIuvd79z18fUZExa/I3tS43BUF5suKsBsCbY37NIUlY3EEnWqCgaP0OiNch1Y6deRxGEty9SwzjEh6KiXBNYfprCIUlzPOlQkgdXYQ027O0PpFRUNC+h37PgAvuRzHFP+VGC5n6PJGnUmqbUUEyqDHscOLD1I8lDricfZO1gXkMRl+QG+F1jgTaynbau/Zd0zrKtpDar41meoSJUBxhBIsSgqBD4TfG7KVSyK+ZhhmF5xLcyOAaHOXR/4m9YcbyydfxMm8EM4DxL0uGniQ+hAcAVb6rZlzDnzLGCvJ8jlwWCmymknExStlvPRf5XDoQMEnwpmer/5O7nMdCpG4HG8BQzrCfAOPyv605YZJFFg3S1r4QuenVG6jBLKMGyMxla+kFAbc1TmwukEpbYQKj0VdgQlimAp8uFL8VCWfZgQlXqn/8A1WXmAagPjdbG+zt2waE6oc/dHsCsUDJ5E9B1V2P5PCPTsiI07lJCjcoHC7U2lMYOxFry/a3PMxgwIbinekWQxhnvvsltFLuQkdZb8oSqBwoU4jHWX/xwfQgfw121fKzKhXmUrUVHBBNFPjWQc9d+CPebHKY0h2RtzRAvwyzfTBXG9BwrHvqn1fono4Vdtlg/01MFXqGv3UnkZUhoTqbWOpAzZ5cDAKVRnlhwP6yCQGnMRbciu6EvyBK3VRNHT5D0ksH72IOPDGBHW3bZbZH1tQEf1hbr3LsUkgWecTavAtS40D4eHr/HHJ9AoHOWY7fvhMTQKRy0SBG/9t/cPvXI1Hvz3wvgQOtPV2iAJCU5nFaEJFFFBRi4Blhp5R6yzeXXktXi73OX74CXU3eRQy5APeURgMUOrWRaKTav/cdDDQqqNw/ouR5V1+BxCZbD1UzaBUGAcdd+CPdXr8gKKssB49mMSaheHgJCOiKb4x47Qu9v3BVtqd+pHjBkrsgkogweEJE6raHiOLvrcPX3Ndjypc476uF18nTv6XROluEUtQM8+x4rYd7Web9D2GswaFXkh5G4L07o7dryHBgYBAWFQMjlmsopjQ7A/OkYkJiYEegfUWfnD9KVVM8NlKBvgg86GVIhViXS5q0hcXZKpLhXF+Dgg4GlKkBPZVKgQh4CAgIAI/RDwbF/7NSzwkmjeCyN0nvWx3s5tva3ukpnN8QM5Sb9CpyJ0E/J0E8U4FZVRUQS2tT24ZZ+TaUBbCQEBASGFCZ1zdLQAS11KZBaCxHNMfy5Mdpc7DhUTYBv7u8OeVcIkTpDimigIv09KsQpxCAgICIjQI+Cr2fqTGAxIeKIIHXyvvmTs9CjXk9rfDm9fZDxO1tW6NoxcRQn8iWNZGRLHltd4UIQ7AgICQqoTuhAKeJnutgacpBL0eDimHV4xIfIq012zLPmnDmgrEXXcy2zqcpOW1MbpCB0TRUlqd7NtaBshICAgpDqhB7wupqu1PnGELgfn9XO5i6yvM/n5XM5ZCHN9jM3RVpl0pE6IA6OTBI75g4KwqsG3Em0jBAQEhBQndAjodk9oRDlBkpHEFzWBL7nIHLrc2yObdMvn53GyzglA6J1ersPHCD60jRAQEBDSgNCZzuaaRBVZheVfDaMmHU/pjZZISkxuPidhk5DVgM/D6uoKkhS3Ju8UiWPb9we3OoJCD9pGCAgICGlA6P66nWs5V48vIWlisEGLSqMDDBj2nKy7eY0QdHUndepaFC+DVUNZ43kLXkbwoC2EgICAkCaEzvs9TiHg9SaqwAwmCoIkhNeglXjGA6xbLpknDoeNrSOwYLT5rLjFuIPp/HovquGOgICAkDaELoYCPl/tttUEnYCupdBCV2tVqsxhhRFsSGBRCDF5IGF80FHfj+TjdJQAS74GGZFtdbOtaAshICAgKANxCA6TJNa+vykhtCcKGGXK0MFc9GBr/c4+tySIrK8D05qzkpLOJRFjnQ3fR14XJCwuZ+gwwt3p54Ob2wIbFb/A9VljSLUp+5Cd9QgC433dtQLjCUvBo7QZJaQuo1ASOI51Na0+3HfhlNqoMhVMhgoX52nbLPJMvyMJ2pBdSaiMWVHvB8cxzrt/m8gFnQN9B+y7Dr5H36+/kNzUUBI5d+sG2Kp9wEeldZm0MXfcodu04hi4Bze4ly397t+UP4Wg1IYB+xuB35UENsC6W9f3+11jThV49gzOt3+vyPj2H/IeTfnj+IC9UQg6G/utP7Uxh9JnjxpoDGHPd9bdsl7WfA+1jtXGXMqYU8F7O2oExtve732NZTilt42AJfdZV/MaWaAcav5JWqcyF06D/x5oHsHnjSLV5pzDrke/vV4IuVvC7kdrHUHpMoeD8eVgDM2A90FQGpWlaIbIBZyct2PbLx+r0mfRhpzKI+oyCcaR9bRtknjGG+ULaPicOAGMIrgOfl176+X21EciQzSmQrA3S8B6KATrYjxjr/kc/C4rjzOCkgkdw7zVG77DqVvuTEQZWPk7pXDpAxYOw7pa1mgySsaJUjDpJq23DzYV5vJQkbjKpqeyYLEXNRVbQ52gCay2MbSHFyXFH1uYSuc/rC+YcR7sOz5QcgOh0mE9m9/8Q2Q7TX3hjJtN5afeBns/92z+z6XBju1vH+q7DEWz77SMWfgn+PNda56eHU04mcpOeUKbP3kB7IsceT+QLwCJdYS69y7z1C6/L1obVOu48/9Lm4tK8ShHWLCRIO/vbvLuW/mXQNum18Hn9UvZVFmLj7NNu/ZjiWcxglIPQExqLNRdXQ2eYUy/7x/7m7dU1uEVA9VmgkUYWW+bq2PF4xmRXQ3NFQv+T5s7fh5QjurtG187KRpZy/doKZqTPfu2T5w7P3zcW/fNfZHvq20VZ2VOuPQlGAMaLQ4GbG9AqO27PDVf3xvq3vPZQPOlzhp9tm3qNc/bN75yU6Bl/b8i39flTbzSUnnun2BfCMf2d64LtG546VDzry+Yer117Pn/gLWdutf963TGXvdV5M8YR877o2H4nMVQJA1UcAuuR8fWdx70Nqx4KOx+8qcusYw+8w+AqDH7xlfPYOy1X0b/fcOwrBk3rAh17VkFfu74X543o+SUrBk3viX14Vy4ZuB6hQ7LX9djb4mLjlVPzAKKUVjPbeOI4+8D6/cKQMJlfVtJwIQboBQ3ehtW/sXftuEV7BABurq8SVeaR5/1JFBsLPL8gbUklZ16J/wMtqd+lafh+8fBs32F6FmhhA4tdH/Drj04Seri3bmU1OoxIejvZymBTdEDhF9zFJmXBIROww0U6HstU0fZMnRkZl1HsDnWzVk0ahKD+ecMLyl+8ACpsVDAhuy167gI4dTHssKikS+QSRywhjARCDzz6DP/D3pFhAEsS2j96Ium3/RL4sEAbU1lkgV7AJD2GmDFh1mxqoyRJwHLZywQ+leDz8tzbHnzjCjeGVjyl/G3rnslLG0RJ1VqW9npwPoekVF18fOkxlriqf367mg3ABUHYP05fPu3vjEAowPForthAO8Q/H7O37LuZdjpKMrihG1du6M/O8+IXAhY6nkl5ooznnJs/e8iLJq5CAYejntvq+PoHwTnNNi1cwXv7dwWrsBrrBpb+WkqS3Glbco1S8EYPO6JohT88jny94j8AO/L8w9vw1A85w/B/dveBv/vH0AJMuqLZt8mG6hQ2RmA0CQRfCb4OjB+/wXj2DXgenQ2roqmsfXer4RljL/4/a6fnhoV6VU6OIAHiDpsf3K+rp3uvV88hfV5XHnNmPIr+u8PuT1v2JGaZfTCF4wlJ14HH43zdLQxPTVfgO/xw4fX2MpOo015I8B9vaDKGHGCc8f7i6ONgWZY5W+sVRe8JvOCp6VBJm7wUKTOVqHOGDlHmzdxLvg1EhG6ggk91Nawe9fvzxmL9+aEx1+oC/0bs3vrv/uTr+H7h5J14iQxXAh1eLn9k5+qrozX94tJVL8dCkhgqS317fvhsUEONkbpMjOBxX6Lp+7b+6JbZ9NuAD9jgzL0cJWFcUKFhbp2f+hrWv1khJuTANbLVdax572gyx1/eqhz5xWB9i3/jvgZUhSCAfeez2/u/7mAVUrmP2gqPfkPQLlY4m9d/y9gBe/r702V6xi0AeF++1GPJfh+YOEFwfffNOi1C8YIPOfZnKf9AWCFPji4OVVhwfatb/QbH6hcURozGIeHDcWzf2eqOP1eSeJZb/3gvufAHcOjjhHa3PGXAiv9xajznz/pKmC1FkqHNxDkUBdv/fcP8oGe2kHdDViPwAo3WKsufLdn02snSUdolfC+jm3u6qVhc26hFlkBqVcccn+AOTePOutZ48gTrgMKLeva/fGNwY7t78pkfgAeglJrskafbRm76FVD0awLoU7h2vXRFX2VChz8jKnkpEegB8jX+OO/3dWfXgcV7l+NL2uxYfjsm0P2mu8QNSuY0HsZAFoGoqCYJ4fauZQ6EwkeRWIFiUVLOvrowHPFQbpDYGXBHvAZFkDoN/pa1j0jMt79/a3zmbdCAxT8rJPUmDOP4H600SR1oG3TKwSts1nHXfg4oTEXDUyrtA4I1ECk9e+pXX6vylwwU5sz/nhgrU+IRugHhfQxqEjgt1UGYFj5BvGrGB9ytQPOzQOk+3vW07aesdd8Mag5BWMQVdTwIbd777JbOe/+rdaqi14zjjzx3uD+7f8FBFozmKdlHPtWqzNLZwMr/e5g+5Y3ImMUIE/pi4/7PeC3EO9u267OLJt22GGg1MZBr0fG20XQWqsme/Qcw4h5/w8YJw8M3tsHNCPp0PtDlzPhUkDm14tcgHNsfet8SP7RvC/Bzh3vC5yv2zbpys8BMV/Eedo2hCmtOE6BvZINPUShzl0f9SVzCHgEAxTFu5C8GjwINAQI6cHpA7hVj8S676r+hLHXraAM2WZD4YzfRbHOb6QNwzIYR8NPwc5dH+DhbeqPGpy3Y3uviiYOKkYhBHsVyG7fQz3zsamzke7cIxY4lAqDliCwwpaTaoPWMnrhs4TamBuLKQ+0b3491LXrG6BgqXT5U64ZHOHR0D3+L9bdultlKSrR5k38bT/Cy5t0pcpcmBfq2PFRyL738yNJoIkks6Nbj7s/BsQnr0Nz+Wn3a2xlZ8TOvQU0z7wJl0GvTmD/1g+ikXlfsI59K/wta1+BRyJAqVyM9w3UgMHIfMgJYweMJSf8P0qXWYYEEyJ0BISjZB9YYEifDQVIv5feVgbPPw9lUUJL1Ne46lF4fqkvnL6EUBmyf9lAwJrWF824CVodgKgelfiQ51izB8FnZvR6ZgdXM5k25U6UFYIBSxzLFpk66njIr4zSQ5RHhr9M0IbsMQP9PnT9H4IhoFxnnTs/uoLzd9lpc8EIa+Wif8dq6n1Na56E58marIqzcGIQmtaBMsv+ptV/h/cOrPQ7+1qzuGydz7kLBpp5G1Y+Ksnjc/iPhWM84HoEn3kYUtf52za+FGjf+gW8P+u4C14ntWDOYkEQFNCGTAXTYWyAr/nnp4/kd6ACJLJ+sA5zJgFlLb+PEhjyNax8BB5hqTNLp2fNvHmzpXLRi5qsUWfA70GC6tgR15rmlMGciZMUJcXR141jvbaO4HP1RLr8YXpMMtZ1h4E5ke5OLU3oTBrSGOuxhdq1nxX8PkZMmhru8MzWMHzWTYbi427qL7C0mH3Tq5cF9297a2ABqjIA63tlqKd+kzZ71GRD0czbDgZaAYK/iTbmZAGreAfTU7dckzX6nCNZlQNZuJAswL0C60vsDdceQEOJdLcfhMpSOFObO/43YHnwQsjdPIB1iJE6W+mwub+viUZgcLw6V/01X4D9Avr/LgeUI3327Nu3Rt1t4E/XT09O5LwdWw9h9OlE1rvfXf357zLGX/SGdtjYU4wlJz7srf/+gaGfe6BgAQLBZcIYXB9n6B4Pdmx7m3O3PqgyF5VqcydcHgCEKs9/3qSrwLUCf+uGr3l/926gM1x2ONsc/smc9NuPoyl+cD32bPnPtfDo5ZBuA0kSXbs/vlZlKdhK6bKyLaPOfKZnyxunx2TPk6Sa87Tt4rz7Nx/Jz8MUQDAWdZQ+qxSLSB2EXhO4AICFfg9tyCkxjpy3BOynJTA7I+So/9ZXv+IvfNBRh6g5CQi95I6nv9CPGDVG5OJ31AsJSOQ5vvr+SyZE5sNnTrpiOW0cVj5Ib2xiXCpgw3vqv/tn5LnZ4kkZl//z3KK/hUKxDVPQaEnsmR86X7jvi7a7k2fQCIzzdNbwfvueKGSNCSFX02EWkWwp+/atfFSTWfKRrmj6db7Gn/4KWJUH1vmNsnXeuOqxvj97aIcBj9HG3Ima7HDyB4atCXze79S2sslAePYEO3a+F+WXRZgGrM0Zd2GkUqC2FB+vK5x2Naky0r7mtR8DIbxpQK8DH/KGHNUronskOCayT0DfsQDv8aHuvcv7u/R7CV3kQq7DDQH8T7Bj+zs+S+FsY8lJNxlHnnAP49i3gnXuWzHUnN5Htx8so1HQRQ6s9H9aqi78p3HEcb8HxPQaVPSAkng7MDxFsDb+fITfIw8SY6/9AZ71R12PQWfDkTyTCIjTsfWdC7KmX79Cm1t1mt4+/RZgHT8z9BoxJoFpp3Bwd+CLuSOSuocwlIAy9HKwc8d7Glv56ZrsyvPAnppPGYYNN5ryr9bYRp3h2bvsD4GBMjAQlEPopEZrIPVGA87GL9sJ5uviLItFqzEBNW+guRuwJCJ0cL9QvvQLYNFQuMagJQ0xrccHRBFNE9i2tsCWZFrkUEgG2re9AQn5WD5HPkvvqduoyR4zRVcw5XpMFELAysgO2Wu2Bzt3fnDkHhYG0xVMvUQ/fPYlEZarTPa8r7ujZ/ObZ0cWFjlg4PEErdNnTr7y3TDugIafJEDrWgRE+b2nZtnvBha3JCANV5Nj69tnH72CTFASFww4try5YCjmxrP3qztoQ24VUFCOy6i64O3OH58skSR+yAQEodLboEIncgE7dkQVVQaGv33zq/riOXcAi7xEmzP2AtqUP422FBb5WzZ8fahCL/00JvDHVf3pdUDB3HuszwcUoJXumi//BCz0hyxjznmadTX+wEdbN8fC50DzoI15FbQ5fwrrbPrp8HLeXEjqM4sxUTyU18wT7NjxHnzBYyvtsMpFhhFz/wC+Z4R51IKnQz11X6dEm+tUJnT39p++0JePHyMJcQx273VBC6QOdlzraOr3Jtzjkpg8MzbAvZ5aYTod40XwJ3Yud+iwJDgRq+4K7U62hX7oc90jH33vvlWPqzNKPgQW5f1Yb6o6TMH5C3Y0ne4goQa6O4HN193XqGMd9V9znvbNQJh9N7Aww3FgLQqcp3Wv1CfXXa6uZsjODXbtXurY9s65R8LMx+T3GmyUe7/tKbCA3K6nDFnfUPphedZx570FCPJ5bIiaEuiHz7kbeqgZoIzB44Jjulee8fobf/oHPe78p0xlp/4VLCmDyPqlPtb50SiZ+qFa276GH/6sySiZrxlWOTej6pKPHNvfOQ8865AINcDlLtbdslaXP/kUQ9GsOxxHQOjwSIpUGYElvmm5EPIctjw0VLb8rRteYr0d27KmX/8jrtKZYRQ/InSFEzrn6GrF4pwqJgEtkTSYSVPl9JODzbXbwjcoLBKRbJ1UJXjf/QSpRUtZYz22KpLAdncGa+t7mNp03TAwypdx1G9SZZTIJV4ZV+MOYJ3/76isRqBbeJrXPu0dTF48QdAi5/d2r3t+siT8WvILlgXNnvW7bUCon6yyFs+NWphEoYBnz+49y+7OmLD4bc2wcYtwSmuRhGMvQghTCTVZFccJQWfQf6gz6aOz0l8HVvrdlC4rH3r/gvu3f3Xk1nnsrBbHtnfPGzb71l3Aii4xVyx4Gsg1ARsKrQhoBr59q/6iyRp1sjZn/Nnart2XHireBPzcQl3htMvhaZB3HwyA+3UiKX32GGCJn+NrXPWPaLnzUJmVuBCL0xoak1IpqTh+iGuUu3fX+m/EoL+3kpIShHNPzRc4mUwxcTgGs11C9r3LIt8RxNj3QpebsvBSyM+K/iSzz7EjrTF9BAKOB1b6Y3DdwFLWQNg9Ptj0sqEEzDd3V39+ByxYZhm98LnDWoDSsawXGJTHDmlQZLBj+3+99d//g1TpMI2t/MRftNdDzmn0c37alDfJOu6CNyxjznkKOiI8tV/ff9g4iSO30j2+xtV/h82moIPEO8hiRWD8vEM5fkDJs7uql8rHLGpb2VycUtMDVSs8WjDOfSvA3PwFp1RERtVFb5pHnfksQevD+mAQlMZiKj3l8cyJl35AqPQqQNovss6mH8Msd6AIgXl51DblmhUqS9HMvrn40O1uLDnhAUKl1faGMUsChqBsC10I+Ny8z+WgTBkZkhBfN7fEc0w07TMpZy3KffOiFPtAABLH1jb5kq15Ao4BI0GbM+4iWm8bFV1ToTDe11nrbejnOj3YwC7MjcPIVbV+fANYaFSwa9eHA/zOwPfT+/4gtVocP/Dq9/vB/Vv/E7LPuEVjq6iCUeOemq/uHGD9yI1HrGPPe2PArwAGkqd2+T1CRBEdSOU4rdUDwfzOgKVZwXh66797LEoQYtTx/EXhb1j5kMpcMBlYefN+/fmB5pSF+f/Xq60jTwh7AxCLJnvMWaTaBF25mGv3J/f6mtb84zBzgR/m/TAE2je9praVniIGXU2sK5y0sCNqeihhpvLTn5K4QE/UL4UxH22b3gnZa748mvsNdu58z9uwYrZx5Am3HOBy/Ij2x6HHQIac1YETlKn0pLuNpfNv0uWOvzTkaPgWzENALjucAQPbsm1gTWC+hpUvu6s/uz7yM1hn4w+sp/VUzbDKmSpr8RqgZHUxjn3fw3Wkyhg5nzbl58G16a39+m98yLEP0bPCCZ11drWF2vdVGzOGzZaE+AWiwTN73cix0zHsvbAI0N6iB3gSTlt4+k2OkcopyVSX8EKMvVTgW5PO3Q6jsoGQUJkLx6mtI8YNJECB8NzVj9Dx3gCmyC4a4PN4166PfjvA9+EHpgcf6H6ifebRPM9AVd7ggb5r96fXZM+4cTUQ6nfA5h2Mo/7byA+Aq4RQ6Uz6olmXHYrQvY2rnsAiCB2SEdg2pL5w2kUDPuL/Z+864KOqsv6bedN7SU9IhUAgCSGBSIlIWxUFwRV2sawF13XLJ6ur65bP/dRdv/Vb17Yr6mJZEUFdUYqAAhaKdEJoKSQhCenJJDPJ9PLad88LwWQyMykkIYF7fjzzc2bee7ece//nnHsKKSacdcfXEf6A3tn3IOFjHJIekJb5y3B19H6RMiws+BgJeOVTok/JlRpTc3tgvdtidjYXfuOoPviP0NW7OudKIAg9l37zj7R0S8G6W/pzT9c1BP9RRGXeEsxSibRUMD+X9QD07/kxqDDIZwrUJ82WGsdO7pOfRD/40Va+60lf+4X96rELnkHgm6OMnXpHF4sDOOidRWvor5AWNtD9roaCtUjb34+Egv9B7buRVBijlcrwFRctaARlrStz1h5711lz8FWsoQ9wu/M/qpg4cSJRUlIyZC+Mv+8Pb0bccu/PWc/wWW2FEhnhrCg8W/LUisyun8ujJt9lyLpzQ4dwMRqObAR8CFbL4dVT0YK/FJKUGSWfXPBY2ilwiBsqnzgwt6MVxuatLs09We86MVoYnJTrEoVipb63cqFok3b6pwZFWl4MKdNEIpwxB4vp7vE+mXaMUKIKo50tZYEKecBZNylR6mh3e8NAnH5EyvA0tAeLKaepMJhJFUp0CkVyBUu5HbSrtay78izTkgpDcl8SxaE+lPgfVcCzkQAkD3k/pHd1tpb7m+VFCkOKUKzQ0O62OvaSQ2DgMSSl6jDaY21kvfamHrwoVhjQOCYELp8KiWCsjYzX0dQrT4sVRtSmeNplqWEDaMtQtUwk18WgvlQGCjEL2HapGvGMNpJytpwPVHoUfRePnmsMzY9CCKWs9y/eAhn10PRFoWFtY9ztF4L2SyTTQdlX1uey0W5LRW/rg5So9Kh7TWwP4S04iVWR6bzkdmnf5NiupVr7MPbd5xB4xmEqGbSjsWuAnn76aeKZZ565cho6L6VdOFdwJc6tObpnrJzPVp8/nJaCy4ZzIUlQDoin7g48DAREs0MvkIA40e5m2kYT08PGF2rzC3mv19YQKLlKyHs81lomRNgQnHUz7oEPIYBs77/pGW/fSQBMrK3h5MDfH/zZvd7rAnCxXPYYIvC1wHW5vAEg7rMGNnvz3yOBy9dPoQuSqgSqrd6lbzV9FQ57tAcBrq8PoNvhmV53cijXB9qHCi9z7AdlDjH5CUrDDujVJScYR7tXMNyOcQKS9DdBDSgV5BVFdKRJUh4rmCa7La5hKMoiJgVEcZO70OSgTHjZYMKECRMGdKiNXsN63fQAszAOTBqkfYQiPjVdHps8cdTPWABJKDdeOV0kFg5pqXmhUEA02ahGp2/0pHzFhAkTJgzoQ0iMy9HurCw8IpRIh++lUB5QLBYLRGJJ97aYyyl74+lRFboWwCFqfIQsjRQJhtYLAGnoX52378ZLBhMmTJhGJg07knEsQ1PtrQ3DqaF3gjrBds9FCLmwOXb0JJeBM3Sv+fxO/88phqOG2qcPjRxXb6Xq8JLBhKm3dSqSyiIn/RCcFt3NZzfCX1KmjYW9D2c/w3RVaehA1tMHdw47oCPQ9tfQOz4eTefoAiKQ1+9Qx6CLhALCYqecByode/GSwYQpNOnTl28Im/rgh+G5D39snPKTL5Rxub+IuuH3laqEWb/Bo4PpqgN0qq2lnvW6fcMG6lAPWyojtFl5PQpKsF5b/fALF5cn/vt/FKMRxwyDhs4OS/IaTJhGOUn0CbO9reVnLGc+/r0sfOJNxuz73iBIkcRjKt6MRwfTkCpfV+Klrqqi47TVYhfpwowcPUxZMyEng1gq9/8YalgrYrKXjI7EwZBXAmI/u9MNyer5HD10PQCHuyM11kNtoyxkDROmK0G2818/BaFpXnP5Tsj9L4uYtJB2NFVAkRM8OpiuOkDnWJb2NFWXqo1RM4cN0Ikg6V9D1O0dacQxPpZymnpUOmOGWHMGA0ajnWpgRmH2JqFEGSEkpUouhAkDkmQxPqcZMoBd9lhB4hapygDJaAbyPL69IpkSEotADe4+3YPeie4zsJTb3lEmNGhHSVKmiydY2hsqVrqTILEOkh+l6JlW9OyAMcNQFQtdut5qaQj4OgReR9eEMpDLmxQrw7rODcwFS3lC96NrG2WaOLSExag/zRxDuYLPi1RDSlRG9LuWvuahR31XkFJtJO221PQnTbSrPv+ti2NjQO9qc1TtfbnP/ENKlKidESH5taOmg5v1hU6eA0ls0NiQ/ekzJgzoAwFWn7u+slgzOW8m4XUPkxDBENLIMWP5HaPr7sMD+igwuUOzGS/rszcU+H/FckNf/3VXme3L0cjg2tSFLynjpq1AGCYIlgoTbbxE29mNq5y1R1cPUGiIlEdMXCKLSLtdpIrKEMn1MQgE6ilH81mPqXiTu+HUBo6l3aFASR6V9WOpMeVmsTo6BwkEOsreXIomu87dXLTJVX/ivVAZtBQx2St16T98gXaZTa3H3/kBVC8LDPxyfeTMX5f4bPUnWo+/PSvwWMj0irjcn0mN4xZINDEzBJBxzmttouxNZ5G2udXTUrodCRuXEqMoE2Y9rk29+Y/d6qR0gh8fkSHoFDoIZ+2RD9oKP7uUMlcRlXGnPv1Hr6OhQXMjFHbyOQJ9M+0wnYXEI6j/G91NZ/4TrO/GKfd+KdEnTmg99tZST2vZjuBjlHWvYfLdr7Tmv3u/u/H0huDCkVSriJv2kDRs/E0imSZZpIxIQuNViNrU5G48td7VePpDPk9pcBAdoxwz/VcS3ZipIoUxHQlQEbSr9QKaz0KPqehTj6nkc0j8Eux+WXjqImPWT9YjfhUGS8cqIKUEetYuc8H7CwMId3pV0g1PSvQJM8TqmJlIKBExbksV4sUiT3PxZ57W0i9CZenDhAF9QOQsP32QY+ifDp92SxPKsZkzBXxu7+81TdZrq+NYiu0odjHSDe89Te56ucigk4s07BAFoUPKV5eX9TbaqIZRyeFQDFsoEhECL0x7wI2YZ4cBCkUSXXyeIeuejWJ1VBTs80hrguAJGmm3sWhDjVPGTlvoGXPdw7ZzO57wtl3Y538/FI3Rjr/lebEmNhHSYDIeG8vSPlqkDJ9AGpImyCMzFqgS8h6xle96FopvBOkjJE0SIQCJ0U5YvNpyav3iQGlnOyYUoYGw57FNp3UgPPfhI2LdmCRYCmhtMOg5NAKlaNS+aKiJ7bVU/Np06J9pl8YLDR6Ma1fjDWqKmMdxlqE4gu0yxizr35iOuRF2FJbnf8gLHgaJIXkuFIxDwsUd7oaT91pOf7QsYHU16As8o9cSjhffBX+DgX5szkOalPl/QH1NgnazXgcYMyg0txmkVJ2hiJ78A6Wp5GHruR2P+mx1x3sKDVPu1Y6/9WWRKsII3WEpJ8vzgkyXJNbEJSHBcrHPVltlLvhgKe1oPhOMYXvjV6JjLJlA82fIunuzPDJ9Jv9+n4NGfxEvRSRLdAnJyrjcxQjQzyChLy9QWlpMGNAHTN7mmnKCHeaKa0xP+z6U+EOaAIWkXikx0kvwgjXBT8vMiJZnJhllcR7f0FjDwcO9sd3XdrJu9ORv97fNgAzkqDjyT2f1gReDCUoIK9oHAubGnAe2i+Q6LdIOTzqq9r3ga68+8P33STeokmY/KY9In4p47wXv8bemd7UOyaMn/8Qw+c51CMCgzvoJZ83h1V6oYMULlgKBPHLSMmVC3mNibVwa2qg/spz+UOhuOvtRIJEE/rGUB7TeuVTKvGdtZTufIIJJL0GEF2X89EfEuvgkpB232Mp3/h78S3itU6qNgwpm6PuH+NSvXfrgqD7wkqs+/+2uwrAx58E9CIwjW47+ayrH+lydY8wxPpd/YyCBo6+l5mDb2f+s6KGtRkz8oTZ14QuK2OxbKKfpuYDV46AvHd3pZfHCGLEdfwP1fUzur/Tpy1dD0AsSnL5z1h1b42ur2te57qCYCBKsHpfHZM+kHE0P+Yq7AzoSyv6hHjt/FbTCYyo+bK/c9wJlr8/v/F5qHHeTKvH630r1iePDclbuNBe8tzBI7nOO59fSfc8564+/FYxfEVD3sNioE2f/DgmAM33tNRdspTseR0LHMX4NK8LGyyInLUZAv5hxt1djMMeAPujkqik/422urZWGx4xhh+scneMXNdsDJEeByR2sl7TTdJ7zO8uEOujcEAoiYPSze1m7gDf/caOTy/mUue42pP0OWhy9WBWZYcy5fxvSvrTO2uObECDd6X/m7W46vcFjKtqknbDoJUfN4Te7AiG6P1Of8aP3gf0QeL5oO//tn/1T+jqqD72CAPw/huz7vpAaUiYj7e+fHvP5ndCXgJs863NDpVh10pzHKFv9icDgH5xk4Wm3wxQjMPiNq/H0+ks8hsYNHLocNYdeu6gZXuoH+Akw/r4CfH14OGRoqwpaYrVbuyl3oLlx1hz5J4s+N2Tf/5kKCRuO6sOvsF7roOdCEKki0zXjb30B+KS9ZOufHFX7X/Q/4nDV5b/laS76VJ2y4E8I7N/t+p1Ul5CnSprDg7mz5tD7bYWbVhJ+1Vdc9SfeRYLCRiPSoGVRmfMMmXduNB1+LTPgUQrvR+Cy9IdfIY21RDdmJsfRhKNq79/cpuJNXecPCYrf2Mp3/0kwinyGMA3AonqlXsx6XHba0d5GCIenCeB8J42Ii5MnpGX3MHGNBiZHzaRd5nLWbzPnuKFFWaFISBy84NjvodnRXQVJENzUOhBSJsz6DdJ8dEiLK2o78/GKYA5sAGvtxVt+STuaz3a7P2n270mpRuBqOLnVWvrlb/3B/NJm7LU3mE+svZmy1paL1JFhyrhpPw/cPTHhNVd85Wku3ioQSYTa8YteFCnDxvdP7ukQ2iSGpLkB16zX3tTH81dBJ8j0mbmDkKeldBsSTsoEpFTcUe548KU9pNn+QSTXK5AAtMte8e1zwfwVwDHQem7bY3TXwiSoUarkG56Cprnq8z9rK/zsASJIKTUQfswnNyylbQ21Yl38OHl01j2Dx69o8uCMguUIadi4G4O8385SbhypggF9aMhWfOxrgXiY8rpALLpMKROpNIZui9TnNFH2xoJB3u+HCpR6CB5iUiAe2nEjiEqzt2J0szlfb3nQBBIou4k2zZs52kdA/WeO10j7cb9EGS4PS72R8dpc9so9f+lV+PU5mkBrFKDlqojKClHDnKXbCj+9h7Y3N4jVUTG6iUvf6Y+wigSCrwHTFbFTH9BnLF8rVkdPvtIzxxEsw5c2DVVj/rKWlFAsNSTOQUDH2s9/9cd+a/cKfTI40DE+B2PruD+kgA2Cm/3Cdy9Bf+TRGXfxklgQq0W/xomlvUgg+Rh8CxXRWbfrM370ARLoUkddASpMl2dtupIv97U21fDn6MOW2IW3uDPdFwJayVA7mU+RPrLzpgRanIvStEsEpIBv+mCPooDrEIS+u+DYN5qZnEPKszxy0nKkhaX06CMpJpw1h9f4rB3njX2bB7ESPNtZykF726r29nvRqSIzSbnBSNkaLtABohYCaqrm8i9opCAKJQot1LsO6CktJKUQnoRA/X5jzv3bZRET87TjF75iPbfjkb68A2mnTyMQz5BFTpqrSsi7D874KWvDcU9LyXZPy7ltUPdguOdOrAyfJDEkz0Br1N6RpnmQN0B1dBaai3DK3lDm60c9764cBDKTz1KZT7sslX0SnCyV33C0mxCrY7IhNA5pzlZ/flVET7kPfZ8TiF8Rzx2FIwD/75x1x9+SGlPmycLT5qsSZt4jj0r/MeNur3LWHn3T01q2k3a2nCMwYUAfKnKUHP+Wo2lIyUoMh0MaX4QlUCgI2gj5qBmhcMROFL9p2L53sukklVSogsIpYuHgC0VCNFQUwzEeihvd5naWBge2LKlxbFaPPorkkFxof38AnXe0Q+IO5Wwt8d+M+2gtYnl+h4BiMA2FCIPqJMZjrWM8tnaJNi4BgdAUX1vVnsD2FACMiq8cVXv/rkld+N+qhFk/B8dPd3PhJ71puCAkmAvWLpRHZ92piJv2MHrXdFl46nVwMb4Fz0KmM1vZzj/SLnPZoJvPAoG5JnaqPmP5BrAkOxpP72b7UAu83xug3DhWIFaKeSezfsSadxtzOA5zm8/3ZR47jCkX/XY6fs8F5FdDcq40fHxuIH4V1ByMDAToELvfmv/vBWjufiaPmHS7xJA4W6wdk6rXJ7yC+Of/XA2nN6D5+x2LGBdDHwb0QSdvc11FyVMrcrnv96KhBUW08DwNVaX+n9vObX/EUfGtdhjCuS+r7ZTT1KPtz3/b9Jd/55vXsOzgjx8AusvHuIuaPYWjmckFIinhqNjzLtJg1gQaV9rVWtHf2QDXBdAeBUhbDhoiFlQcoFxoL6cgIUqHybV3IBDJdQnoMtAOUx0VQLDrwdPnv3lKrImbpojJvlGbdtvr4H3P9iHRDcI0r6v+xFq4xKrIdFlE2m1I079dok+cqoydegcp149rPbZmOgLAQUkgAT5zEtTO8Ot+3kOgEiPBRSjTijwtpSdspTtWXZ7IENg5j3a1nOMoh09AShQXzy24fi9MxAsiRdiEi8JZr0IBf9YNgN5xzicIxK/2sl3/cAWIl4fXsT6nJdTzXUhThwvNVZIsLPVGpLEvkUVMWKhKun6lSBmWYT7x3tz+8iwmDOi9K04+j8tZWXT8Sg9Ch8ZhHpUTWNPuq4YLs3JI8waBlM9qBISDwmtIw2mh7Y2npMbUbJkxZYGr4eT7/bkfzNgISBrE6ph4eVTmXa76gnd7u0calrqIlOvUtLO1Bm3GfQo7ai/e/KBIGb4f4qr1mSs2mgvev5nrhxZKOZoL4bJX7fubMn7mKt2ERS9KdPGZEk1sbqCY+oEhLUsIJQqNTDlhWvePaR7skWDxeXvhZw8GyxzXmZeht6x6Irkh+aLSIPDvI+NuM6M+pcrCxy/xtJzb0q/mU552pP22SXQJU8SamByqD5YeWfiE2yGZkael+DjqozMgv7osFZfLr6hfYG5fAxdo7fr0O9Ygfp2G5nBWZ0gipquLhHgIMF0TmC4gB815EBzs3E1nPgJk0Iy/5UVSqo7pp0jAIkD8jhCSAnXy/KcgRWeoX5MyXYIq6YYn+LCohoJ/93lD99jqrCXbViEw9EiNY2fqJi75F2q9L7AWitRFqTo2mHrrrD74Cu1qrRXwW8bgnU3BtPhsjcWtJ967p+vlbi78WihWgGe9KVQaWJ+t7ihYsKWGpHkhBDoSrAwdeS/8zHAsQyFNeB1oxZpxN/4FHB77BZpee4PPUvGNUKIU6tJu+1dvTogSfdIcZfyMB0FYcTecWR/MTN9/ZzaBQKyOygqltXstlUcEIjlfPAbvCBjQMWEavdTH882+kqvuxNs+e0OdSBEWZsi6+xOJdsz0gJqhwjjWOHXlLkXs1G5ZEe3lu5+k7U1NSKtLNOY8sAvMo4HuF2vico059++CTHJIezzpqs9/pz/t9LSWbref//pvgDOK2Jy7hGKligiQkx8Sp0TM/PVxZcKsX4PTXc9+hKUKJSp9h5Y7iMc7YEL22uogHWvXq71o80okQLSpkmb/FLLpBZ0HJFixtJdAv3sEab63BfoNJMyRaOJSKEdTC4T2+XOGo/rgy772miqpPjndmH3fl3DUENBKok+6IXz6rw5JDSkLus1l5b7naZfZJjWOm2LI/PFHkP414P2GlPn6jGXviuQ6na/tQiG0fbD4FYF0XviMVYdUCTMfFUCeXX+hUG5IESnDx3K0h6CsdbhIzFVKVzz+WkCKxNLw2GSC4IbcLU7Ah4MwjLelvqpbtizwUpGhDZU/0xqJyVP4PJoXE3V8vxlDAblEvTRJJBz8eYRREAkFZHWb74KbYt2jmsshZFGiikTgmhpEuQHzrpvxWGv7rGPTHqvl1IalYTkPfIG0v1kiVdQ37sZT6zymoq3g7QxALouctEQRNflukSpciRQuvavhxLudbI40u8b24q2/MExBwoAuYUJ47sNHXY2n1npMxVsh1htC2+B+VfyM3wglapK2NzZaznx8x0AKvtir9v0vEhymKGKybwuGEwAICMii9enLXlXFT3/U3XBqPZ+cBN0AOerlMdn3kjKdxmetKUeCTP7gsndPrRbmwlr6xZNIWHpbO2Hxa15L1R7W52j2/523texLdB1BYzXdkLlio7364EvelpItkPkPissgAWWVPCr99g7g3fNcoGdA6Kr13PbHkOC0RRo2blpY7sPHnLVHX/FZa09AzLlEFz8TPX+pPCJ9CSnXEZS94U6vpeLrzvsh7NVcsHaxMfv+bcox05ch4WgB4oUP3M1FW6EfIlXERDmaS3lU1j2kTCOCTG6WMx8tC5p0hy/3rI4Oyq/8fsBxaD+4QFwMmYRERaREIdel3/EK5PZ3m0o+8bVVHgS/CXlkxjJ5dOZ96HlhlL3ZhISJ/Rj6rlJLpD+MTpw4kSgpKRm2BogNkXGTnt9YQipUSo4Z2mJe4OVOtbW0FD25dCzjcV06hwSNJCLvsfOkRGUYkQXFQIuhXFbTgVfH8jG5nZswKZAUPTGxAoF6rI8ZXEFERAqIRpuveebq0pyG0ZrHHZFh8l2bESguZaA2ShCREcytCBROtRx5Y0q/+VcTk6Mdf+vfERDMBQ9kCDkC0AReEwgl6P89hKu+YKOtfPd/Q2KgQPfr0m5bLQ1LnQ7mZwTYvF8Vn56dlPLP87aWH7ac/vDHjNcWUOBQJ83+gyHrJ3911B761pz/3vxAvwELQPi0h/aIdfEJHlMJ6uvrU/zGQKOMm/YzddKcJ0mFPhza3hG6z/Ge1ZCBjLLWVyAhZjkCsJOhxiTy+t/WkjJ1TOO3z2lDVflCgsMqY87Kfzjr84+0HntrRiBJCwk821UJebc4aw7vNp9cvygQCIqQ9ol+95lElzgZUreCFgryescYSiCOn0Hj/6y9cm/ImH8E3Nfr0pa8LjEkZcBcQCg4mg+OlKoFENbKeNoZJHR9YCv98reBjgGQYHa9dvzC55EmPksglhGQp6CDFzp8H1nKCSl+v7SWbHs0WKQAhAqGT/3pulD8Cm3hWB/RvO/vyYwHCfmXxnPmo6qk2Y+L1VFxaNL4cYBnAH/DeKD5O48Elyc8LSVbMfSNfnr66aeJZ555ZmRp6FSbqcFVXVqgzcqbzXiGVhGEvNGgjXMMTQcATbT6hSM0vSkUXhJJ/AP2p8QqcmL10ggIgCIH+fBEIhYSdVaqbjSDOZCv/cJ+JykGJ2c+SCywvCQGLWtAMbqUrQEql82TGpLnIE12KSk3JCDQgbRdHNLUq5DGvcXbVrU/1P0tx9bkyYypNyEtcJlQrDAQREetINbnMkO6UY+5bDcRQtKkHKYiZ93RzV5zZVDNGRyk2s5+ulKdMve/kIbYo6+g+TsuHHgRUpSCox4SUOYj1LhYAY1kvZbKA2Du74uFAAHGFjB59WY2pp2tpc66Y5vRs88GM63YSr+AlKoIWVkSKsGBNt3jOW5LRcuRN69Dbb5JHjFpmUAk01wcQwhdb0bCwBuUvelM77xS813L0TdzO5+DAH4GKdMmO2uPfQIV6rwIjCm/jH/d769G9/8rTxYxcakihk8AJCQ6UrhxlLOlFCqtod8cCtUGPm68Pn9zKH6FxyIBi0Gd6yYsOWoOvYoEjvWy8NSF0rAJS9CWBhZHcKdnIZTR3Vy0ZShC/zBhDb0bJf3irx9FLrx7BWW1DDAUtO+aLnqBp/TP9891VhQe+V5Dl+sjrn+imhTL1SNSQ0fSNu1sqWo98kYW0poubahL03V3bF459lO3Z/DbLJeRxMt7ml57fFvdKrxMMF2LFD7jkbNSfWK66fBrN2AzNabRoKGPCKe4xq1v/8V8cMcOxu20kkoNIZRIhyZ7HMcSpEIjk4bHJnb/mHLTzubCkZr+FY4YqfbaQ13BnNdMWI4eMoOCSECUtXpL8bLBdK2So2rvc67Gk5+AU6JQrAjDI4JppNOIAHRPQ1Vx+d9+uaj4j8sn13/86p+dlUUnIYECqVAjcJcNOqhzNOXr/hHtYZymkl5LKl9RVBf0kDZ4QB/MVxD8uTwhV4iIhlav+btKx168RDBdc4TWmmbcjf8nFMk0HO2lhSK5jBjEsEdMmIaKRlSVMV9rY3XDp2883fDZm88okyZO1WbPWaydcv2tqnGTsztqVnsJjg6cLbFf61UcQErgz6hH8ibTs4jD/LGaHwxGAnfwHJBKSN6Bpqbd17huT9N7aw63rqmz+mrwEsF0zeE5QnSpPmmOJGXe7yBhjbPm8DvgEIFHBhMG9AFp0RwHGeTgatz05rParNm36qbN+6E6ffp8aXhsHJjGO8B9IHXUOUKXPWep5fDOD7t/zjIjeaJYj7UHuCboJYmX80wx0sZFEiHhdjPcV+ese9/PN7/3ebF1q93L2PDSwHStEsexdOvxd64XiKRqfu1RGMwxYUAfnMXFskx7wd7P4SKVGr06bepsXc7cJepJuQtk0YljOIYmOMrXL2e6QBq623Tuc0XcdfeN0B2GCJSqkWK4gUg0hFws5M/I68ze5g8KLGu3nG3fcqzWiZNNYMJ0ackxFIeBHBMG9KEjxmlra8//ditcAO7GvEX36HLm3KZMyZgh0uiVCPwJ1uvupb6CAMz2PfI+c7TXPqI7HyD5Rn/O0EVCASEGIEdjc6DScWRzUfum9SfM75sctAkvA0yYMGHCgH5Fwd2068PX4JJGxY/TZs66kdfcM6b/QCiW8lo7S/dMWw0avSQsKkEokSmgOMylLyB38rDVZR8QondrnEwklCXoJImhqqzBHeDkJiSFRKudat9WYNm2Nr/1399VOfZx3IgMuMeECRMmTNcaoHclb1NNuQmu3R+9rhqfnQdau2Zy3kJ5XEo6eMmD1g5A3qGJU4Q8PjWTVKr1XQGd9TqaONrjRpqwfDhqs/ePAH67J+nQyISazGhFFkP3bCuJtHFIDEMgsK+weKvXHG5Zs+6E5b1mO9WEWR4TJkyYMKCPCnKUFhyAS/DJa08pU9Kn6bLnLDZev/gBsTEqQiDgze0E53HShF/xc9reeJJxtzeJlOFJ3OBGg12eXi4kIRNWs8/aPcMUQDzN8mfol/wBpCKkjUtIot3mc+0us+1741DL6gNV9u/sXtaOWR0TJkyYMKCPSoJYc0fpyYNwNe14/2XNpNx5upy5t6nTp89D2nkkQkphD+QUjNBAdKSdo3/d8uKCQxyAOpjV5RLUbFJAnGtwV358yvLhf061fXiuxVOC2RsTJkyYrmFAdzgcV10naZvFZDm882O4UJcjhKlZeWxbi6e7xssQdqdHJSK8l8zzI0JDJ5GG7vJoOJbpJmzEypl0udCtcTo4YleZ9evtRdbPPyj0rkNfWTFbY8KECdPVTV6vt3dAX758OVFfX3+16u0IrBkTR/k2CbOW+/mZCWhVYtoLEt2Y7EEunX15gC4QEozPabGNMzNd88zfPEGrdaZpX/ukwPLJftZ+wJXCEnekCXlvdkyYMGHCdHVTTk5OT7zgOOzsjAkTJkyYMI12woCOCRMmTJgwXQX0/wIMAIVx9Ka1oDkfAAAAAElFTkSuQmCC');
                                                                                                                            background-size: contain;
                                                                                                                            background-repeat: no-repeat;
                                                                                                                            background-position: center
                                                                                                                        } */
    </style>
@endsection

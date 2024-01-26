<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td,
        span,
        p,
        img {
            margin: 0;
            outline: 0;
            padding: 0;
            vertical-align: baseline;
        }

        body {
            width: 29.7cm;
            height: 21cm;
            margin: 30mm 45mm 30mm 45mm;
        }

    </style>
    <title>{{ $formlist->formlist->description }}-{{ $formlist->employee->user->name }}</title>
</head>

<body>
    <div class="table-responsive text-nowrap" style="width: 100%; position: absolute; left:0; top:0;">
        <table class="table table-sm table-bordered">
            <thead class="">
                <tr id="l1">
                    <th class="border border-dark text-center" colspan="3" id="img_logo">
                        <img src="{{ public_path('images/stnlogo.png') }}" alt="Logo da empresa">
                    </th>
                    <th class="border border-dark text-center text-uppercase" colspan="3">
                        {{ $formlist->formlist->description }}</th>
                    <th class="border border-dark text-center" colspan="2" rowspan="2">
                        <img class="position-absolute img img-fluid rounded" id="img-user"
                            src="https://img.freepik.com/premium-vector/white-man-icon-app-web-isolated-white-background-color-icon_599062-393.jpg?w=740"
                            alt="">
                    </th>
                </tr>
                <tr id="l2">
                    <th class="border border-dark " style="padding: 0; margin: 0; font-size: 0.8em;" colspan="6">
                        <span style="margin-left: 2px">Unidade (Obra):</span><span style="margin-left: 2px"
                            style="font-weight: normal">
                            {{ $formlist->base->name }}({{ $formlist->base->project->name }})</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-dark " style="padding: 0; margin: 0; font-size: 0.8em;" colspan="3">
                        <span style="margin-left: 2px">Matricula:</span>
                        {{ $formlist->employee->registration }}
                    </td>
                    <td class="border border-dark " style="padding: 0; margin: 0; font-size: 0.8em;" colspan="1">
                        <span style="margin-left: 2px">Nome:</span>
                        {{ $formlist->employee->user->name }}
                    </td>
                    <td class="border border-dark " colspan="2" style="padding: 0; margin: 0; font-size: 0.8em;">
                        <span style="margin-left: 2px">Admissão:</span>
                        {{ date('d/m/Y', strtotime($formlist->employee->admission)) }}
                    </td>
                    <td class="border border-dark " colspan="2" style="padding: 0; margin: 0; font-size: 0.8em;">
                        <span style="margin-left: 2px">Status: </span> Ativo
                    </td>

                </tr>
                <tr>
                    <td style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark " colspan="4">
                        <span style="margin-left: 2px">Responsável Técnico:</span> Marcos Athie
                        Trevisan
                    </td>
                    <td class="border border-dark " colspan="2" style="padding: 0; margin: 0; font-size: 0.8em;">
                        <span style="margin-left: 2px">Form Nº
                        </span>{{ str_repeat('0', strlen($formlist->formlist->id) < 5 ? 4 - strlen($formlist->formlist->id) : 0) }}{{ $formlist->formlist->id }}
                    </td>
                    <td style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark " colspan="2">
                        <span style="margin-left: 2px">Rev: </span>{{ $formlist->formlist->revision }}
                    </td>
                </tr>
                <tr>
                    <td class="border border-dark text-center font-weight-bold"
                        style="padding: 0; margin: 0; font-size: 0.8em;" colspan="4">Fornecimento</td>
                    <td class="border border-dark text-center font-weight-bold"
                        style="padding: 0; margin: 0; font-size: 0.8em;" colspan="2">Entrega</td>
                    <td class="border border-dark text-center font-weight-bold"
                        style="padding: 0; margin: 0; font-size: 0.8em;" colspan="2">Devolução</td>
                </tr>
            </tbody>
            <tfoot class="table table-bordered table-sm table-striped">
                <thead class="thead-dark text-center">
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center"
                        width="25px">#</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center"
                        width="20px">Qtd.</th>
                    {{-- <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Cód</th> --}}
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">C.A.
                    </th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">
                        Descrição</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Data
                    </th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">
                        Assinatura</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Data
                    </th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">
                        Assinatura</th>
                </thead>
                <tbody id="list">
                    @foreach ($formlist->fields()->get() as $key => $field)
                        <tr>
                            <td class="border text-center border-dark p-0 m-0">
                                <p id="index" style="font-size: 0.8em;">{{ $key + 1 }}</p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->qtd_delivered }}</p>
                            </td>
                            {{-- <td class="border border-dark text-center">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->stoks->id }}</p>
                        </td> --}}
                            <td class="border border-dark text-center p-0">
                                <p style=" margin: 0; font-size: 0.8em;">
                                    <i class="fa fa-certificate text-success ml-1 mr-1" aria-hidden="true"></i>
                                    {{ $field->ca_first ?? $field->ca_second }}
                                    {{-- <i class="fa fa-id-card fa-lg text-danger" aria-hidden="true"></i> --}}
                                    {{-- <i class="fa fa-newspaper-o fa-lg text-danger ml-2" aria-hidden="true"></i> --}}
                                    <a href="#"><i class="fa fa-book fa-lg text-danger fa-lg ml-2 mt-1"
                                            aria-hidden="true"></i></a>
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
                                        Assinado
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
    </div>
    {{-- <div class="card page-break" style="width: 100%; position: absolute; left:0; top:0;">
        <div class="card-header d-flex">
            <h5 class="mb-0">Número CA: <span data-item="numero_ca">38257</span></h5>
            <div class="ml-3"> <a href="#" target="_blank" class="text-light font-weight-bold"
                    rel="noopener noreferrer"> - CLIQUE AQUI ACESSAR PDF DO CERTIFICADO</a></div>
        </div>
        <div class="card-body">
            <div class="row mb-0"  style="display:flex">
                <label class="bdg-label" for="Sua Etiqueta">Sobre o CA</label>
                <div class="ctn bdg">
                    <div class="item mx-1 font-weight-bold">Data de Validade: <span
                            data-item="data_validade">29/12/2028 00:00:00</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Situação: <span data-item="situacao">VÁLIDO</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Processo: <span
                            data-item="processo">19966201432202351</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">CNPJ: <span data-item="cnpj">10.702.092/0001-05</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Razão Social: <span data-item="razao_social">VCH -
                            IMPORTADORA, EXPORTADORA E DISTRIBUICAO DE PRODUTOS LTDA</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Natureza: <span data-item="natureza">Importado</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="bdg-label" for="Sua Etiqueta">Sobre o Equipamento</label>
                <div class="ctn bdg">
                    <div class="item mx-1 font-weight-bold">Equipamento: <span data-item="equipamento">LUVA PARA
                            PROTEÇÃO CONTRA AGENTES MECÂNICOS E VIBRAÇÃO</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Marcação CA: <span data-item="marcacao_ca">Impressão no
                            dorso e na etiqueta.</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Referência: <span data-item="referencia">Gorila.</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Tamanho: <span data-item="tamanho">8(M), 9 G) e
                            10(EG).</span></div>
                    <div class="item mx-1 font-weight-bold">Cor: <span data-item="cor">Preta.</span></div>
                    <div class="item mx-1 font-weight-bold">Descrição: <span data-item="descricao">Luva de segurança,
                            confeccionada em fibras naturais e sintéticas, revestimento palmar, pontas e face palmar dos
                            dedos em borracha "foam" (espuma) em formato de gomos.</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="bdg ctn">
                    <label class="bdg-label" for="Sua Etiqueta">Sobre o Laudo</label>
                    <div class="item mx-1 font-weight-bold">Número do Laudo: <span data-item="numero_laudo">EPI
                            15535/23</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Laudo: <span data-item="laudo">PROTEÇÃO DAS MÃOS DO
                            USUÁRIO CONTRA AGENTES ABRASIVOS, ESCORIANTES, CORTANTES E PERFURANTES E CONTRA
                            VIBRAÇÕES.</span></div>
                    <div class="item mx-1 font-weight-bold">Observações do Laudo: <span data-item="obs_laudo">I) O EPI
                            obteve resultado de níveis de desempenho 4244B para BS EN 388, com valores variando de 1(um)
                            a 4 (quatro) para abrasão, rasgamento e perfuração e 1 (um) a 5 (cinco) para corte, sendo 1
                            (um) o pior resultado, em que: 4 - resistência à abrasão; 2 - resistência ao corte por
                            lâmina; 4 - resistência ao rasgamento; 4 - resistência à perfuração por punção; B -
                            resistência ao corte TDM (ensaio adicional previsto na norma EN ISO 13997, com valores de A
                            a F, sendo F o melhor resultado). II) Para a seleção e correta utilização do equipamento,
                            verificar o disposto no Comunicado XL, disponível no link
                            "https://www.gov.br/trabalho-e-previdencia/pt-br/composicao/orgaos-especificos/secretaria-de-trabalho/inspecao/seguranca-e-saude-no-trabalho/equipamentos-de-protecao-individual-epi/comunicados-epi".</span>
                    </div>
                </div>
            </div>
            <div class="row mb-0 pb-0">
                <div class="bdg ctn">
                    <label class="bdg-label" for="Sua Etiqueta">Sobre o Laboratório</label>

                    <div class="item mx-1 font-weight-bold">CNPJ:
                        <span data-item="cnpj_laboratorio">87.190.161/0001-73</span>
                    </div>

                    <div class="item mx-1 font-weight-bold">Norma Técnica:
                        <span data-item="norma_tecnica">BS EN 388:2016 + A1:2018</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Razão Social:
                        <span data-item="razao_social_laboratorio">IBTEC - INSTITUTO BRASILEIRO DE TECNOLOGIA DO COURO,
                            CALCADO E ARTEFATOS</span>
                    </div>
                    <div class="item mx-1 font-weight-bold">Histórico de Alterações:
                        <span data-item="historico_alteracoes">
                            <ul>
                                <ul>
                                    <li>Data da Alteração (Ordem Crescente) Ocorrência CA</li>
                                    <li>16/03/2016 Expedido</li>
                                    <li>22/01/2021 Expedido</li>
                                    <li>05/03/2021 Expedido</li>
                                    <li>29/12/2023 Expedido</li>
                                </ul>
                            </ul>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @foreach ($fields as $field)
        @foreach ($field->stoks->documents as $document)
            @if ($document['type'] == 'caepi')
            @include('layouts.partials.caepi',['caepi' => $document, 'complements' => $document->parseComplementToJson()])      
            @endif
        @endforeach
    @endforeach
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script>
        $("input:checkbox").on('click', function() {
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>
    <style>
        td>span {
            font-weight: bold;
        }

        input:checked {
            border: none;
            background-color: black;
        }
    </style>
    <style>
        @page {
            size: landscape;
        }

        #list tr:nth-child(even) {
            background-color: #A9BCF5;
        }

        #l2 {
            height: 27px;
            padding: 0;
            margin: 0;
        }

        #img-user {
            position: relative;
            margin-top: 0;
            height: 120px;
            margin-left: auto;
            margin-right: auto;
            width: auto;
            border: black solid 1px;
        }

        #img_logo img {
            max-width: 100%;
            height: 100px;
        }
    </style>
    <style>
        @page {
            size: landscape;
        }

        .card {
            width: 100%;
            margin-bottom: 0px;
            height: auto;
            padding-bottom: 0;
            border-color: #007bff;
            font-size: 0.7em;
            border-radius: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            height: 25px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-header>* {
            float: left;
        }

        .card-body {
            margin: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: bold;
        }

        .info-label>span {
            font-weight: normal;
        }

        .bdg-wrapper {
            position: relative;
        }

        .bdg {
            border: 1px solid gray;
            border-radius: 6px;
            position: relative;
            width: 100%;
            margin-top: 8px;
        }

        .bdg-label {
            position: relative;
            top: -10px;
            z-index: 1;
            left: 2em;
            background-color: white;
            padding: 0 5px;

        }

        .ctn {
            /* display: flex;
                flex-wrap: wrap; */
            padding: 5px;
            position: relative;
            top: -30px;
            width: 99%;
            min-height: 80px;
        }

        .item {
            min-width: 250px;
            padding-bottom: 5px;
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
            display: inline-block;
        }

        .item>span {
            font-weight: normal;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</body>

</html>

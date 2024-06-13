<!doctype html>
<html lang="pt-BR">

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
            margin: 0;
            vertical-align: baseline;
        }
    </style>
    <title>{{ $formlist->formlist->description }}-{{ $formlist->employee->user->name }}</title>
</head>

<body>
    <div class="table-responsive text-nowrap">
        <table class="table table-sm table-bordered">
            <thead class="">
                <tr id="l1">
                    <th class="border border-dark text-center" colspan="3" id="img_logo">
                        <img src="{{ public_path('images/stnlogo.png') }}" alt="Logo da empresa">
                    </th>
                    <th class="border border-dark text-center text-uppercase" style="font-size: 1.5em" colspan="3">
                        {{ $formlist->formlist->description }}</th>
                    <th class="border border-dark text-center" colspan="2" rowspan="2" style="padding: 0;">
                        <img id="img-client" src="{{ public_path('images/channels4_profile.jpg') }}" alt="">
                    </th>
                </tr>
                <tr id="l2">
                    <th class="border border-dark " style="padding: 0; margin: 0; font-size: 0.7em;" colspan="6">
                        <span style="margin-left: 2px">Unidade (Obra):</span><span style="margin-left: 2px"
                            style="font-weight: normal">
                            {{ $formlist->base->name }}({{ $formlist->base->project->name }})</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-dark " style="padding: 0; margin: 0; font-size: 0.7em;" colspan="3">
                        <span style="margin-left: 2px">Matricula:</span>
                        {{ $formlist->employee->registration }}
                    </td>
                    <td class="border border-dark " style="padding: 0; margin: 0; font-size: 0.7em;" colspan="1">
                        <span style="margin-left: 2px">Nome:</span>
                        {{ $formlist->employee->user->name }}
                    </td>
                    <td class="border border-dark " colspan="3" style="padding: 0; margin: 0; font-size: 0.7em;">
                        <span style="margin-left: 2px">Função: </span> {{ $formlist->employee->profession->name }}
                    </td>
                    <td class="border border-dark " colspan="1" style="padding: 0; margin: 0; font-size: 0.7em;">
                        <span style="margin-left: 2px">Admissão:</span>
                        {{ date('d/m/Y', strtotime($formlist->employee->admission)) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark " colspan="4">
                        <span style="margin-left: 2px">Responsável Técnico:</span>
                        {{ implode(', ', $formlist->formlistBase->users()->pluck('name')->toArray()) }}
                    </td>
                    <td class="border border-dark " colspan="2" style="padding: 0; margin: 0; font-size: 0.7em;">
                        <span style="margin-left: 2px">Form Nº
                        </span>{{ str_repeat('0', strlen($formlist->formlist->id) < 5 ? 4 - strlen($formlist->formlist->id) : 0) }}{{ $formlist->formlist->id }}
                    </td>
                    <td style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark " colspan="1">
                        <span style="margin-left: 2px">Rev: </span>{{ $formlist->formlist->revision }}
                    </td>
                    <td class="border border-dark " style="padding: 0; margin: 0; font-size: 0.7em;" colspan="1">
                        <span style="margin-left: 2px">Matricula:</span>
                        {{ $formlist->employee->registration }}
                    </td>
                </tr>
                <tr>
                    <td class="border border-dark text-center font-weight-bold"
                        style="padding: 0; margin: 0; font-size: 0.7em;" colspan="4">Fornecimento</td>
                    <td class="border border-dark text-center font-weight-bold"
                        style="padding: 0; margin: 0; font-size: 0.7em;" colspan="2">Entrega</td>
                    <td class="border border-dark text-center font-weight-bold"
                        style="padding: 0; margin: 0; font-size: 0.7em;" colspan="2">Devolução</td>
                </tr>
            </tbody>
            <tfoot class="table table-bordered table-sm table-striped">
                <thead class="thead-dark text-center">
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center"
                        width="25px">#</th>
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center"
                        width="20px">Qtd.</th>
                    {{-- <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center">Cód</th> --}}
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center">C.A.
                    </th>
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center">
                        Descrição</th>
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center">Data
                    </th>
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center">
                        Assinatura</th>
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center">Data
                    </th>
                    <th style="padding: 0; margin: 0; font-size: 0.7em;" class="border border-dark text-center">
                        Assinatura</th>
                </thead>
                <tbody id="list">
                    @foreach ($formlist->fields()->get() as $key => $field)
                        <tr>
                            <td class="border text-center border-dark p-0 m-0">
                                <p id="index" style="font-size: 0.7em;">{{ $key + 1 }}</p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.7em;">{{ $field->qtd_delivered }}</p>
                            </td>s
                            <td class="border border-dark text-center p-0">
                                <p style=" margin: 0; font-size: 0.7em;">
                                    <i class="fa fa-certificate text-success ml-1 mr-1" aria-hidden="true"></i>
                                    {{ $field->ca_first ?? $field->ca_second }}
                                    <a href="#"><i class="fa fa-book fa-lg text-danger fa-lg ml-2 mt-1"
                                            aria-hidden="true"></i></a>
                                </p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;" colspan="2">
                                    {{ $field->stoks->invoiceProduct->description }}</p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.7em;">
                                    {{ date('d/m/y', strtotime($field->date_delivered)) }}</p>
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.7em;">
                                    @if ($field->date_delivered && $field->signature_delivered)
                                        @if ($_SERVER['HTTP_HOST'] == 'localhost')
                                            <a href="http://localhost{{ URL::signedRoute('extern.field.showSignature', ['signatureField' => $field->signature_delivered, 'field' => $field], null, false) }}"
                                                class="text-dark font-weight-bold" target="_blank"
                                                rel="noopener noreferrer">Assinatura digital</a>
                                        @else
                                            <a href="https://www.jfwebsystem.com.br{{ URL::signedRoute('extern.field.showSignature', ['signatureField' => $field->signature_delivered, 'field' => $field], null, false) }}"
                                                class="text-dark font-weight-bold" target="_blank"
                                                rel="noopener noreferrer">Assinatura digital</a>
                                        @endif
                                    @else
                                        Falha na assinatura
                                    @endif
                                </p>
                            </td>
                            <td class="border border-dark text-center">
                                @if ($field->date_returned)
                                    <p style="padding: 0; margin: 0; font-size: 0.7em;">
                                        {{ date('d/m/y', strtotime($field->date_returned)) }}
                                    </p>
                                @endif
                            </td>
                            <td class="border border-dark text-center">
                                <p style="padding: 0; margin: 0; font-size: 0.7em;">
                                    @if ($field->date_returned)
                                        @if ($field->signature_returned)
                                            @if ($_SERVER['HTTP_HOST'] == 'localhost')
                                                <a href="http://localhost{{ URL::signedRoute('extern.field.showSignature', ['signatureField' => $field->signature_returned, 'field' => $field], null, false) }}"
                                                    class="text-dark font-weight-bold" target="_blank"
                                                    rel="noopener noreferrer">Assinatura digital</a>
                                            @else
                                                <a href="https://www.jfwebsystem.com.br{{ URL::signedRoute('extern.field.showSignature', ['signatureField' => $field->signature_returned, 'field' => $field], null, false) }}"
                                                    class="text-dark font-weight-bold" target="_blank"
                                                    rel="noopener noreferrer">Assinatura digital</a>
                                            @endif
                                        @else
                                            Falha na assinatura
                                        @endif
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </tfoot>
        </table>
    </div>
    @if ($documentable)
        @foreach ($documents as $document)
            @if ($document->type == 'caepi')
                @include('layouts.partials.caepi', [
                    'caepi' => $document,
                    'complements' => $document->parseComplementToJson(),
                ])
            @endif
        @endforeach
    @endif
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
            position: absolute;
            top: 5px;
            right: 40px;
            height: 100px;
            width: 80px;
            margin: 0;
            border: black solid 1px;
        }

        #img-client {
            height: 60px;
            position: relative;
            top: -20px;
            margin: 0;
        }

        #img_logo img {
            max-width: 100%;
            height: 60px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
    <style>
        .card {
            width: 100%;
            margin-bottom: 0px;
            max-height: 98%;
            padding-bottom: 0;
            border-color: #007bff;
            font-size: 0.7em;
            border-radius: 20px;
            padding-top: 0px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .card-header>div {
            position: absolute;
            top: 8px;
        }

        .card-body {
            margin: 0;
            padding-bottom: 0;
        }

        .bdg {
            border: 1px solid gray;
            border-radius: 6px;
            width: 99%;
            padding: 5px;
            position: relative;
            top: -40px;
            overflow: hidden;
            margin-bottom: 0px;
        }

        .bdg-label {
            position: relative;
            top: -30px;
            z-index: 1;
            left: 2em;
            background-color: white;
            padding: 0 5px;
            border-radius: 3px
        }

        .bdg-wrapper {
            position: relative;
        }

        .item {
            min-width: 150px;
            padding-bottom: 5px;
            display: inline-block;
        }

        .item>span {
            font-weight: normal;
        }
    </style>
</body>

</html>

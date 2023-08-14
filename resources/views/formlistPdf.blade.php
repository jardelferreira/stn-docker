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
                    <th class="border border-dark text-center text-uppercase" colspan="3">
                        {{ $formlist->formlist->description }}</th>
                    <th class="border border-dark text-center" colspan="2" rowspan="2">
                        <img class="position-absolute img img-fluid rounded" id="img-user"
                            src="https://img.freepik.com/premium-vector/white-man-icon-app-web-isolated-white-background-color-icon_599062-393.jpg?w=740"
                            alt="">
                    </th>
                </tr>
                <tr id="l2">
                    <th class="border border-dark " style="padding: 0; margin: 0; font-size: 0.8em;" colspan="6"><span style="margin-left: 2px">Unidade (Obra):</span><span style="margin-left: 2px"
                            style="font-weight: normal">
                            {{ $formlist->base->name }}({{ $formlist->base->project->name }})</span> </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-dark " style="padding: 0; margin: 0; font-size: 0.8em;" colspan="3"><span style="margin-left: 2px">Matricula:</span>
                        {{ $formlist->employee->registration }}
                    </td>
                    <td class="border border-dark " style="padding: 0; margin: 0; font-size: 0.8em;" colspan="1"><span style="margin-left: 2px">Nome:</span>
                        {{ $formlist->employee->user->name }}</td>
                    <td class="border border-dark " colspan="2" style="padding: 0; margin: 0; font-size: 0.8em;">
                        <span style="margin-left: 2px">Admissão:</span> {{ date('d/m/Y', strtotime($formlist->employee->admission)) }}
                    </td>
                    <td class="border border-dark " colspan="2" style="padding: 0; margin: 0; font-size: 0.8em;">
                        <span style="margin-left: 2px">Status: </span> Ativo
                    </td>

                </tr>
                <tr>
                    <td style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark " colspan="4"><span style="margin-left: 2px">Responsável Técnico:</span> Marcos Athie
                        Trevisan</td>
                    <td class="border border-dark " colspan="2" style="padding: 0; margin: 0; font-size: 0.8em;"><span style="margin-left: 2px">Form Nº
                        </span>{{ str_repeat('0', strlen($formlist->formlist->id) < 5 ? 4 - strlen($formlist->formlist->id) : 0) }}{{ $formlist->formlist->id }}
                    </td>
                    <td style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark " colspan="2"><span style="margin-left: 2px">Rev: </span>{{ $formlist->formlist->revision }}
                    </td>
                </tr>
                <tr>
                    <td class="border border-dark text-center font-weight-bold" style="padding: 0; margin: 0; font-size: 0.8em;" colspan="4">Fornecimento</td>
                    <td class="border border-dark text-center font-weight-bold" style="padding: 0; margin: 0; font-size: 0.8em;" colspan="2">Entrega</td>
                    <td class="border border-dark text-center font-weight-bold" style="padding: 0; margin: 0; font-size: 0.8em;" colspan="2">Devolução</td>
                </tr>
            </tbody>
            <tfoot class="table table-bordered table-sm table-striped">
                <thead class="thead-dark text-center">
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center" width="25px">#</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center" width="20px">Qtd.</th>
                    {{-- <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Cód</th> --}}
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">C.A.</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Descrição</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Data</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Assinatura</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Data</th>
                    <th style="padding: 0; margin: 0; font-size: 0.8em;" class="border border-dark text-center">Assinatura</th>
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
                                <p style=" margin: 0; font-size: 1em;">
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
</body>

</html>

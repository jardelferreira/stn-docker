<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>{{ $formlist->formlist->description }}-{{ $formlist->employee->user->name }}</title>
</head>

<body>
    <div class="table-responsive text-nowrap">
        <table class="table table-sm table-bordered">
            <thead class="">
                <tr>
                    <th class="border border-dark" colspan="3" id="img_logo">
                             <img src="{{ asset('images/stnlogo.png') }}" alt="logo-stn">
                    </th>
                    <th class="border border-dark text-center text-uppercase" colspan="4">
                        {{ $formlist->formlist->description }}</th>
                    <th class="border border-dark" colspan="2">
                        <p>FORM. Nº-0{{ $formlist->formlist->id }}</p>
                        Rev: {{ $formlist->formlist->revision }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-dark" colspan="5" style="font-size: 0.8em"><span>Nome:</span>
                        {{ $formlist->employee->user->name }}</td>
                    <td class="border border-dark" colspan="4" style="font-size: 0.8em"><span>Matricula:</span>
                        {{ $formlist->employee->registration }}</td>
                </tr>
                <tr>
                    <td style="font-size: 0.8em" class="border border-dark" colspan="5"><span>Responsável:</span>
                        Marcos Athie Trevisan</td>
                    <td style="font-size: 0.8em" class="border border-dark" colspan="4"><span>Unidade
                            (Obra):</span>{{ $formlist->base->name }}(
                        {{ $formlist->base->project->name }})</td>
                </tr>
                <tr>
                    <td class="border border-dark" style="font-size: 0.8em" colspan="6"><span>Área:</span>

                        <div class="d-inline py-0 my-0">
                            <label class="d-inline py-0 ml-2 my-0" style="font-size: 0.8em">
                                <input type="checkbox" class="d-inline py-0 my-0" name="area[]" value="area"
                                    checked>Civil
                            </label>
                        </div>
                        <div class="d-inline py-0 my-0">
                            <label class="d-inline py-0 ml-2 my-0" style="font-size: 0.8em">
                                <input type="checkbox" class="d-inline py-0 my-0" name="area[]" value="area">
                                Elétrica
                            </label>
                        </div>
                        <div class="d-inline py-0 my-0">
                            <label class="d-inline py-0 ml-2 my-0" style="font-size: 0.8em">
                                <input type="checkbox" class="d-inline py-0 my-0" name="area[]" value="area">
                                Eletromecânica
                            </label>
                        </div>
                        <div class="d-inline py-0 my-0">
                            <label class="d-inline py-0 ml-2 my-0" style="font-size: 0.8em">
                                <input type="checkbox" class="d-inline py-0 my-0" name="area[]" value="area">
                                Engenharia
                            </label>
                        </div>
                        <div class="d-inline py-0 my-0">
                            <label class="d-inline py-0 ml-2 my-0" style="font-size: 0.8em">
                                <input type="checkbox" class="d-inline py-0 my-0" name="area[]" value="area">
                                Ti
                            </label>
                        </div>
                    </td>
                    <td class="border border-dark" colspan="3" style="font-size: 0.8em">
                        <span>Admissão:</span> {{ date('d/m/Y', strtotime($formlist->employee->admission)) }}
                    </td>
                </tr>
                <tr>
                    <td class="border border-dark text-center font-weight-bold" colspan="5" style="font-size: 0.8em">
                        Fornecimento</td>
                    <td style="font-size: 0.8em" class="border border-dark text-center font-weight-bold" colspan="2">
                        Entrega</td>
                    <td style="font-size: 0.8em" class="border border-dark text-center font-weight-bold" colspan="2">
                        Devolução</td>
                </tr>
            </tbody>
            <tfoot class="table table-bordered table-sm table-striped">
                <thead class="thead-dark text-center">
                    <th style="font-size: 0.8em" class="border border-dark text-center" width="15px">#</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">Qtd.</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">Cód</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">C.A.</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">Descrição</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">Data</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">Assinatura</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">Data</th>
                    <th style="font-size: 0.8em" class="border border-dark text-center">Assinatura</th>
                </thead>
                <tbody id="list">
                    @foreach ($formlist->fields()->get() as $key => $field)
                        <tr>
                            <td class="border text-center border-dark p-0 m-0">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">{{ $key + 1 }}</p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">{{ $field->stoks->id }}</p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">{{ $field->qtd_delivered }}</p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">
                                    {{ $field->stoks->invoiceProduct->ca_number }}</p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">
                                    {{ $field->stoks->invoiceProduct->description }}</p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">
                                    {{ date('d/m/Y', strtotime($field->date_delivered)) }}</p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">
                                    @if ($field->signature_delivered)
                                        Assinado
                                    @else
                                        Falha na assinatura
                                    @endif
                                </p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">{{ $field->date_returned }}</p>
                            </td>
                            <td class="border text-center border-dark">
                                <p style="padding: 0; margin: 0; font-size: 0.6em;">{{ $field->signature_returned }}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </tfoot>
        </table>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
<script>
    $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
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

    #img_logo {}

    #img_logo img {
        max-width: 175px;
    }
</style>

</html>

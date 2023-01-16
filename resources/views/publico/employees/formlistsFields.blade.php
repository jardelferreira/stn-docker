@extends('publico.page')

@section('title', 'Formulário')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

@section('content')
    <h2 class="bg-light">
        <a class="ms-4 btn btn-primary btn-sm" onclick="window.print()" href="#">imprimir ficha<i
                class="fas fa-print fa-fw"></i></a>
        <a id="del" class="btn btn-outline-danger btn-sm" href="#" role="button"
            onclick="DownloadFile('{{ $formlist->name }}-{{ $employee->user->name }}.pdf','{{ route('formlistPdf', $formlist_employee) }}')">
            Salvar PDF - <i class="fa fa-file-pdf " aria-hidden="true"></i>
        </a>
    </h2>
    <div class="table-responsive text-nowrap bg-light mt-1 mx-1">

        <table class="table table-sm table-bordered" id="section-to-print">
            <thead class="">
                <tr>
                    <th class="border border-dark" colspan="2" id="img_logo">
                        <img src="{{ asset('images/stnlogo.png') }}" alt="">
                    </th>
                    <th class="border border-dark text-center text-uppercase" colspan="5">
                        {{ $formlist->description }}</th>
                    <th class="border border-dark" colspan="2">
                        <p>FORM. Nº-0{{ $formlist->id }}</p>
                        Rev: {{ $formlist->revision }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-dark" colspan="5"><span>Nome:</span> {{ $employee->user->name }}</td>
                    <td class="border border-dark" colspan="4"><span>Matricula:</span> {{ $employee->registration }}</td>
                </tr>
                <tr>
                    <td class="border border-dark" colspan="5"><span>Responsável:</span> Marcos Athie Trevisan</td>
                    <td class="border border-dark" colspan="4"><span>Unidade (Obra):</span>{{ $base->name }}(
                        {{ $base->project->name }})</td>
                </tr>
                <tr>
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
                </tr>
                <tr>
                    <td class="border border-dark text-center font-weight-bold" colspan="5"><span> Fornecimento</span>
                    </td>
                    <td class="border border-dark text-center font-weight-bold" colspan="2"><span> Entrega</span></td>
                    <td class="border border-dark text-center font-weight-bold" colspan="2"><span> Devolução</span></td>
                </tr>
            </tbody>
            <tbody id="list">
                <tr id="head-itens" class="table table-bordered">
                    <th class="border border-dark text-center " width="25px"><span>#</span></th>
                    <th class="border border-dark text-center "><span>Código.</span></th>
                    <th class="border border-dark text-center "><span>Qtd.</span></th>
                    <th class="border border-dark text-center "><span>C.A.</span></th>
                    <th class="border border-dark text-center "><span>Descrição</span></th>
                    <th class="border border-dark text-center "><span>Data</span></th>
                    <th class="border border-dark text-center "><span>Assinatura</span></th>
                    <th class="border border-dark text-center "><span>Data</span></th>
                    <th class="border border-dark text-center "><span>Assinatura</span></th>
                </tr>
                @foreach ($fields as $key => $field)
                    <tr>
                        <td class="border text-center border-dark p-0 m-0">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $key + 1 }}</p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->stoks->id }}</p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->qtd_delivered }}</p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">
                                {{ $field->stoks->invoiceProduct->ca_number }}</p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">
                                {{ $field->stoks->invoiceProduct->description }}</p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">
                                {{ date('d/m/Y', strtotime($field->date_delivered)) }}</p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">
                                @if ($field->signature_delivered)
                                    Assinado
                                @else
                                    Falha na assinatura
                                @endif
                            </p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->date_returned }}</p>
                        </td>
                        <td class="border text-center border-dark">
                            <p style="padding: 0; margin: 0; font-size: 0.8em;">{{ $field->signature_returned }}</p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('css')

    <style>
        td>span {
            font-weight: bold;
        }

        #list tr:nth-child(even) {
            background-color: #A9BCF5;
        }



        #img_logo img {
            max-width: 175px;
        }
    </style>
    <style type="text/css" media="print">
        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                border: black solid 1px;
                position: absolute;
                left: 5px;
                top: 10px;
                padding: 2px;
                margin: 5px;
            }

            @page {
                size: landscape;

            }
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
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
                    var blob = new Blob([data], {
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
                        swal.close()
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
    </script>
@endsection

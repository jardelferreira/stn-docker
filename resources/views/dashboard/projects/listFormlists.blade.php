@extends('adminlte::page')

@section('title', 'Listagem de Fichas')

@section('content_header')
    <div class="form-check form-check-inline">
        <h4>Listagem de fichas do projeto - <small class="text-primary">{{ $project->name }}</small></h4>
        <label class="custom-checkbox ml-4">
            <input type="checkbox" id="checkbox">
            <span class="checkmark"></span>
            BAIXAR CERTIFICADOS JUNTO
        </label>
    </div>
@stop
@section('css')
    <style>
        th {
            text-align: center !important;
            margin: auto;
        }

        td {
            white-space: nowrap !important;
        }

        #history {
            font-size: 0.8em;
        }

        #history tbody td {
            margin-top: 0 !important;
            padding-top: 0 !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        /* Esconda o checkbox padrão */
        .custom-checkbox input[type="checkbox"] {
            display: none;
        }

        /* Estilo do contêiner da caixa de seleção */
        .custom-checkbox {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            font-size: 16px;
        }

        /* Estilo do checkmark */
        .custom-checkbox .checkmark {
            width: 20px;
            /* Aumente o tamanho aqui */
            height: 20px;
            /* Aumente o tamanho aqui */
            border: 2px solid #4c57af;
            background-color: #fff;
            border-radius: 4px;
            display: inline-block;
            position: relative;
            margin-right: 10px;
            transition: all 0.3s;
        }

        /* Estilo do checkmark quando o checkbox está checado */
        .custom-checkbox input[type="checkbox"]:checked+.checkmark {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        /* Estilo do pseudo-elemento do checkmark */
        .custom-checkbox .checkmark::after {
            content: "";
            position: absolute;
            left: 3px;
            /* Ajuste para centralizar a marca de verificação */
            top: 1px;
            /* Ajuste para centralizar a marca de verificação */
            width: 10px;
            /* Ajuste para centralizar a marca de verificação */
            height: 10px;
            /* Ajuste para centralizar a marca de verificação */
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
            opacity: 0;
            transition: opacity 0.3s;
        }

        /* Exibe o pseudo-elemento quando o checkbox está checado */
        .custom-checkbox input[type="checkbox"]:checked+.checkmark::after {
            opacity: 1;
        }

        /* Estilo do checkmark quando focado */
        .custom-checkbox input[type="checkbox"]:focus+.checkmark {
            box-shadow: 0 0 3px 2px rgba(76, 175, 80, 0.5);
        }
    </style>
@endsection
@section('content')
    @if ($bases->count())
        <table class="table table-striped table-bordered" id="formlists">
            <thead class="thead-inverse thead-secondary border border-light">
                <tr>
                    <th>Base</th>
                    <th>Funcionário</th>
                    <th>Formulário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bases as $base)
                    @foreach ($base->employees as $employee)
                        @foreach ($employee->formlistsFromEmployee as $formlistsFromEmployee)
                            <tr>
                                <td scope="row">{{ $base->name }}</td>
                                <td scope="row">{{ $formlistsFromEmployee->employee->user->name }}</td>
                                <td scope="row">{{ $formlistsFromEmployee->formlist->name }}</td>
                                <td scope="row">
                                    <a id="del" class="btn ml-1 rounded btn-outline-danger btn-sm" href="#"
                                        role="button"
                                        onclick="DownloadFile('{{ $formlistsFromEmployee->formlist->name }}-{{ $formlistsFromEmployee->employee->user->name }}.pdf',
                                                '{{ route('stn.formlistPdf', $formlistsFromEmployee->id) }}')">
                                        Salvar PDF - <i class="fa fa-file-pdf " aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach

            </tbody>
        </table>
    @else
        <p>Não há permissões para listagem</p>
    @endif

@endsection
@section('js')
    <script>
        $.ajax({
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#formlists').DataTable({
                    responsive: true,
                    order: [1, 'asc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });
        function DownloadFile(fileName, url) {
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
            });

            var popupTextElement = "";
            documentable = document.getElementById("checkbox").checked ? 1 : 0
            $.ajax({
                url: `${url}?documentable=${documentable}`,
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
    </script>
@endsection

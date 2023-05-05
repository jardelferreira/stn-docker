@extends('adminlte::page')

@section('css')
    <style>
        * {
            padding: 0;
            margin: 0;
            border: 0;
        }

        svg:not(:root) {
            display: block;
        }

        .playable-code {
            background-color: #a3e8ff;
            border: none;
            border-left: 6px solid #558abb;
            border-width: medium medium medium 6px;
            color: #4d4e53;
            height: 100px;
            width: 90%;
            padding: 10px 10px 0;
        }

        .playable-canvas {
            border: 1px solid #4d4e53;
            border-radius: 2px;
        }

        .playable-buttons {
            text-align: right;
            width: 90%;
            padding: 5px 10px 5px 26px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        #image,
        #img_signature {
            background-image: linear-gradient(rgba(255, 255, 255, .7) 0%, rgba(255, 255, 255, .7) 100%), url("https://www.jfwebsystem.com.br/images/stnlogo.png");
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
            width: 100%;
            height: 100%;
            back
        }

        #back {
            background-image: linear-gradient(rgba(255, 255, 255, .7) 0%, rgba(255, 255, 255, .7) 100%), url("https://www.jfwebsystem.com.br/images/stnlogo.png");
            background-repeat: repeat space;
            background-size: 5%;
        }

        #img_signature {
            width: 7cm;
        }

        #image {
            width: 10cm;
        }
    </style>
@endsection
@section('content')
    <div>
        @if ($receipt->list()->exists())
            <div class="btn-group no-print">
                @if ($receipt->link)
                    <a class="mx-1 btn btn-primary" href="{{ $receipt->link }}" target="_blank">Acessar link público</a>
                @else
                    <form action="{{ route('dashboard.financeiro.receipts.genLink', $receipt) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button class="mx-1 btn btn-secondary" type="submit">Atualizar link público</button>
                    </form>
                @endif
                @if (!$receipt->temporary_link)
                    <button type="button" class="btn btn-primary btn-sm" id="genLink">
                        <small>Gerar link de assinatura</small>
                    </button>
                @else
                    <button type="button" class="btn btn-info btn-clipboard" data-clipboard-action="copy"
                        data-clipboard-text="{{ route('welcome') }}{{ $receipt->temporary_link }}">Copiar link para
                        assinatura</button>
                    <a class="btn btn-secondary ml-1" target="_blank" href="{{ $receipt->temporary_link }}">Link para
                        assinatura</a>
                @endif
            </div>
        @endif
        <div class="border border-dark" id="back">
            <div class="logo d-flex justify-content-center m-2">
                <img src="{{ asset('images/stnlogo.png') }}" height="100px" width="200px"
                    class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                    alt="logo da STN">
                <div class="ml-5" id="qrcode"></div>
            </div>
            <div class="alert alert-secondary text-center font-weight-bold text-uppercase h-5">Recibo - <span
                    id="number"><span
                        id="zerofill"></span>{{ str_repeat('0', strlen($receipt->id) < 5 ? 4 - strlen($receipt->id) : 0) }}{{ $receipt->id }}</span>
            </div>
            <div class=" mb-1 text-uppercase text-center font-weight-bold align-self-center border border-dark">
                {{ $receipt->branch->nome }} / {{ $receipt->branch->cidade }}-{{ $receipt->branch->uf }} -
                CNPJ n.º<span>{{ $receipt->branch->cnpj }}</span></div>
            <div class="border border-dark mb-1 p-1">
                <div class="border border-bottom">Eu,<span class="my-1">{{ $receipt->favored }}</span></div>
                <div class="border">CPF/CNPJ: <span class="my-1">{{ $receipt->register }}</span></div>
            </div>
            <div class="border border-dark p-1">
                <p class="border-bottom border-dark">Recebi a importancia de <span class="font-weight-bold" id="valued">
                        R$ {{ number_format($receipt->value, 2, ',', '.') }} </span><span id="extensed"
                        data-value="{{ number_format($receipt->value, 2, ',', '.') }}"></span>, da <span
                        class="font-weight-bold">
                        {{ $receipt->branch->nome }}.</span></p>
                @if (!$receipt->list()->count())
                    <div class="btn-group">
                        <button id="add" class="btn btn-primary">Adicionar mais</button>
                        <button id="send" class="btn ml-1 btn-success">Finalizar e salvar</button>
                    </div>
                    <form action="{{ route('dashboard.financeiro.receipts.storeList', $receipt) }}" method="post"
                        id="form">
                        @csrf
                        @method('POST')
                        <div class="form-row mb-2" id="formline">
                            <button id="rm" type="button" class="btn btn-danger ml-2"><i class="fa fa-trash"
                                    aria-hidden="true" disable></i></button>
                            <div class="form-group col-2">
                                <label for="qtd[]">Qtd:</label>
                                <input type="number" class="form-control" name="qtd[]" id="qtd[]"
                                    aria-describedby="helpQtd" placeholder="5">
                                <small id="helpQtd" class="form-text text-muted">10 und</small>
                            </div>
                            <div class="form-group  col-9">
                                <label for="description[]">Descrição</label>
                                <input type="text" class="form-control" name="description[]" id="description[]"
                                    aria-describedby="helpDescription" placeholder="descreva o item aqui">
                                <small id="helpDescription" class="form-text text-muted">Descreva o produto</small>
                            </div>
                            <hr>
                        </div>
                    </form>
                @else
                    <P class="font-weight-bold">Referente a:</P>
                    <ul class="list-group">
                        @foreach ($receipt->list as $item)
                            <li class="list-group-item">{{ $item->qtd }} - {{ $item->description }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="d-flex align-items-center flex-column mb-1">
                @if ($receipt->signature()->exists())
                    <p class="border-bottom border-dark p-0 mb-2 mt-2">{{ $receipt->local }}, <span id="emited"
                            data-created="{{ $receipt->created_at }}"></span></p>
                    <img src="{{ $receipt->signature->signature_image ?? '' }}" alt="assinatura digital"
                        id="img_signature">
                        <p class="border-top border-dark p-0 mt-0 text-center" style="width: 15cm;">Assinatura</p>
                @else
                    <p class="border-bottom border-dark mb-5 mt-5">{{ $receipt->local }}, <span id="emited"
                            data-created="{{ $receipt->created_at }}" style="height: 7cm;"></span></p>
                    <p class="border-top border-dark mt-5 text-center" style="width: 15cm;">Assinatura</p>
                @endif
            </div>
            <div class="d-flex justify-content-center">
                <small>gerado em jfwebsystem.com.br <span id="genered">
                        {{ date_create($receipt->created_at)->format('d/m/Y H:i:s') }}</span> Usuário: <span
                        class="font-weight-bold">
                        {{ $receipt->user->name }}</span></small>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        $(document).ready(function() {
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



            var clipboard = new ClipboardJS('.btn-clipboard');
            clipboard.on('success', function(e) {
                Toast.fire({
                    icon: 'success',
                    title: 'Link copiado com sucesso!'
                })
            });

            clipboard.on('error', function(e) {
                Toast.fire({
                    icon: 'error',
                    title: 'Não foi possível copiar!'
                })
            });

        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        getNowDate = () => {
            date = new Date().addHours(24);
            date_string = date.toLocaleString("pt-BR", {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric'
            })
            // parse date_string formtat '01/05/2023, 11:12' to array ['01', '05', '2023', ' T11:12']
            date_array = date_string.replace(", ", "/T").split("/")
            // generate especific format from input datetime-locale => "yyyy-MM-ddThh:mm" 

            return `${date_array[2]}-${date_array[1]}-${date_array[0]}${date_array[3]}`;
        }

        $("#genLink").on("click", () => {
            var url = window.location.href;

            Swal.fire({
                title: 'Informe a data limite para o link',
                html: ` <input type="datetime-local" class="swal2-input" name="assign_limit" id="assign_limit" aria-describedby="limit" placeholder="">`,
                footer: `<p>prazo mínimo de 1h</p>`,
                inputAttributes: {
                    autocapitalize: 'off',
                    required: true,
                },
                confirmButtonText: 'Confirmar',
                showLoaderOnConfirm: true,
                didOpen: (e) => {
                    Swal.getHtmlContainer().querySelector('#assign_limit').value = getNowDate();

                },
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (!value) {
                            resolve($("#assign_limit").val())
                        }
                        resolve()
                    })
                },
                preConfirm: (pass) => {
                    Swal.showLoading()
                    datetime = Swal.getHtmlContainer().querySelector('#assign_limit').value;
                    if (!datetime) {
                        Swal.showValidationMessage("A data é Obrigatória!")
                    }
                    // requisição
                    return $.ajax({
                        method: "POST",
                        url: url.replace("show", "genTemporaryLink"),
                        data: {
                            datetime: `${datetime.replace("T"," ")}:00`,
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
                    Swal.DismissReason.timer
                    Swal.fire({
                        icon: "success",
                        title: "Url Gerada com sucesso!",
                    })
                    window.location.reload()
                    // Swal.fire({
                    //     icon: result.value.type,
                    //     title: result.value.message,
                    //     text: result.value.event,
                    //     footer: result.value.footer,
                    //     didOpen: (element) => {
                    //         $("#signature_delivered").val(signature);
                    //         $("form").submit();
                    //     }
                    // })

                }
            })

        })
    </script>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>


    <script>
        String.prototype.extenso = function(c) {
            var ex = [
                ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze",
                    "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"
                ],
                ["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
                ["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos",
                    "oitocentos", "novecentos"
                ],
                ["mil", "milhão", "bilhão", "trilhão", "quadrilhão", "quintilhão", "sextilhão", "setilhão",
                    "octilhão", "nonilhão", "decilhão", "undecilhão", "dodecilhão", "tredecilhão", "quatrodecilhão",
                    "quindecilhão", "sedecilhão", "septendecilhão", "octencilhão", "nonencilhão"
                ]
            ];
            var a, n, v, i, n = this.replace(c ? /[^,\d]/g : /\D/g, "").split(","),
                e = " e ",
                $ = "real",
                d = "centavo",
                sl;
            for (var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []) {
                j && (n[j] = (("." + n[j]) * 1).toFixed(2).slice(2));
                if (!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [],
                        v = a ? v.concat(a) : v).length) continue;
                for (a = -1, l = v.length; ++a < l; t = "") {
                    if (!(i = v[a] * 1)) continue;
                    i % 100 < 20 && (t += ex[0][i % 100]) ||
                        i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
                    s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e +
                            t)) +
                        ((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ão", "ões") : ex[3][t]) :
                            ""));
                }
                a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (n[j + 1] * 1 >
                    0) || r.length) ? "" : ex[0][0]));
                a && r.push(a + (c ? (" " + (v.join("") * 1 > 1 ? j ? d + "s" : (/0{6,}$/.test(n[0]) ? "de " : "") + $
                    .replace("l", "is") : j ? d : $)) : ""));
            }
            return r.join(e);
        }

        window.onload = () => {
            valued = document.getElementById("valued").textContent.split(",");
            document.getElementById("extensed").textContent =
                `(${valued[0].extenso()} reais ${valued[1] > 0 ? `, e ${valued[1].extenso()} centavos` : ''})`

            data = $("#emited").attr("data-created")
            data = new Date(data);

            var day = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira",
                "Sábado"
            ][data.getDay()];
            var date = data.getDate();
            var month = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro",
                "Outubro", "Novembro", "Dezembro"
            ][data.getMonth()];
            var year = data.getFullYear();

            document.getElementById("emited").textContent = `${day}, ${date} de ${month} de ${year}`
            // document.getElementById("genered").textContent = new Date(Date.now()).toLocaleString();


            const qrcode = new QRCode(document.getElementById('qrcode'), {
                text: window.location.href,
                width: 100,
                height: 100,
                colorDark: '#000',
                colorLight: '#fff',
                correctLevel: QRCode.CorrectLevel.H
            });

            add = document.getElementById("add")
            if (add) {

                add.addEventListener("click", () => {
                    clone = document.getElementById("formline").cloneNode(true)
                    document.getElementById("form").prepend(clone)
                    rm = document.getElementById("rm")
                    rm.addEventListener("click", (e) => {
                        console.log(e)
                        if (e.target.parentNode.tagName == "DIV") {
                            e.target.parentNode.remove()
                        } else {
                            e.target.parentNode.parentNode.remove()
                        }

                    })
                })
                document.getElementById("send").addEventListener("click", () => document.getElementById("form")
                    .submit())
            }


        }
    </script>
@endsection

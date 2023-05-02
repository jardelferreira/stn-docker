<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Assinatura de recibos</title>
</head>

<body class="p-2">
    @if ($receipt->list()->exists())

        <div id="header">
            <h1>Assinatura de recibo</h1>
            <div class="btn-group">
                <a class="ml-1 rounded btn btn-primary btn-sm" onclick="window.print()" href="#">imprimir Recibo<i
                        class="fas fa-print fa-fw"></i></a>
                @if (!$receipt->signature()->exists())
                    <button class="btn btn-info ml-1" onclick="signatureCanvas()">Assinatura Digital<i
                            class="fa fa-pencil ml-1" aria-hidden="true"></i> </button>
                @endif
            </div>
            <hr>
        </div>
    @endif
    <style>
        * {
            padding: 0;
            margin: 0;
            border: 0;
        }

        html {
            font-size: 1.4rem;
        }

        @media print {
            #header {
                display: none;
            }
        }

        #sig-canvas {
            border: 2px dotted #CCCCCC;
            border-radius: 15px;
            cursor: crosshair;
            margin: 0;

        }

        #img-signature {
            width: 10cm;
        }
    </style>
    <div class="m-2">
        <div class="border border-dark">
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
                CNPJ N.º<span>{{ $receipt->branch->cnpj }}</span></div>
            <div class="border border-dark mb-1 p-1">
                <div class="border border-bottom">Eu,<span class="my-1">{{ $receipt->favored }}</span></div>
                <div class="border">CPF/CNPJ: <span class="my-1">{{ $receipt->register }}</span></div>
            </div>
            <div class="border border-dark p-1">
                <p class="border-bottom border-dark">Recebi a importancia de <span class="font-weight-bold"
                        id="valued">
                        R$ {{ number_format($receipt->value, 2, ',', '.') }} </span><span id="extensed"
                        data-value="{{ number_format($receipt->value, 2, ',', '.') }}"></span>, da <span
                        class="font-weight-bold">
                        {{ $receipt->branch->nome }}.</span></p>
                <P class="font-weight-bold">Referente a:</P>
                <ul class="list-group">
                    @foreach ($receipt->list as $item)
                        <li class="list-group-item">{{ $item->qtd }} - {{ $item->description }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="d-flex align-items-center flex-column mb-1">
                <p class="border-bottom border-dark p-0 mb-3 mt-2">{{ $receipt->local }}, <span id="emited"
                        data-created="{{ $receipt->created_at }}"></span></p>
                <p class=" mt-2 mb-2 mt-5 p-0">
                    @if ($receipt->signature()->exists())
                        <img src="{{ $receipt->signature->signature_image ?? '' }}" id="img_signature"
                            alt="assinatura digital">
                    @endif
                </p>
                <p class="border-top border-dark p-0 mt-0 text-center" style="width: 15cm;">Assinatura</p>
            </div>
            <div class="d-flex justify-content-center">
                <small>gerado em jfwebsystem.com.br <span id="genered">
                        {{ date_create($receipt->created_at)->format('d/m/Y H:i:s') }}</span> Usuário: <span
                        class="font-weight-bold">
                        {{ $receipt->user->name }}</span></small>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- SweetAlert2 -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script> --}}
    <script>
        window.signatureHtml = () => {
            return `<div class="container bg-light">
		<div m-0 p-0" id="canvas">
		 		<canvas id="sig-canvas" width="660" height="380" class="bg-light">
		 		</canvas>
		</div>
		<div id="image" width="660" height="380">
				<img id="sig-image" src=""/>
		</div>`
        }
    </script>

    {{-- canvas --}}
    <script>
        function signatureCanvas() {
            Swal.fire({
                title: "<small>Assine o documento no campo abaixo</small>",
                html: signatureHtml(),
                footer: `<div class="row">
				<button class="btn btn-primary btn-sm mt-0 mb-0" id="sig-submitBtn"><small>Visualizar</small></button>
				<button class="btn btn-success btn-sm mt-0 mb-0" id="sig-send"><small>Assinar</small></button>
				<button class="btn btn-secondary btn-sm ml-1 mt-0 mb-0" id="sig-clearBtn"><small>Apagar</small></button>
				<button class="btn btn-danger ml-1 btn-sm p-0" id="close">fechar</button>
		        </div>`,
                background: "linear-gradient( 95.2deg, rgba(173,252,234,1) 26.8%, rgba(192,229,246,1) 64% )",
                showCancelButton: false,
                showConfirmButton: false,
                width: 1024,

            })

            $("#sig-send").hide();
            $("#image").hide();
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
            ctx.strokeStyle = "#000F55";
            ctx.lineWidth = 4;

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
                var ctx = canvas.getContext("2d");
                ctx.strokeStyle = "#000F55";
                ctx.lineWidth = 4;
            }

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");
            var sendBtn = document.getElementById("sig-send");
            var closeBtn = document.getElementById("close");

            closeBtn.addEventListener("click", (e) => {
                clearCanvas();
                sigImage.setAttribute("src", "");
                $("#sig-submitBtn").show();
                $("#image").show();
                $("#canvas").show();
                $("#sig-send").hide();
                Swal.close()
            })
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                sigImage.setAttribute("src", "");
                $("#sig-submitBtn").show();
                $("#image").show();
                $("#canvas").show();
                $("#sig-send").hide();
            }, false);
            submitBtn.addEventListener("click", function(e) {
                var dataUrl = canvas.toDataURL();
                // sigText.innerHTML = dataUrl;
                if (dataUrl.length < 5000) {
                    console.log("Falha ao assinar");
                } else {
                    $("#sig-send").show();
                    $("#sig-submitBtn").hide();
                    $("#canvas").hide();
                    $("#image").show();
                    sigImage.setAttribute("src", dataUrl);
                }
            }, false);
            sendBtn.addEventListener("click", function(e) {
                // var dataUrl = canvas.toDataURL();
                // $("#sig-submitBtn").show();
                // $("#image").hide();
                // $("#sig-send").hide();
                $(".swal2-modal").hide();
                Swal.close();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = window.location.href
                Swal.fire({
                    title: 'Confirmação',
                    icon: 'question',
                    html: `<h3>Enviar assinatura digital? `,
                    confirmButtonText: 'Confirmar',
                    showLoaderOnConfirm: true,
                    preConfirm: (pass) => {
                        Swal.showLoading()
                        dataUrl = canvas.toDataURL();
                        if (!dataUrl) {
                            Swal.showValidationMessage("A assinatura é obrigatória!")
                        }
                        // requisição
                        return $.ajax({
                            method: "POST",
                            url: `${url.substr(0,url.indexOf("assinatura"))}assign`,
                            data: {
                                dataUrl: dataUrl,
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
                            title: "Documento Assinado com sucesso!",
                        })
                        window.location.reload()

                    }
                })

            }) // end send event
        }
    </script>
</body>

</html>

<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Assinatura de recibos</title>
</head>

<body class="p-2">
    <div id="header">
        <h1>Assinatura de recibo</h1>
        <div class="btn-group">
            <a class="ml-1 rounded btn btn-primary btn-sm" onclick="window.print()" href="#">imprimir Recibo<i
                    class="fas fa-print fa-fw"></i></a>
        </div>
        <hr>
    </div>
    <style>
        * {
            padding: 0;
            margin: 0;
            border: 0;
        }

        @media print {
            #header {
                display: none;
            }
        }
    </style>
    <div class="m-2" id="receipt">
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
                    <img src="{{ $receipt->signature->signature_image ?? "" }}" alt="assinatura digital">
                    @endif</p>
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

</body>

</html>

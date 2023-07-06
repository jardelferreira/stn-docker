<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Consulta Fichas</title>
</head>

<body class="d-block align-items-center mb-5">

    <div class="d-flex justify-content-center mt-5">
        <img src="{{ asset('images/stnlogo.png') }}" alt="Logo" class="img-fluid">
    </div>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <form method="POST" action="{{ route('stn.redirectUserByCpf') }}" enctype="multipart/form-data"
            class="col-lg-4 col-md-6 col-sm-12">
            @csrf
            <div class="form-group mt-2">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" aria-describedby="helpCpf"
                    placeholder="Digite seu CPF">
                <small id="helpCpf" class="form-text text-muted">Informe seu CPF</small>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Consultar fichas</button>

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js"
integrity="sha512-hAJgR+pK6+s492clbGlnrRnt2J1CJK6kZ82FZy08tm6XG2Xl/ex9oVZLE6Krz+W+Iv4Gsr8U2mGMdh0ckRH61Q=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () { 
        var $cpf = $("#cpf");
        $cpf.mask('000.000.000-00', {reverse: true});
    });
  </script>
</html>

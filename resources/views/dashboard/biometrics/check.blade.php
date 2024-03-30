<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verificação de Biometria</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- SweetAlert2 CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 15px 15px 0 0;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Verificação de Biometria</h5>
                    </div>
                    <div class="card-body">
                        <form id="biometryForm">
                            <div class="form-group">
                                <label for="biometryHash">Hash da Biometria:</label>
                                <textarea class="form-control" id="biometryHash" rows="5" placeholder="Cole o hash da biometria aqui"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" onclick="verifyBiometry()">Verificar
                                    Biometria</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Bootstrap JS (optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Função para realizar a verificação da biometria
        function verifyBiometry() {
            // Obtém o valor do hash da biometria do campo de entrada
            var digital = $('#biometryHash').val();
            template = {}
            template.template = digital
            if (digital != "") {
                // digital = JSON.parse(digital);
                $.ajax({
                    url: 'https://localhost:9000/apiservice/match-one-on-one',
                    type: 'POST',
                    headers: {
                        'Access-Control-Allow-Origin': '*',
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
                        'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept'
                    },
                    dataType: 'json',
                    data: JSON.stringify(template),
                    success: function(data) {
                        if (data != "") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Verificação de biometria bem-sucedida!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: 'Digital capturada não corresponde!'
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        if (!xhr.status) {
                            Swal.fire({
                                icon: 'error',
                                title: `Atenção!`,
                                text: "Não Foi possível identificar a digital."
                            });
                        } else {
                            errorCode = xhr.responseText.match(/\d+/g) ?? xhr.responseJSON.message;
                            Swal.fire({
                                icon: 'info',
                                title: `Atenção!`,
                                text: errosMap[errorCode] ?? xhr.responseText
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Por favor, cole o hash da biometria antes de verificar.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
        errosMap = {
            "261": "Leitor Biométrico não localizado",
            "513": "Operação cancelada pelo usuário",
            "1287": "Biometria existente no leitor",
            "Timeout": "Tempo de espera foi excedido!, não foi possível identificar a digital"
        }
    </script>
</body>

</html>

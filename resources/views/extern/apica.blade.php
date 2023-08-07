<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Consulta CA</title>
    <!-- Adicione o link do CSS do Bootstrap -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-1">
        <h4>Informações do Certificado de Aprovação</h4>
        <div class="row">
            <!-- Input para receber o número do CA -->
            <div class="form-group col-6">
                <label for="caNumber">Número do CA:</label>
                <input type="number" class="form-control" id="caNumber" placeholder="Digite o número do CA">
            </div>
            <button style="height: 50%; position: relative; top: 30px;" type="button" class="col-3 btn btn-primary"
                id="btnBuscarCA">Buscar CA</button>
            <!-- Botão para enviar a requisição -->
        </div>
       <div id="error"></div>
        <div class="row mt-4">
            <div class="col-md-6">
                <!-- Campos para exibir as informações -->
                <p><strong>Registro CA:</strong> <span id="registroCA"></span></p>
                <p><strong>Data de Validade:</strong> <span id="dataValidade"></span></p>
                <p><strong>Situação:</strong> <span id="situacao"></span></p>
                <p><strong>Número do Processo:</strong> <span id="nrProcesso"></span></p>
                <p><strong>CNPJ:</strong> <span id="cnpj"></span></p>
                <p><strong>Razão Social:</strong> <span id="razaoSocial"></span></p>
                <p><strong>Natureza:</strong> <span id="natureza"></span></p>
                <p><strong>Nome do Equipamento:</strong> <span id="nomeEquipamento"></span></p>
                <p><strong>Descrição do Equipamento:</strong> <span id="descricaoEquipamento"></span></p>
                <p><strong>Marca do CA:</strong> <span id="marcaCA"></span></p>
                <p><strong>Referência:</strong> <span id="referencia"></span></p>
            </div>
            <div class="col-md-6">
                <p><strong>Cor:</strong> <span id="cor">Nulo</span></p>
                <p><strong>Aprovado para Laudo:</strong> <span id="aprovadoParaLaudo"></span></p>
                <p><strong>Restrição de Laudo:</strong> <span id="restricaoLaudo">Nulo</span></p>
                <p><strong>Observação de Análise de Laudo:</strong> <span id="observacaoAnaliseLaudo"></span></p>
                <p><strong>CNPJ do Laboratório:</strong> <span id="cnpjLaboratorio"></span></p>
                <p><strong>Razão Social do Laboratório:</strong> <span id="razaoSocialLaboratorio"></span></p>
                <p><strong>NR do Laudo:</strong> <span id="nrLaudo">Nulo</span></p>
                <p><strong>Norma:</strong> <span id="norma">Nulo</span></p>
            </div>
        </div>
    </div>
    <!-- Adicione o link do JavaScript do Bootstrap e do jQuery (opcional) -->
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
    <!-- Script para fazer a requisição AJAX -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#btnBuscarCA").click(function() {
                // Obter o valor do input
                var caNumber = $("#caNumber").val();
                $.ajax({
                    method: "POST",
                    url: `https://www.apica.jfwebsystem.com.br/CA/${caNumber}`,
                }).done(function(data) {
                        // Preencher os campos com os valores recebidos
                        $("#registroCA").text(data.RegistroCA);
                        $("#dataValidade").text(data.DataValidade);
                        $("#situacao").text(data.Situacao);
                        $("#nrProcesso").text(data.NRProcesso);
                        $("#cnpj").text(data.CNPJ);
                        $("#razaoSocial").text(data.RazaoSocial);
                        $("#natureza").text(data.Natureza);
                        $("#nomeEquipamento").text(data.NomeEquipamento);
                        $("#descricaoEquipamento").text(data.DescricaoEquipamento);
                        $("#marcaCA").text(data.MarcaCA);
                        $("#referencia").text(data.Referencia);
                        $("#cor").text(data.Cor || "Nulo");
                        $("#aprovadoParaLaudo").text(data.AprovadoParaLaudo);
                        $("#restricaoLaudo").text(data.RestricaoLaudo || "Nulo");
                        $("#observacaoAnaliseLaudo").text(data.ObservacaoAnaliseLaudo);
                        $("#cnpjLaboratorio").text(data.CNPJLaboratorio);
                        $("#razaoSocialLaboratorio").text(data.RazaoSocialLaboratorio);
                        $("#nrLaudo").text(data.NRLaudo || "Nulo");
                        $("#norma").text(data.Norma || "Nulo");
                    }).fail(function(jqXHR, textStatus) {
                        $('#error').append(` <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Erro!</h4>
                            <p>Descrição</p>
                            <p class="mb-0">desculfa-pulse</p>
                            </div>`)
                    });
                // Fazer a requisição AJAX
                // $.ajax({
                //     type: "GET",
                //     url: `https://apica.jfwebsystem.com.br/CA/${caNumber}`, // Substitua pela URL da sua API
                //     success: function(data) {
                //         // Preencher os campos com os valores recebidos
                //         $("#registroCA").text(data.RegistroCA);
                //         $("#dataValidade").text(data.DataValidade);
                //         $("#situacao").text(data.Situacao);
                //         $("#nrProcesso").text(data.NRProcesso);
                //         $("#cnpj").text(data.CNPJ);
                //         $("#razaoSocial").text(data.RazaoSocial);
                //         $("#natureza").text(data.Natureza);
                //         $("#nomeEquipamento").text(data.NomeEquipamento);
                //         $("#descricaoEquipamento").text(data.DescricaoEquipamento);
                //         $("#marcaCA").text(data.MarcaCA);
                //         $("#referencia").text(data.Referencia);
                //         $("#cor").text(data.Cor || "Nulo");
                //         $("#aprovadoParaLaudo").text(data.AprovadoParaLaudo);
                //         $("#restricaoLaudo").text(data.RestricaoLaudo || "Nulo");
                //         $("#observacaoAnaliseLaudo").text(data.ObservacaoAnaliseLaudo);
                //         $("#cnpjLaboratorio").text(data.CNPJLaboratorio);
                //         $("#razaoSocialLaboratorio").text(data.RazaoSocialLaboratorio);
                //         $("#nrLaudo").text(data.NRLaudo || "Nulo");
                //         $("#norma").text(data.Norma || "Nulo");
                //     },
                //     error: function(error) {
                //         // Lidar com o erro, se necessário
                //         alert("Erro ao buscar o CA.");
                //     }
                // });
            });
        });
    </script>
</body>

</html>

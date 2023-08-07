<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Consulta CA</title>
    <!-- Adicione o link do CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-1">
        <h4>Informações do Certificado de Aprovação</h4>
        <div class="row">
            <!-- Input para receber o número do CA -->
            <div class="form-group col-lg-9 col-sm-6">
                <label for="caNumber">Número do CA:</label>
                <input type="number" class="form-control" id="caNumber" placeholder="Digite o número do CA">
            </div>
            <button style="height: 50%; position: relative; top: 30px;" type="button" class="col-lg-3 col-sm-6 btn btn-primary" id="btnBuscarCA">Buscar CA</button>
            <!-- Botão para enviar a requisição -->
        </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <!-- Script para fazer a requisição AJAX -->
    <script>
        $(document).ready(function () {
            $("#btnBuscarCA").click(function () {
                // Obter o valor do input
                var caNumber = $("#caNumber").val();

                // Fazer a requisição AJAX
                $.ajax({
                    type: "GET",
                    url: `https://apica.jfwebsystem.com.br/CA/${caNumber}`, // Substitua pela URL da sua API
                    success: function (data) {
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
                    },
                    error: function () {
                        // Lidar com o erro, se necessário
                        alert("Erro ao buscar o CA.");
                    }
                });
            });
        });
    </script>
</body>

</html>
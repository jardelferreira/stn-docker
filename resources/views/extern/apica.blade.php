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
    <title>Consulta CA</title>
</head>

<body>
    <div class="container mt-1">
        <h4>Informações do Certificado de Aprovação</h4>
        <div class="row">
            <!-- Input para receber o número do CA -->
            <div class="form-group col-lg-6 col-sm-6">
                <label for="caNumber">Número do CA:</label>
                <input type="number" class="form-control" id="caNumber" placeholder="Digite o número do CA">
            </div>
            <button style="height: 50%; position: relative; top: 30px;" type="button"
                class="col-sm-4 col-lg-3 btn btn-primary" id="btnBuscarCA">Buscar CA</button>
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
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
        $("#btnBuscarCA").on('click', () => {
            var caNumber = $("#caNumber").val();
            $.ajax({
                type: 'GET',
                dataType: "jsonp",
                processData: false,
                crossDomain: true,
                url: `https://apica.jfwebsystem.com.br/CA/${caNumber}`,
                success: function(responseData, textStatus, jqXHR) {
                    console.log("in");
                    var data = JSON.parse(responseData['AuthenticateUserResult']);
                    console.log(data);
                },
                error: function(responseData, textStatus, errorThrown) {
                    alert(`GET failed. | response = ${textStatus} | data = ${responseData}`);
                }
            });
            $.ajax({
                url: `https://apica.jfwebsystem.com.br/CA/${caNumber}`,
                method: "GET",
                cache: false,
                success: function(data) {
                    //Convert the Byte Data to BLOB object.
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
                error: function(error) {
                    // Lidar com o erro, se necessário
                    alert(`Error, url = ${window.location.href}, error = ${error}`);
                }
            });
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Assinatura Digital</title>
    <!-- Adicionando Bootstrap 4 (CSS) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    {{-- {{dd($field->formlistBaseEmployee->base()->withoutGlobalScopes()->first()->project->name)}} --}}
    <div class="container mt-5">
        <h1 class="mb-4">Detalhes da Assinatura Digital</h1>

        <ul class="list-group">
            <li class="list-group-item"><strong>Documento Assinado:</strong>
                {{ $field->formlistBaseEmployee->formlist->description }}</li>
            <li class="list-group-item"><strong>Projeto:</strong>
                {{ $field->formlistBaseEmployee->base()->withoutGlobalScopes()->first()->project->name }}</li>
            <li class="list-group-item"><strong>Base:</strong>
                {{ $field->formlistBaseEmployee->base()->withoutGlobalScopes()->first()->name }}</li>
            <li class="list-group-item"><strong>Quem Assinou:</strong> {{ $user->user->name ?? $user->name }}</li>
            <li class="list-group-item"><strong>Usuário Logado:</strong> {{ $field->user->name }}</li>
            <li class="list-group-item"><strong>Descrição do Evento:</strong>
                {{ $signature->event ?? 'evento não localizado.' }}</li>
            <li class="list-group-item"><strong>Hash da Biometria:</strong>
                <span style="overflow-wrap: break-word;"
                    id="hash">{{ $biometric ?? 'hash não localizado.' }}</span><button
                    onclick="copyToClipboard()">Copiar
                    Texto</button>
            </li>
            @if ($biometric)
                <li class="list-group-item"><a href="{{ route('extern.check.biometric') }}" target="_blank"
                        rel="noopener noreferrer">Página de verificação de Biometrias </a></li>
            @endif
            <li class="list-group-item"><strong>Localização aproximada:</strong>
                {{ $signature->location ?? 'Local não informado.' }}</li>
            <li class="list-group-item"><strong>Assinado em:</strong>
                {{ \Carbon\Carbon::parse($signature->created_at)->format('d/m/Y H:m:s') }}</li>
        </ul>
    </div>

    <!-- Adicionando Bootstrap 4 (JS) e CryptoJS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha256.js"></script>

    <script>
        // Função para gerar o hash SHA-256 das informações da assinatura
        function generateHash() {
            const signatureDetails = {
                documento: "Nome do Documento",
                quemAssinou: "Nome do Signatário",
                usuarioLogado: "Nome do Usuário",
                descricaoEvento: "João pegou um {produto->description}, inserido por {auth->user}, no dia {date.now}.",
                localizacao: "Coordenadas Geográficas (latitude, longitude)",
                dispositivo: "Nome do Dispositivo"
            };

            // Concatenar as informações
            const concatenatedData = Object.values(signatureDetails).join('');

            // Gerar o hash SHA-256
            const hash = CryptoJS.SHA256(concatenatedData).toString();

            // Exibir o hash na página
            document.getElementById('hash').textContent = hash;
        }

        // Chamar a função ao carregar a página
        generateHash();

        function copyToClipboard() {
            var listItem = document.getElementById("hash");
            // Cria um elemento temporário para armazenar o texto
            var tempInput = document.createElement("textarea");
            tempInput.value = listItem.innerText;
            document.body.appendChild(tempInput);

            // Seleciona o texto no elemento temporário
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // Para dispositivos móveis

            // Copia o texto selecionado para a área de transferência
            document.execCommand('copy');
            // Remove o elemento temporário
            document.body.removeChild(tempInput);
            // Mensagem de confirmação
            alert("O texto foi copiado para a área de transferência:");
        }
    </script>

</body>

</html>

<div class="card page-break" style="width: 100%; position: absolute; left:0; top:0;">
    <div class="card-header d-flex">
        <h5 class="mb-0">Número CA: <span data-item="numero_ca">{{ $caepi->serie }}</span></h5>
        <div class="ml-3" style="float: right">
            @if ($_SERVER['HTTP_HOST'] == 'localhost')
            <a href="http://localhost{{URL::signedRoute('extern.documents.showFile',['document' => $caepi->id], null, false)}}" target="_blank"
                class="h6 text-light font-weight-bold btn" rel="noopener noreferrer">CLIQUE AQUI ACESSAR PDF DO
                CERTIFICADO</a></div>
            @else
                
            <a href="https://www.jfwebsystem.com.br/{{URL::signedRoute('extern.documents.showFile',['document' => $caepi->id], null, false)}}" target="_blank"
                class="h6 text-light font-weight-bold btn" rel="noopener noreferrer">CLIQUE AQUI ACESSAR PDF DO
                CERTIFICADO</a></div>
                @endif
    </div>
    <div class="card-body">
        <div class="row mb-1 p-1" style="display:flex">
            <label class="bdg-label" for="Sua Etiqueta">Sobre o CA</label>
            <div class="ctn bdg">
                <div class="item mx-1 font-weight-bold">Data de Validade: <span
                        data-item="data_validade">{{ $complements->data_validade }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Situação: <span
                        data-item="situacao">{{ $complements->situacao }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Processo: <span
                        data-item="processo">{{ $complements->processo }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">CNPJ: <span data-item="cnpj">{{ $complements->cnpj }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Razão Social: <span
                        data-item="razao_social">{{ $complements->razao_social }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Natureza: <span
                        data-item="natureza">{{ $complements->natureza }}</span>
                </div>
            </div>
        </div>
        <div class="row mb-1 p-1">
            <label class="bdg-label" for="Sua Etiqueta">Sobre o Equipamento</label>
            <div class="ctn bdg">
                <div class="item mx-1 font-weight-bold">Equipamento: <span
                        data-item="equipamento">{{ $complements->equipamento }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Marcação CA: <span
                        data-item="marcacao_ca">{{ $complements->marcacao_ca }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Referência: <span data-item="referencia">Gorila.</span>
                </div>
                <div class="item mx-1 font-weight-bold">Tamanho: <span
                        data-item="tamanho">{{ $complements->tamanho }}</span></div>
                <div class="item mx-1 font-weight-bold">Cor: <span
                        data-item="cor">{{ $complements->cor ?? 'N/A' }}</span></div>
                <div class="item mx-1 font-weight-bold">Descrição: <span
                        data-item="descricao">{{ $complements->descricao }}</span>
                </div>
            </div>
        </div>
        <div class="row mb-1 p-1">
            <label class="bdg-label" for="Sua Etiqueta">Sobre o Laudo</label>
            <div class="bdg ctn">
                <div class="item mx-1 font-weight-bold">Número do Laudo: <span
                        data-item="numero_laudo">{{ $complements->numero_laudo }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Laudo: <span data-item="laudo">{{ $complements->laudo }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">Observações do Laudo: <span
                        data-item="obs_laudo">{{ $complements->obs_laudo }}</span>
                </div>
            </div>
        </div>
        <div class="row mb-1 p-1">
            <label class="bdg-label" for="Sua Etiqueta">Sobre o Laboratório</label>
            <div class="bdg ctn">
                <div class="item  mx-1 font-weight-bold">Razão Social:
                    <span data-item="razao_social_laboratorio">{{ $complements->razao_social_laboratorio }}</span>
                </div>
                <div class="item mx-1 font-weight-bold">CNPJ:
                    <span data-item="cnpj_laboratorio">{{ $complements->cnpj_laboratorio }}</span>
                </div>

                <div class="item mx-1 font-weight-bold">Norma Técnica:
                    <span data-item="norma_tecnica">{{ $complements->norma_tecnica }}</span>
                </div>
                <div class=" mx-1 ">
                    <strong data-item="historico_alteracoes">{{ $complements->historico_alteracoes[0] }}</strong>
                    @for ($i = 1; $i < count($complements->historico_alteracoes); $i++)
                        <li style="margin-left: 10px">{{ $complements->historico_alteracoes[$i] }}</li>
                    @endfor

                    </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

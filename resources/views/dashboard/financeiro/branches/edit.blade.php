@extends('adminlte::page')
@section('title', 'Editar Nota')
@section('content_header')
    <h1>Alterar de Nota</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.invoices.index') }}">Notas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
    <hr>
@stop
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form">
        <form action="{{ route('dashboard.financeiro.branches.update') }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label for="nome">Nome: </label>
                    <input type="text" autocomplete="off" value="{{ $branch->nome }}" class="form-control" name="nome"
                        id="nome" aria-describedby="helpNome" placeholder="">
                    <small id="helpNome" class="form-text text-muted">informe o nome da filial</small>
                </div>
                <div class="form-group col-lg-4 col-md-6 col-sm-8">
                    <label for="cnpj">CNPJ: </label>
                    <input type="text" autocomplete="off" class="form-control" value="{{ $branch->cnpj }}" name="cnpj"
                        id="cnpj" aria-describedby="helpCNPJ" placeholder="17.933.652/0004-34">
                    <small id="helpCNPJ" class="form-text text-muted">Informe a CNPJ</small>
                </div>
                <div class="form-group col-lg-2 col-md-4 col-sm-4">
                    <label for="cep">CEP: </label>
                    <input type="number" autocomplete="off" class="form-control" name="cep" id="cep"
                        value="{{ $branch->cep }}" aria-describedby="helpCEP" placeholder="50500-000">
                    <small id="helpCEP" class="form-text text-muted">Informe o Vencimento</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-2 col-md-2 col-sm-2">
                    <label for="uf">UF: </label>
                    <input type="text" autocomplete="off" class="form-control" name="uf" value="{{ $branch->uf }}"
                        id="uf" aria-describedby="helpUF">
                    <small id="helpUF" class="form-text text-muted">Informe o Estado</small>
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-10">
                    <label for="cidade">Cidade: </label>
                    <input type="text" autocomplete="off" class="form-control" name="cidade"
                        value="{{ $branch->cidade }}" id="cidade" aria-describedby="helpCidade">
                    <small id="helpCidade" class="form-text text-muted">Cidade</small>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                    <label for="bairro">Bairro: </label>
                    <input id="bairro" class="form-control" type="bairro" name="bairro" value="{{ $branch->bairro }}">
                    <small id="helpBairro" class="form-text text-muted">Bairro</small>
                </div>
            </div>
            <div class="form-group col-lg-10 col-md-12 col-sm-12">
                <label for="logradouro">Logradouro: </label>
                <input id="logradouro" class="form-control" type="logradouro" name="logradouro"
                    value="{{ $branch->logradouro }}">
                <small id="helpBairro" class="form-text text-muted">Bairro</small>
            </div>
            <div class="form-group col-lg-2 col-md-12 col-sm-12">
                <label for="numero">Número: </label>
                <input id="numero" class="form-control" type="numero" name="numero" value="{{ $branch->numero }}">
                <small id="helpBairro" class="form-text text-muted">Número</small>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                <label for="complemento">Complemento: </label>
                <input id="complemento" class="form-control" type="complemento" name="complemento"
                    value="{{ $branch->complemento }}">
                <small id="helpBairro" class="form-text text-muted">Complemento</small>
            </div>
            <button type="submit" class="btn btn-success">Salvar alterações</button>
    </div>
    </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#logradouro").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {
                console.log("buscando")
                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#logradouro").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#logradouro").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#numero").focus();
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
    </script>
@stop

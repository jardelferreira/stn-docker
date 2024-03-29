@extends('adminlte::page')

@section('title', 'Cadastro de Recibo')

@section('content_header')
    <h1>Cadastro de Recibo</h1>
    <hr>
@stop

@section('content')
    <div class="form">
        <form action="{{ route('dashboard.financeiro.receipts.store') }}" method="post" autocomplete="off">
            @csrf
            @method('POST')
            <div class="form">
                <div class="row">
                    <div class="form-group col-lg-8 col-md-8 col-sm-6">
                        <label for="branch_id">Filial</label>
                        <select class="form-control" name="branch_id" id="branch_id">
                            <option>Selecione...</option>
                            @foreach ($branches as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }} /
                                    {{ $item->cidade }}-{{ $item->uf }}</option>
                            @endforeach
                        </select>
                        <small id="helpBranch" class="form-text text-muted">Filiais cadastradas.</small>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-6">
                        <label for="local">Local</label>
                        <input type="text" class="form-control" name="local" id="local"
                            aria-describedby="helpLocal" placeholder="ex: Areal-RJ">
                        <small id="helpLocal" class="form-text text-muted">Cidade que será realizado o pagemnto.</small>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-2 col-md-2  col-sm-4">
                        <label for="value">Valor</label>
                        <input type="text" class="form-control" name="value" id="value"
                            aria-describedby="helpValur" placeholder="1.250,00">
                        <small id="helpValur" class="form-text text-muted">Informe o valor total</small>
                    </div>

                    <div class="form-group col-lg-5 col-md-5  col-sm-8">
                        <label for="favored">Favorecido</label>
                        <input type="text" class="form-control" name="favored" id="favored"
                            aria-describedby="helpFavored" placeholder="nome do favorecido">
                        <small id="helpFavored" class="form-text text-muted">Informe o nome do favorecido</small>
                    </div>
                    <div class="form-group col-lg-5 col-md-5  col-sm-6">
                        <label for="register">CPF/CNPJ</label>
                        <input type="text" class="form-control" name="register" id="register"
                            aria-describedby="helpRegister" placeholder="17.933.652/0001-81">
                        <small id="helpRegister" class="form-text text-muted">Informe o número do documento</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
    <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#value").inputmask('currency', {
                "autoUnmask": true,
                radixPoint: ",",
                groupSeparator: ".",
                allowMinus: false,
                prefix: 'R$ ',
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });
        });
        $("form").on("submit", (e) => {
            e.preventDefault()
            $("#value").inputmask('remove');
            e.currentTarget.submit()
        })
    </script>
@stop

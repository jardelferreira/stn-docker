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
        <form action="{{ route('dashboard.invoices.update') }}" method="post" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row">
                <input type="hidden" name="uuid" value="{{ $invoice->uuid }}">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="number">Número: </label>
                    <input type="text" autocomplete="off" class="form-control" value="{{ $invoice->number }}"
                        name="number" id="number" aria-describedby="helpName" placeholder="0001">
                    <small id="helpName" class="form-text text-muted">informe número da nota</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="invoice_type">Tipo de Documento: </label>
                    <select class="form-control" name="invoice_type" id="invoice_type">
                        <option value="">Selecione o tipo de documento</option>
                        <option @if ($invoice->invoice_type == 'NF') selected @endif value="NF">NF</option>
                        <option @if ($invoice->invoice_type == 'NFS') selected @endif value="NFS">NFS</option>
                        <option @if ($invoice->invoice_type == 'FAT') selected @endif value="FAT">FAT</option>
                        <option @if ($invoice->invoice_type == 'CTE') selected @endif value="CTE">CTE</option>
                        <option @if ($invoice->invoice_type == 'REC') selected @endif value="REC">REC</option>
                    </select>
                    <small id="helpName" class="form-text text-muted">Informe o tipo</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="issue">Emissão: </label>
                    <input type="date" autocomplete="off" value="{{ $invoice->issue }}" class="form-control"
                        name="issue" id="issue" aria-describedby="helpName" placeholder="emissão">
                    <small id="helpName" class="form-text text-muted">Informe a Emissão</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="due_date">Vencimento: </label>
                    <input type="date" autocomplete="off" class="form-control" value="{{ $invoice->due_date }}"
                        name="due_date" id="due_date" aria-describedby="helpName" placeholder="vencimento">
                    <small id="helpName" class="form-text text-muted">Informe o Vencimento</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-sm-12 col-md-12">
                    <label for="provider">Fornecedor: </label>
                    <select id="provider" class="form-control" name="provider_id">
                        <option value="">Selecione um fornecedor</option>
                        @foreach ($providers as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $invoice->provider_id) selected @endif>
                                {{ $item->corporate_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6 col-sm-12 col-md-12">
                    <label for="departament_cost">Departamento: </label>
                    <select id="departament_cost" class="form-control" name="departament_cost_id">
                        <option value="">Selecione um departamento</option>
                        @foreach ($departament_costs as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $invoice->departament_cost_id) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="value">Valor total: </label>
                    <input type="text" value="{{ $invoice->value }}" step="0.01" autocomplete="off"
                        class="form-control" name="value" id="value" aria-describedby="helpName"
                        placeholder="R$ 1.000,00">
                    <small id="helpName" class="form-text text-muted">Informar valor</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="value_departament">Valor para o Departamento: </label>
                    <input type="text" step="0.01" autocomplete="off"
                        value="{{ floatVal($invoice->value_departament) }}" class="form-control"
                        name="value_departament" id="value_departament" aria-describedby="helpName"
                        placeholder="R$ 1.000,00">
                    <small id="helpName" class="form-text text-muted">Informar valor</small>
                </div>
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label for="file">Carregar arquivo</label>
                    <input id="file" class="form-control-file" type="file" name="file_invoice">
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
            $("#value, #value_departament").inputmask('currency', {
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

        })
        $("form").on("submit", (e) => {
            e.preventDefault()
            $("#value,#value_departament").inputmask('remove');
            e.currentTarget.submit()
        })
    </script>
@stop

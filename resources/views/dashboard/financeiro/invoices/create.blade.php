@extends('adminlte::page')

@section('title', 'Cadastro de Notas')

@section('content_header')
    <h1>Cadastro de Notas</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.invoices.index') }}">Notas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastrar</li>
        </ol>
    </nav>
    <hr>
@stop

@section('content')
    <div class="form">
        <form action="{{ route('dashboard.invoices.store') }}" method="post" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="number">Número: </label>
                    <input type="text" autocomplete="off" class="form-control" name="number" id="number"
                        aria-describedby="helpName" placeholder="0001">
                    <small id="helpNumber" class="form-text text-muted">informe número da nota</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="invoice_type">Tipo de Documento: </label>
                    <select class="form-control" name="invoice_type" id="invoice_type">
                        <option value="">Selecione o tipo de documento</option>
                        <option value="NF">NF</option>
                        <option value="NFS">NFS</option>
                        <option value="FAT">FAT</option>
                        <option value="CTE">CTE</option>
                        <option value="REC">REC</option>
                        <option value="CF">CUPOM FISCAL</option>
                    </select>
                    <small id="helpInvoice_type" class="form-text text-muted">Informe o tipo</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="issue">Emissão: </label>
                    <input type="date" autocomplete="off" class="form-control" name="issue" id="issue"
                        aria-describedby="helpName" placeholder="emissão">
                    <small id="helpIssue" class="form-text text-muted">Informe a Emissão</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="due_date">Vencimento: </label>
                    <input type="date" autocomplete="off" class="form-control" name="due_date" id="due_date"
                        aria-describedby="helpName" placeholder="vencimento">
                    <small id="helpDue_date" class="form-text text-muted">Informe o Vencimento</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-sm-12 col-md-12">
                    <label for="provider">Fornecedor: </label>
                    <select id="provider" class="form-control" name="provider_id">
                        <option value="">Selecione um fornecedor</option>
                        {{-- @foreach ($providers as $item)
                            <option value="{{ $item->id }}"><small>{{ $item->corporate_name }}</small></option>
                        @endforeach --}}
                    </select>
                    <small id="helpProvider" class="form-text text-muted">Lista de Fornecedores</small>
                </div>
                <div class="form-group col-lg-6 col-sm-12 col-md-12">
                    <label for="departament_cost">Departamento: </label>
                    <select id="departament_cost" class="form-control" name="departament_cost_id">
                        <option value="">Selecione um departamento</option>
                        @foreach ($departament_costs as $item)
                            <option value="{{ $item->id }}"><small>{{ $item->sectorCost->cost->project->name }} =>
                                    {{ $item->sectorCost->cost->name }} => {{ $item->sectorCost->name }} =>
                                    {{ $item->name }}</small></option>
                        @endforeach
                    </select>
                    <small id="helpDepartament_cos" class="form-text text-muted">Lista de departamentos</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="value">Valor total: </label>
                    <input type="text" step="0.01" autocomplete="off" class="form-control" name="value"
                        id="value" aria-describedby="helpName" placeholder="R$ 1.000,00">
                    <small id="helpName" class="form-text text-muted">Informar valor</small>
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="value_departament">Valor para Departamento: </label>
                    <input type="text" step="0.01" autocomplete="off" class="form-control" name="value_departament"
                        id="value_departament" aria-describedby="helpName" placeholder="R$ 1.000,00">
                    <small id="helpName" class="form-text text-muted">Informar valor</small>
                </div>
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label for="file">Carregar arquivo: </label>
                    <input id="file" class="form-control-file" type="file" name="file_invoice">
                    <small id="helpFile" class="form-text text-muted">carregar PDF</small>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
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

        $("#provider_id").select2({
                    ajax: {
                        url: `https://www.jfwebsystem.com.br/api/providers`,
                        type: "GET",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term, // search term
                            };
                        },
                        processResults: function(response) {

                            let providers = response.map(function(e) {
                                return {
                                    "id": e.id,
                                    "text": e.name
                                }
                            })
                            return {
                                results: providers
                            };
                        },
                        cache: true
                    }
                });
    </script>
@stop

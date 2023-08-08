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
    @if ($errors->has('name'))
        <div class="alert alert-danger p-0 m-1">
           <p class="p-0">{{$errors->first('name')}}</p>
        </div>
    @endif
    <div class="form">
        <form action="{{ route('dashboard.invoices.store') }}" method="post" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="number">Número: </label>
                    <input type="text" autocomplete="off"
                        class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="number" id="number"
                        required aria-describedby="helpName" placeholder="0001" value="{{ old('number') }}">
                    @if ($errors->has('number'))
                        <div class="invalid-feedback">
                            {{$errors->first('number') }}
                        </div>
                    @else
                        <small id="helpNumber" class="form-text text-muted">informe número da nota</small>
                    @endif
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="invoice_type">Tipo de Documento: </label>
                    <select class="form-control {{ $errors->has('invoice_type') ? 'is-invalid' : '' }}" name="invoice_type"
                        id="invoice_type" value="{{ old('invoice_type') }}" required>
                        <option value="">Selecione o tipo de documento</option>
                        <option value="NF">NF</option>
                        <option value="NFS">NFS</option>
                        <option value="FAT">FAT</option>
                        <option value="CTE">CTE</option>
                        <option value="REC">REC</option>
                        <option value="CF">CUPOM FISCAL</option>
                    </select>
                    @if ($errors->has('invoice_type'))
                        <div id="" class="invalid-feedback">
                            {{ $errors->first('invoice_type') }}
                        </div>
                    @else
                        <small id="helpInvoice_type" class="form-text text-muted">Informe o tipo</small>
                    @endif
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="issue">Emissão: </label>
                    <input type="date" autocomplete="off"
                        class="form-control {{ $errors->has('issue') ? 'is-invalid' : '' }}" name="issue" id="issue"
                        value="{{ old('issue') }}" aria-describedby="helpName" placeholder="emissão" required>
                    @if ($errors->has('issue'))
                        <div class="invalid-feedback">
                            {{$errors->first('issue') }}
                        </div>
                    @else
                        <small id="helpIssue" class="form-text text-muted">Informe a Emissão</small>
                    @endif
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="due_date">Vencimento: </label>
                    <input type="date" autocomplete="off"
                        class="form-control {{ $errors->has('due_date') ? 'is-invalid' : '' }}" name="due_date"
                        id="due_date" required value="{{ old('due_date') }}" aria-describedby="helpName"
                        placeholder="vencimento">
                    @if ($errors->has('due_date'))
                        <div id="" class="invalid-feedback">
                            {{ $errors->first('due_date') }}
                        </div>
                    @else
                        <small id="helpDue_date" class="form-text text-muted">Informe o Vencimento</small>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-6 col-sm-12 col-md-12">
                    <label for="provider">Fornecedor: </label>
                    <select id="provider" class="form-control {{ $errors->has('provider_id') ? 'is-invalid' : '' }}"
                        name="provider_id"   required value="{{ old('provider_id') }}">
                        <option value="">Selecione um fornecedor</option>
                        {{-- @foreach ($providers as $item)
                            <option value="{{ $item->id }}"><small>{{ $item->corporate_name }}</small></option>
                        @endforeach --}}
                    </select>
                    @if ($errors->has('provider_id'))
                        <div id="" class="invalid-feedback">
                            {{ $errors->first('provider_id') }}
                        </div>
                    @else
                        <small id="helpProvider" class="form-text text-muted">Lista de Fornecedores</small>
                    @endif
                </div>
                <div class="form-group col-lg-6 col-sm-12 col-md-12">
                    <label for="departament_cost">Departamento: </label>
                    <select id="departament_cost" class="form-control {{ $errors->has('departament_cost_id') ? 'is-invalid' : '' }}" name="departament_cost_id"
                        value="{{ old('departament_cost_id') }}">
                        <option value="">Selecione um departamento</option>
                        @foreach ($departament_costs as $item)
                            <option value="{{ $item->id }}"><small>{{ $item->sectorCost->cost->project->name }} =>
                                    {{ $item->sectorCost->cost->name }} => {{ $item->sectorCost->name }} =>
                                    {{ $item->name }}</small></option>
                        @endforeach
                    </select>
                    @if ($errors->has('departament_cost_id'))
                        <div id="" class="invalid-feedback">
                            {{ $errors->first('departament_cost_id') }}
                        </div>
                    @else
                        <small id="helpDepartament_cos" class="form-text text-muted">Lista de departamentos</small>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="value">Valor total: </label>
                    <input type="text" step="0.01" autocomplete="off" class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value"
                         required value="{{ old('value') }}" id="value"
                        aria-describedby="helpName" placeholder="R$ 1.000,00">
                    @if ($errors->has('value'))
                        <div id="" class="invalid-feedback">
                            {{ $errors->first('value') }}
                        </div>
                    @else
                        <small id="helpName" class="form-text text-muted">Informar valor</small>
                    @endif
                </div>
                <div class="form-group col-lg-3 col-md-6 col-sm-12">
                    <label for="value_departament">Valor para Departamento: </label>
                    <input type="text" step="0.01" autocomplete="off" class="form-control {{ $errors->has('value_departament') ? 'is-invalid' : '' }}" required
                        value="{{ old('value_departament') }}" id="value_departament" name="value_departament" aria-describedby="helpName"
                        placeholder="R$ 1.000,00">
                    @if ($errors->has('value_departament'))
                        <div id="" class="invalid-feedback">
                            {{ $errors->first('value_departament') }}
                        </div>
                    @else
                        <small id="helpName" class="form-text text-muted">Informar valor</small>
                    @endif
                </div>
                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                    <label for="file">Carregar arquivo: </label>
                    <input id="file" class="form-control-file {{ $errors->has('file_invoice') ? 'is-invalid' : '' }}" type="file" name="file_invoice" required>
                    @if ($errors->has('file_invoice'))
                        <div id="" class="invalid-feedback">
                            {{ $errors->first('file_invoice') }}
                        </div>
                    @else
                        <small id="helpFile" class="form-text text-muted">carregar PDF</small> 
                    @endif
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        var url = window.location.href;
        $("#provider").select2({
            ajax: {
                url: `${url.substring(0,url.indexOf("dashboard"))}api/providers`,
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                    };
                },
                processResults: function(response) {
                    // console.log(response);
                    let providers = response.map(function(e) {
                        return {
                            "id": e.id,
                            "text": e.corporate_name
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

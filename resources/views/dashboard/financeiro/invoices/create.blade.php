@extends('adminlte::page')

@section('title', 'Cadastro de Notas')

@section('content_header')
    <h1>Cadastro de Notas</h1>
@stop

@section('content')
    <form action="{{route('dashboard.invoices.store')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="number">Número</label>
          <input type="text" autocomplete="off" class="form-control" name="number" id="number" aria-describedby="helpName" placeholder="0001">
          <small id="helpName" class="form-text text-muted">informe número da nota</small>
        </div>
        <div class="form-group">
          <label for="provider">Fornecedor</label>
          <select id="provider" class="form-control" name="provider_id">
            <option value="">Selecione um fornecedor</option>
            @foreach ($providers as $item)
                <option value="{{$item->id}}">{{$item->corporate_name}}</option>
            @endforeach
          </select>
        </div> 
        <div class="form-group">
          <label for="departament_cost">Departamento</label>
          <select id="departament_cost" class="form-control" name="departament_cost_id">
            <option value="">Selecione um departamento</option>
            @foreach ($departament_costs as $item)
                <option value="{{$item->id}}">{{$item->sectorCost->cost->project->name}} => {{$item->sectorCost->cost->name}} => {{$item->sectorCost->name}} => {{$item->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="value">Valor total</label>
          <input type="number" step="0.01" autocomplete="off" class="form-control" name="value" id="value" aria-describedby="helpName" placeholder="R$ 1.000,00">
          <small id="helpName" class="form-text text-muted">Informar valor</small>
        </div>
        <div class="form-group">
          <label for="value_departament">Valor</label>
          <input type="number" step="0.01" autocomplete="off" class="form-control" name="value_departament" id="value_departament" aria-describedby="helpName" placeholder="R$ 1.000,00">
          <small id="helpName" class="form-text text-muted">Informar valor</small>
        </div>
        <div class="form-group">
          <label for="issue">Emissão</label>
          <input type="date" autocomplete="off" class="form-control" name="issue" id="issue" aria-describedby="helpName" placeholder="emissão">
          <small id="helpName" class="form-text text-muted">Informe a Emissão</small>
        </div>
        <div class="form-group">
          <label for="due_date">Vencimento</label>
          <input type="date" autocomplete="off" class="form-control" name="due_date" id="due_date" aria-describedby="helpName" placeholder="vencimento">
          <small id="helpName" class="form-text text-muted">Informe o Vencimento</small>
        </div>
        <div class="form-group">
          <label for="invoice_type">Tipo de Documento</label>
          <select class="form-control" name="invoice_type" id="invoice_type">
            <option value="">Selecione o tipo de documento</option>
           <option value="NF">NF</option>
           <option value="NFS">NFS</option>
           <option value="FAT">FAT</option>
           <option value="CTE">CTE</option>
           <option value="REC">REC</option>
          </select>
          <small id="helpName" class="form-text text-muted">Informe o tipo</small>
        </div>
      <div class="form-group">
        <label for="file">Carregar arquivo</label>
        <input id="file" class="form-control-file" type="file" name="file_invoice">
      </div>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

{{-- @section('js')
    <script> console.log('Hi!'); </script>
@stop --}}
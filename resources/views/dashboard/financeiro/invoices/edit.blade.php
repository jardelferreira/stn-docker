@extends('adminlte::page')

@section('content')
<div class="container">
  <form action="{{route('dashboard.invoices.edit',$invoice)}}" method="post" autocomplete="off" enctype="multipart/form-data">
      @csrf
        @method('POST')
        <div class="form-group">
          <label for="number">Número</label>
          <input type="text" autocomplete="off" class="form-control" name="number" id="number" aria-describedby="helpName" placeholder="razão social">
          <small id="helpName" class="form-text text-muted">informe número da nota</small>
        </div>
        <div class="form-group">
          <label for="provider">Fornecedor</label>
          <select id="provider" class="form-control" name="provider_id">
            <option value="">Selecione um fornecedor</option>
            @foreach ($providers as $item)
            <option value="{{$item->id}}"
              @if ($item->id == $invoice->provider_id)
                  selected
              @endif
              >{{$item->corporate_name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="value">Valor</label>
          <input type="number" step="0.01" autocomplete="off" class="form-control" name="value" id="value" aria-describedby="helpName" placeholder="nome fantasia">
          <small id="helpName" class="form-text text-muted">Insira o nome do projeto</small>
        </div>
        <div class="form-group">
          <label for="issue">Emissão</label>
          <input type="date" autocomplete="off" class="form-control" name="issue" id="issue" aria-describedby="helpName" placeholder="nome fantasia">
          <small id="helpName" class="form-text text-muted">Informe a Emissão</small>
        </div>
        <div class="form-group">
          <label for="due_date">Vencimento</label>
          <input type="date" autocomplete="off" class="form-control" name="due_date" id="due_date" aria-describedby="helpName" placeholder="nome fantasia">
          <small id="helpName" class="form-text text-muted">Informe o Vencimento</small>
        </div>
        <div class="form-group">
          <label for="invoice_type"></label>
          <select class="form-control" name="invoice_type" id="invoice_type">
            <option value="">Selecione um projeto para o setor de custo</option>
           <option value="NF">NF</option>
           <option value="NFS">NFS</option>
           <option value="FAT">FAT</option>
           <option value="CTE">CTE</option>
           <option value="REC">REC</option>
          </select>
        </div>
      <div class="form-group">
        <label for="file">Carregar arquivo</label>
        <input id="file" class="form-control-file" type="file" name="file_invoice">
      </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
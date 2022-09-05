@extends('adminlte::page')

@section('title', 'Cadastro de fornecedores')

@section('content_header')
    <h1>Cadastro de Fornecedores</h1>
@stop

@section('content')
    <form action="{{route('dashboard.providers.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="corporate_name">Razão Social</label>
          <input type="text" autocomplete="off" class="form-control" name="corporate_name" id="corporate_name" aria-describedby="helpName" placeholder="razão social">
          <small id="helpName" class="form-text text-muted">informe a razão social</small>
        </div>
        <div class="form-group">
          <label for="fantasy_name">Nome Fantasia</label>
          <input type="text" autocomplete="off" class="form-control" name="fantasy_name" id="fantasy_name" aria-describedby="helpName" placeholder="nome fantasia">
          <small id="helpName" class="form-text text-muted">Insira o nome do projeto</small>
        </div>
        <div class="form-group">
          <label for="cnpj">CNPJ</label>
          <input type="text" autocomplete="off" class="form-control" name="cnpj" id="cnpj" aria-describedby="helpName" placeholder="nome fantasia">
          <small id="helpName" class="form-text text-muted">Insira o CNPJ</small>
        </div>
        <div class="form-group">
          <label for="headquarters">Caso este fornecedor pertença a uma matriz, favor selecionar da lista</label>
          <select class="form-control" name="headquarters" id="headquarters">
            <option value="">Selecione um fornecedor para cadastrar como matriz</option>
            @foreach ($headquarters as $item)
                <option value="{{$item->id}}">{{$item->corporate_name}}</option>
            @endforeach
          </select>
          <small id="headquarters" class="form-text text-muted">Não é obrigatório</small>
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
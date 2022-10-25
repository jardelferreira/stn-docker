@extends('adminlte::page')

@section('title', 'Cadastro de Setores')

@section('content_header')
    <h1>Cadastro de Setores</h1>
@stop

@section('content')
    <form action="{{route('dashboard.sectors.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome do Setor</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da Setores">
          <small id="helpName" class="form-text text-muted">Insira o nome do Setor</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do Setor</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="nome da Setores">
          <small id="description" class="form-text text-muted">Descreva este Setores</small>
        </div>
        <div class="form-group">
          <label for="base_id">Selecione uma setor</label>
          <select class="form-control" name="base_id" id="bases">
            <option value="">Selecione a Base para o Setor</option>
            @foreach ($bases as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
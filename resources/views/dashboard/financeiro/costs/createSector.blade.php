@extends('adminlte::page')

@section('title', 'Cadastro de setor de custo')

@section('content_header')
    <h1>Cadastro de setor de custos</h1>
@stop

@section('content')
    <form action="{{route('dashboard.costs_sectors.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome do setor de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da setor de custo">
          <small id="helpName" class="form-text text-muted">Insira o nome do setor</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do setor de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="descrição">
          <small id="description" class="form-text text-muted">Descrição do setor</small>
        </div>
      <input type="hidden" name="cost_center_id" value="{{$cost->id}}">

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
@extends('adminlte::page')

@section('title', 'Profissões')

@section('content_header')
    <h1>Cadastro de Profissão	</h1>
@stop

@section('content')
    <form action="{{route('dashboard.professions.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Profissão</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da profissão">
          <small id="helpName" class="form-text text-muted">Insira o nome do profissão</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="helpDecription" placeholder="Descreva as atribuições dessa profissão aqui">
          <small id="helpDescription" class="form-text text-muted">Descrição da profissão</small>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop
{{-- 
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
    <script> console.log('Hi!'); </script>
@stop
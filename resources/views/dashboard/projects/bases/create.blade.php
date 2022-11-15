@extends('adminlte::page')

@section('title', 'Cadastro de Bases')

@section('content_header')
    <h1>Cadastro de Bases</h1>
@stop

@section('content')
    <form action="{{route('dashboard.bases.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome do Base</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da Bases">
          <small id="helpName" class="form-text text-muted">Insira o nome do Base</small>
        </div>
        <div class="form-group">
          <label for="place">Local da Base</label>
          <input type="text" autocomplete="off" class="form-control" name="place" id="place" aria-describedby="place" placeholder="nome da Bases">
          <small id="place" class="form-text text-muted">Insira o local do Base</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do Base</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="nome da Bases">
          <small id="description" class="form-text text-muted">Descreva este Bases</small>
        </div>
        <div class="form-group">
          <label for="project_id"></label>
          <select class="form-control" name="project_id" id="projects">
            <option value="">Selecione um projeto para o Bases</option>
            @foreach ($projects as $item)
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
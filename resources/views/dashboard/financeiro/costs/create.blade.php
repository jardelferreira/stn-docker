@extends('adminlte::page')

@section('title', 'Cadastro de centro de custo')

@section('content_header')
    <h1>Cadastro de Centro de custos</h1>
@stop

@section('content')
    <form action="{{route('dashboard.costs.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome do Centro de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da centro de custo">
          <small id="helpName" class="form-text text-muted">Insira o nome do Centro de custo</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do Centro de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="nome da centro de custo">
          <small id="description" class="form-text text-muted">Descreva este centro de custo</small>
        </div>
        <div class="form-group">
          <label for="project_id"></label>
          <select class="form-control" name="project_id" id="projects">
            <option value="">Selecione um projeto para o centro de custo</option>
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
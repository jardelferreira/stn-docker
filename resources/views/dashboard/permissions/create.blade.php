@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastro de permissões </h1>
@stop

@section('content')
    <form action="{{ route('dashboard.permissions.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="row">
            <div class="form-group col-3">
                <label for="name">Permissão</label>
                <input type="text" autocomplete="off" class="form-control" name="name" id="name"
                    aria-describedby="'helpName'" placeholder="nome da permissão">
                <small id="'helpName'" class="form-text text-muted">Insira o nome do permissão</small>
            </div>
            <div class="form-group">
                <label for="resource">Recurso</label>
                <select class="custom-select" name="resource" id="resource">
                    <option selected>System</option>
                    <option value="project">Projeto</option>
                    <option value="base">Base</option>
                    <option value=""></option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary my-2">Cadastrar</button>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastro de usuários</h1>
@stop

@section('content')
    <form action="{{route('dashboard.users.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="'helpName'" placeholder="nome do usuário">
          <small id="'helpName'" class="form-text text-muted">Insira o nome do usuário</small>
        </div>
        <div class="form-group">
          <label for="email">E-mail:</label>
          <input type="email" class="form-control" autocomplete="off" name="email" id="email" aria-describedby="emailHelpId" placeholder="usuario@mail">
          <small id="emailHelpId" class="form-text text-muted">informe um e-mail válido</small>
          <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" name="password" autocomplete="off" id="password" placeholder="informe sua senha">
          </div>
          <div class="form-group">
            <label for="_confirm">Confirmação de senha</label>
            <input type="password" class="form-control" name="_confirm" autocomplete="off" id="_confirm" placeholder="repita a senha">
          </div>
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
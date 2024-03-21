@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastro de usuários</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('dashboard.users.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="row">
            <div class="form-group col-lg-6 col-sm-12">
                <label for="name">Nome:</label>
                <input type="text" autocomplete="off" class="form-control" name="name" id="name"
                    aria-describedby="'helpName'" placeholder="nome do usuário">
                <small id="'helpName'" class="form-text text-muted">Insira o nome do usuário</small>
            </div>
            <div class="form-group col-lg-6 col-sm-12">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" autocomplete="off" name="email" id="email" required
                    aria-describedby="emailHelpId" placeholder="usuario@mail">
                <small id="emailHelpId" class="form-text text-muted">informe um e-mail válido</small>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label for="password">Senha</label>
                <input type="password" class="form-control" name="password" autocomplete="off" id="password" required
                    placeholder="informe sua senha">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label for="password_confirmation">Confirmação de senha</label>
                <input type="password" class="form-control" name="password_confirmation" autocomplete="off" required
                    id="password_confirmation" placeholder="repita a senha">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
              <label class="form-group mt-5 ml-5">
                <input type="checkbox" class="form-check-input" name="biometric" id="biometric" value="checkedValue" checked>
                Cadastrar Biometria após o Cadastro
              </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

@section('css')

@stop

@section('js')
    <script>

    </script>
@stop

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastro de Projetos</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.projects.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="row">
            <div class="form-group col-lg-8 col-md-8 col-sm-12">
                <label for="name">Nome do projeto</label>
                <input type="text" autocomplete="off" class="form-control" name="name" id="name"
                    aria-describedby="helpName" placeholder="Nome do projeto">
                <small id="helpName" class="form-text text-muted">Insira o nome do projeto</small>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label for="initials">Sigla do projeto</label>
                <input type="text" autocomplete="off" class="form-control" name="initials" id="initials"
                    aria-describedby="helpDecription" placeholder="PJATRIO">
                <small id="helpDescription" class="form-text text-muted">Descrição da projeto</small>
            </div>
        </div>
        <div class="form-group col-12">
            <label for="description">Descrição</label>
            <input type="text" autocomplete="off" class="form-control" name="description" id="description"
                aria-describedby="helpDecription" placeholder="Descreva seu projeto aqui">
            <small id="helpDescription" class="form-text text-muted">Descrição da projeto</small>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        let inputName = document.getElementById("name");
        inputName.addEventListener("keyup", (e) => {
          
            let initials = "";
            regex = /[0-9]/;
            let arrayNames = e.target.value.split(" ");
            arrayNames.forEach((e) => {
                if (e.length < 3) {
                    initials += e.toUpperCase();
                } else {
                    initials += regex.test(e) ? `-${e.toUpperCase()}-` : e[0].toUpperCase();
                }
            })
            document.getElementById("initials").value = initials;
        })
    </script>
@stop

@extends('adminlte::page')

@section('title', 'Criar Formulários')

@section('content_header')
    <h1>Cadastro de Formulários</h1>
@stop

@section('content')
    <form action="{{route('dashboard.formlists.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST') 
        <div class="form-group">
          <label for="name">Nome do formulário</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="Nome do formulário">
          <small id="helpName" class="form-text text-muted">Insira o nome do formulário</small>
        </div>
        {{-- <div class="form-group">
          <label for="revision">Revisão</label>
          <input type="text" autocomplete="off" class="form-control" name="revision" id="revision" aria-describedby="helpDecription" placeholder="Descreva seu formulário aqui">
          <small id="helpDescription" class="form-text text-muted">Revisão da formulário</small>
        </div> --}}
        {{-- <div class="form-group"> 
          <label for="initials">Sigla do formulário</label>
          <input type="text" autocomplete="off" class="form-control" name="initials" id="initials" aria-describedby="helpDecription" placeholder="SGLT - 2022">
          <small id="helpDescription" class="form-text text-muted">Descrição da formulário</small>
        </div> --}}
        <div class="form-group">
          <label for="area">Área</label>
          <select class="form-control" name="area" id="area">
            <option>Selecione uma área de aplicação</option>
            <option>Civil</option>
            <option>Eletro mecânica</option>
            <option>Eletrica</option>
            <option>Engenharia</option>
            <option>Adm</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description">Descrição</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="helpDecription" placeholder="Descreva seu formulário aqui">
          <small id="helpDescription" class="form-text text-muted">Descrição da formulário</small>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

{{-- @section('js')
    <script>
     let  inputName = document.getElementById("name");
     inputName.addEventListener("blur", (e) => {
       let initials = "";
        regex = /[0-9]/;
       let  arrayNames = e.target.value.split(" ");
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
@stop --}}
@extends('adminlte::page')

@section('title', 'Cadastro de Empregados')

@section('content_header')
    <h1>Cadastro de Empregados</h1>
@stop

@section('content')
    <form action="{{route('dashboard.employees.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="cpf">CPF</label>
          <input type="text" autocomplete="off" class="form-control" name="cpf" id="cpf" aria-describedby="helpCPF">
          <small id="helpCPF" class="form-text text-muted">informe número do CPF</small>
        </div>
        <div class="form-group">
          <label for="user">Usuário</label>
          <select id="user" class="form-control" name="user_id">
            <option value="">Selecione um Usuário</option>
            @foreach ($users as $item)
                <option value="{{$item->id}}">{{$item->name}} => {{$item->email}}</option>
            @endforeach
          </select>
        </div> 
        <div class="form-group">
          <label for="profession">Profissão</label>
          <select id="profession" class="form-control" name="profession_id">
            <option value="">Selecione um Profissão</option>
            @foreach ($professions as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="admission">Adimissão</label>
          <input type="date" autocomplete="off" class="form-control" name="admission" id="admission" aria-describedby="Adimission">
          <small id="Adimission" class="form-text text-muted">Informe a Adimissão</small>
        </div>
        <div class="form-group">
          <label for="registration">Matricula</label>
          <input type="text" autocomplete="off" class="form-control" name="registration" id="registration" aria-describedby="registration">
          <small id="registration" class="form-text text-muted">Informe o Vencimento</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

{{-- @section('js')
    <script> console.log('Hi!'); </script>
@stop --}}
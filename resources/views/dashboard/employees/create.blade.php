@extends('adminlte::page')

@section('title', 'Cadastro de Colaboradores')

@section('content_header')
    <h1>Cadastro de Colaboradores</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.employees') }}">Colaboradores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastrar</li>
        </ol>
    </nav>
    <hr>
@stop

@section('content')
    <div class="form">
        <form action="{{ route('dashboard.employees.store') }}" method="post" autocomplete="off">
            @csrf
            @method('POST')
            <div class="form-row">
                <div class="col-lg-6 form-group ">
                    <label for="cpf">CPF:</label>
                    <input type="text" autocomplete="off" class=" @error('cpf') is-invalid @enderror form-control"
                        name="cpf" @if($errors->any()) value="{{ old('cpf') }}" @endif id="cpf"
                        aria-describedby="helpCPF">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="helpCPF" class="form-text text-muted">informe número do CPF</small>
                </div>
                <div class="col-lg-6 form-group">
                    <label for="user">Usuário:</label>
                    <select id="user" class=" @error('user_id') is-invalid @enderror form-control" name="user_id">
                        <option value="">Selecione um Usuário</option>
                        @foreach ($users as $item)
                            <option value="{{ $item->id }}"
                              @if ($errors->any() && old('user_id') == $item->id) selected @endif>
                                {{ $item->name }} => {{ $item->email }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-lg-4 form-group">
                    <label for="profession">Profissão:</label>
                    <select id="profession" class=" @error('profession_id') is-invalid @enderror form-control"
                        name="profession_id">
                        <option value="">Selecione um Profissão</option>
                        @foreach ($professions as $item)
                            <option value="{{ $item->id }}"
                                @if ( $errors->any() && old('profession_id') == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('profession_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-4 form-group">
                    <label for="admission">Adimissão:</label>
                    <input type="date" @if($errors->any()) value="{{ old('admission') }}" @endif autocomplete="off"
                        class="@error('admission') is-invalid @enderror form-control " name="admission" id="admission"
                        aria-describedby="Adimission">
                    @error('admission')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="Adimission" class="form-text text-muted">Informe a Adimissão</small>
                </div>
                <div class="col-lg-4 form-group">
                    <label for="registration">Matricula:</label>
                    <input type="text" @if($errors->any()) value="{{ old('registration') }}" @endif
                        autocomplete="off" class="form-control @error('registration') is-invalid @enderror "
                        name="registration" id="registration" aria-describedby="registration">
                    @error('registration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="registration" class="form-text text-muted">Informe o Vencimento</small>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary mb-3">Cadastrar</button>
        </form>
    </div>
@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
<script> 
  $(document).ready(function () { 
      var $cpf = $("#cpf");
      $cpf.mask('000.000.000-00', {reverse: true});
  });
</script>
@stop

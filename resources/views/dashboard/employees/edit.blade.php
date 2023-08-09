@extends('adminlte::page')

@section('title', 'Alteração de Colaborador')

@section('content_header')
    <h1>Alteração de Colaborador / {{ $employee->user->name }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.employees') }}">Colaboradors</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
    <hr>
@stop

@section('content')
    <div class="form">
        <form action="{{ route('dashboard.employees.update', $employee) }}" method="post" autocomplete="off">
            @csrf
            @method('put')
            <input type="hidden" name="uuid" value="{{ $employee->uuid }}">
            <div class="form-row">
                <div class="form-group col-lg-6">
                    <label for="cpf">CPF:</label>
                    <input type="text" autocomplete="off" class="form-control @error('cpf') is-invalid @enderror"
                        @if ($errors->any()) value="{{ old('cpf') }}"
                        @else
                        value="{{ $employee->cpf }}" @endif
                        name="cpf" id="cpf" aria-describedby="helpCPF">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="helpCPF" class="form-text text-muted">informe número do CPF</small>
                </div>
                <div class="form-group col-lg-6">
                    <label for="user">Usuário</label>
                    <select id="user" class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                        <option value="">Selecione um Usuário</option>
                        @foreach ($users as $item)
                            <option value="{{ $item->id }}"
                                @if ($errors->any() && old('user_id') == $item->id) selected 
                              @elseif($employee->user_id == $item->id) selected @endif>
                                {{ $item->name }} => {{ $item->email }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="helpUSer" class="form-text text-muted">Selecione um Usuário</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-4">
                    <label for="profession">Profissão</label>
                    <select id="profession" class="form-control @error('profession_id') is-invalid @enderror"
                        name="profession_id">
                        <option value="">Selecione um Profissão</option>
                        @foreach ($professions as $item)
                            <option value="{{ $item->id }}"
                                @if ($errors->any() && old('profession_id') == $item->id) selected
                              @elseif ($employee->profession_id == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                      </select>
                        @error('profession')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      <small id="helpProfession" class="form-text text-muted">Selecione uma Profissão</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="admission">Adimissão</label>
                    <input type="date"
                    @if ($errors->any())
                        value="{{old('admission')}}"
                    @else
                        value="{{$employee->admission}}"
                    @endif
                        autocomplete="off" class="form-control @error('admission') is-invalid @enderror" name="admission"
                        id="admission" aria-describedby="Adimission">
                    @error('admission')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="helpAdimission" class="form-text text-muted">Informe a Adimissão</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="registration">Matricula</label>
                    <input type="text" autocomplete="off"
                        value="@if ($errors->any()) {{ old('registration') }} @else {{ $employee->registration }} @endif"
                        class="form-control @error('registration') is-invalid @enderror" name="registration"
                        id="registration" aria-describedby="registration">
                    @error('registration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small id="helpRegistration" class="form-text text-muted">Matrícula do funcionário</small>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Salvar Alterações</button>
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

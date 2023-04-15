@extends('adminlte::page')

@section('title','Editar Categorias')

@section('content')
<div class="container">
    <form action="{{route('dashboard.financeiro.categories.update',$category)}}" method="post">
     @csrf
     @method('PUT')
        <div class="mb-3">
        <label for="name" class="form-label">Nome da Profissão</label>
          <input type="text" value="{{$category->name}}"
           class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da Profissão">
          <small id="helpName" class="form-text text-muted">Informe o nome da Profissão</small>
        </div>
        <div class="mb-3">
        <label for="description" class="form-label">Descrição da Profissão</label>
          <input type="text" value="{{$category->description}}"
           class="form-control" name="description" id="description" aria-describedby="helpDescription" placeholder="Descreva a Profissão">
          <small id="helpDescription" class="form-text text-muted">Informe o nome da Profissão</small>
        </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
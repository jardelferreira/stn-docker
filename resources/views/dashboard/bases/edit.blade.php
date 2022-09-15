@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{route('dashboard.bases.update',['base' => $base->id])}}" method="post">
     @csrf
     @method('PUT')
     <input type="hidden" name="uuid" value="{{$base->uuid}}">
     <div class="form-group">
      <label for="name">Nome do Base</label>
      <input type="text" autocomplete="off" class="form-control" value="{{$base->name}}" name="name" id="name" aria-describedby="helpName" placeholder="Central">
      <small id="helpName" class="form-text text-muted">Insira o nome do Base</small>
    </div>
    <div class="form-group">
      <label for="place">Local do Base</label>
      <input type="text" autocomplete="off" class="form-control" name="place" value="{{$base->place}}" id="place" aria-describedby="place" placeholder="Areal-RJ">
      <small id="place" class="form-text text-muted">Insira o local do Base</small>
    </div>
    <div class="form-group">
      <label for="description">Descrição do Base</label>
      <input type="text" autocomplete="off" class="form-control" name="description" value="{{$base->description}}" id="description" aria-describedby="description" placeholder="nome da Bases">
      <small id="description" class="form-text text-muted">Descreva este Bases</small>
    </div>
    <div class="form-group">
      <label for="project_id"></label>
      <select class="form-control" name="project_id" id="projects">
        <option value="">Selecione um projeto para o Bases</option>
        @foreach ($projects as $item)
            <option value="{{$item->id}}" @if ($base->id == $item->id)
                selected
            @endif >{{$item->name}}</option>
        @endforeach
      </select>
    </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
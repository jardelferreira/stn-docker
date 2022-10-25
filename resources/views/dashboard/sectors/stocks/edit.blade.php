@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{route('dashboard.sectors.update',['sector' => $sector->id])}}" method="post">
     @csrf
     @method('PUT')
     <input type="hidden" name="uuid" value="{{$sector->uuid}}">
     <div class="form-group">
      <label for="name">Nome do Base</label>
      <input type="text" autocomplete="off" class="form-control" value="{{$sector->name}}" name="name" id="name" aria-describedby="helpName" placeholder="Central">
      <small id="helpName" class="form-text text-muted">Insira o nome do Base</small>
    </div>
    <div class="form-group">
      <label for="description">Descrição do Base</label>
      <input type="text" autocomplete="off" class="form-control" name="description" value="{{$sector->description}}" id="description" aria-describedby="description" placeholder="nome da Bases">
      <small id="description" class="form-text text-muted">Descreva este Bases</small>
    </div>
    <div class="form-group">
      <label for="base_id"></label>
      <select class="form-control" name="base_id" id="bases">
        <option value="">Selecione a Base do Setor</option>
        @foreach ($bases as $item)
            <option value="{{$item->id}}" @if ($sector->id == $item->id)
                selected
            @endif >{{$item->name}}</option>
        @endforeach
      </select>
    </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
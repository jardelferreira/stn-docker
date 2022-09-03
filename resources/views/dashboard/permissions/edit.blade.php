@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{route('dashboard.permissions.update',['id' => $permission->id])}}" method="post">
     @csrf
     @method('PUT')
        <div class="mb-3">
        <label for="name" class="form-label">Nome da permissão</label>
          <input type="text" value="{{$permission->name}}"
           class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="">
          <small id="helpName" class="form-text text-muted">Informe o nome da Permissão</small>
        </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
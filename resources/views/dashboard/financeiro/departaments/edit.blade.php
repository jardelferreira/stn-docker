@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{route('dashboard.costs_departaments.update',['id' => $departament->id])}}" method="post">
     @csrf
     @method('PUT')
     <input type="hidden" name="uuid" value="{{$departament->uuid}}">
        <div class="mb-3">
        <label for="name" class="form-label">Nome do Centro de custo</label>
          <input type="text" value="{{$departament->name}}"
           class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da função">
          <small id="helpName" class="form-text text-muted">Informe o nome do centro de custo</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do departamento de custo</label>
          <input type="text" autocomplete="off" class="form-control" value="{{$departament->description}}" name="description" id="description" aria-describedby="description" placeholder="nome da departamento de custo">
          <small id="description" class="form-text text-muted">Descriçã do departamento</small>
        </div>
        <div class="form-group">
            <label for="cost_sector_id">Setor de custo</label>
            <select class="form-control" name="cost_sector_id" id="sectors">
              @foreach ($sectors as $item)
                  <option value="{{$item->id}}"
                    @if ($item->id == $departament->cost_sector_id)
                        selected
                    @endif
                    >{{$item->name}} / {{$item->cost->name}} / {{$item->cost->project->name}} </option>
              @endforeach
            </select>
          </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
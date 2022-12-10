@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{route('dashboard.costs_sectors.update',['id' => $sector->id])}}" method="post">
     @csrf
     @method('PUT')
     <input type="hidden" name="uuid" value="{{$sector->uuid}}">
        <div class="mb-3">
        <label for="name" class="form-label">Nome do Centro de custo</label>
          <input type="text" value="{{$sector->name}}"
           class="form-control text-uppercase" name="name" id="name" aria-describedby="helpName" placeholder="nome da função">
          <small id="helpName" class="form-text text-muted">Informe o nome do centro de custo</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do setor de custo</label>
          <input type="text" autocomplete="off" value="{{$sector->description}}" class="form-control text-uppercase" name="description" id="description" aria-describedby="description" placeholder="descrição">
          <small id="description" class="form-text text-muted">Descrição do setor</small>
        </div>
        <div class="form-group">
            <label for="cost_id">Centro de custo</label>
            <select class="form-control" readonly disabled name="cost_id" id="cost_id">
              @foreach ($costs as $item)
                  <option value="{{$item->id}}"
                    @if ($item->id == $sector->cost_id)
                        selected
                    @endif
                    >{{$item->name}} - {{$item->project->name}}</option>
              @endforeach
            </select>
          </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
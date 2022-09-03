@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{route('dashboard.costs_departaments.update',['id' => $departament->id])}}" method="post">
     @csrf
     @method('PUT')
        <div class="mb-3">
        <label for="name" class="form-label">Nome do Centro de custo</label>
          <input type="text" value="{{$departament->name}}"
           class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da função">
          <small id="helpName" class="form-text text-muted">Informe o nome do centro de custo</small>
        </div>
        <div class="form-group">
            <label for="sector_id">Setor de custo</label>
            <select class="form-control" name="sector_id" id="sectors">
              @foreach ($sectors as $item)
                  <option value="{{$item->id}}"
                    @if ($item->id == $departament->cost_sector_id)
                        selected
                    @endif
                    >{{$item->name}}</option>
              @endforeach
            </select>
          </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
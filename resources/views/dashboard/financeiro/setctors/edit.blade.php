@extends('adminlte::page')

@section('content')
<div class="container">
    <form action="{{route('dashboard.costs_sectors.update',['id' => $sector->id])}}" method="post">
     @csrf
     @method('PUT')
        <div class="mb-3">
        <label for="name" class="form-label">Nome do Centro de custo</label>
          <input type="text" value="{{$sector->name}}"
           class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da função">
          <small id="helpName" class="form-text text-muted">Informe o nome do centro de custo</small>
        </div>
        <div class="form-group">
            <label for="cost_id"></label>
            <select class="form-control" name="cost_id" id="cost_id">
              @foreach ($costs as $item)
                  <option value="{{$item->id}}"
                    @if ($item->id == $sector->cost_id)
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
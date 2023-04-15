@extends('adminlte::page')

@section('title','Editar Produtos')

@section('content')
<div class="container">
    <form action="{{route('dashboard.financeiro.products.update',$product)}}" method="post">
     @csrf
     @method('PUT')
        <div class="mb-3">
        <label for="name" class="form-label">Nome do Produto</label>
          <input type="text" value="{{$product->name}}"
           class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome do Produto">
          <small id="helpName" class="form-text text-muted">Informe o nome do Produto</small>
        </div>
        <div class="mb-3">
        <label for="description" class="form-label">Descrição do Produto</label>
          <input type="text" value="{{$product->description}}"
           class="form-control" name="description" id="description" aria-describedby="helpDescription" placeholder="Descreva o Produto">
          <small id="helpDescription" class="form-text text-muted">Informe o nome do Produto</small>
        </div>
        <div class="form-group">
          <label for="category_id">Identifique a Categoria</label>
          <select class="form-control" name="category_id" id="category_id">
            <option>Selecione</option>
            @foreach ($categories as $item)
            <option value="{{$item->id}}" @if ($item->id == $product->category_id)
                selected
            @endif >{{$item->description}}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar alterações</button>
    </form>
  </div>
@endsection 
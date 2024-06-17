@extends('adminlte::page')

@section('title', 'Editar Produtos')

@section('content')
    <div class="">
        <form action="{{ route('dashboard.financeiro.products.update', $product) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3 col-lg-4 col-md-4">
                    <label for="name" class="form-label">Nome do Produto</label>
                    <input type="text" value="{{ $product->name }}" class="form-control" name="name" id="name"
                        aria-describedby="helpName" placeholder="nome do Produto">
                    <small id="helpName" class="form-text text-muted">Informe o nome do Produto</small>
                </div>
                <div class="mb-3 col-lg-8 col-md-8">
                    <label for="description" class="form-label">Descrição do Produto</label>
                    <input type="text" value="{{ $product->description }}" class="form-control" name="description"
                        id="description" aria-describedby="helpDescription" placeholder="Descreva o Produto">
                    <small id="helpDescription" class="form-text text-muted">Informe o nome do Produto</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="category_id">Identifique a Categoria:</label>
                    <select class="form-control" name="category_id" id="category_id" aria-describedby="helpCategory">
                        <option>Selecione</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" @if ($item->id == $product->category_id) selected @endif>
                                {{ $item->description }}</option>
                        @endforeach
                    </select>
                    <small id="helpCategory" class="form-text text-muted">Selecione uma categoria da lista</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="dimensions">Dimensões:</label>
                    <input type="text" class="form-control" name="dimensions" id="dimensions" value="{{$product->dimensions}}"
                        aria-describedby="helpDimensions" placeholder="100x450x10">
                    <small id="helpDimensions" class="form-text text-muted">Informe as Dimensões</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="color">Cor:</label>
                    <input type="text" class="form-control" name="color" id="color" aria-describedby="helpColor"
                    value="{{$product->color}}" placeholder="azul, verde, amarelo">
                    <small id="helpColor" class="form-text text-muted">Informe a cor</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-2">
                    <label for="weight">Peso Kg:</label>
                    <input type="text" class="form-control" name="weight" id="weight" aria-describedby="helpWeight"
                    value="{{$product->weight}}" placeholder="10kg">
                    <small id="helpWeight" class="form-text text-muted">Informe o peso do produto</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="material">Material:</label>
                    <input type="text" class="form-control" name="material" id="material"
                    value="{{$product->material}}" aria-describedby="helpMaterial" placeholder="aço carbono, alumínio, PVC ...">
                    <small id="helpMaterial" class="form-text text-muted">Informe o tipo de material</small>
                </div>
                <div class="form-group col-lg-2">
                    <label for="size">Tamanho: </label>
                    <input type="text" class="form-control" name="size" id="size" aria-describedby="helpSize"
                    value="{{$product->size}}" placeholder="P, M, G , 40,41,42">
                    <small id="helpSize" class="form-text text-muted">Informe o tamanho</small>
                </div>
                <div class="form-group col-lg-4">
                    <label for="characteristics">Característica: </label>
                    <input type="text" class="form-control" name="characteristics" id="characteristics"
                    value="{{$product->characteristics}}" aria-describedby="helpCh" placeholder="220V, 127V - 8KVA - 1 a 135KVA - Padrão Empresa">
                    <small id="helpCh" class="form-text text-muted">Informe a característica principal do produto
                        aqui.</small>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Salvar alterações</button>
        </form>
    </div>
@endsection

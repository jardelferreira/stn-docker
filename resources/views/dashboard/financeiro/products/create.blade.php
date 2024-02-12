@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Cadastro de Produtos </h1>
@stop

@section('content')
    <form action="{{ route('dashboard.financeiro.products.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="name">Produtos</label>
            <input type="text" autocomplete="off" class="form-control" name="name" id="name"
                aria-describedby="helpName" placeholder="nome da categoria">
            <small id="helpName" class="form-text text-muted">Insira o nome do categoria</small>
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" autocomplete="off" class="form-control" name="description" id="description"
                aria-describedby="helpDecription" placeholder="Descreva as atribuições dessa categoria aqui">
            <small id="helpDescription" class="form-text text-muted">Descrição da categoria</small>
        </div>
        <div class="form-group">
            <label for="categories">Identifique a categoria</label>
            <select class="form-control" name="category_id" id="categories">
                <option>Selecione</option>
                @foreach ($categories as $item)
                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop
@section('js')
    <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $("#categories").select2()
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();

        });
    </script>
@endsection

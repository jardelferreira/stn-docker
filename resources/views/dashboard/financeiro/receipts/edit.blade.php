@extends('adminlte::page')
@section('title', 'Editar Nota')
@section('content_header')
    <h1>Alterar de Nota</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.invoices.index') }}">Notas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>
    <hr>
@stop
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form">
        <form action="{{ route('dashboard.financeiro.branches.update') }}" method="post" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="form">
                <div class="form-group">
                  <label for="branch_id">Filial</label>
                  <select class="form-control" name="branch_id" id="branch_id">
                    <option>Selecione...</option>
                    @foreach ($branches as $item)
                        <option value="{{$item->id}}" @if ($item->id == $receipt->branch_id)
                            selected
                        @endif>{{$item->nome}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="local">Local</label>
                  <input type="text" class="form-control" name="local" id="local" aria-describedby="helpLocal" placeholder="cidade de emissão">
                  <small id="helpLocal" class="form-text text-muted">Informe a cidade da emissão</small>
                </div>
                <div class="form-group">
                  <label for="value">Valor</label>
                  <input type="text" class="form-control" name="value" id="value" aria-describedby="helpValur" placeholder="1.250,00">
                  <small id="helpValur" class="form-text text-muted">Informe o valor total</small>
                </div>
                
                <div class="form-group">
                  <label for="favored">Favorecido</label>
                  <input type="text" class="form-control" name="favored" id="favored" aria-describedby="helpFavored" placeholder="nome do favorecido">
                  <small id="helpFavored" class="form-text text-muted">Informe o nome do favorecido</small>
                </div>
                <div class="form-group">
                  <label for="register">CPF/CNPJ</label>
                  <input type="text" class="form-control" name="register" id="register" aria-describedby="helpRegister" placeholder="17.933.652/0001-81">
                  <small id="helpRegister" class="form-text text-muted">Informe o número do documento</small>
                </div>
                <button type="submit" class="btn btn-success">Salvar alterações</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#value").inputmask('currency', {
                "autoUnmask": true,
                radixPoint: ",",
                groupSeparator: ".",
                allowMinus: false,
                prefix: 'R$ ',
                digits: 2,
                digitsOptional: false,
                rightAlign: true,
                unmaskAsNumber: true
            });

        })
        $("form").on("submit", (e) => {
            e.preventDefault()
            $("#value").inputmask('remove');
            e.currentTarget.submit()
        })
    </script>
@stop

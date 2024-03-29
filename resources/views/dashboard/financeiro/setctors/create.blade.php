@extends('adminlte::page')

@section('title', 'Cadastro de setor de custo')

@section('content_header')
    <h1>Cadastro de setor de custos</h1>
@stop

@section('content')
    <form action="{{route('dashboard.costs_sectors.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome do setor de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da setor de custo">
          <small id="helpName" class="form-text text-muted">Insira o nome do setor</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do setor de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="description" placeholder="descrição">
          <small id="description" class="form-text text-muted">Descrição do setor</small>
        </div>
        <div class="form-group">
          <label for="cost_center_id"></label>
          <select class="form-control" name="cost_center_id" id="cost_centers">
            <option value="">Selecione um projeto para o setor de custo</option>
            @foreach ($cost_centers as $item)
                <option value="{{$item->id}}">{{$item->name}} - {{$item->project->name}}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $("#cost_centers").select2()
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();

    });
    
</script>
@stop
@extends('adminlte::page')

@section('title', 'Cadastro de departamento de custo')

@section('content_header')
    <h1>Cadastro de departamento de custos</h1>
@stop

@section('content')
    <form action="{{route('dashboard.costs_departaments.store')}}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group">
          <label for="name">Nome do departamento de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpName" placeholder="nome da departamento de custo">
          <small id="helpName" class="form-text text-muted">Insira o nome do departamento</small>
        </div>
        <div class="form-group">
          <label for="description">Descrição do departamento de custo</label>
          <input type="text" autocomplete="off" class="form-control" name="description" id="description" aria-describedby="helpName" placeholder="nome da departamento de custo">
          <small id="helpName" class="form-text text-muted">Descriçã do departamento</small>
        </div>

        <div class="form-group">
          <label for="cost_center_id">Selecione o Setor de custo para vincular:</label>
          <select class="form-control" name="cost_sector_id" id="cost_sectors">
            <option value="">Selecione um projeto para o departamento de custo</option>
            @foreach ($cost_sectors as $item)
                <option value="{{$item->id}}">{{$item->name}} - {{$item->cost->name}} - {{$item->cost->project->name}}</option>
            @endforeach
          </select>
          <small id="helpName" class="form-text text-muted">Selecionar da lista</small>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

@stop

@section('css')

@stop

@section('js')
<script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $("#cost_sectors").select2()
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();

    });
    
</script>
@stop
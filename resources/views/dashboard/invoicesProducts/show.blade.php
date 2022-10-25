@extends('adminlte::page')

@section('content')
<h5>Listagem de produtos da {{$invoice->name}}</h5>

<div class="grey-bg container-fluid">
  @if ($invoice->hasProducts)
  <table class="table table-striped  table-responsive">
    <thead class="thead-default">
      <tr>
        <th>Qtd.</th>
        <th>Und</th>
        <th>Descrição</th>
        <th>Valor unitário</th>
        <th>Valor total</th>
        <th>Ações</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($invoice->products as $item)
        <tr>
          <td scope="row">{{$item->qtd}}</td>
          <td>{{$item->und}}</td>
          <td>{{$item->description}}</td>
          <td>{{$item->value_unid}}</td>
          <td>{{$item->value_total}}</td>
          <td>Ações</td>
        </tr>
        @endforeach
      </tbody>
  </table>
  @else
      
  @endif
  <h5>Esta nota Ainda não possui Produtos cadastrados</h5><a href="#" class="btn btn-info">Cadastrar itens da nota</a>
</section>
</div>

@endsection



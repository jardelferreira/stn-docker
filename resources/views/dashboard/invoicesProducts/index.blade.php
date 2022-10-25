@extends('adminlte::page')

@section('title','Produtos da nota')

@section('content_header')
    <h1>Listagem de produtos - {{$invoice->name}}</h1>
@stop

@section('content')
@if (count($invoice->products))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Arquivado por</th>
                <th>Nota</th>
                <th>Qtd</th>
                <th>Und.</th>
                <th>Item</th>
                <th>Valor Unitário</th>
                {{-- <th>Detalhes</th> --}}
            </tr>
            </thead>
            <tbody>
               @foreach ($invoice->products as $item)
               <tr>
                   <td scope="row">{{$invoice->user->name}}</td>
                   <td scope="row">{{$invoice->name}}</td>
                   <td scope="row">{{$item->qtd}}</td>
                   <td scope="row">{{$item->und}}</td>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">{{$item->value_und}}</td>
                   {{-- <td scope="row"><a href="{{route('dashboard.invoicesProducts.show',$item)}}" target="_blank" class="text-danger" ><i class="fa fa-file-pdf  ml-3 fa-xl" aria-hidden="true"></i></a></td> --}}
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há Produtos para listagem</p>
               @endif
@endsection

@extends('adminlte::page')

@section('title','Notas fiscais')

@section('content_header')
    <h1>Listagem de Notas - <a name="" id="" class="btn btn-success" href="{{route('dashboard.invoices.create')}}" role="button">Criar novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($invoicers))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Arquivado por</th>
                <th>Nota</th>
                <th>Valor departamento</th>
                <th>Valor total</th>
                <th>Arquivo</th>
                <th>Emissão</th>
                <th>Vencimento</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($invoicers as $item)
               
               <tr>
                   <td scope="row">{{$item->user->name}}</td>
                   <td scope="row">{{$item->name}}</td>
                   <td scope="row">{{$item->value_departament}}</td>
                   <td scope="row">{{$item->value}}</td>
                   <td scope="row"><a href="{{route('dashboard.invoices.show',$item)}}" target="_blank" class="text-danger" ><i class="fa fa-file-pdf  ml-3 fa-xl" aria-hidden="true"></i></a></td>
                   <td scope="row">{{date('d/m/Y', strtotime($item->issue))}}</td>
                   <td scope="row">{{date('d/m/Y', strtotime($item->due_date))}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.invoices.edit',$item)}}" >Editar</a>
                       @if (count($item->products))
                       <a class="btn btn-success btn-sm mr-1" href="{{route('dashboard.invoicesProducts.index',['invoice' => $item->id])}}" >Ver Produtos</a>
                       
                       @else
                       
                       <a class="btn btn-warning btn-sm mr-1" href="{{route('dashboard.invoices.popular.create',['invoice' => $item->id])}}" >Cadastrar produtos</a>
                       @endif
                        <form action="{{route('dashboard.invoices.destroy', ['invoice' => $item->id])}}" method="POST" id="{{$item->id}}">
                            @csrf
                            @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Deletar</button>
                        </form>
                    </td>
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há Notas para listagem</p>
               @endif
@endsection

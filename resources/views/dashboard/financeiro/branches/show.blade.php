@extends('adminlte::page')

@section('css')


@endsection
@section('content')
<ul class="list-group">
    <li class="list-group-item">{{$branch->nome}}</li>
    <li class="list-group-item">{{$branch->cnpj}}</li>
    <li class="list-group-item">{{$branch->logradouro}}, {{$branch->cidade}}-{{$branch->ud}}</li>
</ul>

@endsection



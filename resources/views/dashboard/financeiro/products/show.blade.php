@extends('adminlte::page')

@section('title','Projeto')  

@section('content')
<div class="container">
  <div class="alert alert-success" role="alert">
    <strong>{{$product->name}} - {{$product->description}}</strong>
  </div>  
</div>
@endsection


@extends('adminlte::page')

@section('title','Categoria')  

@section('content')
<div class="container">
  <div class="alert alert-success" role="alert">
    <strong>{{$category->name}} - {{$category->description}}</strong>
  </div>  
</div>
@endsection


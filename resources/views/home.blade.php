@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    <a href="{{route('dashboard.stock.history')}}"></a>
@stop

@section('content')

@stop

@section('css')

@stop

@section('js')
<script>
   localStorage.reaproveita = 0
</script>
@stop

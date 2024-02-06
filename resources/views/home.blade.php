@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

@stop

@section('css')

@stop

@section('js')
<script>
    localStorage.removeItem("coordinates");
    localStorage.removeItem("geolocation");
</script>
@stop

@extends('adminlte::page')

@section('title', 'Funcionários vinculados')

@section('content_header')
    <h1>Listagem de Funcionários - {{$base->name }} - <a class="btn btn-primary"
        href="{{route('dashboard.bases.employees',$base)}}" role="button">Vincular funcionários - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($employees))
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Empregado</th>
                    <th>Profissão</th>
                    <th>CPF</th>
                    <th>Matrícula</th>
                    <th>Adimissão</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $item)
                    <tr>
                        <td scope="row">{{ $item->user->name }}</td>
                        <td scope="row">{{ $item->profession->name }}</td>
                        <td scope="row">{{ $item->cpf }}</td>
                        <td scope="row">{{ $item->registration }}</td>
                        <td scope="row">{{ date('d/m/Y', strtotime($item->adimission)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Funcionários para listagem</p>
    @endif
@endsection

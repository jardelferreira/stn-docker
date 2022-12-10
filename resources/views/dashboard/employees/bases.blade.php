@extends('adminlte::page')

@section('title', 'Bases')

@section('content_header')
    <h1>Listagem de Bases - <a name="" id="" class="btn btn-success"
        class="btn btn-warning btn-sm mr-1 btn-sm" href="{{ route('dashboard.employees.projects', $employee) }}">Criar novo - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($projects))
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Projeto</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td scope="row">{{ $project->initials }}</td>
                        <td scope="row">{{ $project->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Bases para listagem</p>
    @endif
@endsection

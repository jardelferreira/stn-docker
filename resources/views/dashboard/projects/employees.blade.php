@extends('adminlte::page')

@section('title', 'Empregados')

@section('content_header')
    <h1>Listagem de Empregados - <a name="" id="" class="btn btn-primary"
            href="{{ route('dashboard.projects.listEmployees',$project) }}" role="button">Vincular funcionários - <i class="fa fa-plus"
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
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $item)
                    <tr>
                        <td scope="row">{{ $item->user->name }}</td>
                        <td scope="row">{{ $item->profession->name }}</td>
                        <td scope="row">{{ $item->cpf }}</td>
                        <td scope="row">{{ $item->registration }}</td>
                        <td scope="row">{{ date('d/m/Y', strtotime($item->admission)) }}</td>
                        <td class="btn-group" role="group">
                            {{-- <a href="#" class="btn btn-sm mr-1 btn-secondary">Projetos</a> --}}
                            {{-- <a class="btn btn-info btn-sm mr-1 btn-sm" href="{{ route('dashboard.employees.edit', $item) }}">Editar</a> --}}
                            {{-- <a class="btn btn-warning btn-sm mr-1 btn-sm" href="{{ route('dashboard.employees.projects', $item) }}">Vincular</a> --}}
                            <a href="{{ route('dashboard.employees.show', $item) }}" target="_blank" class="mr-1 btn btn-success btn-sm">Visualizar</a>
                            <form action="{{ route('dashboard.projects.detachEmployee',['project' => $project, 'employee' => $item]) }}" method="POST"
                                id="{{ $item->id }}">
                                @csrf
                                @method('POST')
                                <button class="btn btn-danger btn-sm mr-1" type="submit">Desvincular</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Empregados para listagem</p>
    @endif
@endsection

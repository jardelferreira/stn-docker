@extends('adminlte::page')

@section('title', 'Vincular Funcionários')

@section('content_header')
    <h4>Vincular funcionários para - <small class="text-primary">{{ $project->name }}</small> - <a name=""
            id="" class="btn btn-success btn-sm" href="{{ route('dashboard.employees.create') }}"
            role="button">Cadastrar novo Funcionário- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop

@section('content')

    @if (count($employees))
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Funcionário</th>
                    <th>Profissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $item)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td scope="row">{{ $item->user->name }}</td>
                        <td scope="row">{{ $item->profession->name }}</td>
                        <td scope="row">
                            <form action="{{route('dashboard.projects.attachEmployee',['project' => $project, 'employee' => $item])}}" method="post">
                                @csrf
                                @method('post')
                                <button class="btn btn-primary">Vincular ao projeto</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há permissões para listagem</p>
    @endif
@endsection

@extends('adminlte::page')

@section('title', 'Colaborador vinculados')

@section('content_header')
    <h1>Listagem de Colaborador - {{$base->name }} - <a class="btn btn-primary"
        href="{{route('dashboard.bases.employees',$base)}}" role="button">Vincular Colaborador - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($employees))
        <table class="table table-striped table-inverse table-responsive" id="employees">
            <thead class="thead-inverse">
                <tr>
                    <th>Colaborador</th>
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
                        <td scope="row" class="btn-group">
                            <a href="{{route('dashboard.bases.employees.formlists',['base' => $base,'employee' => $item])}}" class="btn btn-sm btn-info mx-1">Ver Formulários</a>
                            <form action="{{route('dashboard.bases.employees.detachEmployee',['base' => $base,'employee' => $item])}}" method="post">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-sm btn-danger mx-1">Desvincular</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Colaborador para listagem</p>
    @endif
@endsection
@section('js')
    <script>
         $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#employees').DataTable({
                    responsive: true,
                    order: [0, 'desc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });
    </script>
@endsection
{{-- select users.`name`, professions.`name` from employees join users on employees.`user_id` = users.`id` join professions on professions.`id` = employees.`profession_id` join employee_base where employees.id = employee_base.`employee_id`;  --}}

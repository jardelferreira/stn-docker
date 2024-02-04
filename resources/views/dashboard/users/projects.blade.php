@extends('adminlte::page')

@section('title', 'Projetos')

@section('content_header')
    <h1>Listagem de projetos de - {{$user->name}} 
        <a name="" id="" class="btn btn-success ml-1 btn-sm"  href="{{ route('dashboard.projects.create') }}" 
        role="button">Criar nova - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($projects))
        <table class="table table-striped table-inverse table-responsive" id="projects">
            <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Siglas</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td scope="row">{{ $project->id }}</td>
                        <td scope="row">{{ $project->initials }}</td>
                        <td scope="row">{{ $project->name }}</td>
                        <td class="btn-group" role="group">
                            @if (!in_array($project->id,$user_projects))
                            <form action="{{ route('dashboard.users.projects.attachProject',$user)}}"
                                method="POST" id="attach-{{$project->id}}">
                                @csrf
                                <input type="hidden" name="project_id" value="{{$project->id}}">
                                @method('POST')
                                <button class=" dropdown-item bg-primary rounded" type="submit">Vincular</button>
                            </form>
                            @else
                            <form action="{{ route('dashboard.users.projects.detachProject',$user)}}"
                                method="POST" id="detach-{{$project->id}}">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="project_id" value="{{$project->id}}">
                                <button class=" dropdown-item bg-danger rounded" type="submit">Desvincular</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Projetos para listagem</p>
    @endif
@endsection
@section('js')
    <script>
        $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#projects').DataTable({
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

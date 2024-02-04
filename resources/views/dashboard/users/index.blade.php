@extends('adminlte::page')

@section('title','usuários')  

@section('content_header')
    <h1>Listagem de usuários  - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.users.create')}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i>Cadastrar novo</a></h1>
@stop
@section('css')
    <style>
        .dropdown-item:hover{
            background-color: #3B71CA;
            color: #fff;
            text-decoration: none;
        }
        .dropdown-item{
            border-bottom: solid 1px slategray;
        }
    </style>
@endsection
@section('content')
@if (count($users))
    <table class="table table-striped table-inverse table-responsive" id="users">
        <thead class="thead-inverse">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($users as $user)
               <tr>
                   <td scope="row">{{$user->name}}</td>
                   <td>{{$user->email}}</td>
                   <td class="btn-group" role="group"><a name="" id="ver-perfil" class="btn btn-primary btn-sm mr-1" href="{{route('dashboard.users.show',['user' => $user->id])}}" role="button">
                    Ver Perfil - <i class="fa fa-user" aria-hidden="true"></i></a>
                        <div class="dropdown show mr-1">
                            <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button"
                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Adm. Acesso
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{route('dashboard.users.projects',$user)}}">Projetos</a>
                                <a class="dropdown-item" href="{{ route('dashboard.users.permissions', $user->id) }}">Permissões</a>
                                <a class="dropdown-item" href="{{ route('dashboard.users.roles',$user->id) }}">Funções</a>
                                <a class="dropdown-item" href="{{ route('dashboard.employees.formlists', $user->employee) }}" target="_blank">Formulários</a>
                                <a class="dropdown-item"
                                    href="{{ route('dashboard.users.edit',$user->id)}}">Editar</a>
                                <form action="#"
                                    method="POST" id="{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class=" dropdown-item bg-danger" type="submit">Deletar</button>
                                </form>

                            </div>
                        </div>
                   <form action="{{route('dashboard.users.destroy',[ 'user' => $user->id])}}" method="POST">
                    @method('delete')
                    @csrf
                    {{-- <button type="submit" class="btn btn-sm btn-danger">Deletar</button> --}}
                </form></td>
               </tr>                   
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há usuários para listagem</p>
               @endif
@endsection
@section('js')
@section('plugins.Datatables', true)
<script>
    var lang = "";
    $(document).ready(function() {
        $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#users').DataTable({
                    responsive: true,
                    order: [0,'desc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });

    });
    $(".dropdown").on("hidden.bs.dropdown", () => {
            if (users.rows.length < 6) {
                users.style.height = ""
            }
        })
        $(".dropdown").on("show.bs.dropdown", () => {
            if (users.rows.length < 6) {
                users.style.height = "220px"
            }
        })
</script>
@endsection
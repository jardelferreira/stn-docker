@extends('adminlte::page')

@section('title','funções')

@section('content_header')
    <h1>Listagem de funções  -  <a name="" id="" class="btn btn-success" href="{{route('dashboard.roles.create')}}" role="button">Criar nova - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($roles))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>funções</th>
                <th>Descrição</th> 
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($roles as $role)
               <tr>
                   <td scope="row">{{$role->name}}</td>
                   <td scope="row">{{$role->description}}</td>
                   <td class="btn-group" role="group">
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.roles.show', $role)}}" >Exibir</a>
                       <a class="btn btn-warning btn-sm mr-1" href="{{route('dashboard.roles.permissions',$role)}}" >Vincular</a>
                       <a class="btn btn-info btn-sm mr-1" href="{{route('dashboard.roles.edit', $role)}}" >Editar</a>
                        <form action="{{route('dashboard.roles.destroy', $role)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Deletar</button>
                        </form>
                    </td>
               </tr>
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há funções para listagem</p>
               @endif
@endsection

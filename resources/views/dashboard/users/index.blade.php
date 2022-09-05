@extends('adminlte::page')

@section('title','usuários')  

@section('content_header')
    <h1>Listagem de usuários  - <a name="" id="" class="btn btn-success" href="{{route('dashboard.users.create')}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (count($users))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($users as $item)
               <tr>
                   <td scope="row">{{$item->name}}</td>
                   <td>{{$item->password}}</td>
                   <td><a name="" id="" class="btn btn-primary btn-sm" href="{{route('dashboard.users.show',['user' => $item->id])}}" role="button">
                    Ver Perfil - <i class="fa fa-user" aria-hidden="true"></i></a></td>
                   <td><form action="{{route('dashboard.users.destroy',[ 'user' => $item->id])}}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Deletar</button>
                </form></td>
               </tr>                   
               @endforeach
            </tbody>
    </table>
               @else
                   <p>Não há usuários para listagem</p>
               @endif
@endsection
@extends('adminlte::page')

@section('title','permissões')

@section('content_header')
    <h4>Adicionar permissões - {{$user->name}} - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.permissions.create')}}" role="button">Criar nova Permissão- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
    <hr>
@stop

@section('content')

@if (count($permissions))
<form action="{{route('dashboard.users.permissions.update',$user->id)}}" method="post">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-primary">Atualizar permissões do usuário</button>
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>permissões</th>
            </tr>
            </thead>
            <tbody>
               @foreach ($permissions as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="permissions[]" @if(in_array($item->id,$user_permissions))
                               checked
                           @endif
                           name="{{$item->id}}" id="{{$item->id}}" type="checkbox" value="{{$item->id}}" aria-label="Permissão">
                        </div>
                    </td>
                    <td scope="row">{{$item->name}}</td>
               </tr>
               @endforeach
            </tbody>
        </form>
    </table>
               @else
                   <p>Não há permissões para listagem</p>
               @endif
@endsection

@extends('adminlte::page')

@section('title','permissões')

@section('content_header')
    <h4>Vincular permissão para - <small class="text-primary">{{$role->name}}</small> - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.permissions.create')}}" role="button">Criar nova Permissão- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop

@section('content')

@if (count($permissions))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Marque as permissões que deseja vincular a esta função</th>
            </tr>
            </thead>
            <tbody>
                <form action="{{route('dashboard.roles.sync',$role)}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Atualizar permissões vinculadas à função</button>
               @foreach ($permissions as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="permissions[]" @if(in_array($item->slug,$role_permissions))
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

@extends('adminlte::page')

@section('title','usuários')  

@section('content')
<div class="container">
  <ul class="list-group">
    <li class="list-group-item active">{{$role->name}} <a name="" id="" class="btn btn-light ml-5" href="{{route('dashboard.roles.permissions',$role)}}" role="button">Atribuir novas permissões</a></li>
    <li class="list-group-item list-group-item-warning">Permissões atribuídas a esta função</li>
    @foreach ($role->getPermissions() as $key => $item)
    <li class="list-group-item">{{$loop->index + 1}} - {{$item}}</li>
    @endforeach
  </ul>
</div>
@endsection


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
@extends('adminlte::page')

@section('title','usuários')  

@section('content')
<div class="container">
  <ul class="list-group">
    <li class="list-group-item active text-center p-0">
      <h4 style="font-size: 3em;" class="font-weight-bold m-0">{{$role->name}} </h4>
      @can(['can','admin'], auth()->user())
      <a name="" id="" class="btn btn-light ml-5" href="{{route('dashboard.roles.permissions',$role)}}" role="button">Atribuir novas permissões</a>      
      @endcan
    </li>
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
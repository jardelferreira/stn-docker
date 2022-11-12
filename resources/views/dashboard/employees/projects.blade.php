@extends('adminlte::page')

@section('title','Projetos do Funcionário')

@section('content_header')
    <h4>Vincular projeto para - <small class="text-primary">{{$employee->user->name}}</small> - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.employees.create')}}" employee="button">Criar nova projeto- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop

@section('content')

@if (count($projects))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Marque os projetos que deseja vincular a este Funcionário</th>
            </tr>
            </thead>
            <tbody>
                <form action="{{route('dashboard.employees.sync',$employee)}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Atualizar projetos vinculadas ao Funcionário</button>
               @foreach ($projects as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="projects[]" @if(in_array($item->id,$employee_projects))
                               checked
                           @endif
                           name="{{$item->id}}" id="{{$item->id}}" type="checkbox" value="{{$item->id}}" aria-label="projeto">
                        </div>
                    </td>
                    <td scope="row">{{$item->name}}</td>
               </tr>
               @endforeach
            </tbody>
        </form>
    </table>
               @else
                   <p>Não há projetos para listagem</p>
               @endif
@endsection

@extends('adminlte::page')

@section('title','Vincular Funcionários')

@section('content_header')
    <h4>Vincular funcionários para - <small class="text-primary">{{$project->name}}</small> - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.employees.create')}}" role="button">Criar novo Funcionário- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop

@section('content')

@if (count($employees))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Marque os funcionários que deseja vincular a este projeto</th>
            </tr>
            </thead>
            <tbody>
                <form action="{{route('dashboard.projects.syncEmployees',$project )}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Atualizar funcionários vinculadas ao Projeto</button>
               @foreach ($employees as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="employees[]" @if(in_array($item->id,$project_employees))
                               checked
                           @endif
                            id="{{$item->id}}" type="checkbox" value="{{$item->id}}" aria-label="Permissão">
                        </div>
                    </td>
                    <td scope="row">{{$item->user->name}}</td>
                    <td scope="row">{{$item->profession->name}}</td>
               </tr>
               @endforeach
            </tbody>
        </form>
    </table>
               @else
                   <p>Não há permissões para listagem</p>
               @endif
@endsection

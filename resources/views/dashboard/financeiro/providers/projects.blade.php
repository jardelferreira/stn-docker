@extends('adminlte::page')

@section('title','permissões')

@section('content_header')
    <h4>Vincular projetos para - <small class="text-primary">{{$provider->corporate_name}}</small> - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.providers.create')}}" role="button">Criar novo Fornecedor- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop

@section('content')

@if (count($projects))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Marque os projetos que deseja vincular a este fornecedor</th>
            </tr>
            </thead>
            <tbody>
                <form action="{{route('dashboard.providers.syncProjects',$provider )}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Atualizar projetos vinculados ao Fornecedor</button>
               @foreach ($projects as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="projects[]" @if(in_array($item->id,$provider_projects))
                               checked
                           @endif
                            id="{{$item->id}}" type="checkbox" value="{{$item->id}}" aria-label="Permissão">
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

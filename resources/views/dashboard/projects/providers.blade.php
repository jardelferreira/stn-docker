@extends('adminlte::page')

@section('title','Vincular Fornecedores')

@section('content_header')
    <h4>Vincular fornecedores para - <small class="text-primary">{{$project->name}}</small> - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.providers.create')}}" role="button">Criar novo Fornecedor- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop

@section('content')

@if (count($providers))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Marque os fornecedores que deseja vincular a este projeto</th>
            </tr>
            </thead>
            <tbody>
                <form action="{{route('dashboard.projects.syncProviders',$project )}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Atualizar fornecedores vinculadas ao Projeto</button>
               @foreach ($providers as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="providers[]" @if(in_array($item->id,$project_providers))
                               checked
                           @endif
                            id="{{$item->id}}" type="checkbox" value="{{$item->id}}" aria-label="Permissão">
                        </div>
                    </td>
                    <td scope="row">{{$item->corporate_name}}</td>
               </tr>
               @endforeach
            </tbody>
        </form>
    </table>
               @else
                   <p>Não há permissões para listagem</p>
               @endif
@endsection

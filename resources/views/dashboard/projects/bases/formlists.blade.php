@extends('adminlte::page')

@section('title','Vincular Formulários')

@section('content_header')
    <h4>Vincular formulários para - <small class="text-primary">{{$base->name}}</small> - <a class="btn btn-success btn-sm" href="{{route('dashboard.formlists.create')}}" role="button">Criar novo formulario- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop

@section('content')

@if (count($formlists))
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th rowspan="2">Marque os formulários que deseja vincular a esta base</th>
            </tr>
            </thead>
            <tbody>
                <form action="{{route('dashboard.bases.formlists.sync',$base )}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Atualizar formulários vinculadas ao Base</button>
               @foreach ($formlists as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="formlists[]" @if(in_array($item->id,$base_formlists))
                               checked
                           @endif
                            id="{{$item->id}}" type="checkbox" value="{{$item->id}}" aria-label="formlists">
                        </div>
                    </td>
                    <td scope="row">{{$item->name}}</td>
                    <td scope="row">{{$item->description}}</td>
               </tr>
               @endforeach
            </tbody>
        </form>
    </table>
               @else
                   <p>Não há formulários para listagem</p>
               @endif
@endsection

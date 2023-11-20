@extends('adminlte::page')

@section('title','Vincular Colaboradores')

@section('content_header')
    <h4>Vincular Colaboradores para - <small class="text-primary">{{$base->name}}</small> -
         <a class="btn btn-success btn-sm" href="{{route('dashboard.employees.create')}}" role="button">Criar novo Funcionário- <i class="fa fa-plus" aria-hidden="true"></i></a>
        <a class="btn btn-primary" href="{{route('dashboard.bases.show',$base)}}">Retornar à Base</a>
        </h4>
@stop

@section('content')

@if (count($employees))
    <table class="table table-striped table-inverse table-responsive" id="employees">
        <thead class="thead-inverse">
            <tr>
                <th>#</th>
                <th colspan="2">Marque os Colaboradores que deseja vincular a esta base</th>
            </tr>
            </thead>
            <tbody>
                <form action="{{route('dashboard.bases.employees.sync',$base )}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">Vincular Colaboradores vinculadas ao Base</button>
               @foreach ($employees as $item)
               <tr>
                   <td>
                       <div class="form-check">
                           <input class="form-check-input" name="employees[]" @if(in_array($item->id,$base_employees))
                               checked
                           @endif
                            id="{{$item->id}}" type="checkbox" value="{{$item->id}}" aria-label="employees">
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
                   <p>Não há Colaboradores para listagem</p>
               @endif
@endsection
@section('js')
@section('plugins.Datatables', true)
<script>
    var lang = "";
    $(document).ready(function() {
        $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#employees').DataTable({
                    responsive: true,
                    order: [0,'desc'],
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });

    });
</script>
@extends('adminlte::page')

@section('title','permissões')

@section('content_header')
    <h4>Vincular permissão para - <small class="text-primary">{{$role->name}}</small> - <a name="" id="" class="btn btn-success btn-sm" href="{{route('dashboard.permissions.create')}}" role="button">Criar nova Permissão- <i class="fa fa-plus" aria-hidden="true"></i></a></h4>
@stop
@section('css')
    <style>
        input[type=checkbox] {
            /* Double-sized Checkboxes */
            -ms-transform: scale(2);
            /* IE */
            -moz-transform: scale(2);
            /* FF */
            -webkit-transform: scale(2);
            /* Safari and Chrome */
            -o-transform: scale(2);
            /* Opera */
            transform: scale(2);
            padding: 10px;
        }

        /* Might want to wrap a span around your checkbox text */
        .checkboxtext {
            /* Checkbox text */
            font-size: 110%;
            display: inline;
        }
    </style>
@endsection
@section('content')

    @if (count($permissions))
        <form action="{{route('dashboard.roles.sync',$role)}}" method="post" id="form">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-primary mb-2">Vincular permissões selecionadas</button>
            <table class="table table-striped table-inverse mt-2 table-responsive" id="permissions">
                <thead class="thead-inverse">
                    <tr>
                        <th>#1</th>
                        <th>permissões col -1</th>
                        <th>#2</th>
                        <th>permissões col -2</th>
                        <th>#3</th>
                        <th>permissões col -3</th>
                        <th>#4</th>
                        <th>permissões col -4</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $chunk)
                        <tr>
                            @foreach ($chunk as $item)
                                
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" name="permissions[]"
                                    @if (in_array($item->id, $role_permissions)) checked @endif name="{{ $item->id }}"
                                    id="{{ $item->id }}" type="checkbox" value="{{ $item->id }}"
                                    aria-label="Permissão">
                                </div>
                            </td>
                            <td scope="row">{{ $item->name }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
        </form>
        </table>
    @else
        <p>Não há permissões para listagem</p>
    @endif
@endsection
@section('js')
    <script>
        $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
               data_table = $('#permissions').DataTable({
                    "language": result,
                    lengthMenu: [
                        [-1],
                        ['Tudo'],
                    ],
                });
            }
        });
        form = document.getElementById("form")
        form.onsubmit = (e) => {
            e.preventDefault()
            $('#permissions').dataTable().fnFilter('');
            setTimeout(() => {
                form.submit()
            }, 1000);
        }
    </script>
@endsection

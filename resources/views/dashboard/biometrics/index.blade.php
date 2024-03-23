@extends('adminlte::page')

@section('title', 'Biometrias')

@section('content_header')
    <h1>Listagem de biometrias -
        <button style="border: none; margin: 0; padding: 0;" class="border border-dark rounded ml-1" onclick="addBiometric()"><img style="height: 35px;" class="ml-2" src="{{ asset('images/finger-add.svg') }}" alt=""></button> 
        <button onclick="searchUser()" style="border: none; margin: 0; padding: 0;" class="border border-dark rounded ml-1"><img style="height: 35px;" class="ml-2" src="{{ asset('images/finger-search.svg') }}" alt=""></button>
        <button type="button" onclick="loadFromDatabase()" class="btn btn-outline-info"><i class="fa fa-cloud-download fa-2xl" aria-hidden="true"></i></button>
    </h1>
@stop

@section('content')
    @if (count($biometrics))
        <table class="table table-striped table-inverse table-responsive" id="biometrics">
            <thead class="thead-inverse">
                <tr>
                    <th>id</th>
                    <th>Usuário</th>
                    <th>Recursos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($biometrics as $biometric)
                    <tr>
                        <td scope="row">{{ $biometric->id }}</td>
                        <td scope="row">{{ $biometric->user->name }}</td>
                        <td class="btn-group" role="group">
                            <button style="border: none; margin: 0; padding: 0;" class="border border-dark rounded ml-1"><img style="height: 35px;" class="ml-1" src="{{ asset('images/finger-update.svg') }}" alt=""></button>
                            <button style="border: none; margin: 0; padding: 0;" class="border border-dark rounded ml-1"><img style="height: 35px;" class="ml-1" src="{{ asset('images/finger-delete.svg') }}" alt=""></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há biometrias para listagem</p>
    @endif
@endsection
@section('js')
    <script>
        $.ajax({
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#biometrics').DataTable({
                    "language": result,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'Tudo'],
                    ],
                });
            }
        });
    </script>
<script src="{{ asset('js/fingertechweb.js') }}"></script>

    <script>
        function addBiometric(){
            
        }
    </script>
@endsection

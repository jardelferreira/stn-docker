@extends('adminlte::page')

@section('title', 'Filiais')

@section('content_header')
    <h1>Listagem de Filiais - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.financeiro.branches.create') }}" role="button">Cadastrar nova Filial - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($branches))
        <div class="table ">
            <table class="text-nowrap table-sm table-striped table-responsive" id="nfs">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Endereço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($branches as $item)
                        <tr>
                            <td scope="row">{{ $item->id }}</td>
                            <td scope="row">{{ $item->nome }}</td>
                            <td scope="row">{{ $item->cnpj }}</td>
                            <td scope="row"><a class="btn btn-warning" href="{{route('dashboard.financeiro.branches.show',$item)}}"><i class="fa fa-eye" aria-hidden="true"></i>Mostrar</a></td>

                            {{-- <td scope="row">{{ $item->logradouro }}, {{ $item->numero }}, {{ $item->bairro }}, {{ $item->cidade }}-({{ $item->uf }}), CEP: {{ $item->cep }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Não há Filiais para listagem</p>
    @endif
@endsection
@section('js')
@section('plugins.Datatables', true)
<script>
    var lang = "";
    $(document).ready(function() {
        $.ajax({
            url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            success: function(result) {
                $('#nfs').DataTable({
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

@endsection

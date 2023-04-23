@extends('adminlte::page')

@section('title', 'Recibos')

@section('content_header')
    <h1>Listagem de Recibos - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.financeiro.receipts.create') }}" role="button">Cadastrar nova Recibo - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($receipts))
        <div class="table ">
            <table class="text-nowrap table-sm table-striped table-responsive" id="receipts">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Filial</th>
                        <th>Favorecido</th>
                        <th>Valor</th>
                        <th>CPF/CNPJ</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receipts as $item)
                        <tr>
                            <td scope="row">{{ $item->id }}</td>
                            <td scope="row">{{ $item->branch->name }}</td>
                            <td scope="row">{{ $item->favored }}</td>
                            <td scope="row">R$ {{number_format($item->value,2,",",".") }}</td>
                            <td scope="row">{{ $item->register }}</td>
                            <td scope="row"><a class="btn btn-warning" href="{{route('dashboard.financeiro.receipts.show',$item)}}"><i class="fa fa-eye" aria-hidden="true"></i>Mostrar</a></td>

                            {{-- <td scope="row">{{ $item->logradouro }}, {{ $item->numero }}, {{ $item->bairro }}, {{ $item->cidade }}-({{ $item->uf }}), CEP: {{ $item->cep }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Não há Recibos para listagem</p>
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
                $('#receipts').DataTable({
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

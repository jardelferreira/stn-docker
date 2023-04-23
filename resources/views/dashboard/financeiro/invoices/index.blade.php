@extends('adminlte::page')

@section('title', 'Notas fiscais')

@section('content_header')
    <h1>Listagem de Notas - <a name="" id="" class="btn btn-success"
            href="{{ route('dashboard.invoices.create') }}" role="button">Cadastrar nova NF - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($invoicers))
        <div class="table ">
            <table class="text-nowrap table-sm table-striped table-responsive" id="nfs">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nota</th>
                        <th>Valor departamento</th>
                        <th>Valor total</th>
                        <th>Arquivo</th>
                        <th>Emissão</th>
                        <th>Vencimento</th>
                        <th>Ações</th>
                        <th>Lançada por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoicers as $item)
                        <tr>
                            <td scope="row">{{ $item->id }}</td>
                            <td scope="row">{{ $item->name }}</td>
                            <td scope="row">R$ {{number_format($item->value_departament,2,",",".")}}</td>
                            <td scope="row">R$ {{number_format($item->value,2,",",".")}}</td>
                            <td scope="row"><a href="{{ route('dashboard.invoices.show', $item) }}" target="_blank"
                                    class="text-danger"><i class="fa fa-file-pdf  ml-3 fa-xl" aria-hidden="true"></i></a>
                            </td>
                            <td scope="row">{{ date('d/m/Y', strtotime($item->issue)) }}</td>
                            <td scope="row">{{ date('d/m/Y', strtotime($item->due_date)) }}</td>
                            <td class="btn-group" role="group">
                                {{-- <a class="btn btn-info btn-sm mr-1"
                                    href="{{ route('dashboard.invoices.edit', $item) }}">Editar</a> --}}
                                @if (count($item->products))
                                    <a class="btn btn-success btn-sm mr-1"
                                        href="{{ route('dashboard.invoicesProducts.index', ['invoice' => $item->id]) }}">Ver
                                        Produtos</a>
                                @else
                                    <a class="btn ml-1 btn-warning btn-sm mr-1"
                                        href="{{ route('dashboard.invoices.popular.create', ['invoice' => $item->id]) }}">Cadastrar
                                        produtos</a>
                                @endif
                                <form action="{{ route('dashboard.invoices.destroy', ['invoice' => $item->id]) }}"
                                    method="POST" id="{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Deletar</button>
                                </form>
                            </td>
                            <td scope="row">{{ $item->user->name }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Não há Notas para listagem</p>
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

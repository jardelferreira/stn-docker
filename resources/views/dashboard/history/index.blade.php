@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
    <h1>Histórico de estoques</h1>
@stop
@section('css')
    <style>
        th{
            text-align: center !important;
            margin: auto;
        }
        td{
            white-space: nowrap !important;
        }
        #history{
            font-size: 0.8em;
        }
        #history tbody td{
            margin-top: 0 !important;
            padding-top: 0 !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
    </style>
@endsection
@section('content')
<input type="search" name="search" style="display: none">
    @if (count($histories))
        <table class="table table-striped table-bordered" id="history">
            <thead class="thead-inverse thead-secondary border border-light">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Qtd.</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    {{-- <th scope="col">Item</th> --}}
                    <th scope="col">Produto</th>
                    <th scope="col">Projeto</th>
                    <th scope="col">Base</th>
                    <th scope="col">Setor</th>
                    <th scope="col">Usuário</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $history)
                    <tr>
                        <td scope="row">{{$history->id}}</td>                      
                        <td scope="row">{{$history->type}}</td>                      
                        <td scope="row">{{$history->reason}}</td>
                        <td scope="row">{{$history->qtd}}</td>
                        <td scope="row">{{date('d/m/Y', strtotime($history->created_at))}}</td>
                        <td scope="row">{{date('H:i:s', strtotime($history->created_at))}}</td>
                        {{-- <td scope="row">{{$history->invoice_product_name}}</td> --}}
                        <td scope="row">{{$history->product_name}}</td>
                        <td scope="row">{{$history->project_name}}</td>
                        <td scope="row">{{$history->base_name}}</td>
                        <td scope="row">{{$history->sector_name}}</td>
                        <td scope="row">{{$history->user_name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Itens para listagem</p>
    @endif
@endsection

<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>

<script>
    $(document).ready(() => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
                url: "https://cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                success: function(result) {
                    $('#history').DataTable({
                        "language": result,
                        order: false,
                        "scrollX": true,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'Tudo'],
                        ],
                    });
                }
            });


    })
</script>

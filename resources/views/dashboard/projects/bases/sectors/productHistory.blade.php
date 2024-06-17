@extends('adminlte::page')

@section('title', 'Perfil do Produto')

@section('content')
    <div class="">
        <div class="card">
            <div class="card-header">
                <h2>Informações do Produto: <small class="text-primary">{{ $product->name }}</small></h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Nome do Produto -->
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="nomeProduto">Nome:</label>
                        <input type="text" class="form-control" id="nomeProduto" value="{{$product->name}}" readonly>
                        <p class="mt-1 ml-1">Quantidade em estoque: <strong>{{ $product->stoks->where('sector_id', $sector->id)->sum('qtd') }}</strong>
                             / Quantidade comprada: <strong>{{$product->purchased()->first()->qtd_total}}</strong></p>
                             <hr>
                    </div>

                    <!-- Descrição do Produto -->
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="descricaoProduto">Descrição:</label>
                        <textarea class="form-control" id="descricaoProduto" rows="3" readonly>{{$product->description}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <!-- Fornecedores -->
                    <div class="form-group col-6">
                        <label for="fornecedoresProduto">Fornecedores:</label>
                        <ul class="list-group">
                            @foreach ($providers as $provider)
                                <li class="list-group-item">{{ $provider->fantasy_name }} - {{ $provider->cnpj }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Atributos Possíveis -->
                    <div class="form-group col-6">
                        <label for="atributosProduto">Atributos Possíveis:</label>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Atributo:</strong> Valor</li>
                            <li class="list-group-item"><strong>Atributo:</strong> Valor</li>
                            <li class="list-group-item"><strong>Atributo:</strong> Valor</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Histórico de Movimentação -->
        <div class="card mt-4">
            <div class="card-header">
                <h2>Histórico de Movimentação no Estoque</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo de Movimentação</th>
                            <th>Quantidade</th>
                            <th>Responsável</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($history->created_at)) }}</td>
                                <td>{{ $history->type }}</td>
                                <td>{{ $history->qtd }}</td>
                                <td>{{ $history->user_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

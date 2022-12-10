@extends('adminlte::page')

@section('title', 'Estoque')

@section('content_header')
    <h1>Estoque da base -{{ $base->name }}</h1>
@stop

@section('content')
    @if (count($base->sectors()->get()))
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Qtd</th>
                    <th>Setor</th>
                    <th>Produto</th>
                    <th>Descrição</th>
                    {{-- <th>Ações</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($base->sectors as $sector)
                    @foreach ($sector->stoks as $item)
                        <tr>
                            <td scope="row">{{ $item->qtd }}</td>
                            <td scope="row">{{ $sector->name }}</td>
                            <td scope="row">{{ $item->invoiceProduct->name }}</td>
                            <td scope="row">{{ $item->invoiceProduct->description }}</td>
                            {{-- <td class="btn-group" role="group">
                                <a class="btn btn-warning btn-sm mr-1"
                                href="{{ route('dashboard.sectors.stoks.index', ['sector' => $item->id]) }}"><i
                                class="fa fa-cubes" aria-hidden="true"></i></a>
                                <a class="btn btn-info btn-sm mr-1"
                                href="{{ route('dashboard.sectors.edit', ['sector' => $item]) }}">Editar</a>
                                <form action="{{ route('dashboard.sectors.destroy', ['sector' => $item->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Deletar</button>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Itens para listagem</p>
    @endif
@endsection

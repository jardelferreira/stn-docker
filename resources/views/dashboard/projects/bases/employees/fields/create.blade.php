@extends('adminlte::page')

@section('title', 'Cadastro de registro')

@section('content_header')
    <h1> Adicionar registro a - {{ $base->name }} / {{ $employee->user->name }} <a
            class="btn btn-primary"
            href="{{ route('dashboard.bases.employees.list.formlists', ['base' => $base, 'employee' => $employee]) }}"
            role="button">Vincular novo - <i class="fa fa-plus" aria-hidden="true"></i></a></h1>
@stop

@section('content')
<form action="{{route('dashboard.fields.salveField',$formlist)}}" method="post">
    <div class="form-group">
        <label for="setor_id">Selecione um Setor</label>
        <select class="form-control" name="setor_id" id="setor_id">
            <option>Selecione</option>
        </select>
    </div>
        @csrf
        @method('POST')
        {{-- <input type="hidden" name="signature_delivered"> --}}
        <div class="form-group">
            <label for="stok_id">Selecione um Produto</label>
            <select class="form-control" name="stok_id" id="stok_id">
                <option>Selecione...</option>

            </select>
        </div>
        <div class="form-group">
            <label for="qtd_delivered">Quantidade disponível: 20 und</label>
            <input type="number" class="form-control" name="qtd_delivered" id="qtd_delivered"
                aria-describedby="qtd_delivered" placeholder="2">
            <small id="qtd_delivered" class="form-text text-muted">Informe a quantidade entregue</small>
        </div>
        <div class="form-group">
            <label for="ca_second">C.A Opcional:</label>
            <input type="text" class="form-control" name="ca_second" id="ca_second" aria-describedby="ca_second"
                placeholder="CA2560.89-NBR">
            <small id="ca_second" class="form-text text-muted">Certificado de Aprovação Opcional</small>
        </div>
        <div class="form-group">
          <label for="observation">Observações:</label>
          <textarea class="form-control" name="observation" id="observation" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@endsection
@section('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var $url = window.location.href

            $("#setor_id").select2({
                ajax: {
                    url: `${$url.replace("adicionar","sectors")}`,
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                        };
                    },
                    processResults: function(response) {
                        console.log(response)
                        let sectors = response.map(function(e) {
                            return {
                                "id": e.id,
                                "text": e.name
                            }
                        })
                        return {
                            results: sectors
                        };
                    },
                    cache: true
                }
            });
            $("#setor_id").on('change', (e) => {
                $("#stok_id").select2({
                    ajax: {
                        url: `${$url.replace("adicionar","sectors")}/${$("#setor_id").val()}`,
                        type: "GET",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term,
                            };
                        },
                        processResults: function(response) {
                            console.log(response)
                            let sectors = response.map(function(e) {
                                return {
                                    "id": e.id,
                                    "text": e.description
                                }
                            })
                            return {
                                results: sectors
                            };
                        },
                        cache: true
                    }
                });
            })

        });
    </script>
@stop

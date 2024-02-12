@extends('adminlte::page')

@section('title', 'Cadastro de fornecedores')

@section('content_header')
    <h1>Cadastro de Fornecedores</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.providers.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-row">
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="corporate_name">Razão Social</label>
                <input type="text" autocomplete="off" class="form-control" name="corporate_name" id="corporate_name"
                    aria-describedby="helpName" placeholder="razão social">
                <small id="helpName" class="form-text text-muted">informe a razão social</small>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="fantasy_name">Nome Fantasia</label>
                <input type="text" autocomplete="off" class="form-control" name="fantasy_name" id="fantasy_name"
                    aria-describedby="helpName" placeholder="nome fantasia">
                <small id="helpName" class="form-text text-muted">Insira nome fantasia</small>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label for="cnpj">CNPJ</label>
                <input type="text" autocomplete="off" class="form-control" name="cnpj" id="cnpj"
                    aria-describedby="helpName" placeholder="12.345.678/0009-10">
                <small id="helpName" class="form-text text-muted">Insira o CNPJ</small>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label for="email">E-mail:</label>
                <input type="email" autocomplete="off" class="form-control" name="email" id="email"
                    aria-describedby="helpName" placeholder="fornecedor@mail">
                <small id="helpName" class="form-text text-muted">Insira o E-mail:</small>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label for="phone">Telefone:</label>
                <input type="phone" autocomplete="off" class="form-control" name="phone" id="phone"
                    aria-describedby="helpName" placeholder="99 9999-9999">
                <small id="helpName" class="form-text text-muted">Insira o telefone:</small>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="address">Endereço:</label>
                <input type="text" autocomplete="off" class="form-control" name="address" id="address"
                    aria-describedby="helpName" placeholder="nome fantasia">
                <small id="helpName" class="form-text text-muted">Insira o Endereço</small>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                <label for="headquarters">Caso este fornecedor pertença a uma matriz, favor selecionar da lista</label>
                <select class="form-control" name="headquarters" id="headquarters">
                    <option value="">Selecione um fornecedor para cadastrar como matriz</option>
                    @foreach ($headquarters as $item)
                        <option value="{{ $item->id }}">{{ $item->corporate_name }}</option>
                    @endforeach
                </select>
                <small id="headquarters" class="form-text text-muted">Não é obrigatório</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
@stop

@section('js')
    {{-- <script>
      $("#teste").on("click",(e) => {

        let timerInterval
        Swal.fire({
            title: 'Auto close alert!',
            html: 'I will close in <b></b> milliseconds.',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
          })
        })
    </script> --}}
    <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $("#headquarters").select2()
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();

        });
    </script>
@stop

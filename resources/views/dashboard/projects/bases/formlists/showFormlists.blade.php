@extends('adminlte::page')

@section('title', 'Formulários')

@section('content_header')
    <h1> Formulários da base - <a href="{{route('dashboard.bases.show',$base)}}">{{ $base->name }}</a>  <a class="btn btn-primary"
            href="{{ route('dashboard.bases.formlists', $base) }}" role="button">Vincular novo - <i class="fa fa-plus"
                aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @if (count($formlists))
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Formulários</th>
                    <th>Revisão</th>
                    <th>Área</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formlists as $item)
                    <tr>
                        <td scope="row">{{ $item->name }} {{ $item->id }}</td>
                        <td scope="row">Rev-{{ $item->revision }}</td>
                        <td scope="row">{{ $item->area }}</td>
                        <td scope="row">{{ $item->description }}</td>
                        <td>
                            <form
                                action="{{ route('dashboard.bases.detachFormlist', ['base' => $base, 'id' => $item->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" data-whatever="{{ $item->pivot->id }}">Resp.
                                    Técnicos</button>
                                <button class="btn btn-danger btn-sm ml-1" type="submit">Desvincular</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há Formulários para listagem</p>
    @endif

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Responsáveis técnicos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dashboard.bases.formlists.users.sync', $base->id) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="modal-body" style="height: 70vh">
                        <input type="hidden" class="form-control" id="recipient-name" name="formlist_id">

                        <div class="form-group">
                            <label for="users[]">Selecionar a partir da lista</label>
                            <select multiple class="custom-select" name="users[]" id="users"
                                style="height: 70; width: 100%">
                                {{-- @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $("#headquarters").select2()
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();

        });
    </script>
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var formlist = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $("#users").val(null)
            $("#users").trigger('change');
            $(".select2-selection__choice").remove()
            var modal = $(this)
            var users = $("#users")
            modal.find('.modal-body input').val(formlist)
            $.get(`${window.location.href}/${formlist}/users`).then((res) => {
                // create the option and append to Select2
                res.users.forEach(user => {
                    if ($('#users').find("option[value='" + user.id + "']").length) {
                        $('#users').val(user.id).trigger('change');
                    } else {
                        // Create a DOM Option and pre-select by default
                        var newOption = new Option(user.name, user.id, true, true);
                        // Append it to the select
                        $('#users').append(newOption).trigger('change');
                    }
                    // var option = new Option(user.name, user.id, false, false);
                    // // }
                    // users.append(option);

                });
                $("#users").val(res.responses).trigger("change")

                // $("#users").trigger("change")
                // option = null;
            });
        })
        $("#users").select2()
        $('#exampleModal').on('hidden.bs.modal', function(e) {
            console.log("fechou")
            $("#users").val(null).trigger("change")
        })
    </script>
@endsection

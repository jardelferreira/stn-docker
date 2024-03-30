@extends('adminlte::page')

@section('title', 'usuários')

@section('content')
    @csrf
    
    @if (session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center profile-pic-wrapper">
                            <div class="pic-holder">
                                <!-- uploaded pic shown here -->
                                <img id="profilePic" class="pic"
                                    @if ($user->image_path) src='{{ asset("{$user->image_path}") }}'
                                @else
                                    src="https://bootdey.com/img/Content/avatar/avatar7.png" @endif>

                                <Input class="uploadProfileInput" type="file" name="image_path" id="newProfilePhoto"
                                    accept="image/*" style="opacity: 0;" />
                                <label for="newProfilePhoto" class="upload-file-block">
                                    <div class="text-center">
                                        <div class="mb-2">
                                            <i class="fa fa-camera fa-2x"></i>
                                        </div>
                                        <div class="text-uppercase">
                                            Atualizar <br /> Foto de Perfil
                                        </div>
                                    </div>
                                </label>
                            </div>
                            {{-- <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle"  width="150"> --}}
                            <div class="mt-3">
                                <h4>{{ $user->name }}</h4>
                                <p class="text-secondary mb-1">{{ $user->email }}</p>
                                <p class="text-muted font-size-sm">STN EMPREENDIMENTOS E CONSTRUÇÕES</p>
                                {{-- <button class="btn btn-outline-primary">Nova imagem</button> --}}
                                @if ($user->hasSignature())
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModalCenter">Nova Assinatura</button>
                                    <a class="btn btn-outline-success rounded-circle btn-sm"><i class="fa fa-key"
                                            aria-hidden="true"></i></a>
                                @else
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                                        data-target="#exampleModal">
                                        Gerar assinatura
                                    </button>
                                @endif
                                @if ($user->biometric)
                                
                                <input type="hidden" id="template" value="{{$user->biometric->template}}">
                                    <button onclick="matchOneOnOne('{{$user->biometric->template}}')" style="border: none; margin: 0; padding: 0;"><img style="height: 35px;"
                                            class="ml-1" src="{{ asset('images/finger-ok.svg') }}"
                                            alt=""></button>
                                @else
                                <input type="hidden" id="template">
                                    <button style="border: none; margin: 0; padding: 0;"
                                        onclick="captureHash({{ $user->id }})" href="#"><img style="height: 35px;"
                                            class="ml-1" src="{{ asset('images/finger-read.svg') }}"
                                            alt=""></button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-globe mr-2 icon-inline">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                    </path>
                                </svg>Website</h6>
                            <span class="text-secondary">https://bootdey.com</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-github mr-2 icon-inline">
                                    <path
                                        d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                    </path>
                                </svg>Github</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-twitter mr-2 icon-inline text-info">
                                    <path
                                        d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                    </path>
                                </svg>Twitter</h6>
                            <span class="text-secondary">@bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-instagram mr-2 icon-inline text-danger">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                    </rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>Instagram</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-facebook mr-2 icon-inline text-primary">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>Facebook</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Nome Completo</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $user->name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">E-mail</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $user->email }}
                            </div>
                        </div>
                        <hr>
                        {{-- <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Telefone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    (239) 816-9029
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Mobile</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    (320) 380-4539
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    Bay Area, San Francisco, CA
                                </div>
                            </div> --}}
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-info " href="{{ route('dashboard.users.edit', $user->id) }}">Atualizar
                                    informações</a>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#updatePassword">Nova senha</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gutters-sm">
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3"><i
                                        class="material-icons text-info mr-2">Participação em projetos</i>Tempo de
                                    contrato</h6>
                                <small>LT São Marcos - ENEL-GO - Almoxarife</small>
                                <div class="progress mb-3" style="height: 10px">
                                    <div class="progress-bar bg-primary h-100" role="progressbar" style="width: 80%"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                                </div>
                                <small>SE São Marcos - ENEL-GO - Almoxarife</small>
                                <div class="progress mb-3" style="height: 10px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 72%"
                                        aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>One Page</small>
                                <div class="progress mb-3" style="height: 10px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 89%"
                                        aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>Mobile Template</small>
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 55%"
                                        aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small>Backend API</small>
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 66%"
                                        aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3"><i
                                        class="material-icons text-info mr-2">Permissões e Funções
                                    </i>{{ explode(' ', $user->name)[0] }} {{ explode(' ', $user->name)[1] ?? '' }}
                                </h6>
                                <h6>Funções: -
                                    @can(['acl'])
                                        <a name="" id="" class="btn btn-outline-primary btn-sm"
                                            href="{{ route('dashboard.users.roles', $user->id) }}" role="button">Gerenciar
                                            Funções</a>
                                    @endcan
                                </h6>
                                @if (count($user->roles))
                                    <ul class="list-group list-group-flush">
                                        @foreach ($user->roles as $role)
                                            <li class="list-group-item"><a
                                                    href="{{ route('dashboard.roles.show', $role) }}">
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                    {{ $role->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>O usuário ainda não possui Funções</p>
                                @endif
                                <hr>
                                <h6>Permissões: -
                                    @can('acl')
                                        <a name="" id="" class="btn btn-outline-success btn-sm"
                                            href="{{ route('dashboard.users.permissions', $user->id) }}"
                                            role="button">Gerenciar Permissões</a>
                                    @endcan
                                </h6>
                                @if (count($user->permissions))
                                    <ul class="list-group list-group-flush">
                                        @foreach ($user->permissions as $permission)
                                            <li class="list-group-item"><a href="#"><i
                                                        class="fa fa-check text-success" aria-hidden="true"></i>
                                                    {{ $permission->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>O usuário ainda não possui permissões</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de Assinaturas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Informe uma senha para suas assinaturas</p>
                    <form action="{{ route('dashboard.users.signature', $user) }}" method="post">
                        @csrf
                        @method('post')
                        <div class="form-group">
                            <label for="pass">Informe a Senha</label>
                            <input type="password" class="form-control" name="pass" id="pass"
                                placeholder="4 a 8 digitos">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">fechar</button>
                    <button type="submit" class="btn btn-success">Gerar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Atualizar Assinatura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dashboard.users.updateSignaturePass', $user) }}" method="post">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="password">Senha de login</label>
                            <input type="text" class="form-control" name="password" id="password"
                                aria-describedby="helpPawrd" placeholder="senha utlizada para login">
                            <small id="helpPawrd" class="form-text text-muted">Informe a senha de login do usuário</small>
                        </div>
                        <div class="form-group">
                            <label for="signature">Nova assinatura</label>
                            <input type="text" class="form-control" name="signature" id="signature"
                                aria-describedby="helpId" placeholder="4 a 8 digitos">
                            <small id="helpId" class="form-text text-muted">Informe uma senha de 4 até 8
                                digitos</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">fechar</button>
                        <button type="submit" class="btn btn-primary">Mudar assinatura</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- updatePassword modal --}}
    <div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Atualizar senha de usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dashboard.users.updatePassword', $user) }}" method="post">
                    <div class="modal-body">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="user_password">Informe sua senha</label>
                            <input type="text" class="form-control" name="user_password" required id="user_password"
                                aria-describedby="helpPawrd" placeholder="senha utlizada para login">
                            <small id="helpPawrd" class="form-text text-muted">Sua senha de login do usuário</small>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nova senha para o usuário</label>
                            <input type="text" class="form-control" name="new_password" required id="new_password"
                                aria-describedby="helpId" placeholder="Mínimo 8 digitos">
                            <small id="helpId" class="form-text text-muted">Informe a nova senha de usuário</small>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirm">Confirmar senha</label>
                            <input type="text" class="form-control" name="new_password_confirm" required
                                id="new_password_confirm" aria-describedby="helpId" placeholder="Minimo 8 digitos">
                            <small id="helpId" class="form-text text-muted">Confirme a nova senha de usuário</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">fechar</button>
                        <button type="submit" class="btn btn-primary">Mudar assinatura</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        #password,
        #user_password,
        #new_password,
        #new_password_confirm {
            -webkit-text-security: square;
        }
    </style>
    <style>
        .pic-holder {
            text-align: center;
            position: relative;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .pic-holder .pic {
            height: 100%;
            width: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            -o-object-position: center;
            object-position: center;
        }

        .pic-holder .upload-file-block,
        .pic-holder .upload-loader {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(90, 92, 105, 0.7);
            color: #f8f9fc;
            font-size: 12px;
            font-weight: 600;
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .pic-holder .upload-file-block {
            cursor: pointer;
        }

        .pic-holder:hover .upload-file-block,
        .uploadProfileInput:focus~.upload-file-block {
            opacity: 1;
        }

        .pic-holder.uploadInProgress .upload-file-block {
            display: none;
        }

        .pic-holder.uploadInProgress .upload-loader {
            opacity: 1;
        }

        /* Snackbar css */
        .snackbar {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 14px;
            transform: translateX(-50%);
        }

        .snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>
@stop

@section('js')
    <script>
        $(".alert").ready(function() {
            setTimeout(() => {
                $(".alert").fadeOut(2000)
            }, 3000);
        }) 
    </script>
    <script src="{{ asset('js/fingertechweb.js') }}"></script>
    <script>
        document.addEventListener("change", function(event) {
            if (event.target.classList.contains("uploadProfileInput")) {
                var triggerInput = event.target;
                var currentImg = triggerInput.closest(".pic-holder").querySelector(".pic").src;
                var holder = triggerInput.closest(".pic-holder");
                var wrapper = triggerInput.closest(".profile-pic-wrapper");

                var alerts = wrapper.querySelectorAll('[role="alert"]');
                alerts.forEach(function(alert) {
                    alert.remove();
                });

                triggerInput.blur();
                var files = triggerInput.files || [];
                if (!files.length || !window.FileReader) {
                    return;
                }

                if (/^image/.test(files[0].type)) {
                    var reader = new FileReader();
                    reader.readAsDataURL(files[0]);

                    reader.onloadend = function() {
                        holder.classList.add("uploadInProgress");
                        holder.querySelector(".pic").src = this.result;

                        var loader = document.createElement("div");
                        loader.classList.add("upload-loader");
                        loader.innerHTML =
                            '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>';
                        holder.appendChild(loader);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        console.log(files[0])
                        var formData = new FormData()
                        formData.append('file', files[0])
                        $.ajax({
                            url: `${window.location.href}/updateImage`,
                            type: "POST",
                            enctype: 'multipart/form-data',
                            processData: false, // impedir que o jQuery tranforma a "data" em querystring
                            contentType: false,
                            timeout: 600000,
                            data: formData,
                            success: function(result) {
                                console.log(result)
                                if (result) {
                                    loader.remove();
                                    wrapper.innerHTML +=
                                        '<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> Imagem de perfil atualizada com  sucesso!</div>';
                                    triggerInput.value = "";
                                    holder.classList.remove("uploadInProgress");
                                    setTimeout(function() {
                                        wrapper.querySelector('[role="alert"]').remove();
                                    }, 3000);
                                } else {
                                    holder.querySelector(".pic").src = currentImg;
                                    wrapper.innerHTML +=
                                        '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i>Desculpe. Ocorreu um erro ddurante a atualização, tente mais tarde.</div>';
                                    triggerInput.value = "";
                                    setTimeout(function() {
                                        wrapper.querySelector('[role="alert"]').remove();
                                    }, 3000);
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        })
                        setTimeout(function() {
                            holder.classList.remove("uploadInProgress");
                            loader.remove();


                            var random = Math.random();
                            // if (random < 0.9) {
                            //     wrapper.innerHTML +=
                            //         '<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> Profile image updated successfully</div>';
                            //     triggerInput.value = "";
                            //     setTimeout(function() {
                            //         wrapper.querySelector('[role="alert"]').remove();
                            //     }, 3000);
                            // } else {
                            //     holder.querySelector(".pic").src = currentImg;
                            //     wrapper.innerHTML +=
                            //         '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i> There is an error while uploading! Please try again later.</div>';
                            //     triggerInput.value = "";
                            //     setTimeout(function() {
                            //         wrapper.querySelector('[role="alert"]').remove();
                            //     }, 3000);
                            // }
                        }, 1500);
                    };
                } else {
                    wrapper.innerHTML +=
                        '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose a valid image.</div>';
                    setTimeout(function() {
                        var invalidAlert = wrapper.querySelector('[role="alert"]');
                        if (invalidAlert) {
                            invalidAlert.remove();
                        }
                    }, 3000);
                }
            }
        });
    </script>
@stop

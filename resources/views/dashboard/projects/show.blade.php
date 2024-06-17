@extends('adminlte::page')

@section('css')
    <style>
        div.list-group-item>a:hover {
            font-weight: bold
        }

        .list-group-item>.btn-success,
        .btn-primary {
            color: black
        }

        .list-group-item>.btn-success:hover {
            color: #fff;
        }

        .custom-bg-blue {
            background: rgb(2, 0, 36);
            background: -moz-linear-gradient(270deg, rgba(2, 0, 36, 1) 0%, rgba(63, 63, 242, 0.891281512605042) 63%, rgba(0, 212, 255, 1) 100%);
            background: -webkit-linear-gradient(270deg, rgba(2, 0, 36, 1) 0%, rgba(63, 63, 242, 0.891281512605042) 63%, rgba(0, 212, 255, 1) 100%);
            background: linear-gradient(270deg, rgba(2, 0, 36, 1) 0%, rgba(63, 63, 242, 0.891281512605042) 63%, rgba(0, 212, 255, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#020024", endColorstr="#00d4ff", GradientType=1);
        }

        .custom-bg-red {
            background: rgb(36, 0, 8);
            background: -moz-linear-gradient(270deg, rgba(36, 0, 8, 1) 0%, rgba(242, 63, 63, 0.891281512605042) 63%, rgba(255, 98, 0, 1) 100%);
            background: -webkit-linear-gradient(270deg, rgba(36, 0, 8, 1) 0%, rgba(242, 63, 63, 0.891281512605042) 63%, rgba(255, 98, 0, 1) 100%);
            background: linear-gradient(270deg, rgba(36, 0, 8, 1) 0%, rgba(242, 63, 63, 0.891281512605042) 63%, rgba(255, 98, 0, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#240008", endColorstr="#ff6200", GradientType=1);
        }

        .custom-bg-yellow {
            background: rgb(66, 63, 0);
            background: -moz-linear-gradient(270deg, rgba(66, 63, 0, 1) 0%, rgba(249, 250, 24, 0.9613095238095238) 71%, rgba(189, 255, 69, 1) 100%);
            background: -webkit-linear-gradient(270deg, rgba(66, 63, 0, 1) 0%, rgba(249, 250, 24, 0.9613095238095238) 71%, rgba(189, 255, 69, 1) 100%);
            background: linear-gradient(270deg, rgba(66, 63, 0, 1) 0%, rgba(249, 250, 24, 0.9613095238095238) 71%, rgba(189, 255, 69, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#423f00", endColorstr="#bdff45", GradientType=1);
        }

        .custom-bg-green {
            background: rgb(4, 65, 1);
            background: -moz-linear-gradient(270deg, rgba(4, 65, 1, 1) 0%, rgba(78, 250, 24, 0.9613095238095238) 69%, rgba(69, 255, 187, 1) 100%);
            background: -webkit-linear-gradient(270deg, rgba(4, 65, 1, 1) 0%, rgba(78, 250, 24, 0.9613095238095238) 69%, rgba(69, 255, 187, 1) 100%);
            background: linear-gradient(270deg, rgba(4, 65, 1, 1) 0%, rgba(78, 250, 24, 0.9613095238095238) 69%, rgba(69, 255, 187, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#044101", endColorstr="#45ffbb", GradientType=1);
        }

        .custom-bg-purple {
            background: rgb(42, 1, 65);
            background: -moz-linear-gradient(270deg, rgba(42, 1, 65, 1) 0%, rgba(101, 0, 168, 0.9613095238095238) 69%, rgba(212, 69, 255, 1) 100%);
            background: -webkit-linear-gradient(270deg, rgba(42, 1, 65, 1) 0%, rgba(101, 0, 168, 0.9613095238095238) 69%, rgba(212, 69, 255, 1) 100%);
            background: linear-gradient(270deg, rgba(42, 1, 65, 1) 0%, rgba(101, 0, 168, 0.9613095238095238) 69%, rgba(212, 69, 255, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#2a0141", endColorstr="#d445ff", GradientType=1);
        }

        .dropdown-bg-primary .dropdown-item:hover {
            background-color: #007bff;
            color: #fff;
        }

        .dropdown-bg-info .dropdown-item:hover {
            background-color: #5bc0de;
            color: #fff;
        }

        .dropdown-bg-warning .dropdown-item:hover {
            background-color: #E4A11B;
            color: #292b2c;
        }

        .dropdown-bg-success .dropdown-item:hover {
            background-color: #5cb85c;
            color: #fff;
        }

        .dropdown-bg-danger .dropdown-item:hover {
            background-color: #d9534f;
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <div class="d-block ml-2 py-1 bg-light text-center">
        <h5 class="mx-auto">{{ $project->name }}</h5>
        <hr>
    </div>
    <div class="grey-bg container-fluid">
        <section id="minimal-statistics">
            <div class="row">
                <div class=" col-xl-3 col-sm-6 col-12">
                    <div class="card border border-info rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 30%;" class="badge badge-info">
                                    Controle de notas</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <i class="fa fa-file-pdf-o fa-3x text-info" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="">
                                            {{ $project->amountInvoicesByProject()->count_invoices ?? 0 }}</h3>
                                        <span class="">Total de notas cadastradas</span>
                                    </div>
                                    <div class="bg-info m-0 dropdown float-right btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#" onclick="openModal('createInvoices')">
                                                <i class="fa fa-plus-circle text-success" aria-hidden="true"></i> Cadastrar
                                                nota</a>
                                            <a class="dropdown-item" role="button" data-toggle="modal" data-target=".list-invoice-modal-xl"
                                            onclick="openModal('listInvoicesModal')"><i class="fa fa-list-ol"
                                                    aria-hidden="true"></i> Listar notas</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-list-alt"
                                                    aria-hidden="true"></i> Adicionar produtos a nota</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-bar-chart"
                                                    aria-hidden="true"></i> Estatísticas de notas</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 ">
                    <div class="card border border-info rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 20%;" class="badge badge-info">
                                    Controle de produtos e compras</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <i class="fa fa-cart-plus fa-3x text-info" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <p class="">
                                            [{{ $project->amountProductsByProject()->count_products ?? 0 }}] <i
                                                class="fa fa-arrow-right" aria-hidden="true"></i>
                                            {{ $project->amountProductsByProject()->amount_products ?? 0 }}</p>
                                        <span class="">Total de produtos comprados</span>
                                    </div>
                                    <div class="bg-info m-0 dropdown float-right btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownCompas" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownCompas">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fa fa-plus-circle text-success" aria-hidden="true"></i> Cadastrar
                                                novo produto</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-list-ol"
                                                    aria-hidden="true"></i> Listar produtos do projeto</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-bar-chart"
                                                    aria-hidden="true"></i> Estatísticas de produtos</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 ">
                    <div class="card border border-info rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 30%;" class="badge badge-info">
                                    Custo efetivo de compras</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <i class="fas fa-dollar-sign  fa-3x text-info"></i>
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="">R$
                                            {{ number_format($project->amountInvoicesByProject()->amount_project ?? 0, 2, ',', '.') }}
                                        </h3>
                                        <span class="">Custo total de compras</span>
                                    </div>
                                    <div class="bg-info m-0 dropdown float-right btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownNfs2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs2">
                                            <a class="dropdown-item" href="#"><i class="fa fa-cogs"
                                                    aria-hidden="true"></i> Definir estimativa de custo</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-list-ol"
                                                    aria-hidden="true"></i> Listagem de custos</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-bar-chart"
                                                    aria-hidden="true"></i> Análise de custos</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 ">
                    <div class="card border border-info rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 30%;" class="badge badge-info">
                                    Estimativa de custo</p>
                                <div class="media d-flex dropleft dropleft">
                                    <div class="align-self-center">
                                        <i class="fa fa-percent fa-3x text-info" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="">
                                            {{ (($project->amountInvoicesByProject()->amount_project ?? 0) / 500000.0) * 100 }}%
                                        </h3>
                                        <span class="">Percentual da estimativa</span>
                                    </div>
                                    <div class="bg-info m-0 dropdown btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownNfs3" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs3">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class=" col-xl-3 col-sm-6 col-12">
                    <div class="card border border-primary rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 30%;" class="badge badge-primary">
                                    Estoque de projeto</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center p-0 m-0">
                                        {{-- <img src="{{asset('images/box-stocks.svg')}}" class="img img-fluid p-0 m-0" style="height: 60px" alt=""> --}}
                                        <i class="fa fa-cubes fa-4x text-info" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3>{{ $project->amountInvoicesByProject()->count_invoices ?? 0 }} - produtos </h3>
                                        <span><a href="#">Consultar estoque do projeto</a></span>
                                    </div>
                                    <div class="bg-primary m-0 dropdown float-right btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownNfs4" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs4">
                                            <a class="dropdown-item" href="#"><i
                                                    class="fa fa-plus-circle text-success" aria-hidden="true"></i>
                                                Adicionar ao estoque</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-list-ol"
                                                    aria-hidden="true"></i> Listar por itens</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-list-ol"
                                                    aria-hidden="true"></i> Listar por produtos</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-bar-chart"
                                                    aria-hidden="true"></i> Estatística de estoque do projeto</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12 ">
                    <div class="card border border-primary rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 30%;" class="badge badge-primary">
                                    Estoque das bases</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <img src="{{ asset('images/headquarter.svg') }}" style="height: 60px"
                                            alt="">
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3>{{ $project->bases->count() }} - Bases </h3>
                                        <span><a href="#">Consultar estoque das bases</a></span>
                                    </div>
                                    <div class="bg-primary m-0 dropdown float-right btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownNfs5" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs5">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 ">
                    <div class="card border border-primary rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 30%;" class="badge badge-primary">
                                    Estoque dos setores</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <i class="fas fa-project-diagram fa-3x  text-info"></i>
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3>{{ $project->amountInvoicesByProject()->count_invoices ?? 0 }} - Setores
                                        </h3>
                                        <span><a href="#">Consultar estoque dos setores</a></span>
                                    </div>
                                    <div class="bg-primary m-0 dropdown float-right btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 ">
                    <div class="card border border-primary rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 20%;" class="badge badge-primary">
                                    Análise estatísticas de estoques</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <i class="fa fa-bar-chart fa-3x text-info" aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3>Estatísticas</h3>
                                        <span><a href="#">Análise e estatisticas de estoque</a></span>
                                    </div>
                                    <div class="bg-primary m-0 dropdown float-right btn p-0 dropdown-bg-primary"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-warning rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 30%;" class="badge badge-warning">
                                    Gestão de fornecedores</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <img src="{{ asset('images/provider.svg') }}" class="float-left"
                                            style="height: 60px" alt="fornecedores">
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="danger">{{ $project->providers()->count() }}</h3>
                                        <span>Fornecedores</span>
                                    </div>
                                    <div class="bg-warning m-0 dropdown float-right btn p-0 dropdown-bg-warning"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-warning rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 25%;" class="badge badge-warning">
                                    Gestão de Centro de custos</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <img src="{{ asset('images/center-cost.svg') }}" class="float-left"
                                            style="height: 60px" alt="centros de custo">
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="success">{{ $project->costs()->count() }}</h3>
                                        <span>Centros de custos</span>
                                    </div>
                                    <div class="bg-warning m-0 dropdown float-right btn p-0 dropdown-bg-warning"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-warning rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 25%;" class="badge badge-warning">
                                    Gestão de Setores de custos</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <img src="{{ asset('images/sector-cost.svg') }}" class="float-left"
                                            style="height: 60px" alt="setores de custo">
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="primary">{{ $project->sectors()->count() }}</h3>
                                        <span>Setores de custos</span>
                                    </div>
                                    <div class="bg-warning m-0 dropdown float-right btn p-0 dropdown-bg-warning"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-warning rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 20%;" class="badge badge-warning">
                                    Gestão de Departamento de custos</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <img src="{{ asset('images/departament-cost.svg') }}" class="float-left"
                                            style="height: 60px" alt="departamentos de custo">
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="warning">{{ $project->departamentCosts()->count() }}</h3>
                                        <span>Departamentos de custos</span>
                                    </div>
                                    <div class="bg-warning m-0 dropdown float-right btn p-0 dropdown-bg-warning"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-success rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 25%;" class="badge badge-success">
                                    Gestão de Funcionários</p>
                                <div class="media d-flex dropleft">
                                    <div class="align-self-center">
                                        <img src="{{ asset('images/employees.svg') }}" class="float-left"
                                            style="height: 60px" alt="departamentos de custo">
                                    </div>
                                    <div class="media-body text-right mr-1">
                                        <h3 class="warning">{{ $project->bases()->count() }} /
                                            {{ $project->employeesOnBases()->count() }}</h3>
                                        <span>Bases / Funcionários</span>
                                    </div>
                                    <div class="bg-success m-0 dropdown float-right btn p-0 dropdown-bg-success"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-success rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 25%;" class="badge badge-success">
                                    Gestão de Funcionários</p>
                                <div class="media d-flex dropleft">
                                    <div class="media-body text-right mr-1">
                                        <h3 class="danger">{{ $project->employees()->count() }}</h3>
                                        <span>Funcionários</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-rocket danger font-large-2 float-right"></i>
                                    </div>
                                    <div class="bg-success m-0 dropdown float-right btn p-0 dropdown-bg-success"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-success rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 25%;" class="badge badge-success">
                                    Gestão de Funcionários</p>
                                <div class="media d-flex dropleft">
                                    <div class="media-body text-right mr-1">
                                        <h3 class="success">
                                            {{ $project->employees()->distinct('profession_id')->count() }}</h3>
                                        <span>Profissões</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-user success font-large-2 float-right"></i>
                                    </div>
                                    <div class="bg-success m-0 dropdown float-right btn p-0 dropdown-bg-success"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border border-success rounded">
                        <div class="card-content">
                            <div class="card-body" style="padding: 20px 0px 20px 10px;">
                                <p style="position: absolute; top: -10px; margin-left: 25%;" class="badge badge-success">
                                    Gestão de Formulários - Fichas</p>
                                <div class="media d-flex dropleft">
                                    <div class="media-body text-right mr-1">
                                        <h3 class="primary">{{ $project->amountFormlists()->count_formlists ?? 0 }}</h3>
                                        <span><a href="{{ route('dashboard.projects.show.formlists', $project) }}">
                                                Consultar fichas abertas <i class="fa fa-search"
                                                    aria-hidden="true"></i></a></span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-support primary font-large-2 float-right"></i>
                                    </div>
                                    <div class="bg-success m-0 dropdown float-right btn p-0 dropdown-bg-success"
                                        style="height:65px; width: 30px;" id="dropdownNfs" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars mt-4" aria-hidden="true"></i>
                                        <div class="dropdown-menu" aria-labelledby="dropdownNfs">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex dropleft">
                                    <div class="media-body text-left">
                                        <h3 class="primary">
                                            R${{ number_format($project->amountInvoicesByProject()->amount_project, 2, ',', '.') }}
                                        </h3>
                                        <span>Montante de notas cadastradas</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-book-open primary font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 80%"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex dropleft">
                                    <div class="media-body text-left">
                                        <h3 class="warning">156</h3>
                                        <span>New Comments</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-bubbles warning font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 35%"
                                        aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex dropleft">
                                    <div class="media-body text-left">
                                        <h3 class="success">64.89 %</h3>
                                        <span>Bounce Rate</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-cup success font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%"
                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex dropleft">
                                    <div class="media-body text-left">
                                        <h3 class="danger">423</h3>
                                        <span>Total Visits</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-direction danger font-large-2 float-right"></i>
                                    </div>
                                </div>
                                <div class="progress mt-1 mb-0" style="height: 7px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 40%"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </section>
        {{-- 
        <section id="stats-subtitle">
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <div class="card overflow-hidden">
                        <div class="card-content">
                            <div class="card-body cleartfix">
                                <div class="media align-items-stretch">
                                    <div class="align-self-center">
                                        <i class="icon-pencil primary font-large-2 mr-2"></i>
                                    </div>
                                    <div class="media-body">
                                        <h4>Total Posts</h4>
                                        <span>Monthly blog posts</span>
                                    </div>
                                    <div class="align-self-center">
                                        <h1>18,000</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body cleartfix">
                                <div class="media align-items-stretch">
                                    <div class="align-self-center">
                                        <i class="icon-speech warning font-large-2 mr-2"></i>
                                    </div>
                                    <div class="media-body">
                                        <h4>Total Comments</h4>
                                        <span>Monthly blog comments</span>
                                    </div>
                                    <div class="align-self-center">
                                        <h1>84,695</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body cleartfix">
                                <div class="media align-items-stretch">
                                    <div class="align-self-center">
                                        <h1 class="mr-2">$76.456.590,00</h1>
                                    </div>
                                    <div class="media-body">
                                        <h4>Valor</h4>
                                        <span><a href="#"> Medições</a></span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-heart danger font-large-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body cleartfix">
                                <div class="media align-items-stretch">
                                    <div class="align-self-center">
                                        <h1 class="mr-2">$36,000.00</h1>
                                    </div>
                                    <div class="media-body">
                                        <h4>Custo Total</h4>
                                        <span><a href="#">Centros de custo</a></span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-wallet success font-large-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
    </div>

    {{-- <a name="provider" id="provider" class="btn btn-primary"
        href="{{ route('dashboard.projects.providers', $project) }}" role="button">Vincular Fornecedores</a>
    <button class="btn btn-success"  data-toggle="modal" data-target="#baseModal" data-whatever="{{$project->id}}">Cadastrar Base</button>
    <button class="btn btn-warning" data-toggle="modal" data-target="#costModal"
        data-whatever="{{ $project->id }}">Cadastrar Centro de custo</button> --}}

    <div class="teste">
        <div class="modal fade" id="costModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastrar novo centro de custo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="{{ route('dashboard.costs.store') }}" method="post" autocomplete="off">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <div class="form-group">
                                <label for="name">Nome do Centro de custo</label>
                                <input type="text" autocomplete="off" class="form-control" name="name"
                                    id="name" aria-describedby="helpName" placeholder="nome da centro de custo">
                                <small id="helpName" class="form-text text-muted">Insira o nome do Centro de
                                    custo</small>
                            </div>
                            <div class="form-group">
                                <label for="description">Descrição do Centro de custo</label>
                                <input type="text" autocomplete="off" class="form-control" name="description"
                                    id="description" aria-describedby="description"
                                    placeholder="nome da centro de custo">
                                <small id="description" class="form-text text-muted">Descreva este centro de custo</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row my-1">
        <div class="col-md-3 my-1">
            <div class="list-group">
                <a class="list-group-item list-group-item-action active bg-primary" data-toggle="collapse"
                    href="#collapseEmployees" role="button" aria-expanded="false" aria-controls="collapseEmployees">
                    Funcionários
                    - <i class="fa fa-user-alt" aria-hidden="true"> </i></a>
                <div class="list-group-item collapse" id="collapseEmployees">

                    <a class="list-group-item btn btn-primary"
                        href="{{ route('dashboard.projects.listEmployees', $project) }}">Vincular</a>
                    <a class="list-group-item btn btn-primary"
                        href="{{ route('dashboard.projects.employees', $project) }}">Listar</a>
                    <a class="list-group-item btn btn-primary" href="#">Terceira opção</a>
                </div>
                <div class="list-group-item justify-content-between">
                    Pendências <span class="badge badge-danger badge-pill">14</span>
                </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
                    Solicitações - <span class="badge badge-light badge-pill">156</span></a>
            </div>
        </div>
        <div class="col-md-3 my-1">
            <div class="list-group">
                <a class="list-group-item list-group-item-action bg-dark active" data-toggle="collapse"
                    href="#collapseBases" role="button" aria-expanded="false" aria-controls="collapseBases"> Bases
                    - <i class="fa fa-archive" aria-hidden="true"></i></a>
                <div class="list-group-item collapse" id="collapseBases">
                    <a class="list-group-item btn " data-toggle="modal" data-target="#baseModal"
                        data-whatever="{{ $project->id }}">Cadastrar</a>
                    <a class="list-group-item btn " href="#">Listar</a>

                    @foreach ($project->bases as $item)
                        <p class="list-group-item-text">
                            {{ $loop->index + 1 }} -
                            <a href="{{ route('dashboard.bases.show', $item) }}">{{ $item->name }}</a>
                        </p>
                    @endforeach
                </div>
                <div class="list-group-item justify-content-between">
                    Pendências <span class="badge badge-danger badge-pill">14</span>
                </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
                    Solicitações - <span class="badge badge-light badge-pill">156</span></a>
            </div>
        </div>
        <div class="col-md-3 my-1">
            <div class="list-group">
                <a class="list-group-item list-group-item-action bg-success active" data-toggle="collapse"
                    href="#collapseProviders" role="button" aria-expanded="false" aria-controls="collapseProviders">
                    Fornecedores
                    - <i class="fa fa-archive" aria-hidden="true"></i></a>
                <div class="list-group-item collapse" id="collapseProviders">
                    <a class="list-group-item btn btn-success"
                        href="{{ route('dashboard.projects.providers', $project) }}">Cadastrar</a>
                    <a class="list-group-item btn btn-success" href="#">Listar</a>

                    @foreach ($project->providers as $item)
                        <p class="list-group-item-text">
                            {{ $loop->index + 1 }} -
                            <a href="#">{{ $item->fantasy_name }}</a>
                        </p>
                    @endforeach
                </div>
                <div class="list-group-item justify-content-between">
                    Pendências <span class="badge badge-danger badge-pill">14</span>
                </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
                    Solicitações - <span class="badge badge-light badge-pill">156</span></a>
            </div>
        </div>
        <div class="col-md-3 my-1">
            <div class="list-group">
                <a class="list-group-item list-group-item-action active bg-warning" data-toggle="collapse"
                    href="#collapseSectors" role="button" aria-expanded="false" aria-controls="collapseSectors">
                    Setores
                    - <i class="fa-solid fa-diagram-project"></i></a>
                <div class="list-group-item collapse" id="collapseSectors">

                    <a class="list-group-item btn btn-warning" data-toggle="modal" data-target="#sectorModal"
                        data-whatever="{{ $project->name }}">Cadastrar Setor</a>
                    <a class="list-group-item btn btn-warning" href="#">Listar</a>
                    <a class="list-group-item btn btn-warning" href="#">Terceira opção</a>
                    @foreach ($project->sectors as $item)
                        <p class="list-group-item-text">
                            {{ $loop->index + 1 }} -
                            <a href="#">{{ $item->name }}</a>
                        </p>
                    @endforeach
                </div>
                <div class="list-group-item justify-content-between">
                    Pendências <span class="badge badge-danger badge-pill">14</span>
                </div> <a href="#" class="list-group-item list-group-item-action active justify-content-between">
                    Solicitações - <span class="badge badge-light badge-pill">156</span></a>
            </div>
        </div>

    </div>
    <div class="modal fade" id="baseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar nova base</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.bases.store') }}" method="post" autocomplete="off">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="form-group">
                            <label for="name">Nome do Base</label>
                            <input type="text" autocomplete="off" class="form-control" name="name" id="name"
                                aria-describedby="helpName" placeholder="nome da Bases">
                            <small id="helpName" class="form-text text-muted">Insira o nome do Base</small>
                        </div>
                        <div class="form-group">
                            <label for="place">Local da Base</label>
                            <input type="text" autocomplete="off" class="form-control" name="place" id="place"
                                aria-describedby="place" placeholder="nome da Bases">
                            <small id="place" class="form-text text-muted">Insira o local do Base</small>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição do Base</label>
                            <input type="text" autocomplete="off" class="form-control" name="description"
                                id="description" aria-describedby="description" placeholder="nome da Bases">
                            <small id="description" class="form-text text-muted">Descreva este Bases</small>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="createInvoices">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cadastro de notas.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <form action="{{ route('dashboard.invoices.store') }}" method="post" autocomplete="off"
                        enctype="multipart/form-data" id="createInvoiceForm">
                        @csrf
                        @method('POST')
                        <div class="form-row">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="number">Número: </label>
                                <input type="text" autocomplete="off"
                                    class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="number"
                                    id="number" required aria-describedby="helpName" placeholder="0001"
                                    value="{{ old('number') }}">
                                @if ($errors->has('number'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('number') }}
                                    </div>
                                @else
                                    <small id="helpNumber" class="form-text text-muted">informe número da nota</small>
                                @endif
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="invoice_type">Tipo de Documento: </label>
                                <select class="form-control {{ $errors->has('invoice_type') ? 'is-invalid' : '' }}"
                                    name="invoice_type" id="invoice_type" value="{{ old('invoice_type') }}" required>
                                    <option value="">Selecione o tipo de documento</option>
                                    <option value="NF">NF</option>
                                    <option value="NFS">NFS</option>
                                    <option value="FAT">FAT</option>
                                    <option value="CTE">CTE</option>
                                    <option value="REC">REC</option>
                                    <option value="CF">CUPOM FISCAL</option>
                                </select>
                                @if ($errors->has('invoice_type'))
                                    <div id="" class="invalid-feedback">
                                        {{ $errors->first('invoice_type') }}
                                    </div>
                                @else
                                    <small id="helpInvoice_type" class="form-text text-muted">Informe o tipo</small>
                                @endif
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="issue">Emissão: </label>
                                <input type="date" autocomplete="off"
                                    class="form-control {{ $errors->has('issue') ? 'is-invalid' : '' }}" name="issue"
                                    id="issue" value="{{ old('issue') }}" aria-describedby="helpName"
                                    placeholder="emissão" required>
                                @if ($errors->has('issue'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('issue') }}
                                    </div>
                                @else
                                    <small id="helpIssue" class="form-text text-muted">Informe a Emissão</small>
                                @endif
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="due_date">Vencimento: </label>
                                <input type="date" autocomplete="off"
                                    class="form-control {{ $errors->has('due_date') ? 'is-invalid' : '' }}"
                                    name="due_date" id="due_date" required value="{{ old('due_date') }}"
                                    aria-describedby="helpName" placeholder="vencimento">
                                @if ($errors->has('due_date'))
                                    <div id="" class="invalid-feedback">
                                        {{ $errors->first('due_date') }}
                                    </div>
                                @else
                                    <small id="helpDue_date" class="form-text text-muted">Informe o Vencimento</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-4 col-sm-12 col-md-12">
                                <label for="provider">Fornecedor: </label>
                                <select id="provider_id"
                                    class="form-control {{ $errors->has('provider_id') ? 'is-invalid' : '' }}"
                                    name="provider_id" required value="{{ old('provider_id') }}">
                                    <option value="">Selecione um fornecedor</option>
                                    @foreach ($project->providers as $provider)
                                        <option value="{{ $provider->id }}">
                                            <small>{{ $provider->corporate_name }}</small>
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('provider_id'))
                                    <div id="" class="invalid-feedback">
                                        {{ $errors->first('provider_id') }}
                                    </div>
                                @else
                                    <small id="helpProvider" class="form-text text-muted">Lista de Fornecedores</small>
                                @endif
                            </div>
                            <div class="form-group col-lg-8 col-sm-12 col-md-12">
                                <label for="departament_cost_id">Departamento: </label>
                                <select id="departament_cost_id"
                                    class="form-control {{ $errors->has('departament_cost_id') ? 'is-invalid' : '' }}"
                                    name="departament_cost_id" value="{{ old('departament_cost_id') }}">
                                    <option value="">Selecione um departamento</option>
                                    @foreach ($project->departamentCosts as $departament)
                                        <option value="{{ $departament->id }}">
                                            <small>{{ $departament->sectorCost->cost->project->name }} =>
                                                {{ $departament->sectorCost->cost->name }} =>
                                                {{ $departament->sectorCost->name }} =>
                                                {{ $departament->name }}</small>
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('departament_cost_id'))
                                    <div id="" class="invalid-feedback">
                                        {{ $errors->first('departament_cost_id') }}
                                    </div>
                                @else
                                    <small id="helpDepartament_cos" class="form-text text-muted">Lista de
                                        departamentos</small>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="value">Valor total: </label>
                                <input type="text" step="0.01" autocomplete="off"
                                    class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value"
                                    required value="{{ old('value') }}" id="value" aria-describedby="helpName"
                                    placeholder="R$ 1.000,00">
                                @if ($errors->has('value'))
                                    <div id="" class="invalid-feedback">
                                        {{ $errors->first('value') }}
                                    </div>
                                @else
                                    <small id="helpName" class="form-text text-muted">Informar valor</small>
                                @endif
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="value_departament">Valor para Departamento: </label>
                                <input type="text" step="0.01" autocomplete="off"
                                    class="form-control {{ $errors->has('value_departament') ? 'is-invalid' : '' }}"
                                    required value="{{ old('value_departament') }}" id="value_departament"
                                    name="value_departament" aria-describedby="helpName" placeholder="R$ 1.000,00">
                                @if ($errors->has('value_departament'))
                                    <div id="" class="invalid-feedback">
                                        {{ $errors->first('value_departament') }}
                                    </div>
                                @else
                                    <small id="helpName" class="form-text text-muted">Informar valor</small>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                <label for="file_invoice">Carregar arquivo: </label>
                                <input id="file_invoice"
                                    class="form-control-file {{ $errors->has('file_invoice') ? 'is-invalid' : '' }}"
                                    type="file" name="file_invoice" required>
                                @if ($errors->has('file_invoice'))
                                    <div id="" class="invalid-feedback">
                                        {{ $errors->first('file_invoice') }}
                                    </div>
                                @else
                                    <small id="helpFile" class="form-text text-muted">carregar PDF</small>
                                @endif
                            </div>
                        </div>
                        <button type="button"
                            onclick="createInvoice('{{ route('api.projects.createInvoices') }}','{{ $token }}',
                            '{{ route('api.products.products.get') }}')"
                            class="btn btn-primary">Cadastrar</button>
                        <button type="button" class="btn btn-secondary"
                            onclick="closeModal('createInvoices')">Cancelar</button>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="createInvoiceProducts">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cadastro de produtos em nota.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                    <div class="container">
                        <div class="row ml-2 mb-1">
                            <button id="add" class="btn btn-success">Adicionar Item</button>
                            <button type="button" id="btn-submit" onclick="createInvoiceProducts()" class="btn btn-primary ml-2">Finalizar e Cadastrar</button>
                            <button type="button" class="btn btn-secondary ml-2" onclick="closeModal('createInvoices')">Cancelar</button>
                            <p class="mr-2 ml-2 my-2">Total de <span id="total" style="font-size: 1.5em;" class="badge badge-danger m-0 pt-1 pb-1"> {{ old() ? old('cont') : 0 }} </span> itens para serem cadastrados</p>
                        </div>
                        <form id="invoiceProductsForm">
                            <input type="hidden" value="" id="invoice_route">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="cont" id="cont" value="1">
                            <div class="itens border border-dark p-0 rounded">
                                <div class="form-row container">
                                    <div class="form-group m-0">
                                        <label for="product_id">Identifique o Produto</label>
                                        <select class="form-control" name="product_id" id="product_id">
                                            <option>Selecione...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row p-0">
                                    <div class="form-group col-lg-1 col-md-2 col-sm-6">
                                        <label for="qtd">Qtd.</label>
                                        <input type="number" class="form-control" name="qtd" id="qtd" aria-describedby="qtdHelp" placeholder="10.0">
                                        <small id="qtdHelp" class="form-text text-muted">Quantidade</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="und">Und.:</label>
                                        <select class="form-control" name="und" id="und">
                                            <option value="UND">UND.</option>
                                            <option value="CJT">CJT.</option>
                                            <option value="PAR">PAR</option>
                                            <option value="CX.">CX.</option>
                                            <option value="PÇ">PÇ</option>
                                            <option value="KG">KG</option>
                                            <option value="TON">TON</option>
                                            <option value="LITRO">LITRO</option>
                                            <option value="METRO">METRO</option>
                                            <option value="METRO²">METRO²</option>
                                            <option value="METRO³">METRO³</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-5 col-md-8 col-sm-12">
                                        <label for="name">Item</label>
                                        <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="nome do meu produto aqui">
                                        <small id="nameHelp" class="form-text text-muted">Informe o nome do produto</small>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-6 col-sm-6">
                                        <label for="value_unid">Valor Unitário</label>
                                        <input type="text" class="form-control" name="value_unid" id="value_unid" aria-describedby="value_unidHelp" placeholder="10.0" >
                                        <small id="value_unidHelp" class="form-text text-muted">Valor unitário</small>
                                    </div>
                                    <div class="form-group col-lg-2 col-md-6 col-sm-6">
                                        <label for="ca_number">Certificado</label>
                                        <input type="text" class="form-control" name="ca_number" id="ca_number" aria-describedby="ca_numberHelp" placeholder="10321">
                                        <small id="ca_numberHelp" class="form-text text-muted">Identificação do certificado</small>
                                    </div>
                                    <input type="hidden" class="form-control value_total" name="value_total" id="value_total" aria-describedby="value_totalHelp" placeholder="10.0">
                                    <div class="form-group col-12">
                                        <label for="description">Descrição do Item</label>
                                        <input type="text" class="form-control" name="description" id="description" aria-describedby="descriptionHelp" placeholder="Detalhe o produto aqui">
                                        <small id="descriptionHelp" class="form-text text-muted">Descreva o produto</small>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                    <table class="table table-striped" id="produts_table">
                        <thead class="bg-warning">
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Qtd.</th>
                                <th>Unidade</th>
                                <th>Item</th>
                                <th>Valor Unitário</th>
                                <th>Certificado</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="container">

                    <hr>
                </div>
            </div>
        </div>
    </div>
    {{-- Include modals --}}
    @include('dashboard.projects.modals.listInvoices')
    @include('dashboard.projects.modals.listInvoiceProducts')
@endsection
@section('js')
    <script src="{{ asset('js/projects.js') }}"></script>
    <script>
        function openModal(modal) {
            $(`#${modal}`).modal('show')
            setTimeout(() => {

                $("#value, #value_departament").inputmask('currency', {
                    "autoUnmask": true,
                    radixPoint: ",",
                    groupSeparator: ".",
                    allowMinus: false,
                    prefix: 'R$ ',
                    digits: 2,
                    digitsOptional: false,
                    rightAlign: true,
                    unmaskAsNumber: true
                });
            }, 1000);
        }

        function closeModal(modal) {
            $(`#${modal}`).modal('hide')
        }
    </script>
@endsection
@section('css')
    <style>
        .modal #total {
            z-index: 0;
            color: red;
        }

        .modal span {
            font-weight: bold;
        }

         .fa-trash:hover {
            cursor: pointer;
        }
    </style>
@endsection

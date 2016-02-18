@extends('templates.layout')

@section('page.title', 'Detalhes do Chef')

@section('page.subtitle')
    <ul class="breadcrumb breadcrumb-caret position-right">
        <li><a href="/">Home</a></li>
        <li><a href="/chefs/listar-registros">Chef</a></li>
        <li>Detalhes</li>
    </ul>
@endsection

@section('header.js')
    <script src="http://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script type="text/javascript" src="/assets/js/core/app.js"></script>
    <script type="text/javascript" src="/assets/js/maps/google/basic/basic.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/ui/moment/moment.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/ui/fullcalendar/lang/pt-br.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/media/fancybox.min.js"></script>
@endsection

@section('content')

    <!-- Cover area -->
    <div class="profile-cover">
        <div class="profile-cover-img" style="background-image: url('{{ image_upload($chef->foto_capa ?: 'chef_wallpaper.jpg') }}')"></div>
        <div class="media">
            <div class="media-left">
                <a href="#" class="profile-thumb">
                    <img src="{{ image_upload($chef->avatar) }}" class="img-circle" alt="">
                </a>
            </div>

            <div class="media-body">
                <h1>{{ $chef->name }} {{ $chef->sobrenome }} <small class="display-block">Membro desde {{ datetime_formatter($chef->membro_desde, "br") }}</small></h1>
            </div>

        </div>
    </div>
    <!-- /cover area -->


    <!-- Toolbar -->
    <div class="navbar navbar-default navbar-xs navbar-component">
        <ul class="nav navbar-nav visible-xs-block">
            <li class="full-width text-center"><a data-toggle="collapse" data-target="#navbar-filter"><i class="icon-menu7"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-filter">
            <ul class="nav navbar-nav element-active-slate-400">
                <li class="active"><a href="#informacoes-pessoais" data-toggle="tab"><i class="icon-menu7 position-left"></i> Informações Pessoais / Localização</a></li>
                <li><a href="#agenda" data-toggle="tab"><i class="icon-calendar3 position-left"></i> Agenda <span class="badge badge-success badge-inline position-right">{{ count($agenda) }}</span></a></li>
                <li><a href="#menus" data-toggle="tab"><i class="fa fa-cutlery position-left"></i> Menus <span class="badge badge-success badge-inline position-right">{{ count($menus) }}</span></a></li>
                <li><a href="#cursos" data-toggle="tab"><i class="icon-graduation position-left"></i> Cursos <span class="badge badge-success badge-inline position-right">{{ count($cursos) }}</span></a></li>
            </ul>
        </div>
    </div>
    <!-- /toolbar -->


    <!-- User profile -->
    <div class="row">
        <div class="col-lg-9">
            <div class="tabbable">
                <div class="tab-content">

                    <div class="tab-pane fade in active" id="informacoes-pessoais">

                        <!-- Profile info -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">Informações Pessoais</h6>
                            </div>

                            <div class="panel-body">
                                <form action="#">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Nome</label>
                                                <input readonly type="text" value="{{ $chef->name }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Sobrenome</label>
                                                <input readonly type="text" value="{{ $chef->sobrenome }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Data de Nascimento</label>
                                                <input readonly type="text" value="{{ date_formatter($chef->data_nascimento, "br") }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>CPF</label>
                                                <input readonly type="text" value="{{ $chef->cpf }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>RG</label>
                                                <input readonly type="text" value="{{ $chef->rg }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Sexo</label>
                                                {!! selectTable("sexo", "id_sexo", "descricao", "Não Cadastrado")->selected($chef->fk_sexo)->create("fk_sexo", ['disabled' => true])->getField() !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <label>Email</label>
                                                <input readonly type="text" value="{{ $chef->email }}" class="form-control">
                                            </div>
                                            <div class="col-md-5">
                                                <label>Telefone</label>
                                                <input readonly type="text" value="{{ $chef->telefone }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>SOBRE O CHEF <small>(HISTÓRICO, FORMAÇÃO, EXPERIÊNCIAS, PAIXÕES)</small></label>
                                                <textarea readonly style="resize:none" class="form-control" cols="30" rows="15">{{ $chef->sobre_chef }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- /profile info -->

                        <div class="panel panel-flat">

                            <div class="panel-heading">
                                <h6 class="panel-title">Contas Bancárias</h6>
                            </div>

                            <div class="panel-body">
                                <form action="#">

                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Banco</th>
                                                <th class="text-center">Agência</th>
                                                <th class="text-center">Conta Corrente</th>
                                                <th class="text-center">Proprietário Conta</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if(count($contas_bancarias) == 0)
                                                <tr>
                                                    <td colspan="4" class="text-center">Nenhuma conta bancária cadastrada.</td>
                                                </tr>
                                            @else

                                                @foreach($contas_bancarias as $conta)
                                                    <tr>
                                                        <td class="text-center">{{ $conta->nome_banco }}</td>
                                                        <td class="text-center">{{ $conta->banco_agencia }}-{{ $conta->banco_agencia_digito }}</td>
                                                        <td class="text-center">{{ $conta->banco_conta }}-{{ $conta->banco_conta_digito }}</td>
                                                        <td class="text-center">{{ $conta->banco_proprietario_conta }}</td>
                                                    </tr>
                                                @endforeach

                                            @endif
                                        </tbody>
                                    </table>

                                </form>

                            </div>

                        </div>

                        <!-- Profile info -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">Localização</h6>
                            </div>

                            <div class="panel-body">
                                <form action="#">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>País</label>
                                                {!! selectTable("pais", "id_pais", "nome_pais", "Não Cadastrado")->selected($chef->fk_pais)->create("fk_pais", ['disabled' => true])->getField() !!}
                                            </div>
                                            <div class="col-md-4">
                                                <label>Estado</label>
                                                {!! selectTable("estado", "id_estado", "nome_estado", "Não Cadastrado")->selected($chef->fk_estado)->create("fk_estado", ['disabled' => true])->getField() !!}
                                            </div>
                                            <div class="col-md-4">
                                                <label>Cidade</label>
                                                {!! selectTable("cidade", "id_cidade", "nome_cidade", "Não Cadastrado")->selected($chef->fk_cidade)->create("fk_cidade", ['disabled' => true])->getField() !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Rua/Logradouro</label>
                                                <input readonly type="text" value="{{ $chef->logradouro }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Número</label>
                                                <input readonly type="text" value="{{ $chef->logradouro_numero }}" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>CEP</label>
                                                <input readonly type="text" value="{{ $chef->cep }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <label>Aceitarei reservas em toda cidade?</label>
                                                {!! select(["1" => "Sim", "0" => "Não"], "Não Cadastrado")->selected($chef->ind_toda_cidade)->create("ind_toda_cidade", ['disabled' => true])->getField() !!}
                                            </div>
                                            <div class="col-md-5">
                                                <label>Distância Aceita</label>
                                                <input readonly type="text" value="{{ $chef->distancia_aceita }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="map-container"></div>

                                </form>
                            </div>
                        </div>
                        <!-- /profile info -->

                    </div>

                    <div class="tab-pane fade" id="agenda">

                        <!-- Profile info -->
                        <div class="panel panel-flat">
                            <div class="panel-body">
                                <div class="schedule"></div>
                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade" id="menus">

                        @if(count($menus))

                            <!-- Profile info -->
                            <div class="row">

                                @foreach($menus as $menu)
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                {{ $menu->titulo }}
                                                <span class="float-right">R$ {{ money_formatter($menu->preco) }}</span>
                                            </h6>
                                        </div>
                                        <div class="panel-body no-padding-bottom">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <ul class="list list-unstyled">
                                                        <li>
                                                            Status: &nbsp;
                                                            @if($menu->ind_ativo)
                                                                <span href="#" class="label bg-success-400">Ativo</span>
                                                            @else
                                                                <span href="#" class="label bg-danger-400">Inativo</span>
                                                            @endif
                                                        </li>
                                                        <li>Qtd Máxima Clientes: <span class="text-semibold">{{ $menu->qtd_maxima_cliente }}</span></li>
                                                        <li>Criado em: <span class="text-semibold">{{ date_formatter($menu->created_at, "br") }}</span></li>
                                                    </ul>
                                                </div>

                                                <div class="col-sm-6">
                                                    <button type="button" data-toggle="modal" data-target="#modal_menu_{{ $menu->id_menu }}" class="mt-10 btn float-right btn-default"><i class="icon-eye position-left"></i> Ver Mais Detalhes</button>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="text-center no-margin content-group text-muted content-divider">
                                            <span class="pt-10 pb-10"><i class="icon-images2"></i></span>
                                        </div>

                                        <div class="pb-10 pl-10 pr-10">
                                            @foreach($menu->imagens as $imagem)
                                                <div class="thumbnail no-margin-bottom mr-10" style="display: inline-block">
                                                    <div class="thumb" style="display: inline-block">
                                                        <a href="{{ image_upload($imagem->nome_imagem) }}" data-popup="lightbox">
                                                            <img class="media-preview" style="display: inline-block" src="{{ thumb_upload($imagem->nome_imagem, 70, 60) }}" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                    </div>

                                </div>

                                <!-- Basic modal -->
                                <div id="modal_menu_{{ $menu->id_menu }}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h6 class="text-semibold">Tipos de Refeição:</h6>
                                                <div class="row">
                                                    @foreach ($menu->tipo_refeicao as $tipoRefeicao)
                                                        <div class="col-md-3">

                                                            <div class="checkbox">
                                                                <label>
                                                                    <div class="checker">
                                                                    <span class="checked">
                                                                        <input type="checkbox" class="control-success" checked="checked">
                                                                    </span>
                                                                    </div>
                                                                    {{ $tipoRefeicao->nome_tipo_refeicao }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <hr>

                                                <h6 class="text-semibold">Tipos de Culinária:</h6>
                                                <div class="row">
                                                    @foreach ($menu->tipo_culinaria as $tipoCulinaria)
                                                        <div class="col-md-3">

                                                            <div class="checkbox">
                                                                <label>
                                                                    <div class="checker">
                                                                    <span class="checked">
                                                                        <input type="checkbox" class="control-success" checked="checked">
                                                                    </span>
                                                                    </div>
                                                                    {{ $tipoCulinaria->nome_culinaria }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <hr>

                                                <h6 class="text-semibold">Promoções/Preços:</h6>

                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <th class="text-center">Quantidade Pessoas</th>
                                                    <th class="text-center">Preço</th>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($menu->precos))
                                                        @foreach($menu->precos as $preco)
                                                            <td class="text-center">{{ $preco->qtd_minima_clientes }}</td>
                                                            <td class="text-center">R$ {{ money_formatter($preco->preco) }}</td>
                                                        @endforeach
                                                    @else
                                                        <td colspan="2" class="text-center">Nenhuma promoção encontrada para este menu.</td>
                                                    @endif
                                                    </tbody>
                                                </table>
                                                <hr>

                                                <h6 class="text-semibold">Aperitivos:</h6>
                                                <p>{{ $menu->aperitivo or "Nenhum aperitivo cadastrado." }}</p>
                                                <hr>

                                                <h6 class="text-semibold">Prato de Entrada:</h6>
                                                <p>{{ $menu->entrada or "Nenhum prato de entrada cadastrado." }}</p>
                                                <hr>

                                                <h6 class="text-semibold">Prato Principal:</h6>
                                                <p>{{ $menu->prato_principal }}</p>
                                                <hr>

                                                <h6 class="text-semibold">Sobremesa:</h6>
                                                <p>{{ $menu->sobremesa or "Nenhuma sobremesa cadastrada." }}</p>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /basic modal -->
                                @endforeach

                            </div>

                        @else

                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <h4 class="text-center">Nenhum menu cadastrado para este chef.</h4>
                                </div>
                            </div>

                        @endif

                    </div>

                    <div class="tab-pane fade" id="cursos">

                        @if(count($cursos))

                            <!-- Profile info -->
                            <div class="row">

                                @foreach($cursos as $curso)
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                {{ $curso->titulo }}
                                                <span class="float-right">R$ {{ money_formatter($curso->preco) }}</span>
                                            </h6>
                                        </div>
                                        <div class="panel-body no-padding-bottom">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <ul class="list list-unstyled">
                                                        <li>
                                                            Status: &nbsp;
                                                            @if($curso->ind_ativo)
                                                                <span href="#" class="label bg-success-400">Ativo</span>
                                                            @else
                                                                <span href="#" class="label bg-danger-400">Inativo</span>
                                                            @endif
                                                        </li>
                                                        <li>Qtd Máxima Clientes: <span class="text-semibold">{{ $curso->qtd_maxima_cliente }}</span></li>
                                                        <li>Criado em: <span class="text-semibold">{{ date_formatter($curso->created_at, "br") }}</span></li>
                                                    </ul>
                                                </div>

                                                <div class="col-sm-6">
                                                    <button type="button" data-toggle="modal" data-target="#modal_curso_{{ $curso->id_curso }}" class="mt-10 btn float-right btn-default"><i class="icon-eye position-left"></i> Ver Mais Detalhes</button>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="text-center no-margin content-group text-muted content-divider">
                                            <span class="pt-10 pb-10"><i class="icon-images2"></i></span>
                                        </div>

                                        <div class="pb-10 pl-10 pr-10">
                                            @foreach($curso->imagens as $imagem)
                                                <div class="thumbnail no-margin-bottom mr-10" style="display: inline-block">
                                                    <div class="thumb" style="display: inline-block">
                                                        <a href="{{ image_upload($imagem->nome_imagem) }}" data-popup="lightbox">
                                                            <img class="media-preview" style="display: inline-block" src="{{ thumb_upload($imagem->nome_imagem, 70, 60) }}" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                    </div>

                                </div>

                                <!-- Basic modal -->
                                <div id="modal_curso_{{ $curso->id_curso }}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">

                                                <h6 class="text-semibold">Tipos de Refeição:</h6>
                                                <div class="row">
                                                    @foreach ($curso->tipo_refeicao as $tipoRefeicao)
                                                    <div class="col-md-3">

                                                        <div class="checkbox">
                                                            <label>
                                                                <div class="checker">
                                                                    <span class="checked">
                                                                        <input type="checkbox" class="control-success" checked="checked">
                                                                    </span>
                                                                </div>
                                                                {{ $tipoRefeicao->nome_tipo_refeicao }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <hr>

                                                <h6 class="text-semibold">Tipos de Culinária:</h6>
                                                <div class="row">
                                                    @foreach ($curso->tipo_culinaria as $tipoCulinaria)
                                                    <div class="col-md-3">

                                                        <div class="checkbox">
                                                            <label>
                                                                <div class="checker">
                                                                    <span class="checked">
                                                                        <input type="checkbox" class="control-success" checked="checked">
                                                                    </span>
                                                                </div>
                                                                {{ $tipoCulinaria->nome_culinaria }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <hr>

                                                <h6 class="text-semibold">Promoções/Preços:</h6>

                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <th class="text-center">Quantidade Pessoas</th>
                                                        <th class="text-center">Preço</th>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($curso->precos))
                                                            @foreach($curso->precos as $preco)
                                                                <td class="text-center">{{ $preco->qtd_minima_clientes }}</td>
                                                                <td class="text-center">R$ {{ money_formatter($preco->preco) }}</td>
                                                            @endforeach
                                                        @else
                                                            <td colspan="2" class="text-center">Nenhuma promoção encontrada para este curso.</td>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <hr>

                                                <h6 class="text-semibold">Descrição do Curso:</h6>
                                                <p>{{ $curso->descricao }}</p>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /basic modal -->
                                @endforeach

                            </div>

                        @else

                            <div class="panel panel-flat">
                                <div class="panel-body">
                                    <h4 class="text-center">Nenhum curso cadastrado para este chef.</h4>
                                </div>
                            </div>

                        @endif

                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-3">

            <!-- Navigation -->
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title no-margin text-center">
                        <i class="icon-flag3"></i>
                        Status</h4>
                </div>
                <div class="panel-body text-center">
                    <span style="white-space: normal; font-size: 15px;" class="label label-flat {{ $classStatus }}">{{ $chef->descricao }}</span>

                    @if($chef->fk_status == 3)
                        <a href="{{ app_url(sprintf("chef/aprovar/%s/%s", $chef->slug, base64_encode(bcrypt("aprovar-perfil")))) }}" class="mt-15 btn-sm btn btn-success aprovar-perfil-btn"><i class="icon-trophy4 position-left"></i> Aprovar Perfil</a>
                        <a href="{{ app_url(sprintf("chef/reprovar/%s/%s", $chef->slug, base64_encode(bcrypt("reprovar-perfil")))) }}" class="mt-15 btn-sm btn btn-danger reprovar-perfil-btn"><i class="icon-user-block position-left"></i> Reprovar Perfil</a>
                    @endif
                </div>
            </div>
            <!-- /navigation -->


            <!-- Navigation -->
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="no-margin text-center">
                        <i class="icon-coins"></i>
                        Saldo para saque
                    </h4>
                </div>
                <div class="panel-body">
                    <h1 class="no-margin timer text-center">R$ {{ money_formatter($chef->saldo) }}</h1>
                </div>
            </div>
            <!-- /navigation -->

        </div>
    </div>
    <!-- /user profile -->


@endsection


@section("footer.js")
<script type="text/javascript">

    $(function() {

        @if ($perfilAprovado)
            swal({
                title: "Sucesso!",
                text: "Perfil aprovado com sucesso.\n Um e-mail de aviso foi enviado para o chef.",
                confirmButtonColor: "#66BB6A",
                type: "success",
                html: true
            });
        @endif

        @if(!empty($chef->cep))

            var map;

            // Map settings
            function initialize() {

                geocoder = new google.maps.Geocoder();

                geocoder.geocode({
                    'address': '{{ $chef->logradouro }} - {{ $chef->nome_cidade }}, {{ $chef->fk_estado }} - {{ $chef->cep }}'
                }, function(results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {

                        var geometryLocation = results[0].geometry.location;

                        // Set coordinates
                        var myLatlng = new google.maps.LatLng(geometryLocation.lat(), geometryLocation.lng());

                        // Optinos
                        var mapOptions = {
                            zoom: 12,
                            center: myLatlng
                        };

                        // Apply options
                        map = new google.maps.Map($('.map-container')[0], mapOptions);

                        // Add marker
                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map
                        });

                        // Add info window
                        var infowindow = new google.maps.InfoWindow({
                            content: '{{ $chef->logradouro }} - {{ $chef->nome_cidade }}, {{ $chef->fk_estado }} - {{ $chef->cep }}'
                        });

                        // Attach click event
                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow.open(map,marker);
                        });

                    }

                });

            }

            // Load map
            google.maps.event.addDomListener(window, 'load', initialize);


        @else

            $('.map-container').hide();

        @endif


            // Add events
        var eventsColors = [
            @foreach($agenda as $day)
            {
                title: 'De: {{ $day->hora_de }} {{ $day->horario_de_marcacao }}\n\rAté: {{ $day->hora_ate }} {{ $day->horario_ate_marcacao }}',
                start: '{{ $day->data }}',
                color: '#546E7A'
            },
            @endforeach
        ];


        // Initialize calendar with options
        $('.schedule').fullCalendar({
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            defaultDate: '{{ date("Y-m-d") }}',
            editable: false,
            lang: 'pt-br',
            events: eventsColors
        });


        // Render in hidden elements
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('.schedule').fullCalendar('render');
        });

        // Image lightbox
        $('[data-popup="lightbox"]').fancybox({
            padding: 3
        });

        $(".aprovar-perfil-btn").click(function (event) {
            var url = $(this).attr("href");

            swal({
                title: 'Confirmação!',
                text: 'Tem certeza que deseja aprovar o perfil deste chef?',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4CAF50",
                cancelButtonColor: "#EF5350",
                confirmButtonText: "Sim, eu desejo aprovar!",
                cancelButtonText: "Não, eu não quero aprovar!",
                closeOnConfirm: false
            }, function () {
                location.href = url;
            });
            event.preventDefault();
        });

    });

</script>
@endsection
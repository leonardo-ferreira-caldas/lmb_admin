@extends('templates.layout')

@section('header.js')
    <script type="text/javascript" src="/assets/js/plugins/forms/validation/validate.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/inputs/touchspin.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/styling/uniform.min.js"></script>

    <script type="text/javascript" src="/assets/js/core/app.js"></script>
    <script type="text/javascript" src="/assets/js/pages/form_validation.js"></script>
@endsection

@section('page.title', $page_title)

@section('page.subtitle')
    <ul class="breadcrumb breadcrumb-caret position-right">
        <li><a href="/">Home</a></li>
        @foreach($breadcrumb as $link)
            <li>{{ $link }}</li>
        @endforeach
    </ul>
@endsection

@section('page.heading-elements')

    <div class="heading-elements">
        <div class="heading-btn-group">
            <a href="{{ $route['list'] }}" class="btn btn-default btn-lg heading-btn">
                <i class="fa fa-arrow-circle-o-left position-left"></i> Voltar
            </a>
        </div>
    </div>

@endsection


@section('content')

    <div class="panel panel-flat">

        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ $route['update'] }}">

                {!! csrf_field() !!}

                <fieldset class="content-group">
                    <legend class="text-bold">Editar Registro</legend>

                    @foreach ($fields as $field)
                        <div class="form-group">
                            <label class="control-label col-lg-2">{{ $field->getAttribute('label') }}</label>
                            <div class="col-lg-10">
                                {!! $field->getField() !!}
                            </div>
                        </div>
                    @endforeach

                </fieldset>

                <div class="text-left border-top pt-15 border-default">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-sign-in position-left"></i> Salvar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
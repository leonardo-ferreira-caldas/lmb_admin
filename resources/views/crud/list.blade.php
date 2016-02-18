@extends('templates.layout')

@section('header.js')
    @if($datatable['ajax'])
        @include('crud.datatable.ajax_options')
    @endif

    <script type="text/javascript" src="/assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script type="text/javascript" src="/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/core/app.js"></script>
    <script type="text/javascript" src="/assets/js/pages/datatables_basic.js"></script>
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
            <a href="{{ $route['insert'] }}" class="btn bg-blue btn-labeled heading-btn"><b><i class="icon-googleplus5"></i></b> Novo Registro</a>
        </div>
    </div>

@endsection


@section('content')

    <!-- Basic datatable -->
    <div class="panel panel-flat">

        <table class="table table-bordered table-hover table-striped datatable-basic">
            <thead>
                <tr>
                    @foreach($datatable['columns'] as $headerColumn)
                        <th
                            class="text-{{ $headerColumn['align'] }}"
                            @if(!empty($headerColumn['width']))
                                width="{{ $headerColumn['width'] }}"
                            @endif
                            data-orderable="{{ $headerColumn['order'] ? "true" : "false" }}"
                            data-name="{{ $headerColumn['name'] }}">
                                {{ $headerColumn['label'] }}
                        </th>
                    @endforeach

                    @if(count($datatable['actions']))
                        <th class="text-center" data-orderable="false" width="5%">Ações</th>
                    @endif
                </tr>

                @if($datatable['filter'])
                <tr id="filterrow" class="hidden">
                    @foreach($datatable['columns'] as $headerColumn)
                        @if($headerColumn["filter"])
                            <td>
                                {!! $headerColumn['type']->getField() !!}
                            </td>
                        @else
                            <td>&nbsp;</td>
                        @endif
                    @endforeach

                    @if(count($datatable['actions']))
                        <td class="no-filter">&nbsp;</td>
                    @endif
                </tr>
                @endif
            </thead>
            <tbody>
                @foreach($datatable['rows'] as $row)
                    <tr>
                        @foreach($row['columns'] as $column)
                            <td class="text-{{ $column['align'] }}">{!! $column['value'] !!}</td>
                        @endforeach

                        @if(count($datatable['actions']))
                            <td class="text-center">
                                @include('crud.datatable.column_actions', [
                                    'datatable_actions' => $datatable['actions'],
                                    'keys'              => $row['keys']
                                ])
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->

@endsection
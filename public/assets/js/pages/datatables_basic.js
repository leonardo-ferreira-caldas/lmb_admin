/* ------------------------------------------------------------------------------
*
*  # Basic datatables
*
*  Specific JS code additions for datatable_basic.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: false,
            width: '100px'
        }],
        dom: '<"datatable-header"Bl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            zeroRecords: "Nenhum registro encontrado.",
            emptyTable: "Nenhum registro cadastrado.",
            infoEmpty: "Exibindo página 0 de 0 páginas",
            info: "Exibindo página _PAGE_ de _PAGES_ páginas",
            infoFiltered: "(filtrado de _MAX_ registros totais)",
            lengthMenu: '<span>Exibir:</span> _MENU_',
            loadingRecords: "Carregando...",
            processing:     "Processando...",
            paginate: { 'first': 'Primeira Página', 'last': 'Última Página', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        },
        initComplete: function() {
            $("th[data-orderable=false]").removeClass("sorting_asc").removeClass("sorting_desc");
        }
    });

    var parameters = typeof options != "undefined" ? options : {};

    var datatableParameters = $.extend(parameters, {
        orderCellsTop: true,
        buttons: [
            {
                text: '<i class="fa fa-search position-left"></i> Buscar',
                className: 'btn btn-large btn-default',
                action: function(e, dt, node, config) {
                    if ($("#filterrow").hasClass("hidden")) {
                        $("#filterrow").removeClass("hidden");
                    } else {
                        $("#filterrow").addClass("hidden");
                    }
                }
            }
        ]
    });

    // Basic datatable
    var table = $('.datatable-basic')
        .DataTable(datatableParameters);

    // Apply the filter
    $('.datatable-basic').find("tr#filterrow input, tr#filterrow select").on('change', function () {
        table
            .column( $(this).parent().index() )
            .search( this.value )
            .draw();
    } );

    // External table additions
    // ------------------------------

    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').unbind('keyup search input')
    .bind('keypress', function (e) {
        if (e.which == 13) {
            table.search($(this).val()).draw();
        }
    });


});

<script type="text/javascript">
    var options = {
        serverSide: true,
        processing: true,
        ajax: '{{ $route['list'] }}',
        columns: [
            @foreach($datatable['columns'] as $index => $headerColumn)
            {{ $index == 0 ? "" : "," }}
            {
                "class": "text-{{ $headerColumn['align'] }}",
                "orderable": {{ $headerColumn['order'] ? "true" : "false" }},
                "data": "{{ $headerColumn['name'] }}",
                "width": "{{ $headerColumn["width"] }}",
                "defaultContent": ""
            }
            @endforeach

            @if(count($datatable['actions']))
                , {
                    "class": "text-center",
                    "orderable": false,
                    "data": "datatable.actions",
                    "width": "5%",
                    "defaultContent": "",
                    "render": function(data, type, full, meta) {
                        return full['datatable.actions'];
                    }
                }
            @endif
        ]
    };
</script>
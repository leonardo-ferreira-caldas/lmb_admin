<ul class="icons-list">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="icon-menu9"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-right">
            @foreach($datatable_actions as $action)
                <li><a href="{{ $action->getRoute($keys) }}"><i class="{{ $action->getIcon() }}"></i> {{ $action->getLabel() }}</a></li>
            @endforeach
        </ul>
    </li>
</ul>
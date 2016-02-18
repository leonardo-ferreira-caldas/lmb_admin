@inject('menuRenderer', 'App\Helpers\Menu\MenuRenderer')

<!-- Second navbar -->
<div class="navbar navbar-default" id="navbar-second">
    <ul class="nav navbar-nav no-border visible-xs-block">
        <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
    </ul>

    <div class="navbar-collapse collapse" id="navbar-second-toggle">
        <ul class="nav navbar-nav">
            @foreach($menuRenderer->get() as $menu)
                @if(!$menu->has_submenus)
                    <li><a href="{{ $menu->route }}"><i class="fa-fw fa {{ $menu->icon }} position-left"></i> {{ $menu->label }}</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa {{ $menu->icon }} fa-fw"></i> {{ $menu->label }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu width-200">
                            @foreach($menu->submenus as $submenu)
                                <li>
                                    <a href="{{ $submenu->route }}">
                                    {{--<i class="fa-fw fa {{ $submenu->icon }}"></i>--}}
                                        {{ $submenu->label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>

    </div>
</div>
<!-- /second navbar -->
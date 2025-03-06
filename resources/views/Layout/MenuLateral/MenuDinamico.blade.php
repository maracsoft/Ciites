@if ($empLogeadoPlantilla->seDebeAgruparMenu())

  @foreach ($empLogeadoPlantilla->getRolesWithRoutes() as $role_name => $rutas)
    @if (count($rutas) > 0)
      <li class="nav-item has-treeview @if ($empLogeadoPlantilla->tieneMenuAbierto($role_name)) menu-open @endif">
        <a href="#" class="nav-link" onclick="actualizarEstadoMenu(this)" data-rolname="{{ $role_name }}">
          <i class="far fa-layer-group nav-icon"></i>
          <p>
            {{ $role_name }}
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview pt-1">

          @include('Layout.MenuLateral.PrintRoutes')


        </ul>
      </li>
    @endif
  @endforeach
@else
  @foreach ($empLogeadoPlantilla->getRolesWithRoutes() as $role_name => $rutas)
    @if (count($rutas) > 0)
      <li>
        <div class="cabecera_menu_lateral">
          {{ $role_name }}
        </div>
      </li>

      @include('Layout.MenuLateral.PrintRoutes')
    @endif
  @endforeach

@endif

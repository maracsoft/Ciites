@php
    $empleadoLogeado = App\Empleado::getEmpleadoLogeado();
@endphp
<li>
    - - - - - -
    @if($empleadoLogeado->esArticulador())
        Articulador
    @endif

    @if($empleadoLogeado->esEquipo())
        Equipo
    @endif
    @if($empleadoLogeado->esUGE())
        UGE
    @endif
    CITE - - - - - 
</li>
<li class="nav-item">
    <a href="{{route('CITE.UnidadesProductivas.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Unid Productivas</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('CITE.Servicios.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Servicios</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('CITE.Usuarios.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Usuarios</p>
    </a>
</li>



@if($empleadoLogeado->esEquipo())
    <li class="nav-item">
        <a href="{{route('CITE.ReporteMensual.MisReportes')}}" class="nav-link">
            <i class="far fa-address-card nav-icon"></i>
            <p>Mis reportes</p>
        </a>
    </li>
@endif

@if($empleadoLogeado->esArticulador() || $empleadoLogeado->esUGE())
    <li class="nav-item">
        <a href="{{route('CITE.Dashboard.Ver')}}" class="nav-link">
            <i class="far fa-address-card nav-icon"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{route('CITE.ReporteMensual.VerMatriz')}}" class="nav-link">
            <i class="far fa-address-card nav-icon"></i>
            <p>Reportes Mensuales</p>
        </a>
    </li>

    <li class="nav-item">
      <a href="{{route('CITE.MatrizPat.Ver')}}" class="nav-link">
          <i class="far fa-address-card nav-icon"></i>
          <p>Matriz PAT</p>
      </a>
    </li>

@endif


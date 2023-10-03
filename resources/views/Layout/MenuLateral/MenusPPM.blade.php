@php
    $empleadoLogeado = App\Empleado::getEmpleadoLogeado();
@endphp
<li>
    - - - - - -      
    PPM - - - - - 
</li>

<li class="nav-item">
    <a href="{{route('PPM.Organizacion.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Organizaciones</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{route('PPM.Actividad.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Actividades</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{route('PPM.Persona.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Población Meta</p>
    </a>
</li>


<li class="nav-item">
  <a href="{{route('PPM.Indicadores.VerRegistrar')}}" class="nav-link">
      <i class="far fa-address-card nav-icon"></i>
      <p>Registro de Indicadores</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{route('PPM.Dashboard.Ver')}}" class="nav-link">
      <i class="far fa-address-card nav-icon"></i>
      <p>Dashboard</p>
  </a>
</li>


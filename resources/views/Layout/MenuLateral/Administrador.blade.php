    <li>- - - - - - ADMINISTRADOR - - - - -</li>
    <li class="nav-item">
      <a href="{{route('SolicitudFondos.Administracion.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Abonar Solicitudes</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('RendicionGastos.Administracion.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Observar Rendiciones</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('ReposicionGastos.Administracion.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Abonar Reposiciones</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('RequerimientoBS.Administrador.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Atender Requerimientos</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('OrdenCompra.Empleado.Listar')}}" class="nav-link">
        <i class="far fa-address-card nav-icon"></i>
        <p>Orden de Compra</p>
      </a>
    </li>



    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="fas fa-list nav-icon"></i>
        <p>
           Contratos
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        

        <li class="nav-item">
          <a href="{{route('ContratosLocacion.Listar')}}" class="nav-link">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>Locacion Serv</p>
          </a>
        </li>
        

        
        <li class="nav-item">
          <a href="{{route('ContratosPlazo.Listar')}}" class="nav-link">
            <i class="fas fa-file-alt nav-icon"></i>
            <p>Planilla</p>
          </a>
        </li>
       

      </ul>
    </li>
    

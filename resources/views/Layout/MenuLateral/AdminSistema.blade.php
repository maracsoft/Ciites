<!-- Sidebar Menu -->
    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Solicitud de Fondos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">


              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Empleado.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Empleado</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Gerente.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Gerente/Director</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Administracion.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Administrador</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Contador.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Contador</p>
                </a>
              </li>


              <li class="nav-item">
                <a href="{{route('SolicitudFondos.Observador.Listar')}}" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Supervisor</p>
                </a>
              </li>





        </ul>

      </li>




      <li class="nav-item has-treeview">

        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Rendición de Gastos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{route('RendicionGastos.Empleado.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Empleado</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Empleado.verMisGastos')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Mis Gastos Ren</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="{{route('RendicionGastos.Gerente.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Gerente/Director</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Administracion.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Administrador</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('RendicionGastos.Contador.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Contabilidad</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('RendicionGastos.Observador.Listar')}}" class="nav-link">
                <i class="far fa-address-card nav-icon"></i>
                <p>Supervisor</p>
              </a>
            </li>





        </ul>

      </li>















      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Reposición de Gastos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Empleado.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Empleado</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Empleado.verMisGastos')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Mis gastos</p>
            </a>
          </li>




          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Gerente.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Gerente/Director</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Administracion.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Administrador</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Contador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Contador</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('ReposicionGastos.Observador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Supervisor</p>
            </a>
          </li>



        </ul>
      </li>




      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Requerimientos BS
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Empleado.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Empleado</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Gerente.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Gerente/Director</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Administrador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Administración</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Contador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Contador</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('RequerimientoBS.Observador.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Supervisor</p>
            </a>
          </li>






        </ul>
      </li>





      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
             Inventario
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">


          <li class="nav-item">
            <a href="{{route('RevisionInventario.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Revisiones</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{route('ActivoInventario.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Activos</p>
            </a>
          </li>


        </ul>
      </li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
             Contratos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">


          <li class="nav-item">
            <a href="{{route('ContratosLocacion.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Locacion Serv</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{route('ContratosPlazo.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Plazo Fijo</p>
            </a>
          </li>

        
          <li class="nav-item">
            <a href="{{route('ContratosPlazoNuevo.Listar')}}" class="nav-link">
              <i class="fas fa-file-alt nav-icon"></i>
              <p>Planilla NUEVO</p>
            </a>
          </li>

        </ul>
      </li>



      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Dec. Juradas
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('DJMovilidad.Empleado.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Movilidad</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('DJViaticos.Empleado.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Viaticos</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{route('DJVarios.Empleado.Listar')}}" class="nav-link">
              <i class="far fa-address-card nav-icon"></i>
              <p>Varios</p>
            </a>
          </li>


        </ul>
      </li>




      <li class="nav-item">
        <a href="{{route('OrdenCompra.Empleado.Listar')}}" class="nav-link">
          <i class="far fa-building nav-icon"></i>
          <p>
            Orden de Compra
          </p>
        </a>
      </li>

        
        
      <li class="nav-item">
        <a href="{{route('ConstanciaDepositoCTS.Listar')}}" class="nav-link">
          <i class="far fa-address-card nav-icon"></i>
          <p>Const Deposito CTS</p>
        </a>
      </li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">

          <p>
            Proyectos
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('GestiónProyectos.AdminSistema.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>AdminSistema</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('GestiónProyectos.UGE.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>UGE</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('GestiónProyectos.Gerente.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Gerente</p>
            </a>
          </li>


        </ul>
      </li>






      <li class="nav-header">--------- Admin</li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">

          <p>
            Servicios
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>

        <ul class="nav nav-treeview">

          <li class="nav-item">
            <a href="{{route('HistorialErrores.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Historial de Errores</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('HistorialLogeos.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Historial de Logeos</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('Operaciones.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Operaciones</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('BuscadorMaestro')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>BuscadorMaestro</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('Reportes.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Reportes</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('ParametroSistema.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Parametros</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('AdminPanel.VerPanel')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>AdminPanel</p>
            </a>
          </li>




        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">

          <p>
            Usuarios
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('GestionUsuarios.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Empleados</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('GestionPuestos.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Puestos</p>
            </a>
          </li>


        </ul>
      </li>



      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">

          <p>
            CRUDs
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <a href="{{route('GestiónUnidadMedida.listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Unidades de Medida</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('TipoOperacion.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Tipo Operacion</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('PlanEstrategico.listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Plan Estratégico</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('GestiónTipoPersonaJuridica.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Tipo Personal Juridico</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('EntidadFinanciera.listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Financieras</p>
            </a>
          </li>



          <li class="nav-item">
            <a href="{{route('TipoFinanciamiento.listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Tipos de Financiamiento</p>
            </a>
          </li>





          <li class="nav-item">
            <a href="{{route('GestiónProyectos.AdminSistema.listarPersonasRegistradas')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>P. Naturales y Jur</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('ObjetivoMilenio.listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Obj. Milenio</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('Sede.ListarSedes')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Sedes</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{route('ActividadPrincipal.Listar')}}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Actividades de Personas</p>
            </a>
          </li>


        </ul>
      </li>

















      <!-----------------------------------------------UNIDAD 2----------------------------------------------------------------->


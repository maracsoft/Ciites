
<li class="nav-item dropdown">
  <?php 
    $emp = App\Empleado::getEmpleadoLogeado();
    $listaNotificacionesCITE = $emp->getNotificaciones('CITE',true);
    $cantidadNotificaciones = count($listaNotificacionesCITE);
    $mostrarAlerta = $emp->mostrarMensajeDeRegistrarTuReporte();
    if($mostrarAlerta)
        $cantidadNotificaciones++;
  ?>

  {{-- CABECERA DE TODA LA NOTIF  --}}
  <a class="nav-link px-2 px-sm-4" data-toggle="dropdown" href="#">
    CITE
    @if($cantidadNotificaciones!=0)
      <span class="badge badge-danger navbar-badge">
        {{$cantidadNotificaciones}}
      </span>
    @endif
  </a>



  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    
    
    
      <a href="#" class="dropdown-item dropdown-footer">
        <b>
          @if($cantidadNotificaciones == 0 && !$mostrarAlerta)
            No hay Notificaciones del CITE
          @else
            Notificaciones CITE
          @endif
        </b> 
      </a>
 
      @foreach($listaNotificacionesCITE as $notificacion)
        <div class="dropdown-divider"></div>
        <a href="{{route('Notificacion.MarcarComoVista',$notificacion->getId())}}" class="dropdown-item p-1 {{$notificacion->getClaseVista()}}">
            <div class="media" >
                <div>
                    <p class="text-xs">
                        {{$notificacion->descripcion}}
                    </p>
                </div>
            </div>
        </a>
      @endforeach

      @if($mostrarAlerta)
        <div class="dropdown-divider"></div>
        <a href="{{route('CITE.ReporteMensual.MisReportes')}}" class="dropdown-item p-1">
            <div class="media" >
                <div>
                    <p class="text-xs">
                        Tiene pendiente el reporte de este mes.
                    </p>
                </div>
            </div>
        </a>
      @endif
   



  </div>


</li> 


{{-- ESTILOS PARA NOTIFICACIONES --}}
<style>
 .CheckBoxnotification{
    width: 20px;
    height: 20px;
 }

 .NotificacionVista{
    background-color: rgb(228, 228, 228);

 }


</style>
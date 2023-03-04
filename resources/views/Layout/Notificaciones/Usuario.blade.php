{{-- EN ESTE VAN LAS SOLICITUDES POR RENDIR Y LAS OBSERVADAS --}}

<li class="nav-item dropdown">
    
    {{-- CABECERA DE TODA LA NOTIF  --}}
    <a class="nav-link btn btn-info" style="color:beige" data-toggle="dropdown" href="#">
      <i class="far fa-user"></i>
        <span class=" d-sm-inline d-none"> 
          Cuenta
        </span>
        
      
    </a>



    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">
        
         
        <a href="{{route('GestionUsuarios.verMisDatos')}}" class="dropdown-item">
          <div class="media" >
            <i class="fas fa-address-card"></i> &nbsp;
            
              <h3 class="dropdown-item-title">
                Mis Datos
                <span class="float-right text-sm text-warning"></span>
              </h3>
              
          </div>
        </a>
        <a href="{{route('GestionUsuarios.cambiarContraseña')}}" class="dropdown-item">
          <div class="media" >
            <i class="fas fa-unlock-alt"></i> &nbsp;
              <h3 class="dropdown-item-title">
                Cambiar Contraseña
                <span class="float-right text-sm text-warning"></span>
              </h3>
              
          </div>
        </a>

        @if(App\Configuracion::activarAyuda())
            <a target="_blank" href="{{App\Configuracion::getUrlManual()}}" class="dropdown-item">
                <div class="media" >
                    <i class="fas fa-question-circle"></i> &nbsp;
                    <h3 class="dropdown-item-title">
                    Ayuda
                    <span class="float-right text-sm text-warning"></span>
                    </h3>
                    
                </div>
            </a>
        @endif
        @if($empLogeadoPlantilla->esAdminSistema())
          <a class="dropdown-item" href="{{route('AdminPanel.VerPanel')}}" >
            <i class="fas fa-wrench"></i>
            AdminPanel
          </a>
        @endif


        <a href="#"  onclick="confirmarCerrarSesion()" class="dropdown-item">
            <div class="media" >
                <i class="fas fa-sign-out-alt"></i> &nbsp;
              
                <h3 class="dropdown-item-title">
                  Cerrar Sesión
                  <span class="float-right text-sm text-warning"></span>
                </h3>
                
            </div>
          </a>
          
          
            
        

    </div>


  </li> 
  <style>
     

  </style>
 
  <script>
    


  </script>
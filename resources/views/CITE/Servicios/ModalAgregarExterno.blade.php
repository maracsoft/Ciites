{{-- MODAL DE AGREGAR EXTERNOS --}}
<div class="modal  fade" id="ModalAgregarExterno" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">


      <div class="modal-header">
        <h5 class="modal-title" id="">
          Agregar participantes al servicio
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">

        <form action="{{route('CITE.Servicios.agregarAsistenciaExterna')}}" id="frmAgregarAsistenciaExterna" name="frmAgregarAsistenciaExterna" method="POST">
          @csrf
          <input type="hidden" name="codServicio" value="{{$servicio->codServicio}}">

          <div class="mr-1 my-2 row">


            <div class="col-4">
              <div>
                <label for="">DNI:</label>
              </div>
              <div class="d-flex">


                <div>
                  <input type="number" class="form-control" id="dni" name="dni" value="">
                </div>
                <div>
                  <button type="button" title="Buscar por DNI en la base de datos de Sunat" class="btn-sm btn btn-info d-flex align-items-center m-1" id="botonBuscarPorRUC" onclick="consultarPorDNI()">
                    <i class="fas fa-search m-1"></i>

                  </button>
                </div>

              </div>
            </div>

            <div class="col-4">
              <label for="">Teléfono:</label>
              <input type="number" class="form-control" id="telefono" name="telefono" value="">


            </div>
            <div class="col-4">
              <label for="">Correo:</label>
              <input type="email" class="form-control" id="correo" name="correo" value="">

            </div>
            <div class="col-4">
              <label for="">Nombres:</label>
              <input type="text" class="form-control" id="nombres" name="nombres" value="">

            </div>
            <div class="col-4">

              <label for="">Apellido Paterno:</label>
              <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" value="">


            </div>
            <div class="col-4">

              <label for="">Apellido Materno:</label>
              <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" value="">

            </div>




          </div>
          <div>
            <input type="checkbox" value="1" id="inscribirEnUnidad" name="inscribirEnUnidad">
            <label class="" for="inscribirEnUnidad">
              Inscribir en la unidad(como socio)
            </label>
          </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Salir
        </button>

        <button type="button" class="m-1 btn btn-primary" onclick="agregarAsistenciaExterna()">
          Guardar
          <i class="fas fa-save"></i>
        </button>
      </div>


    </div>
  </div>
</div>

<script>
  /* AGREGAR USUARIOS EXTERNOS EN MODAL */
  function agregarAsistenciaExterna() {

    msjError = validarUsuarioExterno();
    if (msjError != "") {
      alerta(msjError);
      return;
    }

    document.frmAgregarAsistenciaExterna.submit();
  }


  function validarUsuarioExterno() {

    msj = "";
    limpiarEstilos(['dni', 'nombres', 'telefono', 'apellidoMaterno', 'correo', 'apellidoPaterno', ])

    msj = validarTamañoExacto(msj, 'dni', 8, 'DNI')
    //msj = validarTamañoMaximoYNulidad(msj,'telefono',200,'telefono')
    //msj = validarTamañoMaximoYNulidad(msj,'correo',200,'correo')
    msj = validarTamañoMaximoYNulidad(msj, 'nombres', 200, 'nombres')
    msj = validarTamañoMaximoYNulidad(msj, 'apellidoPaterno', 200, 'apellidoPaterno')
    msj = validarTamañoMaximoYNulidad(msj, 'apellidoMaterno', 200, 'apellidoMaterno')

    if (validarQueYaEsteEnElServicio() != "")
      msj = validarQueYaEsteEnElServicio();


    return msj;
  }


  var usuariosDelServicio = @php echo $servicio->getUsuarios() @endphp


  function validarQueYaEsteEnElServicio() {
    //verificamos que no esté ya en el servicio
    var dni = document.getElementById('dni').value;
    var listaDNIiguales = usuariosDelServicio.filter(e => e.dni == dni);
    if (listaDNIiguales.length != 0)
      return "El usuario de DNI " + dni + " ya se encuentra en el servicio actual"
    return "";
  }

</script>

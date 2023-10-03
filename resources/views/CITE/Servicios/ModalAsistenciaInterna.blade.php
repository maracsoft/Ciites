{{-- MODAL DE AGREGAR ASOCIADOS --}}
<div class="modal  fade" id="ModalListaAsistencia" tabindex="-1" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">


      <div class="modal-header">
        <h5 class="modal-title" id="">
          Asistencia de usuarios al servicio
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-12 row">
          <div class="col-10">

            @php
            $i=1;
            @endphp
            <select id="codUsuarioBusquedaRapida" data-select2-id="1" tabindex="-1" onchange="cambioUsuarioBuscado(this.value)" class="fondoBlanco form-control form-control-sm select2-hidden-accessible selectpicker" aria-hidden="true" data-live-search="true">

              <option value="-1" class="fontSize9">- Buscar Usuario -</option>
              @foreach($listaUsuariosYAsistencia as $usuario)

              <option value="{{$usuario->getId()}}" class="fontSize9">
                {{$i}}. {{$usuario->getNombreCompleto()}} {{$usuario->dni}}
              </option>
              @php
              $i++;
              @endphp
              @endforeach

            </select>


          </div>
          <div class="col-2">
            <button id="botonBusqueda" class="btn btn-success btn-sm" type="button" onclick="clickMarcarAsistenciaBusquedaRapida()">
              <span id="msjBusqueda">Marcar asistencia</span>
              <i id="iconoBusqueda" class="fa fa-check"></i>
            </button>
          </div>
        </div>
        <div class="col-12 row mt-2">
          <div class="col-12 align-self-end">
            <label class="d-flex" for="">
              Usuarios de la unidad productiva
            </label>
          </div>


        </div>


        {{-- TABLA --}}
        <div class="col-12">
          <table class="table table-striped table-bordered table-condensed table-hover">
            <thead class="thead-default">
              <tr>
                <th class="text-center">
                  #
                </th>
                <th class="text-left">
                  Nombres
                </th>
                <th class="text-center">
                  DNI
                </th>
                <th class="text-center">
                  Asistencia
                </th>
              </tr>
            </thead>
            <tbody id="modal_AsistenciaUsuarios">
              @php
              $i=1;
              @endphp
              @foreach($listaUsuariosYAsistencia as $usuario)
              <tr>
                <td class="pequeñaRow text-center">
                  {{$i}}
                </td>
                <td class="pequeñaRow">
                  <label for="CB_Asistencia_{{$usuario->codUsuario}}">
                    {{$usuario->getNombreCompleto()}}
                  </label>
                </td>
                <td class="pequeñaRow text-center">
                  <label for="CB_Asistencia_{{$usuario->codUsuario}}">
                    {{$usuario->dni}}
                  </label>
                </td>
                <td class="pequeñaRow text-center">
                  <input type="checkbox" class="specialCB" value="1" id="CB_Asistencia_{{$usuario->codUsuario}}" {{$usuario->asistencia ? 'checked' : ''}} onchange="clickCambiarAsistencia({{$usuario->getId()}},this.checked)">

                </td>
              </tr>
              @php
              $i++;
              @endphp
              @endforeach

            </tbody>
          </table>

        </div>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Salir
        </button>

        <button type="button" class="m-1 btn btn-primary" onclick="clickGuardarNuevaAsistencia()">
          Guardar
          <i class="fas fa-save"></i>
        </button>
      </div>


    </div>
  </div>
</div>


<script>

  

  /* MODAL LISTA DE ASISTENCIAS DE USUARIOS INTERNOS */

  function clickGuardarNuevaAsistencia(){
      url = "/Cite/Servicios/GuardarAsistencias";
      formData = {
          listaUsuariosYAsistencia,
          codServicio : "{{$servicio->codServicio}}",
          _token	 	: "{{ csrf_token() }}"
      }
      request =  {
          method: "POST",
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify(formData)
      }

      maracFetch(url,request,function(objetoRespuesta){

          console.log(objetoRespuesta);
          $(".loader").show();
          alertaMensaje(objetoRespuesta.titulo,objetoRespuesta.mensaje,objetoRespuesta.tipoWarning);


          setTimeout(function(){
              location.href = "{{route('CITE.Servicios.Editar',$servicio->codServicio)}}"
          }, 1500);

      })

  }

  var listaUsuariosYAsistencia = @php echo $listaUsuariosYAsistencia @endphp

  function clickCambiarAsistencia(codUsuario,nuevoValor){
      console.log('(clickCambiarAsistencia) codUsuario',codUsuario)
      console.log('(clickCambiarAsistencia) nuevoValor',nuevoValor)

      for (let index = 0; index < listaUsuariosYAsistencia.length; index++) {
          const element = listaUsuariosYAsistencia[index];
          if(element.codUsuario == codUsuario)
              listaUsuariosYAsistencia[index].nuevaAsistencia = nuevoValor;

      }

      console.log('listaUsuariosYAsistencia',listaUsuariosYAsistencia)
      actualizarBotonBusqueda();

  }





  /* Busqueda rapida x nombre y dni */

  function cambioUsuarioBuscado(newValue) {


    codUsuarioSeleccionado = newValue;
    actualizarBotonBusqueda();
  }

  var codUsuarioSeleccionado = 0;

  function actualizarBotonBusqueda() {
    if (codUsuarioSeleccionado == 0 || codUsuarioSeleccionado == -1) {
      return;
    }

    var relacion = listaUsuariosYAsistencia.find(e => e.codUsuario == codUsuarioSeleccionado);
    console.log("nuevaAsistencia de: " + codUsuarioSeleccionado, relacion.nuevaAsistencia);
    if (relacion.nuevaAsistencia) {
      claseIcono = "fa fa-trash";
      claseBoton = "btn btn-danger btn-sm";
      msjBusqueda = "Eliminar asistencia";
    } else {
      claseIcono = "fa fa-check";
      claseBoton = "btn btn-success btn-sm";
      msjBusqueda = "Marcar asistencia";
    }

    document.getElementById("msjBusqueda").innerHTML = msjBusqueda;
    document.getElementById("botonBusqueda").className = claseBoton
    document.getElementById("iconoBusqueda").className = claseIcono

  }



  function clickMarcarAsistenciaBusquedaRapida() {


    codUsuarioSeleccionado = document.getElementById('codUsuarioBusquedaRapida').value

    if (codUsuarioSeleccionado == "-1") {
      alerta("Seleccione un usuario válido")
      return;
    }


    var comboBox = document.getElementById('CB_Asistencia_' + codUsuarioSeleccionado) //hacemos click
    comboBox.checked = !comboBox.checked;

    clickCambiarAsistencia(codUsuarioSeleccionado, comboBox.checked);
    actualizarBotonBusqueda();

  }


</script>

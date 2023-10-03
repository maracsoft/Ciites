
<div class="modal-header">
  <h5 class="modal-title">
    <b id="titulo_modal">
      {{$titulo_modal}}
    </b>
  </h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <input type="hidden" id="tipo_reporte" value="{{$tipo_reporte}}">
  <input type="hidden" id="codIndicador" value="{{$indicador->codIndicador}}">
  
  
  <div class="row">
    <div class="col-sm-12">
      <label class="mb-0" for="">
        Actividad:
      </label>
      <textarea class="form-control" rows="4" readonly>{{$actividad->descripcion}}</textarea>

    </div>
    <div class="col-sm-12 mb-2">
      <label class="mb-0" for="">
        Indicador:
      </label>
      <textarea class="form-control" rows="4" readonly>{{$indicador->descripcion}}</textarea>

    </div>
    <div class="col-sm-2">

    </div>
    <div class="col-sm-3">
      <label class="mb-0" for="">
        Tipo de Reporte:
      </label>
      <input type="text" class="form-control text-center" readonly value="{{$indicador->tipo_reporte}}"/>
    </div>
    
    @if($tipo_reporte == "mes")
      <input type="hidden" id="codMes" value="{{$mes->codMes}}">
      
      <div class="col-sm-3">
        <label class="mb-0" for="">
          Inicio del Mes:
        </label>
        <input type="text" class="form-control text-center" id="" name="" value="{{$mes->getFechaInicio()}}" readonly>
      </div>
      <div class="col-sm-3">
        <label class="mb-0" for="">
          Fin del Mes:
        </label>
        <input type="text" class="form-control text-center" id="" name="" value="{{$mes->getFechaFin()}}" readonly>
      </div>

    @endif
    @if($tipo_reporte == "region")
      <input type="hidden" id="codDepartamento" value="{{$departamento->codDepartamento}}">
        

      <div class="col-sm-6">
        <label class="mb-0" for="">
          Región:
        </label>
        <input type="text" class="form-control" id="" name="" value="{{$departamento->nombre}}" readonly>
      </div>
    @endif


    <div class="col-sm-3">

    </div>
    <div class="col-sm-2">
      <label class="mb-0" for="">
        Ejecutado:
      </label>
      <input type="text" class="form-control text-center" value="{{$valor_ejecutado}} {{$indicador->tipo_reporte}}" readonly>
    </div>
    
    <div class="col-sm-2">
      <label class="mb-0" for="">
        Meta:
      </label>
      <input type="text" class="form-control text-center" id="valor_meta_actual" value="{{$valor_meta}}" >
    </div>
    <div class="col-sm-2 d-flex flex-row">
      
      <div class="d-flex">
        <button class="btn btn-success mt-auto" type="button" onclick="clickActualizarMeta()">
          Guardar
          <i class="ml-1 fas fa-save"></i>
        </button>
      </div>

    </div>

    
    <div class="col-sm-2">
      
    </div>

  </div>

  <div class="row my-3">

    <div class="col-sm-12 @if($indicador->tipo_reporte == 'servicios') tabla_elegida @endif">
      <label class="mb-0" for="">
        Relación de Servicios:
      </label>
      <table class="table table-bordered table-condensed table-sm"> 
        <thead class="thead-default filaFijada header_azul letrasBlancas " style="">
          <tr>
            <th>Cod</th>
            <th>Descripcion</th>
            <th>Unidad Productiva</th>
            <th>
              Mes
            </th>
            <th>Lugar</th>
            <th>Cantidad / Tipo acceso</th>
            <th>Tipo Servicio</th>
            <th>Convenio?</th>

          </tr>
        </thead>
        <tbody>
          @forelse($listaServicios as $servicio)
            <tr>
              
              
              <td>
                {{$servicio->getId()}}
              </td>
              <td>
                  {{$servicio->descripcion}}
              </td>
              <td>
                  {{$servicio->getUnidadProductiva()->getDenominacion()}}
                  [{{$servicio->getUnidadProductiva()->getRucODNI()}}]

              </td>
              <td>
                  {{$servicio->getMesAño()->getTexto()}}

              </td>

              <td class="text-center">
                  {{$servicio->getTextoLugar()}}
              </td>
              <td>
                  <b>
                      {{$servicio->cantidadServicio}}
                  </b>
                  /
                  {{$servicio->getTipoAcceso()->nombre}}
              </td>
              <td>
                  {{$servicio->getTipoServicio()->nombre}}
              </td>
              <td>
                  {{$servicio->getTextoModalidadConConvenio()}}
              </td>
              


            </tr>
          @empty
            <tr>
              <td class="text-center" colspan="8">
                No hay servicios relacionados
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      
    </div>

    <div class="col-sm-12 @if($indicador->tipo_reporte == 'unidades') tabla_elegida @endif">
      <label class="mb-0" for="">
        Relación de Unidades Productivas:
      </label>
      <table class="table table-bordered table-condensed table-sm ">
        <thead class="header_azul">
          <tr>
            <th>Cod</th>
            <th>Razón Social</th>
            <th>RUC/DNI</th>

            <th>Cadena</th>
            <th>Lugar</th>
            <th>Tipo Personeria</th>
            <th>#Servicios en el sistema</th>
 
          </tr>
        </thead>
        <tbody>
          
          @forelse($listaUnidades as $unidadProductiva)
              <tr class="FilaPaddingReducido">
                  <td>
                      {{$unidadProductiva->getId()}} 
                  </td>
                  <td class="fontSize11">
                      {{$unidadProductiva->getDenominacion()}}
                  </td>
                  <td>
                      {{$unidadProductiva->getRucODNI()}}
                  </td>

                  <td class="fontSize11">
                      {{$unidadProductiva->getNombreCadena()}}
                  </td>
                  <td class="fontSize11">
                      {{$unidadProductiva->getTextoLugar()}}
                  </td>
                  <td class="fontSize11">
                      {{$unidadProductiva->getTipoPersoneria()->nombre}}
                  </td>
                  <td>
                      {{$unidadProductiva->getNroServicios()}}
                  </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center">
                  No hay unidades productivas relacionadas
                </td>
              </tr>
              
            @endforelse
          
        </tbody>
      </table>


    </div>

    <div class="col-sm-12 @if($indicador->tipo_reporte == 'usuario') tabla_elegida @endif">
      <label class="mb-0" for="">
        Usuarios:
      </label>
      <table class="table table-bordered table-condensed table-sm " >
        <thead  class="thead-default header_azul">
            <tr>
                <th>
                    ID
                </th>
                <th class="text-right">
                    DNI
                </th>
                <th class="text-left">
                    Nombre y Apellidos
                </th>
                <th class="text-right">
                    Teléfono
                </th>
                <th class="text-right">
                    Correo
                </th>
                <th class="text-center">
                  #Servicios
                </th>
                <th class="text-center">
                  #Unid Productivas
                </th>
            
            </tr>
        </thead>
        <tbody>
            @forelse($listaUsuarios as $usuario )
                <tr class="FilaPaddingReducido">
                    <td>
                        {{$usuario->getId()}}
                    </td>
                    <td class="text-right">
                        {{$usuario->dni}}
                    </td>
                    <td class="text-left">
                        {{$usuario->getNombreCompleto()}}
                    </td>
                    <td class="text-right">
                        {{$usuario->telefono}}
                    </td>
                    <td class="text-right">
                        {{$usuario->correo}}
                    </td>
                    <td class="text-center">
                        {{$usuario->getCantidadServicios()}}
                    </td>
                    <td  class="text-center">
                        {{$usuario->getCantidadUnidades()}}
                    </td>
                  
                </tr>
            @empty
                <tr>
                  <td colspan="7" class="text-center">
                    No hay usuarios relacionados
                  </td>
                </tr>
            @endforelse
            

        </tbody>
      </table>

    </div>


  </div>
</div>
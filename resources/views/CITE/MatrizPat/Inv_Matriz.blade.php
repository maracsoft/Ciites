<div class="table-responsive">
                
  <table id="matriz_pat" class="table table-bordered table-condensed table-sm" style='background-color:#FFFFFF;'> 
      <thead class="thead-default filaFijada fondoAzul letrasBlancas" style="">
        <tr>
          <th rowspan="3">
            Actividad
          </th>
          <th rowspan="3">
            Indicador
          </th>
          <th rowspan="3">
            Meta
          </th>
          <th rowspan="2" colspan="{{count($listaMeses)}}" class="busqueda_secciones" seccion_matriz="por_mes">
            Por Mes
          </th>
          <th rowspan="1" colspan="{{count($listaDepartamentos)}}" class="busqueda_secciones" seccion_matriz="por_region">
            Por Región
          </th>
        </tr>
        <tr>

          @foreach($listaDepartamentos as $depar)
            <th rowspan="2" colspan="1" class="busqueda_secciones" seccion_matriz="por_region">
              {{$depar->nombre}}
            </th>
          @endforeach
        </tr>
        <tr>
         
          @foreach($listaMeses as $mes)
            <th class="busqueda_secciones" seccion_matriz="por_mes" title="{{$mes->getDescripcion()}}">
              {{$mes->codMes}}
            </th>
          @endforeach

          
          @foreach($listaDepartamentos as $depar)
              
            
          @endforeach
        </tr>
        
      </thead>



      <tbody>
        @foreach($listaActividades as $actividad)
          @php
            $ya_impreso = false;
          @endphp
          @foreach($actividad->getIndicadores() as $indicador)
            <tr>
              <td class="fontSize9">
                @if(!$ya_impreso)
                  <b>
                    {{$actividad->indice}}
                  </b>
                  {{$actividad->descripcion}}
                  @php
                    $ya_impreso = true;
                  @endphp  
                @else
                  <i class=" fas fa-arrow-up"></i>
                @endif
              </td>
              <td class="fontSize9">
                {{$indicador->descripcion}}
              </td>
              <td class="text-center">
                
                <button type="button" class="btn btn-info btn-sm" onclick="clickModalMeta({{$indicador->getId()}})">
                  <b>
                    {{$indicador->meta_anual}}
                  </b>
                </button>

              </td>

              @foreach($listaMeses as $mes)
                @php
                  $tiene_meta_programada = $indicador->tieneValorMeta_Mes($indicador,$mes);
                @endphp
                <td class="busqueda_secciones text-center" seccion_matriz="por_mes">
                   
                  {{-- MEDICION AVANCE --}}
                  <button type="button" class="btn_transition btn @if($tiene_meta_programada) btn-primary @else btn-secondary @endif  btn-sm" onclick="clickInvocarModal({{$indicador->getId()}},{{$mes->getId()}},0)">
                    <div class="d-flex flex-column">
                      <div class="">
                        <b>
                          {{$indicador->getValorEjecutado_Mes($indicador,$mes)}}
                        </b>
                      </div>
                      <div class="linea_separadora">
                          
                        @if($tiene_meta_programada)
                          <b>
                            {{$indicador->getValorMeta_Mes($indicador,$mes)}}
                          </b>
                        @else
                          ?
                        @endif
                        
                      </div>
                    </div>
                  </button>
                     
                </td>
              @endforeach
              
              
              @foreach($listaDepartamentos as $depar)
                @php
                  $tiene_meta_programada = $indicador->tieneValorMeta_Region($indicador,$depar);
                @endphp

                <td class="busqueda_secciones text-center" seccion_matriz="por_region">
                                                         
                    {{-- MEDICION AVANCE --}}
                    <button type="button" class="btn  @if($tiene_meta_programada) btn-primary @else btn-secondary @endif btn-sm"  onclick="clickInvocarModal({{$indicador->getId()}},0,{{$depar->getId()}})">
                      <div class="d-flex flex-column">
                        <div class="">
                          <b>
                            {{$indicador->getValorEjecutado_Region($indicador,$depar)}}
                          </b>
                        </div>
                        <div class="linea_separadora">
                            
                          @if($tiene_meta_programada)
                            <b>
                              {{$indicador->getValorMeta_Region($indicador,$depar)}}
                            </b>
                          @else
                            ?
                          @endif
                          
                        </div>
                      </div>
                    </button>

                </td>
              @endforeach

            </tr>
          @endforeach
        @endforeach
        
      </tbody>
  </table>
</div>
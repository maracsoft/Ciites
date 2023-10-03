<div class="table-responsive">

  
  <table class="table table-bordered table-hover datatable fontSize10" id="table-3">
    <thead class="table-marac-header">
        <tr>
          <th class="">
            Organización
          </th>
          <th class="align-middle text-center" rowspan="2">
            Semestre
          </th>
          <th class="align-middle text-center" rowspan="2">
            Nivel de gestion empresarial
          </th>
          <th>
            Nivel Productivo
          </th>
        </tr>
       
    </thead>
    <tbody>
      @php
          $codsRelaciones = [];
        @endphp
        @forelse($listaRelaciones as $relacion)
          @php
      
            $codsRelaciones[] = $relacion->getId();
            $organizacion = $relacion->getOrganizacion();
            $id = $relacion->getId();
            $i = 1;
 
          @endphp
          <tr>
            <td>
              {{$organizacion->razon_social}}
            </td>
            <td class="text-center">
              {{$relacion->getSemestre()->getTexto()}}
            </td>
            <td class="text-center">
                @php
                  if(is_null($relacion->nivel_gestion_empresarial)){
                    $label_button = "Calcular";
                    $btn_class = "primary";
                    $nivel_calculado = "";
                  }else{
                    $label_button = $relacion->getNivelGestionEmpresarialLabel(); 
                    $nivel_calculado = number_format($relacion->nivel_gestion_empresarial,2);
                    $btn_class = "success";
                  }

                @endphp
                <button class="btn btn-{{$btn_class}} nivel_calculado_button" type="button" onclick="clickCalcularNivelGestion({{$id}})" data-toggle="modal" data-target="#ModalNivelGestion">
                  {{$label_button}}
                  <div class="nivel_calculado">
                    {{$nivel_calculado}}
                  </div>
                </button>
                 
              
            </td>
            <td class="text-center">
              <button type="button" data-toggle="modal" data-target="#ModalNivelProductivo" onclick="clickNivelProductivo({{$id}})" class="btn btn-primary">
                Ingresar
              </button>
            </td>
             
            
            
          </tr>
          @php
            $i++;
          @endphp
        @empty
          <tr>
            <td class="text-center" colspan="11">
              No hay resultados
            </td>
          </tr>
        @endforelse
      

    </tbody>
  </table>  

  
</div>
 

@php
  
  $ruta_descarga_excel_fge = route('PPM.Indicadores.ExportarFichasGestionEmpresarial');
  $ruta_descarga_excel_fge.=  "?array_codsRelacion=".implode(",",$codsRelaciones);
  
@endphp
<div class="text-right">
  <a target="_blank" href="{{$ruta_descarga_excel_fge}}" class="btn btn-success">
    <i class="fas fa-file-download mr-1"></i>
    Reporte de FGE
  </a>
</div>
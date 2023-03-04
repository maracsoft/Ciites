@extends('Layout.Plantilla')

@section('titulo')
    Crear Contrato Locación servicios
@endsection

@section('contenido')
<div >
    <h4 style="text-align: center">
        Crear Contrato Locación Servicios
    </h4>
</div>

<form method = "POST" action = "{{route('ContratosLocacion.Guardar')}}" 
        onsubmit="" id="frmLocacionServicio" name="frmLocacionServicio">
        
     
    @csrf

    <div class="card">
        <div class="card-header">
           
            <div class="row">
                <div class="col-3 font-weight-bold">
                    Datos del Locador:
                </div>
                <div class="col">

                    <select class="form-control" name="esPersonaNatural" id="esPersonaNatural" onchange="cambiarTipoPersona()">
                        <option value="-1">- Tipo Persona -</option>
                        <option value="1">Persona Natural</option>
                        <option value="0">Persona Jurídica</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">

            {{-- Datos del locador --}}
            <div class="">  

               

                

                <div id="FormPN" hidden> 
                  <div class="row">
                    
                    <div class="col-12 col-md-2 p-1">
                        <input type="text" class="form-control" name="PN_ruc" 
                            id="PN_ruc" value="" placeholder="RUC">    

                    </div>
                    
                    <div class="col-12 col-md-2 p-1">
                        <input type="text" class="form-control" name="PN_dni" 
                            id="PN_dni" value="" placeholder="DNI">    

                    </div>
                    

                    
                    <div class="col-12 col-md-2 p-1">
                            <input type="text" class="form-control" name="PN_nombres" 
                            id="PN_nombres" value="" placeholder="Nombres">    

                    </div>
                    
                    
                    <div class="col-12 col-md-2 p-1">
                        <input type="text" class="form-control" name="PN_apellidos" 
                        id="PN_apellidos" value="" placeholder="Apellidos">    

                    </div>
                    <div class="col-12 col-md-2 p-1">
                            <select class="form-control" name="PN_sexo" id="PN_sexo">
                            <option value="-1">- Sexo- </option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>   
                    </div>
                    <div class="col-12 col-md-2 p-1"></div>
                        
                     
                  </div>
                  <div class="row mt-2">
                    <div class="col-12 col-md-6 p-1">
                        
                        <input type="text" class="form-control" name="PN_direccion" 
                        id="PN_direccion" value="" placeholder="Domicilio fiscal">    
                    </div>
                    <div class="col-12 col-md-6 p-1">
                            
                        <input type="text" class="form-control" name="PN_provinciaYDepartamento" 
                        id="PN_provinciaYDepartamento" value="" placeholder="Provincia y Departamento">    


                    </div>
                    
                  </div>


                </div>


                    
                <div  id="FormPJ" hidden>
                    <div class="row">
                      <div class="col-12">
                        <label for="">
                            Datos de la persona jurídica:
                        </label>
                      </div>

                    </div>
                    <div class="row">
 
                      
                      <div class="col-12 col-md-4 p-1">
                          <input type="text" class="form-control" name="PJ_ruc" 
                              id="PJ_ruc" value="" placeholder="RUC">    

                      </div>
                      

                      <div class="col-12 col-md-4 p-1">
                          <input type="text" class="form-control" name="PJ_razonSocialPJ" 
                          id="PJ_razonSocialPJ" value="" placeholder="Razón Social">    
                      </div>
                      <div class="col-12 col-md-4 p-1">
                          <select class="form-control" name="PJ_sexo" id="PJ_sexo">
                              <option value="-1">- Sexo- </option>
                              <option value="M">Masculino</option>
                              <option value="F">Femenino</option>
                          </select>   
                      </div>
                       
                    </div>
                    <div class="row mt-2">

                        
                      
                      <div class="col-12 col-md-6 p-1">
                              
                          <input type="text" class="form-control" name="PJ_direccion" 
                          id="PJ_direccion" value="" placeholder="Domicilio fiscal">    

                      </div>
                      
                      <div class="col-12 col-md-6 p-1">
                          
                          <input type="text" class="form-control" name="PJ_provinciaYDepartamento" 
                          id="PJ_provinciaYDepartamento" value="" placeholder="Provincia y Departamento">    


                      </div>
                   
                    
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <label for="">
                            Datos del representante:
                        </label>
                      </div>
                    </div>
                    <div class="row">

                      
                      <div class="col-12 col-md-6 p-1">
                        <input type="text" class="form-control" name="PJ_dni" 
                            id="PJ_dni" value="" placeholder="DNI">    

                      </div>
                      

                      
                      <div class="col-12 col-md-6 p-1">
                              <input type="text" class="form-control" name="PJ_nombres" 
                              id="PJ_nombres" value="" placeholder="Nombres">    

                      </div>
                      
                      
                      <div class="col-12 col-md-6 p-1">
                          <input type="text" class="form-control" name="PJ_apellidos" 
                          id="PJ_apellidos" value="" placeholder="Apellidos">    

                      </div>

                      
              
                          
                      
                      

                      <div class="col-12 col-md-6 p-1">
                          <input type="text" class="form-control" name="PJ_nombreDelCargoPJ" 
                          id="PJ_nombreDelCargoPJ" value="" placeholder="Cargo en la empresa">    

                      </div>


                    </div>
                </div>



            </div>

            
    

        </div>
    </div>


        
        
    <div class="card">
        <div class="card-header font-weight-bold" >
            
            Datos del Contrato
        </div>
        <div class="card-body">
            {{-- DATOS DEL CONTRATO --}}
         
            <div class="row">

 

                <div class="col-12 col-md-4 p-1">
            
                    <textarea class="form-control" name="motivoContrato" id="motivoContrato" placeholder="Objetivo del contrato"
                    ></textarea>
                    
                </div>
                <div class="col-12 col-md-4 p-1">
                    <input type="number" min="0" class="form-control" name="retribucionTotal" 
                        id="retribucionTotal" value="" placeholder="Monto de honorario" onchange="actualizarRetribucionTotal()">    

                </div>

                <div class="col-12 col-md-4 p-1">
                    <select class="form-control" name="codMoneda" id="codMoneda">
                        <option value="-1">- Moneda - </option>
                        @foreach ($listaMonedas as $moneda)
                            <option value="{{$moneda->codMoneda}}">
                                {{$moneda->nombre}}
                            </option>
                        @endforeach
                    </select>   


                </div>
                <div class="w-100"></div>

        
                <div class="col-12 col-md-4 p-1">
                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  
                        style=" ">
                        <input type="text"  class="form-control text-center" name="fechaInicio" id="fechaInicio" placeholder="Fecha Inicio">
                        <div class="input-group-btn">                                        
                            <button class="btn btn-primary date-set" type="button" >
                                <i class="fa fa-calendar"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 p-1">

                    <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                        <input type="text" class="form-control text-center" name="fechaFin" id="fechaFin" placeholder="Fecha Fin">
                        <div class="input-group-btn">        
                            <button class="btn btn-primary date-set" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </div>
                    </div>
                </div>
                    
             

                
              
                <div class="col-12 col-md-4 p-1">
                    <select class="form-control" name="codSede" id="codSede">
                        <option value="-1">- Sede - </option>
                        @foreach ($listaSedes as $sede)
                            <option value="{{$sede->codSede}}">
                                {{$sede->nombre}}
                            </option>
                        @endforeach
                    </select>   


                </div>
                
                <div class="w-100"></div>
                <div class="col-12 col-md-4 p-1">
                    <input type="text" class="form-control" name="nombreProyecto" id="nombreProyecto" placeholder="Proyecto">

                </div>
                <div class="col-12 col-md-4 p-1">
                    <input type="text" class="form-control" name="nombreFinanciera" id="nombreFinanciera" placeholder="Entidad Financiera">

                </div>


                <div class="col-12 col-md-4 p-1">
                    <select class="form-control" name="esDeCedepas" id="esDeCedepas">
                        <option value="-1">- Tipo Contrato- </option>
                        <option value="1">CEDEPAS</option>
                        <option value="0">GPC </option>
                       
                    </select>   


                </div>



            </div>
 
     
        </div>
    </div>

           
    
      
           
         

    {{-- LISTADO DE DETALLES  --}}
    <div class="container">

        <label for="">
            Productos entregables
        </label>
        <div class="table-responsive">                           
            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover tabla-detalles" style='background-color:#FFFFFF;'> 
                <thead >
                    <th width="15%" class="text-center">
                                                
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            {{-- INPUT PARA EL CBTE DE LA FECHA --}}
                            <input type="text" style="text-align: center" class="form-control" name="nuevaFecha" id="nuevaFecha"
                                    value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="font-size: 10pt;"> 
                            
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                    <i class="fas fa-calendar fa-xs"></i>
                                </button>
                            </div>
                        </div>  
                    </th>                                           
                    <th width="40%"> 
                        <div> {{-- INPUT PARA LUGAR--}}
                            <input type="text" class="form-control" name="nuevaDescripcion" id="nuevaDescripcion">     
                        </div>
                        
                    </th>                                 
                     
                    <th width="10%" class="text-center">
                        <div> {{-- INPUT IMPORTE--}}
                            <input type="number" min="0"  class="form-control" name="nuevoMonto" id="nuevoMonto" readonly onclick="cambiarAModoMonto()" onchange="cambioMonto()">     
                        </div>

                    </th>
                    <th width="10%" class="text-center">
                        <div> {{-- INPUT IMPORTE--}}
                            <input type="number" min="0"  class="form-control" name="nuevoPorcentaje" id="nuevoPorcentaje" readonly  onclick="cambiarAModoPorcentaje()" onchange="cambioPorcentaje()">     
                        </div>

                    </th>
                    
                    <th width="5%" class="text-center">
                        <div>
                            <button type="button" id="btnadddet" name="btnadddet" 
                                class="btn btn-success btn-sm" onclick="agregarDetalle()" >
                                <i class="fas fa-plus"></i>
                                    Agregar
                            </button>
                        </div>      
                    
                    </th>                                            
                    
                </thead>
                
                
                <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                    <th  class="text-center">Fecha Entrega</th>                                        
                                               
                    <th > Descripción del producto entregable</th>
                    <th  class="text-center">Monto</th>
                    <th  class="text-center">Porcentaje</th>
                    
                    <th  class="text-center">Opciones</th>                                            
                    
                </thead>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2">
                            <b>
                                Acumulados:
                            </b>
                            
                        </td>
                        
                        <td class="text-right">
                            <span class="col" id="spanMontoAcumulado">

                            </span>


                        </td>
                        <td class="text-center">
                            
                            <span class="col" id="flagPorcentajeAcumulado" style="">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="col" id="spanPorcentajeAcumulado">

                            </span>
                        </td>
                        <td></td>
                        
                    </tr>
                                                                                    
                </tfoot>
                <tbody>
                    
                </tbody>
            </table>
        </div> 
            
        <div class="row" id="divTotal" name="divTotal">                       
            <div class="col-md-8">
            </div>   
            
            <div class="col-md-2">
                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                <input type="hidden" name="cantElementos" id="cantElementos">                              
                                             
            </div>   
        </div>
                

            
    </div> 
    
    <div class="m-2 row  text-center">  
        <div class="col text-left">
          
            <a href="{{route('ContratosLocacion.Listar')}}" class='btn btn-info '>
                <i class="fas fa-arrow-left"></i> 
                Regresar al Menu
            </a>     

        </div>
        <div class="col text-right">
            <button type="button" class="btn btn-primary" id="btnRegistrar" onclick="registrar()">
                <i class='fas fa-save'></i> 
                Registrar
            </button> 
            

        </div>
        
         
       
    </div>
   
</form>
@endsection

{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}

@include('Layout.EstilosPegados')
@include('Layout.ValidatorJS')
@section('script')
     {{-- <script src="/public/select2/bootstrap-select.min.js"></script>      --}}
    <script>
        var cont=0;
        var total=0;
        var detalleAvance=[];
        var modo;

        var totalAcumulado = 0;
        var porcentajeAcumulado = 0;

        var botonRegistrarBloqueado = true;

        $(document).ready(function(){
            
        });

        function registrar(){
            msje = validarFormCrear();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }
            
            confirmar('¿Estás seguro de crear el contrato?','info','frmLocacionServicio');
            
        }

        var listaArchivos = '';
                    
        function validarFormCrear(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
            msj='';
            
            limpiarEstilos(
                [
                'esPersonaNatural'    ,
                'PN_ruc','PN_dni','PN_nombres','PN_apellidos','PN_sexo','PN_direccion','PN_provinciaYDepartamento' ,//campos de PN
                'PJ_ruc','PJ_razonSocialPJ','PJ_sexo','PJ_direccion','PJ_provinciaYDepartamento','PJ_dni','PJ_nombres','PJ_apellidos','PJ_nombreDelCargoPJ', /* Campos de PJ */
                'motivoContrato','fechaInicio','fechaFin','retribucionTotal','codMoneda','codSede','nombreProyecto','nombreFinanciera','esDeCedepas'
                ]);

             

            msj = validarSelect(msj,'esPersonaNatural','-1','Tipo de persona');

            if(esPersonaNatural.value == '1'){ //PERSONA NATURAL

                msj = validarTamañoExacto(msj,'PN_ruc','11','RUC');
                msj = validarTamañoExacto(msj,'PN_dni','8','DNI');
                msj = validarTamañoMaximoYNulidad(msj,'PN_nombres',300,'Nombres');
                msj = validarTamañoMaximoYNulidad(msj,'PN_apellidos',300,'Apellidos');
                msj = validarSelect(msj,'PN_sexo','-1','Sexo');
                msj = validarTamañoMaximoYNulidad(msj,'PN_direccion', 500,'Dirección');
                msj = validarTamañoMaximoYNulidad(msj,'PN_provinciaYDepartamento',200,'Provincia y Departamento');
            }
            if(esPersonaNatural.value == '0'){ //PERSONA JURIDICA
                msj = validarTamañoExacto(msj,'PJ_ruc','11','RUC');
                msj = validarTamañoMaximoYNulidad(msj,'PJ_razonSocialPJ', 200,'Razón Social');
                msj = validarSelect(msj,'PJ_sexo','-1','Sexo');
                msj = validarTamañoMaximoYNulidad(msj,'PJ_direccion', 500,'Dirección');
                msj = validarTamañoMaximoYNulidad(msj,'PJ_provinciaYDepartamento', 200,'Provincia y Departamento');


                msj = validarTamañoExacto(msj,'PJ_dni','8','DNI');
                msj = validarTamañoMaximoYNulidad(msj,'PJ_nombres',300,'Nombres');
                msj = validarTamañoMaximoYNulidad(msj,'PJ_apellidos',300,'Apellidos');
                msj = validarTamañoMaximoYNulidad(msj,'PJ_nombreDelCargoPJ', 200,'Nombre del cargo');
               
                 
            }


            msj = validarTamañoMaximoYNulidad(msj,'motivoContrato',1000,'Motivo del Contrato');
            msj = validarNulidad(msj,'fechaInicio','Fecha de inicio');
            msj = validarNulidad(msj,'fechaFin','Fecha de fin');

            msj = validarPositividadYNulidad(msj,'retribucionTotal','Monto retribución');
            msj = validarSelect(msj,'codMoneda','-1','Moneda');
            msj = validarSelect(msj,'codSede','-1','Sede');
            msj = validarTamañoMaximoYNulidad(msj,'nombreProyecto',300,'Proyecto');
            msj = validarTamañoMaximoYNulidad(msj,'nombreFinanciera',300,'Financiera');
           
            
            msj = validarSelect(msj,'esDeCedepas','-1','Tipo de contrato');

            msj = validarCantidadMaximaYNulidadDetalles(msj,'cantElementos',{{App\Configuracion::valorMaximoNroItem}});

            //si el monto total coincide, pasará la validación
            if(porcentajeAcumulado!=100 && totalAcumulado != document.getElementById('retribucionTotal').value)
                msj="La suma de los porcentajes debe ser de 100. La actual es " + porcentajeAcumulado;

            return msj;
        }




    indexAEliminar = 0;
        /* Eliminar productos */
    function eliminardetalle(index){
        indexAEliminar = index;
        confirmarConMensaje("Confirmación","¿Desea eliminar el item N° "+(index+1)+"?",'warning',ejecutarEliminacionDetalle);    
    }

    function ejecutarEliminacionDetalle(){

        cont = cont - 1;
        $('#cantElementos').val(cont);
        detalleAvance.splice(indexAEliminar,1);

        console.log('BORRANDO LA FILA' + indexAEliminar);
        //cont--;
        actualizarTabla();
    }




    function calcularNroEnRendicionMayor(){
        mayor = 0;
        for (let index = 0; index < detalleAvance.length; index++) {
            if(mayor < detalleAvance[index].nroEnRendicion)
                mayor = detalleAvance[index].nroEnRendicion;
        }
        return mayor;
    }


    function compararFechas(fecha, fechaIngresada){//1 si la fecha ingresada es menor (dd-mm-yyyy)
        diaActual=fechaIngresada.substring(0,2);
        mesActual=fechaIngresada.substring(3,5);
        anioActual=fechaIngresada.substring(6,10);
        dia=fecha.substring(0,2);
        mes=fecha.substring(3,5);
        anio=fecha.substring(6,10);


        if(parseInt(anio,10)>parseInt(anioActual,10)){
            //console.log('el año ingresado es menor');
            return 1;
        }else if(parseInt(anio,10)==parseInt(anioActual,10)){
            
            if(parseInt(mes,10)>parseInt(mesActual,10)){
                //console.log('el mes ingresado es menor');
                return 1;
            }else if(parseInt(mes,10)==parseInt(mesActual,10)){

                if(parseInt(dia,10)>parseInt(diaActual,10)){
                    //console.log('el dia ingresado es menor');
                    return 1;
                }else{
                    return 0;
                }

            }else return 0;

        }else return 0;

    }


    function agregarDetalle(){


        limpiarEstilos(['nuevaFecha','nuevaDescripcion','nuevoMonto','nuevoPorcentaje']);
        
        nuevaFecha = $("#nuevaFecha").val();    
        nuevaDescripcion = $("#nuevaDescripcion").val();   
        nuevoMonto = $("#nuevoMonto").val(); 
        nuevoPorcentaje = $("#nuevoPorcentaje").val(); 

        msjError="";
        // VALIDAMOS


        msjError = validarNulidad(msjError,'nuevaFecha','Fecha');
        msjError = validarTamañoMaximoYNulidad(msjError,'nuevaDescripcion',{{App\Configuracion::tamañoMaximoLugar}},'Descripción'); 
        
        msjError = validarPositividadYNulidad(msjError,'nuevoMonto','Monto');
        msjError = validarPositividadYNulidad(msjError,'nuevoPorcentaje','Porcentaje');
        
        if(nuevoMonto + totalAcumulado > retribucionTotal.value )
            msjError = "El monto actual se excede del pago total.";

        if(msjError!=""){
            alerta(msjError);
            return false;
        }

        
        

        // FIN DE VALIDACIONES
        if(detalleAvance.length>0){
            temp=0;
            band=true;

            for (let item = 0; item < detalleAvance.length && band; item++) {
                element = detalleAvance[item];
                //console.log('FECHA Nº' + item + ': '+element.fecha+' se compara con '+fecha);
                if(compararFechas(element.fecha, nuevaFecha)==1){ 
                    //console.log('mi fecha es menor');
                    temp=item;
                    band=false;
                }else{
                    //console.log('mi fecha es mayor');
                    temp=item+1;
                }
            }
            
            detalleAvance.splice(temp,0,{
                fecha:nuevaFecha,
                descripcion:nuevaDescripcion,
                monto:nuevoMonto,
                porcentaje:nuevoPorcentaje
            });
            
        }else{
            detalleAvance.push({
                fecha:nuevaFecha,
                descripcion:nuevaDescripcion,
                monto:nuevoMonto,
                porcentaje:nuevoPorcentaje
            });   
        }
        
        cont++;
        actualizarTabla();
        
        $('#nuevaFecha').val("");
        $('#nuevaDescripcion').val('');
        
        $('#nuevoMonto').val('');    
        $('#nuevoPorcentaje').val('');    

         
           
    }

    function actualizarTabla(){
        
        importeTotalEscrito = document.getElementById('retribucionTotal').value;

        totalAcumulado=0;
        porcentajeAcumulado=0;

        //funcion para poner el contenido de detallesVenta en la tabla
        //tambien actualiza el total
        //$('#detalles')
        total=0;
        //vaciamos la tabla
        for (let index = 100; index >=0; index--) {
            $('#fila'+index).remove();
            //console.log('borrando index='+index);
        }

        //insertamos en la tabla los nuevos elementos
        for (let item = 0; item < detalleAvance.length; item++) {
            

            /* Actualizamos el porcentaje escrito */
            detalleAvance[item].porcentaje = (100*parseFloat(detalleAvance[item].monto)/importeTotalEscrito).toFixed(2);


            element = detalleAvance[item];
            
            cont = item+1;

            

            totalAcumulado=totalAcumulado +parseFloat(element.monto);
            porcentajeAcumulado=porcentajeAcumulado +parseFloat(element.porcentaje);
             

            //importes.push(importe);
            //item = getUltimoIndex();
            var fila=  
            /* */
            ` 
                <tr class="selected" id="fila`+item+`" name="fila` +item+`">            

                                    
                    <td style="text-align:center;">              
                        <input type="text" class="form-control" name="colFecha`+item+`" id="colFecha`+item+`" value="`+element.fecha+`" readonly style="font-size:10pt; text-align:center"  >
                    </td>               
            
                    <td style="text-align:center;">               
                        <input type="text" class="form-control" name="colDescripcion`+item+`" id="colDescripcion`+item+`" value="`+element.descripcion+`" readonly>
                    </td>             
            
                
                                    

                    <td  style="text-align:right;">    
                        <input type="text" class="form-control text-right" value="`+number_format(element.monto,2)+`" readonly>
                        <input type="hidden" class="form-control" name="colMonto`+item+`" id="colMonto`+item+`" value="`+(element.monto)+`" readonly>
                    </td>         

                    <td  style="text-align:right;">
                        <input type="text" class="form-control text-right" value="`+element.porcentaje+`%" readonly>
                        <input type="hidden" class="form-control" name="colPorcentaje`+item+`" id="colPorcentaje`+item+`" value="`+(element.porcentaje)+`" readonly>
                    </td>         




                    <td style="text-align:center;">               
                        <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle(`+item+`);">
                            <i class="fa fa-times" ></i>   
                        </button>     
                        <button type="button" class="btn btn-xs" onclick="editarDetalle(`+item+`);">
                            <i class="fas fa-pen"></i>            
                        </button>  

                    </td>               
                </tr>                 
                
                `;


            $('#detalles').append(fila); 
        }

          
        
        //console.log("{{Carbon\Carbon::now()->format('d/m/Y')}}" );

       
        document.getElementById('spanPorcentajeAcumulado').innerHTML = number_format(porcentajeAcumulado,2) +"%";
        document.getElementById('spanMontoAcumulado').innerHTML = number_format(totalAcumulado,2);
        

        
        potVerde = 255*porcentajeAcumulado/100;
        potRoja = 255-potVerde;
        if(porcentajeAcumulado>100.05){
            potVerde=0; potRoja = 255;    
        }

        console.log('potVerde='+potVerde+" potRoja="+potRoja);
        console.log("porcentajeAcumulado=" + porcentajeAcumulado + "totalAcumulado=" + totalAcumulado );


        flagPorcentajeAcumulado.style.color = "rgb("+potRoja+","+potVerde+",0)"

        $('#cantElementos').val(cont);
    }



    function editarDetalle(index){
        $('#nuevaFecha').val( detalleAvance[index].fecha );
        $('#nuevaDescripcion').val( detalleAvance[index].descripcion );
        $('#nuevoMonto').val( detalleAvance[index].monto );
        $('#nuevoPorcentaje').val( detalleAvance[index].porcentaje );
        
        indexAEliminar=index;
        ejecutarEliminacionDetalle();
        
    }



    function actualizarRetribucionTotal(){
        if(!hayMontoRetribucion()){ //si es no valido, ocultamos el coso de monto y porcentaje
            document.getElementById('nuevoMonto').readOnly = true;
            document.getElementById('nuevoPorcentaje').readOnly = true;
        }else{
            modo = "porcentaje";
            document.getElementById('nuevoMonto').readOnly = true;
            document.getElementById('nuevoPorcentaje').readOnly = false;
        }

        actualizarTabla();
        cambioMonto();

    }

    function hayMontoRetribucion(){
        valor =  $('#retribucionTotal').val();
        return (valor!="" && valor != 0);
    }

    function cambiarAModoMonto(){
        if( hayMontoRetribucion()){
            modo = "monto";
            document.getElementById('nuevoMonto').readOnly = false;
            document.getElementById('nuevoPorcentaje').readOnly = true;
        }else{
            alerta("Ingrese un monto de retribución para poder ingresar el monto de los avances entregables.")
        }
        
    }


    function cambiarAModoPorcentaje(){

        if( hayMontoRetribucion()){
            modo = "porcentaje";
            document.getElementById('nuevoMonto').readOnly = true;
            document.getElementById('nuevoPorcentaje').readOnly = false;
        }else{
            alerta("Ingrese un monto de retribución para poder ingresar el monto de los avances entregables.")
        }
    }


    function cambioMonto(){

        nuevoMonto =  $('#nuevoMonto').val();
        retribucionTotal =  $('#retribucionTotal').val();
        porcentaje = (100*nuevoMonto/retribucionTotal).toFixed(2);
        

        $('#nuevoPorcentaje').val(porcentaje);



    }

    function cambioPorcentaje(){

        nuevoPorcentaje =  $('#nuevoPorcentaje').val();
        retribucionTotal =  $('#retribucionTotal').val();

        nuevoMonto = parseFloat(nuevoPorcentaje*retribucionTotal/100).toFixed(2);

        $('#nuevoMonto').val(nuevoMonto);

    }



    function cambiarTipoPersona(){

        esPN = esPersonaNatural.value;
        console.log("esPersonaNatural=" + esPN)
        if(esPN==1)
        { //PERSONA  NATURAL Va DNI y RUC
            FormPN.hidden = false;
            FormPJ.hidden = true;
        }
        if(esPN==0)
        { //PERSONA JURIDICA SOLO RUC
            FormPN.hidden = true;
            FormPJ.hidden = false;
            
             
        }

        if(esPN==-1)
        { //PERSONA JURIDICA SOLO RUC
            FormPN.hidden = true;
            FormPJ.hidden = true;
            
             
        }


    }


    function desbloquearBotonRegistrar(){

        botonRegistrarBloqueado = false;



    }


    </script>

   
    {{-- 
        
        PERSONA NATURAL:
        todos los cmapos son de esa p


        PERSONA JURIDICA
            Del repr: nombres apellidos, dni, cargo

            De empresa: ruc, domicilio fiscal, provincia y dpt, sexo, razon social
        
        
        
        
        
        
        
        --}}







@endsection

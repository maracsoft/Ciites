@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')
  <!-- PARA SOLUCIONAR EL PROBLEMA DE 'funcion(){' EN js--->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


<script type="text/javascript"> 
    
    $(document).ready(function(){

        $('#codArea').change(function(){

            var codigo=$('#codArea').val();
            
            if(codigo!=0){  

                $.ajax({
                    url: '/listarPuestos/' + codigo,
                    type: 'post',
                    data: {
                        codigo     : codigo,
                        _token	 	: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(respuesta) {
                        var comboPuestos = '<label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>';
                         comboPuestos += '<div class="col-sm-4">';
                             comboPuestos += '<select class="form-control" name="codPuesto" id="codPuesto">';
                                 comboPuestos += '<option value="0">--Seleccionar--</option>';
                                for (var i in respuesta.puestos) {
                                     comboPuestos += '<option value="'+respuesta.puestos[i].codPuesto+'">'+respuesta.puestos[i].nombre+'</option>';
                                }
                             comboPuestos += '</select>';
                         comboPuestos += '</div>';

                        $('#comboPuestos').html(comboPuestos);
                    }
                });
                
            }else{
                var comboPuestos = '<label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>';
                         comboPuestos += '<div class="col-sm-4">';
                             comboPuestos += '<select class="form-control" name="codPuesto" id="codPuesto">';
                                 comboPuestos += '<option value="0">--Seleccionar--</option>';
                                
                             comboPuestos += '</select>';
                         comboPuestos += '</div>';

                $('#comboPuestos').html(comboPuestos);
            }

        })
    });
</script>

<script type="text/javascript"> 
          
    function validarregistro() 
        {
            var expreg = new RegExp("^[A-Za-zÑñ À-ÿ]+.$");//para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$
            var tipoContrato=$("#codTipoContrato").val(); 

            var tipo=$("#tipo").val();
            //alert(total);

            if(tipoContrato==1){//PLAZO FIJO

                if (document.getElementById("fechaInicio").value == ""){
                    alert("Ingrese fecha de Inicio");
                    $("#fechaInicio").focus();
                }
                else if (document.getElementById("fechaFin").value == "" && tipo=="1"){
                    alert("Ingrese fecha de Fin");
                    $("#fechaFin").focus();
                }
                else if (probar2()==0 && tipo=="1"){
                    alert("La fecha final tiene que ser mayor que la inicial");
                }
                else if (document.getElementById("sueldo").value == ""){
                    alert("Ingrese sueldo");
                    $("#sueldo").focus();
                }
                else if (document.getElementById("nombreFinanciador").value == ""){
                    alert("Ingrese financiador del usuario");
                    $("#nombreFinanciador").focus();
                }
                else if (document.getElementById("codProyecto").value == "0"){
                    alert("Ingrese proyecto");
                }
                else if (document.getElementById("codArea").value == "0"){
                    alert("Seleccione el area");
                }
                else if (document.getElementById("codPuesto").value == "0"){
                    alert("Seleccione el puesto");
                }
                else if (document.getElementById("codAFP").value == "0"){
                    alert("Seleccione AFP");
                }
                else{
                    document.frmempresa.submit(); // enviamos el formulario	
                }

            }else{//POR LOCACION

                if (document.getElementById("fechaInicio").value == ""){
                    alert("Ingrese fecha de Inicio");
                    $("#fechaInicio").focus();
                }
                else if (document.getElementById("fechaFin").value == ""){
                    alert("Ingrese fecha de Fin");
                    $("#fechaFin").focus();
                }
                else if (probar2()==0){
                    alert("La fecha final tiene que ser mayor que la inicial");
                }
                else if (document.getElementById("sueldo").value == ""){
                    alert("Ingrese sueldo");
                    $("#sueldo").focus();
                }
                else if (document.getElementById("motivo").value == ""){
                    alert("Ingrese motivo");
                    $("#motivo").focus();
                }
                
                else if (!expreg.test(document.getElementById("motivo").value)){
                    alert("Ingrese motivo de manera correcta");
                    $("#motivo").focus();
                }
                else if (cont<=0){
                    alert("Agregar entregables");
                }
                else if (total!=100){
                    alert("El proyecto tiene que ser de 100%");
                }
                else{
                    document.frmempresa.submit(); // enviamos el formulario	
                }

            }


            
        }
    
</script>

    <br>
    <div class="well"><H3 style="text-align: center;">CREAR CONTRATO DE {{$empleado->nombres}}, {{$empleado->apellidos}}</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="/listarEmpleados/crearContrato/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="codEmpleado" name="codEmpleado" value="{{ $empleado->codEmpleado}}" hidden>
            <input type="text" class="form-control" id="codTipoContrato" name="codTipoContrato" value="{{ $tipoContrato}}" hidden>
            @if($tipoContrato==1)
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Tipo:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="tipo" id="tipo" onchange="ocultarFecha()">
                    <option value="1">Periodo definido</option>
                    <option value="2">Periodo indefinido</option>
                    </select>
                </div>
            </div>
            @endif
            <div class="form-group row">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha Inicio:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio"
                                   value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="form-group row" id="divFechaFin">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha Fin:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaFin" id="fechaFin" value="{{ Carbon\Carbon::now()->format('d/m/Y') }}"
                                    style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
<!--
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Turno:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codTurno" id="codTurno">
                    <option value="0">--Seleccionar--</option>
                    </select>
                </div>
            </div>
        -->
            @if($tipoContrato==2)<!-- POR LOCACION-->
              
            @endif
            
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;" id="lbSueldo">Sueldo:</label>
                <div class="col-sm-4">
                    <input type="number" step="any" class="form-control" id="sueldo" name="sueldo" placeholder="sueldo..." >
                </div>
            </div>
            @if($tipoContrato==1)<!-- PLAZO FIJO-->
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Financiador:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombreFinanciador" name="nombreFinanciador" placeholder="Financiador..." >
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Proyecto:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codProyecto" id="codProyecto">
                    <option value="0">--Seleccionar--</option>
                    @foreach($proyectos as $itemProyecto)
                    <option value="{{$itemProyecto->codProyecto}}">{{$itemProyecto->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            </div>



            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Area:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codArea" id="codArea">
                    <option value="0">--Seleccionar--</option>
                    @foreach($areas as $itemarea)
                    <option value="{{$itemarea->codArea}}">{{$itemarea->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group row" id="comboPuestos">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codPuesto" id="codPuesto">
                    <option value="0">--Seleccionar--</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Sistema de pensiones:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codAFP" id="codAFP">
                    <option value="0">--Seleccionar--</option>
                    @foreach($AFPS as $itemAFP)
                    <option value="{{$itemAFP->codAFP}}">{{$itemAFP->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row" id="comboPuestos">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Asistencia:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="asistencia" id="asistencia">
                    <option value="1">SI</option>
                    <option value="0">NO</option>
                    </select>
                </div>
            </div>  
            @endif
            
            
            
            @if($tipoContrato==2)<!-- POR LOCACION-->
            <div class="form-group row" style="margin-left:350px;">
                <label class="col-sm-1 col-form-label">Motivo:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" rows="3" name="motivo" id="motivo" placeholder="Motivo ..." style="margin-top: 0px; margin-bottom: 0px; height: 61px;"></textarea>
                </div>
            </div>
            <div class="col-md-8 pt-3" style="margin-left:250px;">
                <label class="col-sm-1 col-form-label">Entregables:</label>
                <div class="row">                                       
                    <div class="col-md-1">
                        <button type="button" id="btnadddet" class="btn btn-success" onclick="agregarDetalle()">Añadir</button>
                    </div>                         
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="descripcion" id="descripcion">                              
                    </div>
                    <div class="col-md-3">
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fecha" id="fecha"
                                   value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>                             
                    </div>           
                    <div class="col-md-3">
                        <input type="number" min="1" class="form-control" name="porcentaje" id="porcentaje">                              
                    </div>                       
                </div>       
                <div class="table-responsive">                           
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                        <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                            <th width="10" class="text-center">OPCIONES</th>                                        
                            <th class="text-center">PRODUCTO ENTREGABLE</th>
                            <th class="text-center">FECHA ENTREGA</th>                                 
                            <th  class="text-center">PORCENTAJE</th>                                            
                        </thead>
                        <tfoot>
                                                                                                              
                                                                                            
                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div> 
            </div> 
            @endif
            
            <br />
            
            <input type="button" class="btn btn-primary" style="margin-left:600px;" value="Guardar" onclick="validarregistro()" />
            <a href="/listarEmpleados/listarContratos/{{$empleado->codEmpleado}}" class="btn btn-info">Regresar</a>

<script>
    var fechaParaFin=$("#fechaFin").val();
    //alert(fechaParaFin);
</script>
<script>
    function probar2(){
        var cadena1=$('#fechaInicio').val();
        var cadena2=$('#fechaFin').val();
        if(parseInt(cadena1.substr(6,4), 0)==parseInt(cadena2.substr(6,4), 0)){
            if(parseInt(cadena1.substr(3,2), 0)==parseInt(cadena2.substr(3,2), 0)){
                if(parseInt(cadena1.substr(0,2), 0)<=parseInt(cadena2.substr(0,2), 0)){
                    //alert('se puede');
                    return 1;
                }else{
                    //alert('no se puede');
                    return 0;
                }
            }else if(parseInt(cadena1.substr(3,2), 0)<parseInt(cadena2.substr(3,2), 0)){
                //alert('se puede');
                return 1;
            }else{
                //alert('no se puede');
                return 0;
            }
        }else if(parseInt(cadena1.substr(6,4), 0)<parseInt(cadena2.substr(6,4), 0)){
            //alert('se puede');
            return 1;
        }else{
            //alert('no se puede');
            return 0;
        }

        
    }
</script>
@endsection

<script>
    
var cont=0;
var detalleventa=[];
var controlproducto=[];
var total=0;

function ocultarFecha(){
    codigo=$("#tipo").val();
    //alert(codigo);
    if(codigo==1){
        $('#fechaFin').val(fechaParaFin);
        $('#divFechaFin').show();
        $('#lbSueldo').html("Sueldo Fijo:");
    }else{
        $('#fechaFin').val('');
        $('#divFechaFin').hide();
        $('#lbSueldo').html("Sueldo Mensual:");
    }
}

function agregarDetalle()
{
        descripcion=$("#descripcion").val();
        porcentaje=$("#porcentaje").val();
        fecha=$("#fecha").val();

        if(descripcion=='' || porcentaje=='' || fecha==''){
            alert('Faltan datos de entregable');
        }
        else{
            controlproducto[cont]=cont;
                    
            var fila='<tr class="selected" id="fila'+cont+'">'+
                        '<td style="text-align:center;"><button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle('+cont+');"><i class="fa fa-times" ></i></button></td>'+
                        '<td style="text-align:left;"><input type="text" name="descripcion[]" value="'+ descripcion +'" readonly ></td>'+
                        '<td style="text-align:left;"><input type="text" name="fecha[]" value="'+ fecha +'" readonly ></td>'+
                        '<td style="text-align:left;">%<input type="text" name="porcentaje[]" value="'+ porcentaje +'" readonly ></td>'+
                    '</tr>';        
            $('#detalles').append(fila);      
            detalleventa.push({
                fecha:fecha,
                descripcion:descripcion,
                porcentaje:porcentaje
            });
            total+=parseInt(detalleventa[cont].porcentaje, 10);     
            cont++;

            $("#descripcion").val('');
            $("#porcentaje").val('');
            $("#fecha").val('');
        }  
}
function eliminardetalle(index){
    total-=parseInt(detalleventa[index].porcentaje, 10);   
    detalleventa.splice(index,1);    
    $('#fila'+index).remove();
    controlproducto[index]="";
}
</script>


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection

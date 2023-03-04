<?php
namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

//      https://github.com/fzaninotto/Faker

class FakerCedepas extends Model
{
    
    //de los proyectos activos selecciona uno aleatoriamente
    public static function getProyectoAleatorio(){


    }


    public static function getUsuarioAleatorio(){
        $faker = Faker::create();
        return User::findOrFail($faker->numberBetween(1,20));
    }

    public static function F_REN_generarCuerpo($solicitud){
        $faker = Faker::create();
        
        $datos = [
            'resumen' => $faker->text(300)
        ];
        return $datos;
    }
    public static function F_REN_generarDetalle($proyectoSeleccionado){
        $faker = Faker::create();
        $listaTiposComprobantes = CDP::All();

        $item =[
            'colFecha' => $faker->date('d/m/Y'),
            'colTipo'=>   $listaTiposComprobantes[ $faker->randomDigit]->nombreCDP,
            'colComprobante' => $faker->numberBetween(11,99)."-".$faker->numberBetween(11111,999999999),
            'colConcepto' => $faker->text(60),
            'colImporte' => $faker->randomFloat(2,0,1000),
            'colCodigoPresupuestal' => $proyectoSeleccionado->codigoPresupuestal.$faker->numberBetween(10,53333)
            ];
        return $item;

    }

    public static function F_SOL_generarCuerpo($proyectoSeleccionado){
        $faker = Faker::create();
        $datos = [
            'ComboBoxProyecto' => $proyectoSeleccionado->codProyecto,
            //'fechaHoraEmision' => Carbon::now(),
            //'total' =>  $faker->randomFloat(2,1,1000),
            'girarAOrden' => $faker->name." ".$faker->name ,
            'nroCuenta' =>  $faker->numberBetween(111111111111,999999999999999),
            'ComboBoxBanco' => '3',
            'justificacion' => $faker->text(300),
            //'codEstadoSolicitud' => '1',
            'ComboBoxMoneda' =>'1',
             
        ];
        return $datos;
    }
    public static function F_SOL_GenerarDetalle($proyectoSeleccionado){
        $faker = Faker::create();
        $item =[
            'concepto' => $faker->text(60),
            'importe' => $faker->randomFloat(2,0,1000),
            'codigoPresupuestal' => $proyectoSeleccionado->codigoPresupuestal.$faker->numberBetween(10,53333)
            ];
        return $item;
    }
    
    public static function F_REP_generarCuerpo($proyectoSeleccionado){
        $faker = Faker::create();
        $datos = [
            'codProyecto' => $proyectoSeleccionado->codProyecto,
            //'fechaHoraEmision' => Carbon::now(),
            //'total' =>  $faker->randomFloat(2,1,1000),
            'girarAOrdenDe' => $faker->name." ".$faker->name ,
            'numeroCuentaBanco' =>  $faker->numberBetween(111111111111,999999999999999),
            'codBanco' => '3',
            'resumen' => $faker->text(300),
            //'codEstadoSolicitud' => '1',
            'codMoneda' =>'1',
        ];
        return $datos;
    }
    public static function F_REP_GenerarDetalle($proyectoSeleccionado){
        $faker = Faker::create();
        $listaTiposComprobantes = CDP::All();
        
        $item =[
            'colFecha' => $faker->date('d/m/Y'),
            'colTipo'=>   $listaTiposComprobantes[ $faker->randomDigit]->nombreCDP,
            'colComprobante' => $faker->numberBetween(11,99)."-".$faker->numberBetween(11111,999999999),
            'colConcepto' => $faker->text(60),
            'colImporte' => $faker->randomFloat(2,0,1000),
            'colCodigoPresupuestal' => $proyectoSeleccionado->codigoPresupuestal.$faker->numberBetween(10,53333)
            ];
        return $item;
    }

    public static function F_REQ_generarCuerpo($proyectoSeleccionado){
        $faker = Faker::create();
        $datos = [
            'codProyecto' => $proyectoSeleccionado->codProyecto,
            'cuentaBancariaProveedor' =>  $faker->numberBetween(111111111111,999999999999999),
            'justificacion' => $faker->text(300)
        ];
        return $datos;
    }
    public static function F_REQ_GenerarDetalle($proyectoSeleccionado){
        $faker = Faker::create();
        $listaUnidadesMedida = UnidadMedida::All();
        
        $item =[
            'ComboBoxUnidad' => $listaUnidadesMedida[rand(0,count($listaUnidadesMedida)-1)]->nombre,
            'cantidad'=>$faker->randomFloat(2,0,10000),
            'descripcion' => $faker->text(80),
            'codigoPresupuestal' => $proyectoSeleccionado->codigoPresupuestal.$faker->numberBetween(10,53333)
            ];
        return $item;
    }







    public static function F_SOL_generarCuerpoAprobacion($solicitud){
        //genera el cuerpo de datos que el gerente corrije en la aprobacion
        //$listaDetalles = $solicitud->getDetalles();
        

    }


    public static function generarCantidadItemsAleatorio(){
        $faker = Faker::create();
        return $faker->numberBetween(1,14); //cantidad elementos entre 
 
    }


    /* retorna un vector para enviar como POST a la ruta de guardar */
    public static function generarSolicitudFondos($proyectoSeleccionado){
        
        //MODELO DE EJEMPLO
        $cuerpo = [
            'ComboBoxProyecto' => '1',
            'fechaHoraEmision' => Carbon::now(),
            'total' =>  50,
            'girarAOrden' => 'Diego Ernesto Vigo Briones',
            'nroCuenta' =>  '52159 1295929215',
            'ComboBoxBanco' => '3',
            'justificacion' => 'ESTA ES LA JUSTIFICACION',
            'codEstadoSolicitud' => '1',
            'ComboBoxMoneda' =>'1',
            'codigoCedepas' =>'PRB01',
            'cantElementos' => '3',

            'colConcepto0' => 'ESTE ES EL PRIMER CONCEPTO',
            'colImporte0' => '11.12',
            'colCodigoPresupuestal0' => '10755',

            'colConcepto1' => 'ESTE SEGUNDO CONCEPTO',
            'colImporte1' => '753.51',
            'colCodigoPresupuestal1' => '10553',

            'colConcepto2' => 'TERCER ER CONCEPTO ASA S  dsadsa dsad sadsadsadsdsadsa  dsa dsa sadsadsa dsa dsa dsa sdadsasda dsa ds',
            'colImporte2' => '115.12',
            'colCodigoPresupuestal2' => '10222'
        ];
        
        $faker = Faker::create();
        
        $cantidadElementos = $faker->numberBetween(1,14); //cantidad elementos entre 
 
        
 
        $datos = [
            'ComboBoxProyecto' => $proyectoSeleccionado->codProyecto,
            //'fechaHoraEmision' => Carbon::now(),
            //'total' =>  $faker->randomFloat(2,1,1000),
            'girarAOrden' => $faker->name." ".$faker->name ,
            'nroCuenta' =>  $faker->numberBetween(111111111111,999999999999999),
            'ComboBoxBanco' => '3',
            'justificacion' => $faker->text(300),
            //'codEstadoSolicitud' => '1',
            'ComboBoxMoneda' =>'1',
            'cantElementos' => $cantidadElementos,
            
        ];

        $total=0;
        for ($i = 0; $i < $cantidadElementos; $i++) {
            $item =[
                    'colConcepto'.$i => $faker->text(60),
                    'colImporte'.$i => $faker->randomFloat(2,0,1000),
                    'colCodigoPresupuestal'.$i => $proyectoSeleccionado->codigoPresupuestal.$faker->numberBetween(10,53333)
                    ];
            $total += $item['colImporte'.$i];
            $datos = array_merge($datos,$item);
                    
        }
        
        $datos = array_merge($datos,['total' => $total]);
        return $datos;
        

    }

    public static function generarDataAprobacion($solicitud){
        $faker = Faker::create();
        
        $proyectoSeleccionado = $solicitud->getProyecto();
        $datos = [
            'justificacion' => $faker->text(300),
            'codSolicitud' => $solicitud->codSolicitud

        ];

        $listaDetalles = $solicitud->getDetalles();
        foreach($listaDetalles as $detalle)
            $datos['CodigoPresupuestal'.$detalle->codDetalleSolicitud] = $proyectoSeleccionado->codigoPresupuestal.$faker->numberBetween(10,53333);
        
        return $datos;
    }

    public static function generarDataAbonacion($solicitud){        
        $datos = [
            'codSolicitud' => $solicitud->codSolicitud
        ];

        return $datos;
    }

    public static function generarDataRendicion($solicitud){
        $faker = Faker::create();
        $proyectoSeleccionado=$solicitud->getProyecto();
        $cantidadElementos = $faker->numberBetween(1,14); //cantidad elementos entre 
        $datos =[
            'codigoSolicitud' => $solicitud->codSolicitud,
            'resumen' => $faker->text(300),
            'cantElementos'=>$cantidadElementos,
            'nombresArchivos'=>'',
            'filenames' => 
                [
                    //'0' => $faker->image($dir = '/tmp', $width = 640, $height = 480)
                ]
        ];

        /*  
            LAS RENDICIONES SE CREAN SIN FOTOS POST
            (AUNQUE SÍ DEBERIAN TENERLAS XD) 
        */
        $listaTiposComprobantes = CDP::All();


        //$faker->date($format = 'd/m/Y', $max = 'now'),
        $total=0;
        for ($i = 0; $i < $cantidadElementos; $i++) {
            $item =[
                    'colFecha'.$i => $faker->date('d/m/Y'),
                    'colTipo'.$i => $listaTiposComprobantes[$faker->randomDigit]->nombreCDP,
                    'colComprobante'.$i => $faker->numberBetween(11,99)."-".$faker->numberBetween(11111,999999999),
                    'colConcepto'.$i => $faker->text(200),
                    'colImporte'.$i => $faker->randomFloat(2,0,1000),
                    'colCodigoPresupuestal'.$i => $proyectoSeleccionado->codigoPresupuestal.$faker->numberBetween(10,53333)
                    ];

            $total += $item['colImporte'.$i];
            $datos = array_merge($datos,$item);
                    
        }
        
        $datos = array_merge($datos,['totalRendido' => $total]);
        return $datos;


    } 




    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* ------------- PARA POBLAR BD CON 100 000 DATOS FALSOS, USO EXCLUSIVO PARA EL PROYECTO DE SIG ------------ */
    /* 
        Estos valores se insertarán directamente a la base de datos 

    */
    

    public static function poblar_REP_generarCuerpo(){
        $faker = Faker::create();
        
        $empEmisor = Empleado::findOrFail(rand(1,47));

        $randMoneda = rand(1,10);
        if($randMoneda==1) //10% de probabilidades de que sea dolares
            $codMoneda = 2;
        else 
            $codMoneda = 1;

        $datos = [
            'codEstadoReposicion'=> '1', 
            'codEmpleadoSolicitante'=> $empEmisor->codEmpleado, //escogemos un empleado aleatorio del 1 al 20
            'codProyecto' => rand(1,10), //solo los proyectos del 1 al 10
            'codMoneda' =>$codMoneda, //soles 
            'fechaHoraEmision' => $faker->dateTimeBetween('-30 days',  'now', null), // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
            'codigoCedepas' => ReposicionGastos::calcularCodigoCedepas(Numeracion::getNumeracionREP()),
            'girarAOrdenDe' => $empEmisor->getNombreCompleto(),
            'numeroCuentaBanco' =>  $faker->numberBetween(111111111111,999999999999999),
            'codBanco' => rand(1,5),
            'resumen' => $faker->text(250),
            'totalImporte'=>'0'
        ];
        
        return $datos;
    }


    public static function poblar_REP_GenerarDetalle(ReposicionGastos $rep, $nroItem ){
        $faker = Faker::create();
        //generamos una fecha x dias menor a la fecha de generacion de la reposicion
        //donde X es aleatorio
        $x = rand(1,60);
        $dateTime = strtotime($rep->fechaHoraEmision->format("Y-m-d")."- $x days");

        $fechaDetalle = date("Y-m-d",$dateTime); 
        $codigoPresupBase = $rep->getProyecto()->codigoPresupuestal;
        $item =[
            'codReposicionGastos'=>$rep->codReposicionGastos,
            'fechaComprobante'=>$fechaDetalle,
            'nroComprobante'=> $faker->numberBetween(11,99)."-".$faker->numberBetween(11111,999999999),
            'concepto' => $faker->text(60),
            'importe' => $faker->randomFloat(2,0,1000),
            'codigoPresupuestal' => $codigoPresupBase.$faker->numberBetween(10,53333),
            'nroEnReposicion'=>$nroItem,
            'codTipoCDP'=> rand(1,14), //escogemos un CDP de la lista
            'pendienteDeVer'=>'0',
            'contabilizado'=>'0'
        ];

        return $item;
    }

}

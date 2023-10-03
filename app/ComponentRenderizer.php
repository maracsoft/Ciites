<?php

namespace App;

use App\Configuracion;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ComponentRenderizer
{

    /* https://www.oulub.com/es-ES/Laravel/blade PILAS USAR PILAS PARA LOS JS Y LOS CSS */


    /* 
    

        $listaArchivos debe tener los siguientes campos en cada objeto
        

        nombreAparente
        linkDescarga
        linkEliminar
    */
    public static function DescargarArchivos(string $titulo,array $listaArchivos,bool $mostrarBotonesEliminacion ){
        
        return view('ComponentesUI.DescargarArchivos',compact('titulo','listaArchivos','mostrarBotonesEliminacion'));
    }


    /* El nombre es el name y id que tendrá el input con el valor output de codDistrito */
    static function LugarSelector($name,$codDistritoSeleccionado = -1){    

        $codDepartamentoSeleccionado = null;
        $codProvinciaSeleccionada = null;

        $listaProvinciasDelDep = [];
        $listaDistritosDeProv = [];

        $listaDepartamentos = Departamento::All();
        $listaProvincias = Provincia::All();
        $listaDistritos = Distrito::All();

        

        if($codDistritoSeleccionado != -1){
            $distrito = Distrito::findOrFail($codDistritoSeleccionado);
            $provincia = $distrito->getProvincia();
            $departamento = $provincia->getDepartamento();

            $codDepartamentoSeleccionado = $departamento->getId();
            $codProvinciaSeleccionada = $provincia->getId();

            $listaProvinciasDelDep = $departamento->getProvincias(); 
            $listaDistritosDeProv = $provincia->getDistritos();
        }


        return view('ComponentesUI.LugarSelector',
            compact('name','listaDepartamentos','listaProvincias','listaDistritos',
            'codDistritoSeleccionado','codDepartamentoSeleccionado','codProvinciaSeleccionada',
            'listaProvinciasDelDep',
            'listaDistritosDeProv'
        
        ));
    }

    public static function subirArchivos($textoPorDefecto = "Subir Archivos",$tamañoMaximo = null){
        if($tamañoMaximo==null)
            $tamañoMaximo = Configuracion::pesoMaximoArchivoMB;

        return view('ComponentesUI.SubirArchivos',compact('textoPorDefecto','tamañoMaximo'));

    }


    
     
    


}

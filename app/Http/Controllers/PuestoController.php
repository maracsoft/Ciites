<?php

namespace App\Http\Controllers;

use App\Area;
use App\Empleado;
use App\EmpleadoPuesto;
use App\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PuestoController extends Controller
{
    const PAGINATION=10;

    //Request es vector en el que entra toda la informacion a una funcion en un controlador
    public function listarPuestos(Request $request){
        $nombreBuscar=$request->nombreBuscar;
        $puestos=Puesto::where('nombre','like','%'.$nombreBuscar.'%')->paginate($this::PAGINATION);
        $listaEmpleadosPuesto = EmpleadoPuesto::orderBy('codPuesto','DESC')->get();
        return view('Puestos.IndexPuesto',compact('puestos','nombreBuscar','listaEmpleadosPuesto'));
    }

    public function crearPuesto(){
        return view('Puestos.CreatePuesto');
    }

    public function guardarCrearPuesto(Request $request){
        
        $puesto=new Puesto();
        $puesto->nombre=$request->descripcion;
        $puesto->estado=1;
        $puesto->save();

        return redirect()->route('GestionPuestos.Listar');
    }

    public function editarPuesto($id){
        $puesto=Puesto::find($id);
        return view('Puestos.EditPuesto',compact('puesto'));
    }

    public function guardarEditarPuesto(Request $request){

        $puesto=Puesto::find($request->codPuesto);
        $puesto->nombre=$request->descripcion;
        $puesto->save();

        return redirect()->route('GestionPuestos.Listar');
    }

    public function eliminarPuesto($id){
        $puesto=Puesto::find($id);
        $puesto->estado=0;
        $puesto->save();

        return redirect()->route('GestionPuestos.Listar');
        //return response()->json();
    }




}

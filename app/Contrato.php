<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Contrato extends MaracModel
{

  const ColumnasContratoBase = [
    "nombres",
    "apellidos",
    "dni",

    "codigo_unico",
    "codEmpleadoCreador",
    "fechaHoraGeneracion",
    "es_borrador",
  ];
  const MaximoDiasEdicion = 2;

  public function sePuedeEditar(){
    if($this->estaAnulado())
      return false;

    $fechaActual = new DateTime();
    $fechaHoraGeneracion = new DateTime($this->fechaHoraGeneracion);
    $diferenciaDias = $fechaHoraGeneracion->diff($fechaActual);

    return $diferenciaDias->days < Contrato::MaximoDiasEdicion;
  }

  //con este titulo se descargará y guardará
  public function getTituloContrato()
  {
    $msjAnulado = '';
    if ($this->estaAnulado())
      $msjAnulado = ' ANULADO';


    //el mb es pq por alguna razón si lo quito, las tildes se paltean en el PDF xd
    return mb_strtoupper($this->codigo_unico . $msjAnulado . ' - ' . $this->apellidos);
  }


  public function getEmpleadoCreador(): Empleado
  {
    return Empleado::findOrFail($this->codEmpleadoCreador);
  }

  public function getNombreCompleto()
  {

    return $this->nombres . " " . $this->apellidos;
  }

  //APELLIDOS_NOMBRES
  public function getNombreCompletoAN()
  {
    return $this->apellidos . " " . $this->nombres;
  }

  function getFechaHoraEmision()
  {
    return Fecha::formatoFechaHoraParaVistas($this->fechaHoraGeneracion);
  }


  function getFechaInicio()
  {
    return Fecha::formatoParaVistas($this->fecha_inicio_contrato);
  }

  function getFechaFin()
  {
    return Fecha::formatoParaVistas($this->fecha_fin_contrato);
  }
  function getMoneda()
  {
    return Moneda::findOrFail($this->codMoneda);
  }



  public function getSexo()
  {
    if ($this->sexo == 'M')
      return "MASCULINO";
    else
      return "FEMENINO";
  }

  function getFechaInicioEscrita()
  {
    return Fecha::escribirEnTexto($this->fecha_inicio_contrato);
  }
  function getFechaFinEscrita()
  {
    return Fecha::escribirEnTexto($this->fecha_fin_contrato);
  }

  function getFechaGeneracionEscrita()
  {

    return Fecha::escribirEnTexto($this->fechaHoraGeneracion);
  }



  public function sePuedeAnular()
  {
    if ($this->estaAnulado()) //si ya se anuló, entonces no
      return false;

    $emp = Empleado::getEmpleadoLogeado();
    return $this->codEmpleadoCreador == $emp->codEmpleado; //si no se anuló y el eemp logeado es el que lo creó

  }


  public function estaAnulado() : bool
  {
    return !is_null($this->fechaHoraAnulacion);
  }

  function getFechaAnulacion()
  {
    return Fecha::escribirEnTexto($this->fechaHoraAnulacion);
  }

  public function esBorrador() : bool {
    return $this->es_borrador == 1;
  }
}

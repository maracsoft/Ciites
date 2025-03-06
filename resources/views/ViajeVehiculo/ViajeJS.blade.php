var date_config = {
  format: 'dd/mm/yyyy',
  autoclose: true,
  calendarWeeks: false,
  todayHighlight: true,
  endDate: "0d",
};


function validarFormViaje() {
  let msj = "";
  limpiarEstilos(['codEmpleadoAprobador', 'motivo', 'fecha_salida', 'lugar_origen', 'lugar_destino', 'kilometraje_salida']);

  msj = hour_selector_salida.validar(msj);
  msj = validarTamañoMaximoYNulidad(msj, "motivo", 1000, "Motivo");
  msj = validarSelect(msj, "codEmpleadoAprobador", "", "Aprobador");
  msj = validarNulidad(msj, "fecha_salida", "Fecha Salida");

  msj = validarPositividadYNulidad(msj, "kilometraje_salida", "Kilometraje de salida");
  msj = validarTamañoMaximoYNulidad(msj, "lugar_origen", 100, "Lugar de origen");
  msj = validarTamañoMaximoYNulidad(msj, "lugar_destino", 100, "Lugar de destino");
  msj = validarTamañoMaximo(msj, "observaciones_salida", 1000, "Observaciones salida");


  const cb = document.getElementById("declaro_estar_apto");
  if (cb) {
    if (!cb.checked) {
      msj = "Debe declarar que está apto fisicamente para realizar al viaje";
    }
  }


  return msj;
}
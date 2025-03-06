/* ARCHIVO DE CLASE JAVASCRIPT DEL COMPONENTE ASYNC FILE 
Solo se debe llamar una vez a este archivo, ya que es una clase plantilla
Al definir al constructor el name y el CodTipoArchivoGeneral es que se configura el objeto
*/
class HourSelector {


  constructor(name) {
    if (name == null) {
      throw new Error("El nombre del componente no puede ser nulo");
    }

    let padre_id = "div_" + name;
    verificarExistenciaElementoYTirarError(padre_id)
    this.Padre = document.getElementById(padre_id);


    this.InputHora = this.Padre.querySelector('input.hora');
    this.InputMinuto = this.Padre.querySelector('input.minuto');



    this.InputHora.addEventListener("change", this.handleChangeHora);
    this.InputMinuto.addEventListener("change", this.handleChangeMinuto);

    this.BotonAM = this.Padre.querySelector('button.boton_hora_selector.am');
    this.BotonPM = this.Padre.querySelector('button.boton_hora_selector.pm');

    this.BotonAM.addEventListener("click", this.activarAM);
    this.BotonPM.addEventListener("click", this.activarPM);

    this.InputResult = this.Padre.querySelector('input.hour_selector_result');
  }


  handleChangeHora = () => {
    let hora = this.InputHora.value;
    if (hora == "") {
      hora = 0;
    }

    //limitamos al maximo valor
    hora = parseInt(hora) % 12;
    this.InputHora.value = hora.toString().padStart(2, '0');

    this.actualizarResultado();
  }
  handleChangeMinuto = () => {
    let min = this.InputMinuto.value;
    if (min == "") {
      min = 0;
    }

    //limitamos al maximo valor
    min = parseInt(min) % 60;

    this.InputMinuto.value = min.toString().padStart(2, '0');
    this.actualizarResultado();
  }

  actualizarResultado = () => {
    let add = 0;
    if (this.esPm()) {
      add = 12;
    }

    let horas = add + parseInt(this.InputHora.value);
    horas = horas.toString().padStart(2, '0');
    let minutos = this.InputMinuto.value;
    minutos = minutos.toString().padStart(2, '0');


    this.InputResult.value = horas + ":" + minutos + ":00";
    this.Padre.title = this.InputResult.value;
  }

  activarAM = () => {

    this.BotonAM.classList.add("active");
    this.BotonPM.classList.remove("active");
    this.actualizarResultado();
  }
  activarPM = () => {

    this.BotonAM.classList.remove("active");
    this.BotonPM.classList.add("active");

    this.actualizarResultado();
  }


  esPm = () => {
    return this.BotonPM.classList.contains("active");
  }
  esAm = () => {
    return this.BotonAM.classList.contains("active");
  }


  ponerRojoHora = () => {
    this.InputHora.classList.add("error");
  }
  quitarRojoHora = () => {
    this.InputHora.classList.remove("error");
  }

  ponerRojoMinuto = () => {
    this.InputMinuto.classList.add("error");
  }
  quitarRojoMinuto = () => {
    this.InputMinuto.classList.remove("error");
  }


  /* ********** FUNCIONES PARA USO EXTERNO *********** */
  /* ********** FUNCIONES PARA USO EXTERNO *********** */
  /* ********** FUNCIONES PARA USO EXTERNO *********** */
  /* ********** FUNCIONES PARA USO EXTERNO *********** */
  /* ********** FUNCIONES PARA USO EXTERNO *********** */
  /* ********** FUNCIONES PARA USO EXTERNO *********** */

  validar = (msj_error) => {
    this.quitarRojoHora();
    this.quitarRojoMinuto();
    let msj = "";

    if (this.InputHora.value == "") {
      msj = "No ha ingresado la hora";
      this.ponerRojoHora();
    }

    if (this.InputMinuto.value == "") {
      msj = "No ha ingresado el minuto";
      this.ponerRojoMinuto();
    }

    /* si el msj_error tiene contenido, retorna el mismo */
    if (msj_error != '') {
      return msj_error;
    }

    // si no retorna el generado aqui

    return msj;
  }


  /* esta funcion se llama externamente cuando estamos en modo edicion y la hora ya existe 
    tipo = am/pm
  */
  setHora(hora, minuto, tipo) {
    this.InputHora.value = hora;
    this.InputMinuto.value = minuto;
    if (tipo == "pm") {
      this.activarPM();
    } else {
      this.activarAM();
    }

    this.handleChangeHora();
    this.handleChangeMinuto();

  }

  /* llega un formato 05:00:00 */
  setHoraFormatoSql(sql_time) {
    let arr = sql_time.split(":");

    let hora_24 = arr[0];
    let minuto = arr[1];

    let hora;
    let tipo = "";
    if (hora_24 >= 12) {
      hora = hora_24 - 12;
      tipo = "pm";
    } else {
      hora = hora_24;
      tipo = "am";
    }

    this.InputHora.value = hora;
    this.InputMinuto.value = minuto;
    if (tipo == "pm") {
      this.activarPM();
    } else {
      this.activarAM();
    }

    this.handleChangeHora();
    this.handleChangeMinuto();
  }

}
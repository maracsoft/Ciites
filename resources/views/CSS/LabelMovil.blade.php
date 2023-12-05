<style>

.label_movil_container{
    position: relative;
    margin: 5px 0px;
  }



  .label_movil {
    position: absolute;

    padding: 2px 10px;

    text-transform: uppercase;
    line-height: 6pt;
    font-weight: 500 !important;
    margin-bottom: 0px !important;
    cursor: text;
    transition: all 0.1s ease;
    border-radius: 10px;
    z-index: 10;

    -webkit-user-select: none; /* Safari */
    -ms-user-select: none; /* IE 10 and IE 11 */
    user-select: none; /* Standard syntax */
  }

  /* Modo ARRIBA O FOCUSEADO */
  /* Selecciona a los  label_movil que están inmediatamente despues de un input que sí tiene contenido  */
  .form-control:not(:placeholder-shown) ~ .label_movil,
  .form-control:focus ~ .label_movil
  {
    top: 0px;
    left: 10px;
    margin-top: -5px;
    font-size: 9pt;
    color: #a9a9a9;
    background-color: #ffffff;
  }

  /* Modo abajo (dentro del input) */
  /* Selecciona a los  label_movil que están inmediatamente despues de los inputs que no tienen contenido */
  .form-control:not(:focus):placeholder-shown ~ .label_movil
  {
    top: 12px;
    left: 6px;
    font-size: 11pt;
    background-color: #ffffff00;
    color: #adadad;
  }



  /* CON ERRORES */
  /* Modo arriba */
  /* Selecciona a los label_movil que están inmediatamente despues de un input con error en el sí que hay contenido  */
  .form-control-undefined:not(:placeholder-shown) ~ .label_movil  {
    background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 5%, rgba(255,255,255,1) 95%, rgba(191,13,13,0) 100%);
  }


  /* tanto arriba como abajo */
  /* Selecciona a los label_movil que están inmediatamente despues de un input con error */
  .form-control-undefined ~ .label_movil  {
    color:#ff5757 !important;
  }
</style>

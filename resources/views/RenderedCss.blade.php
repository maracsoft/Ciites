<style>
  .fondoPlomoCircular {
    border-radius: 10px;
    background-color: rgb(190, 190, 190);
  }

  .fontSize6 {
    font-size: 6pt;
  }

  .fontSize7 {
    font-size: 7pt;
  }

  .fontSize8 {
    font-size: 8pt;
  }

  .fontSize9 {
    font-size: 9pt;
  }

  .fontSize10 {
    font-size: 10pt;
  }

  .fontSize11 {
    font-size: 11pt;
  }

  .fontSize12 {
    font-size: 12pt;
  }

  .fontSize13 {
    font-size: 13pt;
  }

  .fontSize14 {
    font-size: 14pt;
  }

  .fontSize15 {
    font-size: 15pt;
  }

  .fontSize16 {
    font-size: 16pt;
  }

  .fontSize17 {
    font-size: 17pt;
  }

  .fontSize18 {
    font-size: 18pt;
  }

  .fontSize19 {
    font-size: 19pt;
  }

  .tabla-detalles {
    min-width: 800px;
  }

  .tabla-detalles th {
    padding: 5px;
  }

  .notificacionXRendir {
    background-color: rgb(87, 180, 44);
  }

  .notificacionObservada {
    background-color: rgb(209, 101, 101);
  }

  .form-control-undefined {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: 0 0 5px 3px rgba(220, 53, 69, 0.6);
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }

  .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url("/img/espera.gif") 50% 50% no-repeat rgb(249, 249, 249);
    background-size: 10%;
    opacity: 0.8;
  }

  .hovered:hover {
    background-color: rgb(97, 170, 170);
    border-radius: 3px;
  }

  .naranjaPrueba {
    background-color: orange;
  }

  .verdePrueba {
    background-color: rgb(0, 255, 55);
  }

  .letraRoja {
    color: #ff4444;
  }

  .letraVerde {
    color: rgb(58, 255, 58);
  }

  .letraAmarilla {
    color: rgb(255, 255, 96);
  }

  .internalPadding-1>* {
    padding: 0.15rem;
  }

  .hidden {
    display: none;
  }

  .fondoBlanco {
    background-color: white !important;
  }

  tr.FilaPaddingReducido td {
    padding: 0.3rem;
  }

  .rows_count {
    color: #495057;
    background-color: #ced4da;
    border-radius: 7px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 7px;
    padding-bottom: 5px;
  }

  .table-container {
    overflow-x: auto;
    padding-bottom: 20px;
  }

  .rows_count span {
    font-weight: 800;
  }

  .label_puestos {

    margin: -2px;
    padding: 0px;
    font-size: 10pt;
    font-weight: 500 !important;
  }

  .nombrecompleto-usuario {
    color: #777777;
    font-size: smaller;
    font-weight: 800;
  }


  .cursor-pointer {
    cursor: pointer;
  }

  .cursor-move {
    cursor: move;
  }


  .page-title {
    text-align: center;
    background-color: #cee7e7;
    color: black;
    padding: 10px;
    font-size: 15pt;
    font-weight: 700;
    text-transform: uppercase;

    border-radius: 5px;
  }

  .table-marac-header {
    background-color: #3e8bb7;
    color: #fff;
  }


  /* Código para que el fomr-control-undefined también pinte a los select2 de bootstrap */
  select.form-control.form-control-undefined+button.dropdown-toggle {
    box-shadow: 0 0 5px 3px rgba(220, 53, 69, 0.6);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
  }

  input.cb_big[type="checkbox"] {
    width: 35px;
    height: 35px;
  }

  input.cb_medium[type="checkbox"] {
    width: 25px;
    height: 25px;
  }

  .msj_parametros_faltantes {
    max-width: 200px;
    font-size: 10pt;
    background-color: red;
    padding: 11px;
    border-radius: 9px;
    margin: auto;
  }


  .nombre-entorno {

    color: white;
    font-size: 10pt;
    background-color: #bb0000;

    padding: 5px 10px;
    font-weight: 900;
    text-transform: uppercase;
    text-align: center;
    width: 100%;
  }


  .modal-2xl {
    max-width: 1300px;
  }

  .image-logo-container {
    background-color: white;
    margin-right: -8px;
    margin-left: -8px;

  }




  .nav-pills .nav-link:not(.active):hover {
    color: #215eb3;
    background-color: #efefef;
  }

  aside.main-sidebar {
    background-color: white;
  }

  li.nav-item.has-treeview li.nav-item {
    margin-left: 12px;
  }


  .label_movil_container{
    position: relative;
    margin: 5px 0px;
  }



  .label_movil {
    position: absolute;

    padding: 2px 10px;

    text-transform: uppercase;
    line-height: 8pt;
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

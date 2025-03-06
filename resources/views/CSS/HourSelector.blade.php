<style>
  .hour_selector_container {}

  .hour_selector_container input {
    border: 0px;
    background-color: transparent;
    border: 1px solid #c1c6ca;
    border-radius: 5px;
    text-align: center;
    color: #565656;
    font-weight: bold;
    padding: 0px;
  }

  .hour_selector_container input:focus {
    outline: none
  }


  .hour_selector_container input.error {
    box-shadow: 0 0 5px 3px rgba(220, 53, 69, 0.6);
  }

  .boton_hora_selector {
    border: 1px solid #d7d7d7;
    border-radius: 6px;
  }

  .boton_hora_selector:focus {
    outline: none;
  }

  .boton_hora_selector.active {
    background-color: #0061e0;
    color: white;
  }


  .hour_selector_container .puntos_separadores {
    font-size: 13pt;
    padding: 0px 5px;
  }
</style>

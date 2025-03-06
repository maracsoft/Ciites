@php
  /*
  el name debe coincidir con el name cuando se llama a new HourSelector
  Esta vista se debe llamar por cada file que se quiera cargar, siempre con un name distinto en la pagina
  para obtenerlo del controller usar request->get('hour_selector_' y el name)
  */
@endphp

<div id="div_{{ $name }}" class="hour_selector_container" title="">

  <div class="d-flex ">

    <div class="d-flex">
      <input class="hora" placeholder="" type="number" min="0" max="11">
      <div>
        <span class="puntos_separadores">:</span>
      </div>

      <input class="minuto" placeholder="" type="number" min="0" max="59">
    </div>


    <button type="button" class="boton_hora_selector am mx-1 active">
      AM
    </button>
    <button type="button" class="boton_hora_selector pm">
      PM
    </button>

  </div>

  <div class="hidden">

    {{-- input text que contiene la hora una vez que se selecciona --}}
    <input type="text" class="hour_selector_result" name="hour_selector_{{ $name }}" class="">
  </div>

</div>

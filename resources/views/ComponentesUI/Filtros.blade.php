@php
  $desplegable = new App\UI\UIDesplegable('Filtrar');

@endphp

@if ($hacerDesplegable)
  {{ $desplegable->renderOpen() }}
@endif


<form action="" name="filtros_form_{{ $r }}">

  <div class="d-flex flex-row align-items-end m-2 filter_container flex-wrap" id="componente_filtros_{{ $r }}">

    @php
      $i = 0;
    @endphp
    @foreach ($filtros as $filtro)
      @php
        $modificadorTamaño = '';
        if ($filtro['size'] != '') {
            $modificadorTamaño = 'form-control-' . $filtro['size'];
        }

        $styles = '';
        if ($filtro['max_width'] != '') {
            $styles .= 'max-width: ' . $filtro['max_width'] . ' ;';
        }

        $name = $filtro['name'] . '.' . $filtro['function'];
        $id = $name . '_' . $r;

        $filtro['value'] = '';
        if (array_key_exists($filtro['name'], $filtros_usados)) {
            //Verificamos si en los filtros usados actualmente está incluido este filtro, si sí -> le asignamos el valor que viene en la URL
            $filtro['value'] = $filtros_usados[$filtro['name']];
        }
      @endphp
      <div class="m-1">

        @if ($filtro['show_label'])
          <label for="" class="fontSize10 mb-0">
            {{ $filtro['label'] }}
          </label>
        @endif


        @switch($filtro['type'])
          @case('text')
            <input type="text" class="form-control {{ $modificadorTamaño }}" id="{{ $id }}"
              value="{{ $filtro['value'] }}" placeholder="{{ $filtro['placeholder'] }}">
          @break

          @case('select')
            <select style="{{ $styles }}" class="form-control {{ $modificadorTamaño }}" id="{{ $id }}">
              <option value="">
                {{ $filtro['placeholder'] }}
              </option>

              @foreach ($filtro['options'] as $option)
                @php

                  if (is_null($filtro['options_id_field'])) {
                      //si no se le indicó nada, usara el getId() porque es un modelo de laravel

                      $actual_id = $option->getId();
                  } else {
                      //si se le indicó que hay un campo para usar de id
                      $actual_id = $option[$filtro['options_id_field']];
                  }
                @endphp
                <option value="{{ $actual_id }}" title="{{ $option[$filtro['options_label_field']] }}"
                  @if (strval($filtro['value']) == strval($actual_id)) selected @endif>
                  {{ $option[$filtro['options_label_field']] }}
                </option>
              @endforeach
            </select>
          @break

          @case('select2')
            <div style="{{ $styles }}">
              <select id="{{ $id }}" data-select2-id="-1" tabindex="-1" aria-hidden="true"
                data-live-search="true"
                class="fondoBlanco form-control  {{ $modificadorTamaño }} select2 select2-hidden-accessible selectpicker">

                <option value="">
                  {{ $filtro['placeholder'] }}
                </option>
                @foreach ($filtro['options'] as $option)
                  @php
                    if (is_null($filtro['options_id_field'])) {
                        //si no se le indicó nada, usara el getId() porque es un modelo de laravel
                        $actual_id = $option->getId();
                    } else {
                        //si se le indicó que hay un campo para usar de id
                        $actual_id = $option[$filtro['options_id_field']];
                    }
                  @endphp

                  <option value="{{ $actual_id }}" title="{{ $option[$filtro['options_label_field']] }}"
                    @if (strval($filtro['value']) == strval($actual_id)) selected @endif>
                    {{ $option[$filtro['options_label_field']] }}
                  </option>
                @endforeach

              </select>

            </div>
          @break

          @case('date_interval')
            @php
              $date_start = '';
              $date_end = '';

              if ($filtro['value'] != '') {
                  $date_start = explode(',', $filtro['value'])[0];
                  $date_end = explode(',', $filtro['value'])[1];
              }
            @endphp
            <div class="d-flex flex-row">

              <div class="input-group date form_date mr-1" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control form-control-sm w-date" id="{{ $id }}_start"
                  value="{{ $date_start }}" placeholder="Inicio">
                <div class="input-group-btn d-flex flex-col align-items-center">
                  <button class="btn btn-primary btn-sm date-set" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

              <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                <input type="text" class="form-control form-control-sm w-date" id="{{ $id }}_end"
                  value="{{ $date_end }}" placeholder="Fin">
                <div class="input-group-btn d-flex flex-col align-items-center">
                  <button class="btn btn-primary btn-sm date-set" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </div>
              </div>

            </div>
          @break

          @case('multiple_select')
            @php
              $new_name = $filtro['name'] . '_' . $filtro['function'];
              $selectMult = new App\UI\UISelectMultiple([], $filtro['value'], $new_name, $filtro['placeholder'], false, 30);
              $selectMult->setOptionsWithModel($filtro['options'], $filtro['options_label_field']);

              $filtros[$i]['select_multiple_id'] = $selectMult->getId();

            @endphp

            {{ $selectMult->render() }}
          @break

          @default
        @endswitch

      </div>
      @php
        $i++;
      @endphp
    @endforeach

    <div class="align-bottom mb-1">
      <button class="btn btn-success btn-sm m-1" title="Buscar" type="button"
        onclick="clickSubmit_{{ $r }}()">
        <i class="fas fa-search"></i>
      </button>
      <button class="btn btn-success btn-xs" title="Borrar filtros" type="button"
        onclick="clickRestart_{{ $r }}()">
        <i class="fas fa-trash"></i>
      </button>
    </div>



  </div>
</form>
@if ($hacerDesplegable)
  {{ $desplegable->renderClose() }}
@endif

@include('Layout.ValidatorJS')
<script>
  function clickSubmit_{{ $r }}() {

    msj = validateForm_{{ $r }}();
    if (msj != "") {
      alerta(msj);
      return;
    }


    var query_url = getQueryUrl_{{ $r }}();

    console.log("query_url", query_url)


    var urlActualSinFiltros = window.location.pathname;
    location.href = urlActualSinFiltros + "?" + query_url

  }


  function clickRestart_{{ $r }}() {
    var urlActualSinFiltros = window.location.pathname;
    location.href = urlActualSinFiltros;


  }


  function getQueryUrl_{{ $r }}() {


    var query_array = [];


    @foreach ($filtros as $filtro)
      @php
        $name = $filtro['name'] . '.' . $filtro['function'];
        $id = $name . '_' . $r;
      @endphp

      var type = "";
      type = "{{ $filtro['type'] }}";
      direct_search = {{ $filtro['direct_search'] ? 'true' : 'false' }};


      /* different ways  To obtain the values */
      @switch($filtro['type'])
        @case('date_interval')
        var actual_value = document.getElementById('{{ $id }}_start').value + "," + document.getElementById(
          '{{ $id }}_end').value
        @break

        @case('multiple_select')
        var actual_value = document.getElementById("{{ $filtro['select_multiple_id'] }}").value;
        actual_value = actual_value
        console.log("actual_value", actual_value)
        @break

        @default
        var actual_value = document.getElementById('{{ $id }}').value
      @endswitch



      if (type == "date_interval") {
        if (actual_value != ",") {
          query_array.push("{{ $filtro['name'] }}.{{ $filtro['function'] }}=" + actual_value)
        }
      } else {
        if (actual_value != "") {
          if (direct_search) { // direct search case
            query_array.push("{{ $filtro['name'] }}.direct_search=" + actual_value)
          } else { //Normal case
            query_array.push("{{ $filtro['name'] }}.{{ $filtro['function'] }}=" + actual_value)
          }

        }


      }
    @endforeach

    var query_url = query_array.join("&");

    return query_url;
  }

  function validateForm_{{ $r }}() {

    msj = "";


    @foreach ($filtros as $filtro)
      @php
        $name = $filtro['name'] . '.' . $filtro['function'];
        $id = $name . '_' . $r;
      @endphp

      var type = "";
      type = "{{ $filtro['type'] }}";



      @switch($filtro['type'])
        @case('date_interval')
        /* Validamos fechas */

        msj = validarFechaAnterior(msj, '{{ $id }}_start', '{{ $id }}_end',
          "La fecha inicial debe ser menor que la final");
        @break

        @default
        @break
      @endswitch
    @endforeach

    return msj;


  }


  /* esta lista solo son los form_control */
  const listaFiltros = document.querySelectorAll('#componente_filtros_{{ $r }} .form-control')
  listaFiltros.forEach(input => {

    input.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        event.preventDefault();
        clickSubmit_{{ $r }}();
      }
    });

  });
</script>

<style>
  .w-date {
    width: 100px;

    text-align: center;
  }

  .filter_container {
    background-color: #d4d4d4;
    border-radius: 5px;
    padding: 4px;

  }
</style>

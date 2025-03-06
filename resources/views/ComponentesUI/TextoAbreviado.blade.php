@if ($texto_completo != $texto_abreviado)
  <div class="abreviar_texto cursor-pointer" onclick="mostrarTextoCompleto(this,`{{$texto_completo}}`)">
    <div>
      {{$texto_abreviado}}
    </div>
    <span class="">
      Click para ver más
    </span>
  </div>

@else
  {{$texto_abreviado}}
@endif

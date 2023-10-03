
@if (session('datos'))
<div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert" id="msjEmergenteDatos">
    {{session('datos')}}
  <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true"> &times;</span>
  </button>
  @php
    session(['datos' => null]);
  @endphp
</div>
@endif


@if (session('datos_ok'))
  <div class ="alert alert-success alert-dismissible fade show mt-3" role ="alert" id="msjEmergenteDatos">
    {{session('datos_ok')}}
    <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true"> &times;</span>
    </button>
    
  </div>
@endif


@if (session('datos_error'))
  <div class ="alert alert-danger alert-dismissible fade show mt-3" role ="alert" id="msjEmergenteDatos">
    {{session('datos_error')}}
    <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true"> &times;</span>
    </button>
    
  </div>
@endif

<div class="card">
  <div class="card-header d-flex ">
    <div class="font-weight-bold">
      Información General
    </div>
    <div class="ml-auto fontSize10">
      Registrado el {{ $viaje->getFechaHoraRegistro() }}
    </div>
  </div>
  <div class="card-body">
    <div class="row">


      <div class="col-12 col-sm-3">
        <label class="mb-0" for="">
          Conductor
        </label>
        <input type="text" class="form-control text-center" value="{{ $viaje->getEmpleadoRegistrador()->getNombreCompleto() }}" readonly>
      </div>




      <div class="col-12 col-sm-3">
        <label class="mb-0" for="">
          Vehículo
        </label>
        <input type="text" class="form-control text-center" value="{{ $vehiculo->getDescripcion() }}" readonly>
      </div>


      <div class="col-12 col-sm-3">
        <label class="mb-0" for="">
          Aprobador
        </label>
        <input type="text" class="form-control text-center" value="{{ $viaje->getEmpleadoAprobador()->getNombreCompleto() }}" readonly>
      </div>


      <div class="col-12 col-sm-3">
        <label class="mb-0" for="">
          Estado
        </label>
        <input type="text" class="form-control text-center" value="{{ $viaje->getEstado()->nombreAparente }}"
          title="{{ $viaje->getEstado()->descripcion }}" readonly>
      </div>



    </div>
  </div>
</div>


<div class="card">
  <div class="card-header d-flex ">
    <div class="font-weight-bold">
      Información de Salida
    </div>
  </div>
  <div class="card-body">
    <div class="row">



      <div class="col-12 col-xl-2 mt-1 mt-sm-0">
        <label class="mb-0" for="">
          Km. Salida
        </label>
        <input type="text" class="form-control text-right" value="{{ $viaje->kilometraje_salida }}" readonly>
      </div>


      <div class="col-12 col-xl-2  mt-1 mt-sm-0">
        <label class="mb-0" for="">
          F. Salida
        </label>
        <input type="text" class="form-control text-center px-1" value="{{ $viaje->getFechaSalida() }}" autocomplete="off" readonly>
      </div>


      <div class="col-12 col-xl-2  mt-1 mt-sm-0">
        <label class="mb-0" for="">
          Hora Salida
        </label>
        <input type="text" class="form-control text-center px-1" value="{{ $viaje->getHoraSalida() }}" autocomplete="off" readonly>

      </div>

      <div class="col-12 col-xl-3  mt-1 mt-sm-0">
        <label class="mb-0" for="">
          Motivo
        </label>
        <textarea class="form-control" rows="2" autocomplete="off" readonly>{{ $viaje->motivo }}</textarea>

      </div>

      <div class="col-12 col-xl-3  mt-1 mt-sm-0">
        <label class="mb-0" for="">
          Observaciones Salida
        </label>
        <textarea class="form-control" rows="2" readonly>{{ $viaje->observaciones_salida }}</textarea>

      </div>



      <div class="col-12 col-sm-2  mt-1 mt-sm-0">
        <label class="mb-0" for="">
          Lugar de origen
        </label>
        <input class="form-control" value="{{ $viaje->lugar_origen }}" readonly />
      </div>


      <div class="col-12 col-sm-2  mt-1 mt-sm-0">
        <label class="mb-0" for="">
          Lugar de destino
        </label>
        <input class="form-control" value="{{ $viaje->lugar_destino }}" readonly />
      </div>



    </div>
  </div>
</div>





<div class="card">
  <div class="card-header d-flex ">
    <div class="font-weight-bold">
      Información de Llegada
    </div>
  </div>
  <div class="card-body">

    @if ($viaje->estaFinalizado())
      <div class="row">

        <div class="col-12 col-xl-2  mt-3 mt-sm-0">
          <label class="mb-0" for="">
            Km. Llegada
          </label>
          <input type="number" class="form-control text-right" value="{{ $viaje->kilometraje_llegada }}" readonly>
        </div>



        <div class="col-12 col-xl-2  mt-3 mt-sm-0">
          <label class="mb-0" for="">
            Km Recorridos
          </label>
          <input type="number" class="form-control text-right" value="{{ $viaje->kilometraje_recorrido }}" readonly>
        </div>

        <div class="col-12 col-xl-2  mt-1 mt-sm-0">
          <label class="mb-0" for="">
            F. Llegada
          </label>
          <input type="text" class="form-control text-center px-1" value="{{ $viaje->getFechaLlegada() }}" placeholder="dd/mm/aaaa"
            readonly>

        </div>

        <div class="col-12 col-xl-2  mt-1 mt-sm-0">
          <label class="mb-0" for="">
            Hora Llegada
          </label>
          <input type="text" class="form-control text-center px-1" value="{{ $viaje->getHoraLlegada() }}" autocomplete="off"
            readonly>
        </div>



        <div class="col-12 col-xl-2  mt-1 mt-sm-0">
          <label class="mb-0" for="">
            Código Factura Combustible
          </label>

          <input type="text" class="form-control text-center" value="{{ $viaje->codigo_factura_combustible }}"
            placeholder="N° Serie" readonly>


        </div>



        <div class="col-12 col-xl-2  mt-1 mt-sm-0">
          <label class="mb-0" for="">
            Monto Gastado Soles
          </label>
          <input type="number" class="form-control text-right" value="{{ $viaje->monto_factura_combustible }}"
            placeholder="Monto Soles" readonly>
        </div>

        <div class="col-12 col-xl-2  mt-3 mt-sm-0">
          <label class="mb-0" for="">
            Rendimiento en Km/Sol
          </label>
          <input type="number" class="form-control text-right" value="{{ $viaje->rendimiento }}" readonly>
        </div>

        <div class="col-12 col-xl-9  mt-1 mt-sm-0">
          <label class="mb-0" for="">
            Observaciones Llegada
          </label>
          <textarea class="form-control" rows="2" readonly>{{ $viaje->observaciones_llegada }}</textarea>

        </div>




      </div>
    @else
      <div class="p-2 text-center">
        Información no registrada
      </div>
    @endif




  </div>

</div>

<div class="row">
  <div class="col-12 col-sm-9"></div>
  <div class="col-12 col-sm-3">

    <div class="card">
      <div class="card-body text-center">
        <a class="btn btn-primary btn-sm" href="{{ route('ViajeVehiculo.Pdf.Descargar', $viaje->getId()) }}">
          Descargar PDF
          <i class="fas fa-file-pdf"></i>
        </a>
        <a class="btn btn-primary btn-sm" href="{{ route('ViajeVehiculo.Pdf.Ver', $viaje->getId()) }}">
          Ver PDF
          <i class="fas fa-file-pdf"></i>
        </a>


      </div>

    </div>

  </div>
</div>

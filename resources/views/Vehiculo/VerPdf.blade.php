<!DOCTYPE html>
<html lang="en">

<head>
  <title>Impresion de QR {{ $vehiculo->placa }}</title>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style>
    html {
      /* Arriba | Derecha | Abajo | Izquierda */
      margin: 0px;
      font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
    }


    .qr_image {
      width: 200px;
      height: 200px;
    }

    .placa {
      font-size: 25pt;
      margin-bottom: 10pt;
      font-weight: bold;
    }

    .datos {
      font-size: 20pt;
      margin-bottom: 10pt;
    }

    .container_limitante {
      padding: 50px;
      width: 300px;
      height: 450px;

      border: 1px solid rgb(206, 206, 206);
    }

    .mensaje {
      margin-top: 20px;
    }

    .redirije {
      font-size: 8pt;
      color: rgb(182, 182, 182);
      margin-top: 10pt;
    }
  </style>

  @include('CSS.PdfUtils')
</head>

<body>

  <div class="container_limitante">
    <div class="text-center">
      <div class="placa">
        {{ $vehiculo->placa }}
      </div>
      <div class="datos">

        {{ $vehiculo->modelo }} {{ $vehiculo->color }}
      </div>

      <div>
        <img class="qr_image" src="data:image;base64,{{ base64_encode($qr_svg) }}" />
      </div>

      <div class="mensaje">
        Puede escanear este QR para registrar en el sistema la salida de este vehículo.
      </div>

      <div class="redirije">
        {{ $vehiculo->getUrlRegistroViaje() }}
      </div>
    </div>
  </div>




</body>

</html>

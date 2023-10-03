<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8"/>
     <title>CEDEPAS Norte | Login</title>
	 <link rel="shortcut icon" href="/img/LogoCedepas.png" type="image/png">
  
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta content="width=device-width, initial-scale=1.0" name="viewport"/>      
     <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
     <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
     <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  
      @include('EstilosLogin')
</head>
<div class="conteiner">

	
	
    <br>
<div class="login-wrap">
	

	<form method="POST" action="{{route('user.logearse')}}">
		@csrf  
		<div class="login-html">
			<input id="tab-1" type="radio" name="tab" class="sign-in" checked>
				<label for="tab-1" class="tab" style="font-size: xx-large">Iniciar Sesión</label>


			<input id="tab-2" type="radio" name="tab" class="sign-up">
				<label for="tab-2" class="tab"> </label>


			<div class="login-form">
				<div class="sign-in-htm">
					<div class="group">
						<label for="user" class="label" style="font-size: medium">Usuario</label>
						<input type="text" class="input @error('usuario') is-invalid @enderror" placeholder="Ingrese usuario" 
							id="usuario" name="usuario" value="{{old('usuario')}}">
						
						@error('usuario')
              <span class="invalid-feedback" role="alert" style="font-size: small">
                <strong>{{$message}}</strong>
              </span>
						@enderror
					</div>
					<div class="group container_password">
						<label for="pass" class="label" style="font-size: medium">Contraseña</label>
						<input placeholder="Ingrese contraseña"  id="password" name="password" type="password" class="input @error('password') is-invalid @enderror" data-type="password">
						
            <div class="ojo_clickeable" onclick="clickIconoOjo()" title="Mostrar contraseña">
              <i id="icono_ojo" class="fas fa-lg fa-eye"></i>
            </div>

            @error('password')
              <span class="invalid-feedback" role="alert" style="font-size: small">
                <strong>{{$message}}</strong>
              </span>
						@enderror


					</div>
				
					<div class="group">
						<input id="ingresar" name="ingresar" type="submit" class="button" value="Ingresar">
					</div>
					<div class="hr"></div>
				 
					@if (session('datos'))
						<div class ="alert alert-warning fade show" role ="alert" id="msjEmergenteDatos">
							{{session('datos')}}
						</div>
					@endif

					
				</div>
 
	
			</div>

			<div style="text-align: center">

				<img src="/img/LogoCedepas.png"
				width="200" height="140" >

			</div>
		</div>
		
	</form>


</div>
</div>
<script>

  const IconoOjo = document.getElementById('icono_ojo');
  const InputPassword = document.getElementById('password')
  var estado_ojo = "tachado"; //normal y tachado

  function clickIconoOjo(){
    if(estado_ojo=="tachado"){
      IconoOjo.className = "fas fa-eye-slash";
      estado_ojo = "normal";
      InputPassword.type = "text";
    }else{
      IconoOjo.className = "fas fa-eye";
      estado_ojo = "tachado";
      InputPassword.type = "password";
    }
    InputPassword.focus()
  }


</script>

<style>
  #icono_ojo{
    position: absolute;
    right: 0px;
    top: 13px;
    cursor: pointer;
     
  }
 

  .ojo_clickeable{
    /* background-color: #ff000026; */
    width: 40px;
    height: 40px;
    position: absolute;
    right: 21px;
    top: 31px;
    border-radius: 30px;
    color:#252525;
    cursor: pointer;
  }

  .ojo_clickeable:hover{
    color: #6d7479;
  }

  .container_password{
    position: relative;
  }
</style>

</html>
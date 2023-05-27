<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8"/>
     <title>CIITES | Login</title>
     <link rel="shortcut icon" href="/img/isologo.ico" type="image/png">
  
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta content="width=device-width, initial-scale=1.0" name="viewport"/>      
     <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
     <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
     <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
     <link  rel="stylesheet" href="public/uicons-regular-rounded/css/uicons-regular-rounded.css">
     
</head>
<body>

  <div class="main_container">
      
    <div class="row  row_reverse">
      <div class="col-12 col-sm-6 text-center hexagonal_container">
        <img class="hexagonal align-self-center" src="/img/LogoHexagonal.png" alt="">
      </div>
      <div class="col-12 col-sm-6 d-flex">

        <div class="box align-self-center mx-2 mx-sm-5" style="font-size:16pt;">
          <div class="box-header col-12 title">
            INICIAR SESIÓN
          </div>
          <div class="box-body">


            <form method="POST" action="{{route('user.logearse')}}">
              @csrf  


                  
              <div class="row">
                
                <div class="col-12">
                  <label for="user" class="label" style="">Usuario</label>
                  <input type="text" class="form-control form-control-lg input @error('usuario') is-invalid @enderror" placeholder="Ingrese usuario" 
                    id="usuario" name="usuario" value="{{old('usuario')}}">
                  
                  @error('usuario')
                  <span class="invalid-feedback" role="alert" style="font-size: small">
                    <strong>{{$message}}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-12">
                  <label for="pass" class="label" style="">Contraseña</label>
                  <input placeholder="Ingrese contraseña" id="password" name="password"
                    type="password" class="form-control form-control-lg input @error('password') is-invalid @enderror" data-type="password">
                  @error('password')
                  <span class="invalid-feedback" role="alert" style="font-size: small">
                    <strong>{{$message}}</strong>
                  </span>
                  @enderror

                </div>

                <div class="col-12">
                  <button id="ingresar" name="ingresar" type="submit" class="button-submit">
                    INGRESAR
                  </button>
                </div>

                <div class="col-12">

                  
                  @if (session('datos'))
                    <div class ="alert alert-warning fade show" role ="alert" id="msjEmergenteDatos">
                      {{session('datos')}}
                    </div>
                  @endif
                </div>

              </div>

            </form>     
            
          </div>  
            
        </div>
        
      </div>
      
      
    </div>

  </div>
</body>


<style>

  html{
    background-color: #1b3f78;
    
  }
  
  .main_container{
    background-color: #1b3f78;
    padding: 8px;
    height: 100vh;
  }

  .box-header{
    background: #12a4b4;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    padding: 9px;
    text-align: center;
    padding-bottom: 5px !important;
    border-bottom-width: 1px;
    font-weight: 900;
    border-bottom-style: solid;
    color: #e5e5e5;
  }
  .box-body{
    padding-top: 7px !important;
    background: white;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    padding: 30px;
  }
  

  .button-submit{
    border: none;
    padding: 15px 20px;
    border-radius: 25px;
    background: #7DAE46;
    width: 100%;
    color: #fff;
    display: block;
    font-size: 12pt;
    font-weight: bold;
    font-family: sans-serif;
    margin-top: 24px;
  }


  .hexagonal_container{
    padding: 20px;
    align-self: center;
  }

  
  @media(min-width:1000px){
    .hexagonal_container{
      padding: 50px;
    }
  }

  @media(min-width:500px){
    .hexagonal{
      width: 100%;
    }
  }

  @media(max-width:500px){
    .hexagonal{
      width: 200px;
    }
  }


  /* mobile */
  @media(max-width:575px){
    .row_reverse{
      flex-flow: wrap-reverse;
    }
    .main_container{
      display: flex;
      align-items: center;
 
    }
  }

  @media(min-width:575px){
    .row_reverse{
      height: 100vh;
    }
  }



  row_reverse
  .title{

  }
  
</style>
</html>
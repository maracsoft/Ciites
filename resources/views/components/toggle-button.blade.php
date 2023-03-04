@php
  
  $button_id = "togleButton_$r-$name";
  $circle_id = "circleButton_$r-$name";
  $inputValue_id = "inputValue_$r-$name";
  
  if($initialValue=="1")
    $initialClass = "On";
  else
    $initialClass = "Off";
@endphp
 
  <div class="CSS_SEP">
      

      <!-- Enabled: "bg-orange-500", Not Enabled: "bg-gray-200" -->
      <button id="{{$button_id}}" onclick="JS_SEP_toggle()" type="button" role="switch" aria-checked="true" class="baseButton button{{$initialClass}}">
          <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
          <span aria-hidden="true" id="{{$circle_id}}" class="circleBase circle{{$initialClass}}"></span>
      </button>

      <input type="{{App\Configuracion::getInputTextOHidden()}}" name="{{$name}}" id="{{$inputValue_id}}" value="{{$initialValue}}">
  
      
  </div>
 

<script>
  
  
  function JS_SEP_toggle(){
    const input = document.getElementById('{{$inputValue_id}}');
  
    var estado = JS_SEP_getState();

    JS_SEP_setState(!estado)


    @if($onChangeFunctionName != "")
      {{$onChangeFunctionName}}(input.value);
    @endif

  } 

  /* boolean = new_state */
  function JS_SEP_setState(new_state){
    const button = document.getElementById('{{$button_id}}');
    const circle = document.getElementById('{{$circle_id}}')
    const input = document.getElementById('{{$inputValue_id}}');
  
    if(new_state){
      button.className = "baseButton buttonOn";
      circle.className = "circleBase circleOn";
      input.value = 1;
    }else{
      button.className = "baseButton buttonOff";
      circle.className = "circleBase circleOff";
      input.value = 0;
    }

  }
  @if($setExternalValueFunctionName != "")
    function {{$setExternalValueFunctionName}}(state){
      JS_SEP_setState(!state);
      JS_SEP_toggle();
    }
  @endif


  function JS_SEP_getState(){
    const button = document.getElementById('{{$button_id}}');
    if(button.className.includes("buttonOn"))
      return true;

    return false;
  }


</script>

<style >
  .CSS_SEP .buttonOn{
    background-color: rgb(0 123 255) !important
  }
  .CSS_SEP .buttonOff{
    background-color: rgb(229 231 235) !important;       
  }
  .CSS_SEP .baseButton{
    padding: 0px;
   
    display: inline-flex;
     
    width: 3.75rem;
    border-style: solid;
    
    border-radius: 100px;
    border-width: 3px;
    border-color: #d5d5d5;     
       
    transition-duration: 200ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);

  }
  
  
  .CSS_SEP .baseButton:focus{
    outline: 0px;
  }
   

  .CSS_SEP .circleOff{
    transform: translateX(0rem);
  }

  .CSS_SEP .circleOn{
    transform: translateX(1.65rem);
  }

  .CSS_SEP .circleBase{

    height: 1.75rem;
    width: 1.75rem;
     
    border-radius: 9999px;
    --tw-bg-opacity: 1;
    background-color: rgb(255 255 255 / var(--tw-bg-opacity));
     
    transition-duration: 200ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
 

  }

 
</style>
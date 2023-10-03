<div id="CSS_SEP" class="">
   
  <input type="hidden" class="" name="{{$name}}" id="{{$id}}">
  <div class="d-flex flex-row">
  
    <div class="mb-0 selected_options_container flex-grow-1" id="container_{{$id}}">
      <div class="d-flex flex-row flex-wrap">
        <div id="selected_options_{{$id}}" class="d-flex flex-row  flex-wrap">
        </div>
        <input type="text" class="inside-input flex-grow-1 p-1" id="search_input_{{$id}}" oninput="JS_SEP_updateListFilter()" placeholder="{{$placeholder}}" onclick="JS_SEP_showOptions()" >
      </div>
      
    </div>

    @if($showCleanButton)
      <div class="d-flex flex-col">
        <button type="button" class="my-auto ml-1 btn btn-primary" onclick="JS_SEP_cleanSelecteds()">
          Limpiar
          <i class="fas fa-trash"></i>
        </button>
      </div>
    @endif
  
  </div>
  <div id="options_{{$id}}" class="options_container shadow  hidden py-2"> {{-- This hidden is togleable --}}
     {{-- This container is filled with javascript --}}
  </div>
</div>


<script>
  /* Avaible options that will be printed on the select */ 
  var JS_SEP_optionsList = @json($options)
  
  /* The options filtered by the text */
  var JS_SEP_showedOptionsList = [];
  
  /* The selected options objects and the selected ids */
  var JS_SEP_selectedOptions = [];
  var JS_SEP_selected_Ids = [];
  const JS_SEP_TEXT_MAX_LENGTH = {{$text_max_length}};

  JS_SEP_mounted();

  function JS_SEP_mounted(){



    document.addEventListener("click", JS_SEP_clickSomewhere);
    document.getElementById("search_input_{{$id}}").addEventListener("keyup", function(event) {
      if (event.keyCode === 13) {
        JS_SEP_pressedEnter();
      }
    });

    
    var incomeSelectedIds = [{{$selectedOptionsIds}}];
    for (let index = 0; index < incomeSelectedIds.length; index++) {
      var id = incomeSelectedIds[index]; 
      JS_SEP_selectOption(id);
      
    }
 
    JS_SEP_updateListFilter();


  }

   


  function JS_SEP_clickContainer(){
    JS_SEP_togleOptions();  
  }

  function JS_SEP_togleOptions(){
    const OptionsContainer = document.getElementById("options_{{$id}}");
    
    var isActive = !OptionsContainer.classList.contains("hidden");
    
    if(isActive)
      JS_SEP_hideOptions();
    else
      JS_SEP_showOptions();

  }
  function JS_SEP_showOptions(){
    const OptionsContainer = document.getElementById("options_{{$id}}");

    OptionsContainer.classList.remove("hidden")
     
  }

  function JS_SEP_hideOptions(){
    const OptionsContainer = document.getElementById("options_{{$id}}");

    OptionsContainer.classList.add("hidden")
     
  }

  function JS_SEP_selectOption(value){

    var selectedOption = JS_SEP_optionsList.find(e => e.value == value);
    console.log("Clicked option",selectedOption)

    JS_SEP_hideOptions();
    
    JS_SEP_selectedOptions.push(selectedOption)
    JS_SEP_selected_Ids.push(value.toString())

    
    JS_SEP_printOnInput();
    JS_SEP_updateListFilter();
  }
  function JS_SEP_deleteOption(value){
    console.log("click delete option",value)

    const index = JS_SEP_selected_Ids.indexOf(value.toString());
    if (index > -1) { // only splice array when item is found
      JS_SEP_selectedOptions.splice(index, 1); // 2nd parameter means remove one item only
      JS_SEP_selected_Ids.splice(index, 1); // 2nd parameter means remove one item only
      console.log("deleting index",index)  
    }else{
      console.log("delete option : value not finded")
    }
    
    JS_SEP_printOnInput();
    JS_SEP_updateListFilter();
  }

  /* Only list the options not selected and match with the  */
  function JS_SEP_updateListFilter(){
    const searchedText = document.getElementById("search_input_{{$id}}").value;
    JS_SEP_showedOptionsList = JS_SEP_optionsList.filter( 
        e => (
              e.text.toLowerCase().includes(searchedText.toLowerCase()) && 
              !JS_SEP_selected_Ids.includes(e.value.toString())
            )
    )
    JS_SEP_updateHTMLs();
  }
  
  
  
  function JS_SEP_updateHTMLs(){
    const OptionsContainer = document.getElementById("options_{{$id}}");
    var completeHTML = "";
    
    for (let index = 0; index < JS_SEP_showedOptionsList.length; index++) {
      const option = JS_SEP_showedOptionsList[index];
      completeHTML += /* */
      ` 
      <div onclick="JS_SEP_selectOption('`+option.value+`')" class="sm_option">
        `+option.text+`
        
      </div>
      `
    }
    if(JS_SEP_showedOptionsList.length == 0){
      completeHTML += 
      `
      <div class="sm_option">
        - No hay opciones disponibles - 
      </div>
      `
    }

    
    OptionsContainer.innerHTML = completeHTML;
     




    const SelectedOptionsContainer = document.getElementById("selected_options_{{$id}}");
    completeHTML = "";
    for (let index = 0; index < JS_SEP_selectedOptions.length; index++) {
      const option = JS_SEP_selectedOptions[index];
      var abreviatedText = abreviarString(option.text,JS_SEP_TEXT_MAX_LENGTH)
      completeHTML += 
      ` 
      <div class="selected-option" title="`+option.text+`">
        `+abreviatedText+`
        
        <span aria-hidden="true" class="equis px-1" onclick="JS_SEP_deleteOption('`+option.value+`')">
           
            <i class="fas fa-times"></i>
         
          
        </span>
      </div>
      `
    }


    
    SelectedOptionsContainer.innerHTML = completeHTML;
     
      



  }

  //This function is not independent
  function abreviarString(text,limit){
    if(text.length < limit)
      return text;
    
    return text.substr(0,limit) + "...";
  }


  function JS_SEP_cleanSearchInput(){
    const input = document.getElementById("search_input_{{$id}}");
    input.value = "";

  }
  function JS_SEP_printOnInput(){
    JS_SEP_cleanSearchInput();
    JS_SEP_updateDestinyInput();
    
  }
  function JS_SEP_updateDestinyInput(){
    const input = document.getElementById("{{$id}}");
    input.value = JS_SEP_selected_Ids.join(",");

  }


  function JS_SEP_clickSomewhere(event){//To hide the floating div
    var ignoreClickOnMeElement = document.getElementById('search_input_{{$id}}');
    var isClickInsideElement = ignoreClickOnMeElement.contains(event.target);

    if (!isClickInsideElement) {
      JS_SEP_hideOptions();
    }
  }


  function JS_SEP_pressedEnter(){
    if(JS_SEP_showedOptionsList.length == 0){
      return;
    }
    var firstOption = JS_SEP_showedOptionsList[0];

    JS_SEP_selectOption(firstOption.value);
    JS_SEP_showOptions();

  }

  function JS_SEP_cleanSelecteds(){
    JS_SEP_selectedOptions = [];
    JS_SEP_selected_Ids = [];

    JS_SEP_updateListFilter();
    JS_SEP_updateDestinyInput();
  }


</script>

 
<style>
  #CSS_SEP .options_container {
    position: absolute;
    z-index:50;
    background-color: rgb(236, 236, 236);
    border-radius:8px;
    max-height: 350px;
    overflow:scroll;
    overflow-x:hidden;
  }

  #CSS_SEP .inside-input{
    --tw-ring-color: rgb(255 255 255);
    border: 0px;
    outline: auto 0px -webkit-focus-ring-color;
    border-radius: 5px;
    background-color: rgb(238, 247, 255);
    margin:2px;

    font-size: {{$fontSize}}pt;
  }


  #CSS_SEP .selected_options_container{
    background-color:white;
    border-radius: 5px;
    padding:2px;

  }
  
  
  #CSS_SEP .selected-option{
    background-color: rgb(206 244 255);
    /* padding: 3px; */
    padding-left: 3px;
    
    border-radius: 5px;
    margin: 2px;
    display: flex;
    align-items: center;
    font-size: {{$fontSize}}pt;
  }

  #CSS_SEP .selected-option .equis{
    margin:3px;
    cursor: pointer;
  }
  #CSS_SEP .selected-option .equis:hover{
    color:rgb(211, 61, 61)
  }
  

  #CSS_SEP .sm_option{
    cursor: pointer;
    padding:2px;
    padding-left: 5px;
    padding-right: 5px;
  }

  #CSS_SEP .sm_option:hover{
    background-color: #babfd8;
    color:rgb(0, 0, 0)
  }



</style>

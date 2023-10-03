{{--  --}}


@php
    $r = rand(1,9999);

    //nombres de los select para usarlos en JS
    $cb_dep_name = "ComboBoxDepartamento_".$name;
    $cb_pro_name = "ComboBoxProvincia_".$name;
    $cb_dis_name = "ComboBoxDistrito_".$name;

    $output_name = $name;

    $initialValue = $codDistritoSeleccionado;
    
@endphp
        
        <div class="col-12 col-sm-4">
            <label for="">
                Región:
            </label>
            <select class="form-control"  id="{{$cb_dep_name}}" name="{{$cb_dep_name}}" onchange="clickSelectDepartamento{{$name}}()" >
                <option value="-1">-- Región --</option>
                @foreach($listaDepartamentos as $departamento)
                    <option value="{{$departamento->getId()}}"
                        @if($codDepartamentoSeleccionado == $departamento->getId())
                            selected
                        @endif
                        >
                        {{$departamento->nombre}}
                    </option>
                    
                @endforeach
                
            </select>   
        </div>
        <div class="col-12 col-sm-4">
            <label for="">
                Provincia:
            </label>
            <select class="form-control"  id="{{$cb_pro_name}}" name="{{$cb_pro_name}}"  onchange="clickSelectProvincia{{$name}}()" >
                <option value="-1">-- Provincia --</option>
                @foreach($listaProvinciasDelDep as $prov)
                    <option value="{{$prov->getId()}}"
                        @if($codProvinciaSeleccionada == $prov->getId())
                            selected
                        @endif
                        >
                        {{$prov->nombre}}
                    </option>
                @endforeach
                
            </select>   
        </div>
        <div class="col-12 col-sm-4">
            <label for="">
                Distrito:
            </label>
            <select class="form-control"  id="{{$cb_dis_name}}" name="{{$cb_dis_name}}" onchange="clickSelectDistrito{{$name}}(this.value)">
                <option value="-1">-- Distrito --</option>
                @foreach($listaDistritosDeProv as $distr)
                    <option value="{{$prov->getId()}}"
                        @if($codDistritoSeleccionado == $distr->getId())
                            selected
                        @endif
                        >
                        {{$distr->nombre}}
                    </option>
                @endforeach

            </select>   
        </div>


        {{-- Este input tendrá la salida del componente, que sería el codDistrito seleccionado.
            Si no se seleccionó, tendrá -1 --}}
        <input type="{{App\Configuracion::getInputTextOHidden()}}" value="{{$codDistritoSeleccionado}}" name="{{$output_name}}" id="{{$output_name}}"  >

<script>

    var listaTotalDepartamentos = @php echo $listaDepartamentos @endphp

    var listaTotalProvincias = @php echo $listaProvincias @endphp

    var listaTotalDistritos = @php echo $listaDistritos @endphp

    
    

    
    function clickSelectDepartamento{{$name}}(){
        departamento = document.getElementById('{{$cb_dep_name}}');
        ComboBoxProvincia =  document.getElementById('{{$cb_pro_name}}');
        ComboBoxDistrito =  document.getElementById('{{$cb_dis_name}}'); 

        console.log('el codigo del dep seleccionado es ='+departamento.value);

        listaProvinciasDelDep =  listaTotalProvincias.filter( e => e.codDepartamento == departamento.value);

        cadenaHTML = `<option value="-1" selected> - Provincia - </option>`;
        for (let index = 0; index < listaProvinciasDelDep.length; index++) {
            const provincia = listaProvinciasDelDep[index];
            
            cadenaHTML = cadenaHTML + 
            `
            <option value="`+provincia.codProvincia+`">
                `+ provincia.nombre +`
            </option>   
            `;
        }

        ComboBoxProvincia.innerHTML = cadenaHTML;    
        ComboBoxDistrito.innerHTML =
        `
            <option value="-1" selected>
                - Distrito -
            </option> 
        `;
        limpiarDistrito{{$name}}();
    }

    function clickSelectProvincia{{$name}}(){
        ComboBoxProvincia =  document.getElementById('{{$cb_pro_name}}');
        ComboBoxDistrito =  document.getElementById('{{$cb_dis_name}}'); 

        console.log('el codigo de provincia seleccionada es ='+ComboBoxProvincia.value);
        listaDistritosDeProv =  listaTotalDistritos.filter( e => e.codProvincia == ComboBoxProvincia.value);

        
    
        cadenaHTML = `
            <option value="-1" selected>
                - Distrito -
            </option> 
        `;
        for (let index = 0; index < listaDistritosDeProv.length; index++) {
            const distrito = listaDistritosDeProv[index];
            
            cadenaHTML = cadenaHTML + 
            `
            <option value="`+distrito.codDistrito+`">
                `+ distrito.nombre +`
            </option>   
            `;
        }
        ComboBoxDistrito.innerHTML = cadenaHTML;                
        limpiarDistrito{{$name}}();

    }


    function clickSelectDistrito{{$name}}(value){
        document.getElementById('{{$output_name}}').value = value; 
    }

    function limpiarDistrito{{$name}}(){
        document.getElementById('{{$output_name}}').value = "-1";
    }


    function validarLugarSelector_{{$name}}(msjError){
        msjLocal = "";
        
        limpiarEstilos([
            '{{$cb_dep_name}}',
            '{{$cb_pro_name}}',
            '{{$cb_dis_name}}'
        ])


        msjLocal = validarSelect(msjLocal,'{{$cb_dep_name}}',-1,'Departamento');
        msjLocal = validarSelect(msjLocal,'{{$cb_pro_name}}',-1,'Provincia');
        msjLocal = validarSelect(msjLocal,'{{$cb_dis_name}}',-1,'Distrito');

        
        if(msjError!="") //significa que ya hay un error en el flujo de validaciones
            return msjError; 
        else //si no hay ningun error, retorna el mensaje generado en esta funcion (el cual será nulo si no hubo error)
            return mensaje;


    }

</script>
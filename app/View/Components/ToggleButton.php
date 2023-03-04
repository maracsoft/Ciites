<?php

namespace App\View\Components;

use Exception;
use Illuminate\View\Component;
use Illuminate\View\View;

class ToggleButton extends Component
{

    private string $name;
    private int $initialValue;
    private string $onChangeFunctionName;
    private string $setExternalValueFunctionName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name,int $initialValue,string $onChangeFunctionName,string $setExternalValueFunctionName)
    { 
      if($initialValue!= 0 && $initialValue!= 1){
        throw new Exception("Initial value for ToggleButton must be 1 or 0, $initialValue provided");
      }

      $this->name = $name;
      $this->initialValue = $initialValue;
      $this->onChangeFunctionName = $onChangeFunctionName;
      $this->setExternalValueFunctionName = $setExternalValueFunctionName;

      
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() 
    {
      $r = rand(1,9999);

      $name = $this->name;
      $initialValue = $this->initialValue;
      $onChangeFunctionName = $this->onChangeFunctionName;
      $setExternalValueFunctionName = $this->setExternalValueFunctionName;
      $nativeView = view('components.toggle-button',compact('name','initialValue','r','onChangeFunctionName','setExternalValueFunctionName'));
      
        
      return Aislator::aislate($nativeView,$r,$name);
    }
}

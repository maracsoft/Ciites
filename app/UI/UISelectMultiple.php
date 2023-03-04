<?php
namespace App\UI;

use App\View\Components\Aislator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class UISelectMultiple implements NotFillableInterface{
    
    private array $options; //Array base del select en el que cada elemento tiene value y text
    private $selectedOptionsIds; // id valores seleccionado (para ser renderizado)
    private $name;//nombre
    private $placeholder;//nombre
    private bool $showCleanButton ;
    private int $fontSize;

    private $randomNumber;


    public function __construct($options,$selectedOptionsIds,$name,$placeholder,$showCleanButton,$text_max_length,$fontSize = 10){
      $this->randomNumber = rand(1,9999);
      $this->options = $options;
      $this->selectedOptionsIds = $selectedOptionsIds;
      $this->name = $name;
      $this->placeholder = $placeholder;
      $this->showCleanButton = $showCleanButton;
      $this->text_max_length = $text_max_length;
      $this->fontSize = $fontSize;

       

    }


    public function setOptionsWithModel($model_list,$text_field_name){
      $array = [];
      foreach ($model_list as $model) {
        array_push($array,[
          'value'=>$model->getId(),
          'text' =>$model[$text_field_name]
        ]);
      }

      $this->options = $array;
    }
    
    public function render()  {
      $r = $this->randomNumber;
      $options = $this->options;
      $selectedOptionsIds = $this->selectedOptionsIds;
      $name = $this->name;
      $placeholder = $this->placeholder;
      $showCleanButton = $this->showCleanButton;
      $text_max_length = $this->text_max_length;
      $fontSize = $this->fontSize;

      $id = $this->getId();

      $nativeView = view('ComponentesUI.SelectMultiple',compact('r','options','selectedOptionsIds','name','placeholder','showCleanButton','text_max_length','id','fontSize'));
      
      /* Por alguna razón, con el return renderiza como string */
      echo Aislator::aislate($nativeView,$r,$name);

    }

    public function getId(){
      return $this->name."_".$this->randomNumber;
    }
     
    

}

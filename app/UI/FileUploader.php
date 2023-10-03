<?php

namespace App\UI;

use App\Debug;
use App\Departamento;
use App\Fecha;
use Exception;
use Illuminate\Database\Eloquent\Model;


class FileUploader implements NotFillableInterface {
    
  private string $filenames_input_name;
  private string $file_input_name;
  private bool $isMultiple;
  private string $showedText;
  private $file_types; //array o null , "PDF","WORD"

  private int $maxSize; //on MB
  private int $randomNumber;

  public function __construct(string $filenames_input_name,string $file_input_name, int $maxSize,bool $isMultiple,string $showedText,array $file_types = null){
    $this->randomNumber = rand(1,9999);
    $this->filenames_input_name = $filenames_input_name;
    $this->isMultiple = $isMultiple;
    $this->maxSize = $maxSize;
    $this->file_input_name = $file_input_name;
    $this->showedText = $showedText;
    $this->file_types = $file_types;
    
  }

  public function render(){
    $r = $this->randomNumber;
    $filenames_input_name = $this->filenames_input_name;
    $isMultiple = $this->isMultiple;
    $maxSize = $this->maxSize;
    $file_input_name = $this->file_input_name;
    $showedText = $this->showedText;
    $file_types = $this->file_types;
    
    return view('ComponentesUI.FileUploader',compact('r','filenames_input_name','isMultiple','maxSize','file_input_name','showedText','file_types'));
  }


}
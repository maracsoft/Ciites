<?php


use Phinx\Seed\AbstractSeed;

class InitialData extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
      error_log("Seed InitialData");

      $file_string = $this->readFile("database/maractions/datosIniciales.sql");
      /* El separador es una coma y un enter */
      $separator = "; 
";
      $sql_array = explode($separator,$file_string);
      
      /* El ultimo elemento siempre está vacío por la coma ultima */
      for ($i=0; $i < count($sql_array) - 1; $i++) { 
        $sql = $sql_array[$i].";";
        error_log("$i Executing $sql");
        $result = $this->execute($sql);
        error_log("$i Created rows: $result");
        error_log("-----------");
      }

      
      
    }


    function readFile($ubication){
      $fileString="";
      $fp = fopen($ubication, "r");
      
      while (!feof($fp)){
          $linea = fgets($fp);
          $fileString .= $linea;
      }

      fclose($fp);
      return $fileString;
    }
}

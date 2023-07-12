<?php 
namespace App ;

class validator {   
    
    private $data ;
    protected $errors =[];

    /**
     * validates
     *
     * @param  mixed $data
     * @return void
     */
    public function validates(array $data){
        $this->errors=[];
        $this->data=$data ;
        
        
    }
    public function validate(string $field,string $method, ...$parameters){
      if(!isset($this->data[$field])) {
        $this->errors[$field]="le champs $field n'est pas rempli";
      }else {
        call_user_func([$this,$method],$field,...$parameters);
      }
        
        
    }

    public function minLength(string $field, int $length):bool{
      if (mb_strlen($field) < $length){
          $this->errors[$field]="le champs doit avoir plus de $length caractéres";
          return false ;
      }
      return true ;
    }

    public function date(string $field):bool{
     if( \DateTime::createFromFormat('Y-m-d' ,$this->data[$field]) ===false ){
      $this->errors[$field]="la date ne semble pas valide";
      return false ;
     }
     return true ;
    }

    public function time(string $field):bool{
      if( \DateTime::createFromFormat('H:i' ,$this->data[$field]) ===false ){
       $this->errors[$field]="le temps ne semble pas valide";
       return false ;
      }
      return true ;
     }

     public function  beforeTime(string $startField, string $endField ){
        if ($this->time($startField) && $this->time($endField)) {
          $start=\DateTime::createFromFormat('H:i' ,$this->data[$startField]);
          $end= \DateTime::createFromFormat('H:i' ,$this->data[$endField]);
          if($start->getTimestamp() > $end->getTimestamp()){

            $this->errors[$startField]="le temps doit etre inferieur au temps de fin ";
            return false ;
          }
          return true ;
         }
         return false ;
     }
}
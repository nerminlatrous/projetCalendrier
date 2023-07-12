<?php
namespace Calendar ;
class Event {
    private $id;

    private $name;

    private $description ; 

    private $start ; 

    private $end ;

    private $idutilisateur ;

    private $status;

    private $email;

    public function getEmail():string {
        return $this->email;
    }
    
    public function getId():int {
        return $this->id;
    }
    public function getName():string {
        return $this->name;
    }
    public function getDescription():string {
        return $this->description ?? '';
    }
    public function getStart():\DateTime {
        return new \DateTime( $this->start);
    }
    public function getEnd():\DateTime {
        return new \DateTime( $this->end);
    }
    public function getIdutilisateur():string {
        return $this->idutilisateur;
    }
    public function getStatus():int {
        return $this->status;
    }


    public function setName(string $name ){
        $this->name=$name;
    }
    public function setDescription(string $description){
        $this->description=$description;
    }
    public function setStart(string $start){
        $this->start=$start;
    }
    public function setEnd(string $end){
        $this->end=$end;
    }
    public function setIdutilisateur(string $idutilisateur ){
        $this->idutilisateur=$idutilisateur;
    }

    public function setStatus(int $status){
        $this->status=$status;
    }

    public function setEmail(string $email){
        $this->email=$email;
    }
    
}
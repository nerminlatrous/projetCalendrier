<?php 
namespace Calendar ;

class Login {
    public $connecte;
public function est_connecte():bool{
    
    if(session_status()===PHP_SESSION_NONE){
        session_start();
    } return !empty($_SESSION['connecte']);
}

public function utilisateur_connecte( Login $connecte):void {
    if(!$connecte->est_connecte()){
        header('Location: /login.php');
       exit();
    }
}

}
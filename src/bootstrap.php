<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../vendor/autoload.php';
function e404(){
    require '../public/404.php';
    exit();
}
function dd(...$vars){
   foreach($vars as $var){
        echo'<pre>';
        print_r($var);
        echo'</pre>';
    }
}
function get_pdo(){
    return  new \PDO('mysql:host=localhost;dbname=calendar','root','root', [
        \PDO::ATTR_ERRMODE=> \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE=> \PDO::FETCH_ASSOC
    ]);
}
function h(?string $value):string{
    if ($value===null){
        return '';
    }
  return htmlentities($value);
}
/*function render(string $view,$parameters=[]){
 extract($parameters);
 
}
*/
function verif()
{
    if(empty($_SESSION))
{
    header('location:/pageDeGarde.php');
    exit();
}

}
<?php 
    require '../src/bootstrap.php';
    
    $events=new Calendar\Events(get_pdo()) ;
    if (!isset($_Get['id'])){
        header('location :/404.php');
    }
    try {
        
        $event=$events->find($_GET['id']);
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $events->ResultatDemande($event);
        }
    }catch(\Exception $e ){
       // e404_custom();
    }
    require '../views/header.php';
   // $event=$events->find($_GET['id']);
   // dd($event);
  
?>
<h1><?=h($event->getName());?></h1>
<ul>
    <li>Date: <?=$event->getStart()->format('y/m/d') ;?></li>
   <li>Heure de démarrage: <?=$event->getStart()->format('H:i') ;?></li>
   <li>Heure de fin: <?=$event->getEnd()->format('H:i') ;?></li>
   <li>
    Description: <br>
    <?=h($event->getDescription());?>
   </li>
</ul> 

<form method="post">
        <button type="submit" name="boutonV" class="btn btn-success">Demande confirmer</button>
        <button type="submit" name="boutonR" class="btn btn-danger">Demande refuser</button>
    </form>

<?php require '../views/footer.php' ?>


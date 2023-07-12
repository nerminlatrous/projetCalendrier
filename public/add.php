<?php
require '../src/bootstrap.php';
require '../views/header.php';

$data=[];
session_start();
if($_SERVER['REQUEST_METHOD']==='POST'){
  
    $data=$_POST;
    $errors=[];
    $validator= new Calendar\EventValidator();
    $errors= $validator->validates($_POST);
    if(empty($errors)){
        $event= new \Calendar\Event();
        $event->setName($data['name']);
        $event->setIdutilisateur($_SESSION['id']);
        $event->setEmail($_SESSION['email']);
        $event->setStatus(0);
        $event->setDescription($data['description']);
        $event->setStart(DateTime::createFromFormat('Y-m-d H:i' , $data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(DateTime::createFromFormat('Y-m-d H:i' , $data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));
      
        $events=new \Calendar\Events(get_pdo());
        $events->create($event);
        header('Location: /calendrier.php');
        exit();
    }

}
?>



<div class="container"> 
<?php if(!empty($errors)): ?>
   <div class="alert alert-danger"> Merci de corriger vos erreurs</div>
<?php endif ?>
 <h1> Ajouter un evenement</h1>
    <form action="" method="post" class="form"> 
    <form action="" method="POST" class="form">
    <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Titre</label>
                    <input id="name" type="text" required class="form-control" name="name" value="<?= isset($data['name']) ? h($data['name']) : '' ; ?>">
                        <?php if (isset($errors['name'])):  ?>
                            <smal class="form-text text-muted">  <?= $errors['name'];  ?></smal>  
                        <?php endif ;  ?>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input id="date" type="date" required class="form-control" name="date"  value="<?= isset($data['date']) ? h($data['date']) : '' ; ?>">
                    <?php if (isset($errors['date'])):  ?>
                            <p class="help-block">  <?= $errors['date'];  ?></p> 
                        <?php endif ;  ?>
                </div>
            </div>   
       </div>
       <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="start">Démarrage</label>
                    <input id="start" type="time" required class="form-control" name="start" placeholder="HH:MM" value="<?= isset($data['start'])? h($data['start']) : '' ;  ?>">
                    <?php if (isset($errors['start'])):  ?>
                            <p class="form-text">  <?= $errors['start'];  ?></p> 
                        <?php endif ;  ?>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="end">Fin</label>
                    <input id="end" type="time" required class="form-control" name="end" placeholder="HH:MM" value="<?= isset($data['end']) ? h($data['end']) : '' ; ?>">
                </div>
               
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            
        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter ..."></textarea> <br>
        </div>

        <div class="form-group">
            <button class="btn btn-primary"> Ajouter l'évenement</button>
        </div>
    </form>
     
</div>


<?php  require '../views/footer.php';; ?>
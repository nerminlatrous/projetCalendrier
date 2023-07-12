<?php
require '../src/bootstrap.php';
session_start();
$pdo=get_pdo();
$events=new Calendar\Events($pdo);
$event=new Calendar\Event();
$errors=[];

$event=$events->find($_GET['id']);
try
{
    $event=$events->find($_GET['id'] ?? null);
}catch(\Exception $e){
    e404();
}catch(\Error $e){
    e404();
}
$data=[
    'name' => $event->getName(),
    'date' => $event->getStart()->format('Y-m-d'),
    'start' =>$event->getStart()->format('H:i'),
    'end' => $event->getEnd()->format('H:i'),
    'description' => $event->getDescription()
];
//var_dump($data);
if($_SERVER['REQUEST_METHOD']==='POST')
{
    if(isset($_POST['mod']))
    {
        $data=$_POST;
        $validator=new Calendar\EventValidator();
        $errors=$validator->validates($data);
        if(empty($errors))
        {
            $events->hydrate($event,$data);
            $events->update($event);
            if($_SESSION['role']==="admin")
                header('Location:/index?success=1');
            else
                header('Location:/calendrier.php');
            exit();
        }
    }
    if(isset($_POST['supp']))
    {
        $data=$_POST;
        $validator=new Calendar\EventValidator();
        $errors=$validator->validates($data);
        if(empty($errors))
        {
            $events->hydrate($event,$data);
            $events->delete($event);
            if($_SESSION['role']==="admin")
                header('Location:/index?success=1');
            else
                header('Location:/calendrier.php');
            exit();
        }
    }
}
require '../views/headerUtilisateur.php';
?>
<div class="container">
<h1>Editer l'evenement <small><?= h($event->getName())?></small></h1>
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
            
        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter ..."><?php echo htmlspecialchars($data['description']); ?></textarea>
        </div>
        
        <div class="form-group">
        <form action="edit.php" method="post">
                <br><button class="btn btn-primary" name="mod">Modifier l'evenement</button>
                <button class="btn btn-primary" name="supp">Supprimer l'evenement</button>
                    </form>
            
        </div>
    </form>
</div>
<?php require '../views/footer.php' ?>
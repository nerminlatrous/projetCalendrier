<?php 
require '../src/bootstrap.php';
$ok=[];
try {
    if (isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["pass"]))
    {
        if (!empty($_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["pass"]) )
        {
            $email =$_POST['email'];
            $name=$_POST['name'];
            $pass =$_POST['pass'];
            $pdo = get_pdo();
            $stmt = $pdo->prepare("INSERT INTO utilisateur (email,name,role, pass) VALUES (:email,:name,:role,:pass)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindValue(':role','user');
            $stmt->bindValue(':pass',$pass);
            if ($stmt->execute()) 
            {
                $ok="Data Saved";
            }
        }
    }
    
        

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
require '../views/header.php';
?>


</div>
<!DOCTYPE html>
<html>
<head>
  <title>Formulaire d'inscription'</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
    
<div class="container">

    <?php if(!empty($ok)) :?>
        <div class="alert alert-success">
           <?=$ok?>
        </div>
    <?php endif ?>

    <form action="S'inscrire.php" method="post">
    <h2>S'inscrire</h2>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="mb-3">
        <label for="mdp" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="pass" name="pass">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php require '../views/footer.php';
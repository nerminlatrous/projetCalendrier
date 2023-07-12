<?php
    require '../src/bootstrap.php';
    session_start();
    if(isset($_POST['email']) && isset($_POST['id']) && isset($_POST['pass']))
    {
        if( !empty($_POST['email']) && !empty($_POST['id']) and !empty($_POST['pass']) )
        {
            $pdo = get_pdo();
            $statement = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email AND idutilisateur = :idutilisateur AND pass = :pass");
            $statement->execute(
                 array(
                    'email'     =>     $_POST["email"],
                      'idutilisateur'     =>     $_POST["id"],
                      'pass'     =>     $_POST["pass"]
                 )
            );
            $count = $statement->rowCount();
            if($count > 0)
                {
                    $user = $statement->fetch();
                    $_SESSION["email"] = $_POST["email"];
                    $_SESSION["id"] = $_POST["id"];
                    if($user["role"] === "admin")
                    {
                        header("Location:/index.php");
                    }
                    else
                    {
                        header("Location:/calendrier.php");
                    }
                }
                else
                {
                    $error=' Merci de corriger vos erreurs';
                }
        }
        else
        {
            $error='Wrong Data';
        }
    }
    require '../views/headerLOGIN.php';
?>
    
</nav>
<!DOCTYPE html>
<html>
<head>
  <title>Formulaire de connexion</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
   
    <div class="container">
    <?php if(!empty($error)) :?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
    <?php endif ?>
    <h2>Formulaire de connexion</h2>
       <form action="login.php" method="post">
      
       <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email">
    </div>
       <div class="mb-3">
           <label for="exampleInputEmail1" class="form-label">Identifiant</label>
           <input type="number" class="form-control" name="id" id="id">
        </div>
      <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
          <input type="password" class="form-control" id="pass" name="pass">
        </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
</body>
</html>
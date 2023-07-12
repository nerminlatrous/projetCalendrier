<?php
session_start();
require '../src/bootstrap.php';
use Calendar\{Events};

$pdo = get_pdo();
$events = new Events($pdo);

$start = new DateTime('first day of january');
$end = (clone $start)->modify('last day of december')->modify('+1 day');
$events = $events->getEventsBetwenAdmin($start, $end);
$statement = $pdo->prepare("SELECT e.id, e.name, e.start, e.end, e.idutilisateur,e.email, e.status, u.role
    FROM events e, utilisateur u
    WHERE  e.email = u.email");
$statement->execute();
$resultat = $statement->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accepter'])) {
        $event_id = $_POST['event_id'];
        $acceptStatement = $pdo->prepare("UPDATE events SET status = 1 WHERE id = :event_id");
        $acceptStatement->bindParam(':event_id', $event_id);
        $acceptStatement->execute();
    } elseif (isset($_POST['refuser'])) {
        $event_id = $_POST['event_id'];
        $acceptStatement = $pdo->prepare("UPDATE events SET status = 2 WHERE id = :event_id");
        $acceptStatement->bindParam(':event_id', $event_id);
        $acceptStatement->execute();
    }
}
/*$req=$pdo->prepare("SELECT role FROM utilisateur Where email=:email");
$req->execute([
    'email' => $_SESSION['email']
]);*/
require '../views/header.php' ;
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>id</th>
            <th>nom de l'evenement</th>
            <th>Description de l'evenement</th>
            <th>date de debut</th>
            <th>date de fin</th>
            <th>status</th>
            <th>Email</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?= $event['id'] ?></td>
            <td><?= $event['name'] ?></td>
            <td><?= $event['description'] ?></td>
            <td><?= (new DateTime($event['start']))->format('Y-m-d H:i') ?></td>

            <td><?= (new DateTime($event['end']))->format('Y-m-d H:i') ?></td>

            

            <?php foreach ($resultat as $row): ?>
                <?php if ($row['id'] == $event['id']): ?>
                    <?php if ($row['status'] === 0): ?>
                        <td class="table-warning">En attente</td>
                       
                       
                    <?php elseif ($row['status'] === 1): ?>
                        <td class="table-success">Accepte</td>
                        
                    <?php elseif ($row['status'] === 2): ?>
                        <td class="table-danger">Refuse</td>
                        
                    <?php endif; ?>
                    <td><?= $event['email'] ?></td>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require '../views/footer.php'; ?>
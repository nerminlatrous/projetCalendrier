
    <?php 
     session_start();
    require '../src/bootstrap.php';
    verif();



    $pdo=get_pdo();
    $events=new Calendar\Events($pdo);
    $month= new Calendar\Month($_GET['month'] ?? null , $_GET['year'] ?? null) ;
    $start=$month->getStartingDay();
    $start=$start->format('N')==='1' ? $start: $month->getStartingDay()->modify('last monday');
    $weeks=$month->getWeeks();
    $end= (clone $start)->modify('+' . (6+7*($weeks-1)). 'days');
    $events=$events->getAllEventsForAdmin($start,$end);
    require '../views/headerAdmin.php';
    /*echo '<pre>';
    print_r($events);
    echo '</pre>';*/
     ?>
<div class="calendar"> 
    
   <?php if (isset($_GET['success'])): ?>
   <div class="container">
       <div class="alert alert-success"> 
          L'évènement a bien été enregistré 
       </div>
   </div>
          
    <?php endif ;?>

<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1> <?=  $month->toString();?></h1>
        <div>
            <a href="/index.php?month=<?= $month->previousMonth()->month ?>&year=<?=$month->previousMonth()->year ; ?>" class="btn btn-primary">&lt;</a>
            <a href="/index.php?month=<?= $month->nextMonth()->month ?>&year=<?=$month->nextMonth()->year ; ?>" class="btn btn-primary">&gt;</a>
        </div>
     </div>
     

    <h1><?php $month->toString(); ?></h1>
    <table class="calendar__table calendar__table--<?=$month->getWeeks();?>weeks " >
       <?php  for($i=0; $i<$month->getWeeks();$i++): ?>
           <tr>
              <?php 
                foreach($month->days as $k =>$day): 
               $date= (clone $start)->modify("+" . ($k + $i*7)."days"); 
               $eventsForDay=$events[$date->format('Y-m-d')] ?? [] ;
               $isToday=date('Y-m-d')===$date->format('Y-m-d');
               ?>
               
                <td class=" <?= $month->withinMonth($date) ? '' :'calendar__othermonth' ; ?> <?= $isToday ? 'is_today' : '' ?> ">
                    <?php if ($i===0): ?>
                        <div class="calendar__weekday"> <?= $day ;?> </div>
                    <?php  endif ;?>  
                    
                    <div class ="calendar__day"> <?=$date ->format('d');?></div>
                 

                    <?php foreach($eventsForDay as $event) : ?>
                       <div class="calendar__event">
                           <?=  (new DateTime ($event['start']))->format('H:i')?> 
                           <?php if ($event['status'] === 2) : ?>
                           <a href="/eventAdmin.php?id=<?=$event['id']; ?>" style="color:red !important;"> <?= $event['name']; ?>
                           <?php elseif ($event['status'] === 1) : ?>
                           <a href="/eventAdmin.php?id=<?=$event['id']; ?>" style="color:green !important;"> <?= $event['name']; ?>
                           <?php elseif ($event['status'] === 0) : ?>
                           <a href="/eventAdmin.php?id=<?=$event['id']; ?>" style="color:orange !important;"> <?= $event['name']; ?>
                           <?php endif ?>
                       </div>
                    <?php  endforeach ;?>
                </td>
                <?php  endforeach ;?>
           </tr>
       <?php  endfor ; ?>
    </table>
    <a href="/addAdmin.php" class="calendar__button">+</a> 
   
</div>
    

<?php require '../views/footer.php' ?>
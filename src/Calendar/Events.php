<?php
namespace Calendar ;

class Events extends \stdClass {   
    private $pdo;
    
    public function __construct(\PDO $pdo){
     $this->pdo=$pdo;
    }

    /**
     * getEventsBetwen
     *recupére les evenements entre 2 dates
     * @param  mixed $start
     * @param  mixed $end
     * @return array
     */
    public function getEventsBetwen(\DateTime $start , \DateTime $end) :array{
        //session_start();
        $pdo=new \PDO('mysql:host=localhost;dbname=calendar','root','root', [
            \PDO::ATTR_ERRMODE=> \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE=> \PDO::FETCH_ASSOC
        ]);
        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' AND idutilisateur = '{$_SESSION['id']}' AND email = '{$_SESSION['email']}' ";
        $statement=$this->pdo->query($sql);
        $results=$statement->fetchAll();

     return $results ;

    }    
    /**
     * getEventsBetwenByDay
     *recupére les evenements entre 2 dates indexè par jour 
     * @param  mixed $start
     * @param  mixed $end
     * @return array
     */
    public function getEventsBetwenByDay(\DateTime $start , \DateTime $end) :array{
        $events=$this->getEventsBetwen($start, $end);
        $days=[];
        foreach($events as $event){
            $date=explode(' ',$event['start'])[0];
            if(!isset($days[$date])){
               $days[$date]=[$event];
            }else {
                $days[$date][]=$event;
            }
        } return $days ;
        
    }    
    /**
     * find
     *recupere un evenement
     * @param  mixed $id
     * @return Event
     */
    public function find(int $id):\Calendar\Event{
        
        
      $statement= $this->pdo->query("SELECT * FROM events  WHERE id=$id LIMIT 1");
      $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
      $result=$statement->fetch();
      if($result===false){
        throw new \Exception('aucun resultat n\' a été trouvé');
      } 
      else return $result;
      
    }

    public function create(Event $event):bool{
        $statement= $this->pdo->prepare('INSERT INTO events (name,description ,start ,end ,idutilisateur, email ,status) VALUES(?,?,?,?,?,?,?) ');
       return   $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getIdutilisateur(),
            $event->getEmail(),
            $event->getStatus(),

        ]);

    }
    
    public function getEventsBetwenAdmin(\DateTime $start , \DateTime $end) :array{
        //session_start();
        $pdo=new \PDO('mysql:host=localhost;dbname=calendar','root','root', [
            \PDO::ATTR_ERRMODE=> \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE=> \PDO::FETCH_ASSOC
        ]);
        $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ";
        $statement=$this->pdo->query($sql);
        $results=$statement->fetchAll();

     return $results ;

    }   
    public function getAllEventsForAdmin(\DateTime $start , \DateTime $end) :array{
        $events=$this->getEventsBetwenAdmin($start, $end);
        $days=[];
        foreach($events as $event){
            $date=explode(' ',$event['start'])[0];
            if(!isset($days[$date])){
               $days[$date]=[$event];
            }else {
                $days[$date][]=$event;
            }
        } return $days ;
        
    }
    
    /**
     * ResultatDemande
     * la confirmation ou le refus d'une demande de congés 
     * @return int
     */
    public function ResultatDemande($event):int{
        // Vérifiez si le bouton a été cliqué
        if(isset($_POST['boutonV'])){
            $statement= $this->pdo->prepare("UPDATE events SET status= 1 where id=".$event->getId()."");
        } elseif(isset($_POST['boutonR'])){
            $statement= $this->pdo->prepare("UPDATE events SET status= 2 where id=".$event->getId()."");
        } 
        return   $statement->execute([
           //  $event->getStatus(),
 
         ]);

    }
    

public function delete(Event $event):bool
  {
      $statement=$this->pdo->prepare("DELETE FROM events WHERE id=?  " );
      return $statement->execute([
          $event->getID(),
      ]);
  }
  public function hydrate(Event $event,array $data)
    {   
        $event->setName($data['name']);
        $event->setDescription($data['description']);
        $event->setStart(\DateTime::createFromFormat('Y-m-d H:i',$data['date']. ' '. $data['start'])
    ->format('Y-m-d H:i:s'));
        $event->setEnd(\DateTime::createFromFormat('Y-m-d H:i',$data['date']. ' '. $data['end'])
    ->format('Y-m-d H:i:s'));
    return $event;
    }
    public function update(Event $event): bool
    {
        $statement = $this->pdo->prepare('UPDATE events SET name=?, description=?, start=?, end=? WHERE id=?');
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getId()
        ]);
    }
       
    
}
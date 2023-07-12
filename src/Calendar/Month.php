<?php  
namespace Calendar ;

use DateTime;

class Month {   
    public $days =['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    private $months=['Janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre' ,' décembre'];
     public $month;
     public $year ;
    /**
     * __construct
     *
     * @param  mixed $month
     * @param  mixed $year
     * @return void
     */
    public function __construct( ? int $month=null, ? int $year =null)
    {
        if($month=== null || $month <1 || $month >12){
            $month=intval(date(format:'m'));
        }
        if($year=== null  || $month <1 || $month >12){
            $year=intval(date(format:'Y'));
        }
        //$month=$month % 12;
        $this->month=$month;
        $this->year=$year;
        
    }    
    
    /**
     * getStartingDay
     *revoie le premier jour de mois 
     * @return DateTime
     */
    public function getStartingDay(): \DateTime {
        return new DateTime("{$this->year}-{$this->month}-01");
        
    }
    /**
     * __toString
     *retourne le mois en toute lettre
     * @return string
     */
    public function toString():string
    {
        return $this->months[$this->month-1].' '.$this->year;
    }    
    /**
     * getWeeks
     *renvoie le nombre de semaine dans le mois
     * @return int
     */
    public function getWeeks(): int{
        $start= $this->getStartingDay();
        $end=(clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W'))-intval($start->format('W'))+1;
        if ($weeks<0){
            $weeks=intval($end->format('W'));
        }
        return $weeks;
        
    }    
    /**
     * withinMonth
     *esque le jour est dans le mois en cours
     * @param  mixed $date
     * @return bool
     */
    public function withinMonth( \DateTime $date):bool{
        return $this->getStartingDay()->format('Y-m')===$date->format('Y-m');
    }
    
    /**
     * nextMonth
     *renvoie le mois suivant
     * @return Month
     */
    public function nextMonth():Month {
        $month=$this->month+1;
        $year=$this->year;
        if($month>12){
            $month=1;
            $year+=1;
        }
        return new Month($month, $year);
    }    
    /**
     * previousMonth
     *renvoie le mois precedent
     * @return Month
     */
    public function previousMonth():Month {
        $month=$this->month-1;
        $year=$this->year;
        if($month <1){
            $month=12;
            $year-=1;
        }
        return new Month($month, $year);
    }

}



?>
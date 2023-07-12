<?php 
namespace Calendar;

use App\validator ;

class EventValidator extends validator {    
    /**
     * validates
     *
     * @param  mixed $data
     * @return void
     */
    public function validates(array $data){
        parent::validates($data);
        $this->validate('name','minLength' ,3);
        $this->validate('date','date' );
        $this->validate('start','time' );
        $this->validate('end','time' );
        $this->validate('start','beforeTime','end' );
        return $this->errors ;
    }
} 
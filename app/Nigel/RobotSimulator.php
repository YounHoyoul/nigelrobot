<?php
namespace App\Nigel;

use app\Exceptions\RobotCannotMoveException;

class RobotSimulator
{
    const ERR_COLLISION = "Robot Collision Detected";
    const ERR_CANNOTMOVE = "Robot Cannot Move";
    
    private $input;
    private $robots = array();

    public function __construct($input=""){
        $this->input = $input;
    }

    public function simulate(){
        $lines = explode(PHP_EOL,$this->input); 

        $mat = explode(' ',$lines[0]);

        for( $i = 1 ; $i < count($lines) ; $i++ ){
            $pos = explode(' ',$lines[$i]); 
            $command = $lines[$i+1];
            $this->robots[] = new Robot($pos[0],$pos[1],$pos[2],$command,$mat);
            $i++;
        }

        $allDone = false;
        while(!$allDone){
            foreach($this->robots as $r1){
                try{
                    $r1->nextCommand();
                    foreach($this->robots as $r2){
                        if($r1 !== $r2){
                            if($r2->checkCollision($r1->x,$r2->y)){
                                return [self::ERR_COLLISION];
                            }
                        }
                    }
                }catch(RobotCannotMoveException $e){
                    return [self::ERR_CANNOTMOVE];
                }
            }

            $allDone = true;
            foreach($this->robots as $robot){
                if(!$robot->isDone()){
                    $allDone = false; 
                    break; 
                }
            }
        }

        $result = array();
        foreach($this->robots as $r){
            $result[] = $r->x.' '.$r->y.' '.$r->direction; 
        }

        return $result;
    }
}

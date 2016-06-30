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
        $this->initInput();

        while(!$this->checkAllRobotsDone()){
            foreach($this->robots as $robot){
                try{
                    $robot->nextCommand();
                }catch(RobotCannotMoveException $e){
                    return [self::ERR_CANNOTMOVE];
                }
            }
            foreach($this->robots as $robot){
                if($this->hasRobotCollision($robot)){
                    return [self::ERR_COLLISION];
                }
            }
        }

        return $this->makeResult();
    }

    private function initInput(){
        $lines = explode(PHP_EOL,$this->input); 

        $mat = explode(' ',$lines[0]);

        for( $i = 1 ; $i < count($lines) ; $i++ ){
            $pos = explode(' ',$lines[$i]); 
            $command = $lines[$i+1];
            $this->robots[] = new Robot($pos[0],$pos[1],$pos[2],$command,$mat);
            $i++;
        }
    }

    private function hasRobotCollision($robot){
        foreach($this->robots as $r2){
            if($robot !== $r2){
                if($r2->checkCollision($robot)){
                    return true;
                }
            }
        }

        return false;
    }

    private function checkAllRobotsDone(){
        foreach($this->robots as $robot){
            if(!$robot->isDone()){
                return false;
            }
        }
        return true;
    }

    private function makeResult(){
        $result = array();
        foreach($this->robots as $r){
            $result[] = $r->getX().' '.$r->getY().' '.$r->getDirection(); 
        }

        return $result;
    }
}

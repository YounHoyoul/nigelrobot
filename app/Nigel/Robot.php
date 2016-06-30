<?php
namespace App\Nigel;

use App\Exceptions\RobotCannotMoveException;

class Robot{

    const DIRECTIONS = ['N','E','S','W'];

    public $x;
    public $y;
    public $direction;
    public $mapsize;

    private $commands;
    private $currentIndex;
    private $prev_x;
    private $prev_y;
    private $prev_direction;

    public function __construct($x=0,$y=0,$direction='N',$commands="",$mapsize=[5,5]){
        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;
        $this->prev_x = $x;
        $this->prev_y = $y;
        $this->prev_direction = $direction;
        
        $this->commands = str_split($commands);
        $this->mapsize = $mapsize;
        $this->currentIndex = 0;
    }
    
    public function nextCommand(){
        $this->prev_x = $this->x;
        $this->prev_y = $this->y;
        $this->prev_direction = $this->direction;

        if($this->currentIndex < count($this->commands)){
            $this->command($this->commands[$this->currentIndex]);
            $this->currentIndex++;
        }
    }

    public function isDone(){
        return $this->currentIndex >= count($this->commands);
    }

    public function checkCollision($robot){
        if($robot == null) return false;
        
        //if two robots have the same destination, collision.
        if( $this->x == $robot->x && $this->y == $robot->y){
            return true;
        }

        //if two robots are moving the opposite way on the same path, collision.
        if( $this->x == $robot->prev_x && $this->y == $robot->prev_y &&
            $this->prev_x == $robot->x && $this->prev_y == $robot->y){
            return true;
        }

        return false;
    }

    private function command($cmd){
        switch($cmd){
        case 'L':
            $this->turnLeft();
            break;
        case 'R':
            $this->turnRight();
            break;
        case 'M':
            $this->moveForward();
            break;
        }
    }

    private function turnRight(){
        $len = count(self::DIRECTIONS);
        for( $i = 0 ; $i < $len ; $i++ ){
            if(self::DIRECTIONS[$i] === $this->direction){
                if($i < $len - 1){
                    $this->direction = self::DIRECTIONS[$i+1]; 
                }else{
                    $this->direction = self::DIRECTIONS[0];
                }
                break;
            }
        }
    }

    private function turnLeft(){
        $len = count(self::DIRECTIONS);
        for( $i = $len - 1 ; $i >= 0 ; $i-- ){
            if(self::DIRECTIONS[$i] === $this->direction){
                if($i > 0){
                    $this->direction = self::DIRECTIONS[$i-1]; 
                }else{
                    $this->direction = self::DIRECTIONS[$len - 1];
                }
                break;
            }
        }
    }

    private function moveForward(){
        switch($this->direction){
        case 'N':
            if($this->y == 0){
               throw new RobotCannotMoveException("Can't move forward north.");
            }
            $this->y--;
            break;
        case 'E':
            if($this->x == $this->mapsize[0]){
               throw new RobotCannotMoveException("Can't move forward east");
            }
            $this->x++;
            break;
        case 'S':
            if($this->y == $this->mapsize[1]){
               throw new RobotCannotMoveException("Can't move forward south");
            }
            $this->y++;
            break;
        case 'W':
            if($this->x == 0){
               throw new RobotCannotMoveException("Can't move forward west.");
            }
            $this->x--;
            break;
        }
    }
}

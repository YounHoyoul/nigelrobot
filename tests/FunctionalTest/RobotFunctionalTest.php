<?php

use App\Nigel\Robot;

class RobotFunctionalTest extends TestCase
{
    public function testFirstMove(){
        $robot = new Robot(1,2,'N','LMLMLMLMM',[5,5]);

        while(!$robot->isDone()){
            $robot->nextCommand();
        }

        $this->assertEquals(1,$robot->x);
        $this->assertEquals(1,$robot->y);
        $this->assertEquals('N',$robot->direction);
    }

    public function testSecondMove(){
        $robot = new Robot(3,3,'E','MLMLMRMRMRRM',[5,5]);

        while(!$robot->isDone()){
            $robot->nextCommand();
        }

        $this->assertEquals(3,$robot->x);
        $this->assertEquals(1,$robot->y);
        $this->assertEquals('W',$robot->direction);
    }
}

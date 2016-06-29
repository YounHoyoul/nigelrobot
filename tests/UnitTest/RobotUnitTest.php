<?php

use App\Nigel\Robot;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RobotUnitTest extends TestCase
{
    public function testInstance(){
        $robot = new Robot();
        $this->assertTrue(true);
    }

    public function testInitialization(){
        $robot = new Robot(1,2,'N');
        $this->assertEquals(1,$robot->x);
        $this->assertEquals(2,$robot->y);
        $this->assertEquals('N',$robot->direction);

        $robot = new Robot(3,4,'S');
        $this->assertEquals(3,$robot->x);
        $this->assertEquals(4,$robot->y);
        $this->assertEquals('S',$robot->direction);
    }

    public function testTurnRightAtN(){
        $robot = new Robot(0,0,'N','R');
        $robot->nextCommand();
        $this->assertEquals('E',$robot->direction);
    }

    public function testTurnRightAtE(){
        $robot = new Robot(0,0,'E','R');
        $robot->nextCommand();
        $this->assertEquals('S',$robot->direction);
    }

    public function testTurnRightAtS(){
        $robot = new Robot(0,0,'S','R');
        $robot->nextCommand();
        $this->assertEquals('W',$robot->direction);
    }

    public function testTurnRightAtW(){
        $robot = new Robot(0,0,'W','R');
        $robot->nextCommand();
        $this->assertEquals('N',$robot->direction);
    }

    public function testTurnLeftAtN(){
        $robot = new Robot(0,0,'N','L');
        $robot->nextCommand();
        $this->assertEquals('W',$robot->direction);
    }

    public function testTurnLeftAtW(){
        $robot = new Robot(0,0,'W','L');
        $robot->nextCommand();
        $this->assertEquals('S',$robot->direction);
    }

    public function testTurnLeftAtS(){
        $robot = new Robot(0,0,'S','L');
        $robot->nextCommand();
        $this->assertEquals('E',$robot->direction);
    }

    public function testTurnLeftAtE(){
        $robot = new Robot(0,0,'E','L');
        $robot->nextCommand();
        $this->assertEquals('N',$robot->direction);
    }

    public function testMoveNorth(){
        $robot = new Robot(1,1,'N','M');
        $robot->nextCommand();
        $this->assertEquals(1,$robot->x);
        $this->assertEquals(0,$robot->y);
        $this->assertEquals('N',$robot->direction);
    }

    public function testMoveSouth(){
        $robot = new Robot(1,1,'S','M');
        $robot->nextCommand();
        $this->assertEquals(1,$robot->x);
        $this->assertEquals(2,$robot->y);
        $this->assertEquals('S',$robot->direction);
    }

    public function testMoveEast(){
        $robot = new Robot(1,1,'E','M');
        $robot->nextCommand();
        $this->assertEquals(2,$robot->x);
        $this->assertEquals(1,$robot->y);
        $this->assertEquals('E',$robot->direction);
    }

    public function testMoveWest(){
        $robot = new Robot(1,1,'W','M');
        $robot->nextCommand();
        $this->assertEquals(0,$robot->x);
        $this->assertEquals(1,$robot->y);
        $this->assertEquals('W',$robot->direction);
    }

    /**
     *
     * @expectedException \Exception
     */
    public function testCannotMoveForwardToNorth()
    {
        $robot = new Robot(0,0,'N','M');
        $robot->nextCommand();
    } 

    /**
     *
     * @expectedException \Exception
     */
    public function testCannotMoveForwardToEast()
    {
        $robot = new Robot(2,2,'E','M',[2,2]);
        $robot->nextCommand();
    } 

    /**
     *
     * @expectedException \Exception
     */
    public function testCannotMoveForwardToSouth()
    {
        $robot = new Robot(2,2,'S','M',[2,2]);
        $robot->nextCommand();
    } 

    /**
     *
     * @expectedException \Exception
     */
    public function testCannotMoveForwardToWest()
    {
        $robot = new Robot(0,0,'W','M',[2,2]);
        $robot->nextCommand();
    } 

    public function testCollision(){
        $robot = new Robot(1,1,'N');
        $iscollision = $robot->checkCollision(1,1);
        $this->assertTrue($iscollision);
    }

    public function testNonCollision(){
        $robot = new Robot(1,1,'N');
        $iscollision = $robot->checkCollision(1,2);
        $this->assertFalse($iscollision);
    }

    public function testIsDone(){
       $robot = new Robot(3,3,'N','LM');
       $robot->nextCommand();
       $this->assertFalse($robot->isDone());
       $robot->nextCommand();
       $this->assertTrue($robot->isDone());
    }
}

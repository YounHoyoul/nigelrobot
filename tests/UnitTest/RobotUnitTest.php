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
        $this->assertEquals(1,$robot->getX());
        $this->assertEquals(2,$robot->getY());
        $this->assertEquals('N',$robot->getDirection());

        $robot = new Robot(3,4,'S');
        $this->assertEquals(3,$robot->getX());
        $this->assertEquals(4,$robot->getY());
        $this->assertEquals('S',$robot->getDirection());
    }

    public function testTurnRightAtN(){
        $robot = new Robot(0,0,'N','R');
        $robot->nextCommand();
        $this->assertEquals('E',$robot->getDirection());
    }

    public function testTurnRightAtE(){
        $robot = new Robot(0,0,'E','R');
        $robot->nextCommand();
        $this->assertEquals('S',$robot->getDirection());
    }

    public function testTurnRightAtS(){
        $robot = new Robot(0,0,'S','R');
        $robot->nextCommand();
        $this->assertEquals('W',$robot->getDirection());
    }

    public function testTurnRightAtW(){
        $robot = new Robot(0,0,'W','R');
        $robot->nextCommand();
        $this->assertEquals('N',$robot->getDirection());
    }

    public function testTurnLeftAtN(){
        $robot = new Robot(0,0,'N','L');
        $robot->nextCommand();
        $this->assertEquals('W',$robot->getDirection());
    }

    public function testTurnLeftAtW(){
        $robot = new Robot(0,0,'W','L');
        $robot->nextCommand();
        $this->assertEquals('S',$robot->getDirection());
    }

    public function testTurnLeftAtS(){
        $robot = new Robot(0,0,'S','L');
        $robot->nextCommand();
        $this->assertEquals('E',$robot->getDirection());
    }

    public function testTurnLeftAtE(){
        $robot = new Robot(0,0,'E','L');
        $robot->nextCommand();
        $this->assertEquals('N',$robot->getDirection());
    }

    public function testMoveNorth(){
        $robot = new Robot(1,1,'N','M');
        $robot->nextCommand();
        $this->assertEquals(1,$robot->getX());
        $this->assertEquals(0,$robot->getY());
        $this->assertEquals('N',$robot->getDirection());
    }

    public function testMoveSouth(){
        $robot = new Robot(1,1,'S','M');
        $robot->nextCommand();
        $this->assertEquals(1,$robot->getX());
        $this->assertEquals(2,$robot->getY());
        $this->assertEquals('S',$robot->getDirection());
    }

    public function testMoveEast(){
        $robot = new Robot(1,1,'E','M');
        $robot->nextCommand();
        $this->assertEquals(2,$robot->getX());
        $this->assertEquals(1,$robot->getY());
        $this->assertEquals('E',$robot->getDirection());
    }

    public function testMoveWest(){
        $robot = new Robot(1,1,'W','M');
        $robot->nextCommand();
        $this->assertEquals(0,$robot->getX());
        $this->assertEquals(1,$robot->getY());
        $this->assertEquals('W',$robot->getDirection());
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
        $robot1 = new Robot(1,1,'N');
        $robot2 = new Robot(1,1,'S');
        $iscollision = $robot1->checkCollision($robot2);
        $this->assertTrue($iscollision);
    }

    public function testNonCollision(){
        $robot1 = new Robot(1,1,'N');
        $robot2 = new Robot(1,2,'N');
        $iscollision = $robot1->checkCollision($robot2);
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

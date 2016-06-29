<?php

use App\Nigel\RobotSimulator;

class RobotSimulatorFunctionalTest extends TestCase
{
    public function testFirstTest(){
        $input = "5 5
1 2 N
LMLMLMLMM";

        $simulator = new RobotSimulator($input);

        $result = $simulator->simulate();
        
        $this->assertContains("1 1 N",$result);
    }

    public function testSecondTest(){
        $input = "5 5
3 3 E
MLMLMRMRMRRM";

        $simulator = new RobotSimulator($input);

        $result = $simulator->simulate();
        
        $this->assertContains("3 1 W",$result);
    }

    public function testThirdTest(){
        $input = "5 5
1 2 N
LMLMLMLMM
3 3 E
MLMLMRMRMRRM";

        $simulator = new RobotSimulator($input);

        $result = $simulator->simulate();
        
        $this->assertContains("1 1 N",$result);
        $this->assertContains("3 1 W",$result);
    }

    public function testCollision(){
        $input = "5 5
1 2 N
LMLMLMLMMRMM
3 3 E
MLMLMRMRMRRMRMRMRMRM";

        $simulator = new RobotSimulator($input);

        $result = $simulator->simulate();
        
        $this->assertContains("Robot Collision Detected",$result);
    }
}

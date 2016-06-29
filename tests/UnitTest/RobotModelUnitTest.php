<?php

use App\Models\Robot;

class RobotModelUnitTest extends TestCase
{
    public function testInstance(){
        new Robot();
        $this->assertTrue(true);
    }
}

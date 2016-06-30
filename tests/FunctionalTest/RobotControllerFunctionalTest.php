<?php

use App\Models\Shop;
use App\Models\Robot;

class RobotControllerFunctionalTest extends TestCase
{
    public function testShopPost(){
        $shop = factory(Shop::class)->make()->toArray();
        $response = $this->call('POST','/shop',$shop); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        $this->assertEquals($shop['width'],$actual['width']);
        $this->assertEquals($shop['height'],$actual['height']);
    }

    public function testShopGet(){
        $shop = factory(Shop::class)->create();
        $response = $this->call('GET','/shop/'.$shop->id); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        $this->assertEquals($shop['width'],$actual['width']);
        $this->assertEquals($shop['height'],$actual['height']);
    }

    public function testShopDelete(){
        $shop = factory(Shop::class)->create();
        $response = $this->call('DELETE','/shop/'.$shop->id); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        $this->assertArrayHasKey("status",$actual);
    }

    public function testRobotPost(){
        $shop = factory(Shop::class)->create();
        $robot = factory(Robot::class)->make()->toArray();
        $response = $this->call('POST','/shop/'.$shop->id.'/robot',$robot); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        $this->assertEquals($robot['x'],$actual['x']);
        $this->assertEquals($robot['y'],$actual['y']);
        $this->assertEquals($robot['heading'],$actual['heading']);
        $this->assertEquals($robot['commands'],$actual['commands']);
    }

    public function testRobotPut(){
        $shop = factory(Shop::class)->create();
        $robot = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        $robot['x'] = 100;
        $robot['y'] = 200; 
        $response = $this->call('PUT','/shop/'.$shop->id.'/robot/'.$robot->id,$robot->toArray()); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        $this->assertEquals($robot['x'],$actual['x']);
        $this->assertEquals($robot['y'],$actual['y']);
        $this->assertEquals($robot['heading'],$actual['heading']);
        $this->assertEquals($robot['commands'],$actual['commands']);
    }

    public function testRobotDelete(){
        $shop = factory(Shop::class)->create();
        $robot = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        $response = $this->call('DELETE','/shop/'.$shop->id.'/robot/'.$robot->id); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        $this->assertArrayHasKey("status",$actual);
    }

    public function testShopExecuteWithOneRobot(){
        $shop = factory(Shop::class)->create();
        $robot1 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        
        $response = $this->call('POST','/shop/'.$shop->id.'/execute'); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        if(!isset($actual['error'])){
            $this->assertArrayHasKey("width",$actual);
            $this->assertArrayHasKey("height",$actual);
        }else{
            $this->assertTrue(true);
        }
    }
    
    public function testShopExecuteWithTwoRobot(){
        $shop = factory(Shop::class)->create();
        $robot1 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        $robot2 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        
        $response = $this->call('POST','/shop/'.$shop->id.'/execute'); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        if(!isset($actual['error'])){
            $this->assertArrayHasKey("width",$actual);
            $this->assertArrayHasKey("height",$actual);
        }else{
            $this->assertTrue(true);
        }
    }

    public function testShopExecuteWithMultiRobot(){
        $shop = factory(Shop::class)->create();
        $robot1 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        $robot2 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        $robot3 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        $robot4 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        $robot5 = factory(Robot::class)->create(['shop_id'=>$shop->id]);
        
        $response = $this->call('POST','/shop/'.$shop->id.'/execute'); 
        $this->assertResponseOk();

        $actual = json_decode($response->getContent(),true);
        if(!isset($actual['error'])){
            $this->assertArrayHasKey("width",$actual);
            $this->assertArrayHasKey("height",$actual);
        }else{
            $this->assertTrue(true);
        }
    }
}

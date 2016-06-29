<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Robot;
use App\Nigel\RobotSimulator;

class RobotController extends Controller
{
    public function createShop(Request $request){
        $shop = Shop::create($request->all());

        return json_encode($shop);
    }

    public function executeShop($id){
        $shop = Shop::with('robots')->findOrFail($id);
        
        $input = array();
        $input[] = $shop->width.' '.$shop->height;

        foreach($shop->robots as $r){
            $input[] = $r->x.' '.$r->y.' '.$r->heading;
            $input[] = $r->commands;
        }

        $strinput = implode(PHP_EOL,$input);
        $simulator = new RobotSimulator($strinput);
        $result = $simulator->simulate();

        $index = 0;
        foreach($shop->robots as $r){
            if($result[$index] == RobotSimulator::ERR_COLLISION ||
               $result[$index] == RobotSimulator::ERR_CANNOTMOVE
            ) {
                return json_encode(["error"=>$result[$index]]);
            }

            $data = explode(' ',$result[$index]);
            $r->x = $data[0]; 
            $r->y = $data[1]; 
            $r->heading = $data[2]; 
            $r->save();
            $index++;
        }

        return json_encode($shop);
    }
    
    public function queryShop($id){
        $shop = Shop::with('robots')->findOrFail($id);

        return json_encode($shop);
    }

    public function deleteShop($id){
        Shop::findOrFail($id)->delete();

        $status = ["status" => "OK"];
        return json_encode($status);
    }

    public function createRobot(Request $request,$id){
        $shop = Shop::findOrFail($id); 

        $robot = new Robot();
        $robot->x = $request->input('x');
        $robot->y = $request->input('y');
        $robot->heading = $request->input('heading');
        $robot->commands = $request->input('commands');
        $robot->shop()->associate($shop);

        $shop->robots()->save($robot);

        return json_encode($robot);
    }

    public function updateRobot(Request $request,$id,$rid){
        $robot = Robot::findOrFail($rid);

        $robot->x = $request->input('x');
        $robot->y = $request->input('y');
        $robot->heading = $request->input('heading');
        $robot->commands = $request->input('commands');
        $robot->save();

        return json_encode($robot);
    }

    public function deleteRobot($id,$rid){
        Robot::findOrFail($rid)->delete();

        $status = ["status" => "OK"];
        return json_encode($status);

    }
}

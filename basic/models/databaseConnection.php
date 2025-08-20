<?php
namespace app\models;

use yii\base\Model;
use Kreait\Firebase\Factory;

class databaseConnetion extends Model
{

public function gameAdd(){

 $factory = (new Factory)->withServiceAccount("../config/firebase_credentials.json");
        $factory = $factory->withDatabaseUri((new \app\models\DBURL)->URL);
        $database = $factory->createDatabase();


         $snapshot = $database->getReference('/user/user1/games')->set([
         "game2"=>[

"name"=>"ticket to ride",
"imgAlt"=>"steam train cover art",
"imgRef"=>"",
"playerCount"=>4,
]
         ]);


         return "";


}

}



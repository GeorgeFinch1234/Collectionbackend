<?php
namespace app\models;

use yii\base\Model;
use Kreait\Firebase\Factory;

class databaseConnetion extends Model
{

public $factory;
public $database;

public function __construct(){
    $this->factory = (new Factory)->withServiceAccount("../config/firebase_credentials.json");
        $this->factory = $this->factory->withDatabaseUri((new \app\models\DBURL)->URL);
        $this->database = $this->factory->createDatabase();

}
public function gameAdd(){




         $snapshot = $this->database->getReference('/user/user1/games')->set([
         "game2"=>[

"name"=>"ticket to ride",
"imgAlt"=>"steam train cover art",
"imgRef"=>"",
"playerCount"=>4,
]
         ]);


         return "";


}


public function setAccessToken($userName){

//so is making a unqie string based of time and concatenating it with a random string 
//then its hashing it
  $token =  md5(uniqid().rand(1000000, 9999999));
 
$this->database->getReference('/accessTokens')->push([
"token"=>$token,
"user"=>$userName

]);


return $token;
}


public function createUser($userName, $password){

 $snapshot = $this->database->getReference('/user')->update([
$userName=>[

"password"=>hash('sha256', $password),
//need for when looking for them in signup
"username" =>$userName
]


         ]);


         return "";





}
/*
retuns either user name or "" is no username is found
*/
public function getUserNameFromToken($token){


  $allTokens= $this->database->getReference('/accessTokens');

            $user="";

        foreach ($allTokens->getValue() as $key => $value) {
            
            if($value["token"] == $token){
                $user =$value["user"];

                
            }

            
            }


            return $user;
}


}



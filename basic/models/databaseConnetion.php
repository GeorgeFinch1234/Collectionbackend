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

  $nameTake = $this->database->getReference('/user/'.$userName)->getValue();
if($nameTake == null){


 $snapshot = $this->database->getReference('/user')->update([
$userName=>[

"password"=>hash('sha256', $password),
//need for when looking for them in signup
"username" =>$userName
]


         ]);


         return "";

        }else{
          return "name already taken";
        }



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

/**
 * 
 * $ game is the unqiue idea that is made for games, and removes that whole node.
 * 
 */
public function deleteGame($user, $game){

$allUserGames= $this->database->getReference('/user/'.$user.'/games');
$gameID ="";
foreach ($allUserGames->getValue() as $key => $value) {
            
            if($value["name"] == $game){
                $gameID = $key;

                
            }

            
            }

  $this->database->getReference('/user/'.$user.'/games/'.$gameID)->set(null);
return ('/user/'.$user.'/games/'.$gameID);
}





public function getSelectedGameData($user, $game){

$allUserGames= $this->database->getReference('/user/'.$user.'/games');
$gameID ="";
foreach ($allUserGames->getValue() as $key => $value) {
            
            if($value["name"] == $game){
                $gameID = $key;

                
            }

            
            }

  return $this->database->getReference('/user/'.$user.'/games/'.$gameID)->getValue();



}

/**
 * 
 * $user = string
 * $game = string 
 * $img = string which is either true or false for if the img will show or not
 * true of false used as $_POST i believe will only send in string so its to save on
 * conversion
 */
public function editSelectedGame($user, $gameName, $img){
//so much duplication, need to abstract this out at somepoint
$allUserGames= $this->database->getReference('/user/'.$user.'/games');
$gameInfo ="";



foreach ($allUserGames->getValue() as $key => $value) {
           
            if($value["name"] == $gameName){
                $gameInfo = $key;

                
            }


            
            }
$updates=[];
            if($img == "true"){

$updates = [

/**
 * 
 * i believe it is path then key
 * 
 */

            '/user/'.$user.'/games/'.$gameInfo.'/name' => $_POST["name"],
            '/user/'.$user.'/games/'.$gameInfo.'/playerCount' => $_POST["playerCount"],
           '/user/'.$user.'/games/'.$gameInfo. '/imgRef'=>$_POST["imgRef"],
            '/user/'.$user.'/games/'.$gameInfo.'/imgAlt'=>$_POST["imgAlt"],
            '/user/'.$user.'/games/'.$gameInfo.'/description'=>$_POST["description"],
            '/user/'.$user.'/games/'.$gameInfo.'/cost'=>$_POST["cost"],
            '/user/'.$user.'/games/'.$gameInfo.'/time'=>$_POST["time"],
            '/user/'.$user.'/games/'.$gameInfo.'/minPlayers'=>$_POST["minPlayers"],
            '/user/'.$user.'/games/'.$gameInfo.'/maxPlayers'=>$_POST["maxPlayers"],
            '/user/'.$user.'/games/'.$gameInfo.'/fullInBox'=>$_POST["fullInBox"],

];
            }else{
              $updates = [

/**
 * 
 * i believe it is path then key
 * 
 */

            '/user/'.$user.'/games/'.$gameInfo.'/name' => $_POST["name"],
            '/user/'.$user.'/games/'.$gameInfo.'/playerCount' => $_POST["playerCount"],
//           '/user/'.$user.'/games/'.$gameID. '/imgRef'=>$_POST["imgRef"],
            '/user/'.$user.'/games/'.$gameInfo.'/imgAlt'=>$_POST["imgAlt"],
            '/user/'.$user.'/games/'.$gameInfo.'/description'=>$_POST["description"],

];
            }



$this->database->getReference()->update($updates);



}


/**
 * 
 * made to find the user for when selecting a game
 * 
 * 
 */
public function getUserGames(){


  return $this->database->getReference('/user/'.$_POST["findUser"])->getValue();



}

/**
 * 
 * 
 * 
 * 
 */
public function setMessage(){

  $this->database->getReference('/user/'.$_POST["findUser"].'/messages/')->push([
        
            'aboutGame' => $_POST["aboutGame"],
             'subject' => $_POST["subject"],
              'message' => $_POST["message"],
              'from' => $this->getUserNameFromToken($_POST["from"])
            
           
    
        
    ]);

}



public function getMessages($user){

return $this->database->getReference('/user/'.$user.'/messages/')->getValue();


}






public function getFilteredGameCollection($userName){




  return $this->database->getReference('/user/'.$userName.'/games')->orderByChild($_POST['filterBy'])->startAt((int)$_POST['startAt'])->endAt((int)$_POST['endAt'])->getValue() ;
}




public function deleteMessage(){

$this->database->getReference('/user/'.$this->getUserNameFromToken($_POST['UserName']).'/messages/'.$_POST['messageID'])->set(null);


}





}



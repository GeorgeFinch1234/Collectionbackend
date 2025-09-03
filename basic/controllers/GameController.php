<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\Game;
use yii\filters\auth\HttpBasicAuth;
use Kreait\Firebase\Factory;
use app\models\databaseConnetion;

class GameController extends Controller
{

   /*
loads the game collection based on user access token.
   */
    public function actionIndex()
    {
      
        $factory = (new Factory)->withServiceAccount("../config/firebase_credentials.json");
        $factory = $factory->withDatabaseUri((new \app\models\DBURL)->URL);
        $database = $factory->createDatabase();

$databaseConnection = new databaseConnetion();

      $user=  $databaseConnection->getUserNameFromToken($_POST["token"]);

         $snapshot = $database->getReference('/user/'.$user.'/games');


      return $snapshot->getValue();
        
      
       
        
    }
  
    public function actionCreateGame(){
$databaseConnection = new databaseConnetion();
return $databaseConnection->createGame();
     
    }



public function actionEditGame(){

$databaseConnection = new databaseConnetion();
$databaseConnection->editSelectedGame($databaseConnection->getUserNameFromToken($_POST["token"]), $_POST["orginalGameName"], $_POST["imgPresent"]);


}




public function actionDeleteGame(){
$databaseConnection = new databaseConnetion();

/**
 * 
 * need to find the user ID and game ID
 * 
 * 
 */
return $databaseConnection->deleteGame($databaseConnection->getUserNameFromToken($_POST["Token"]), $_POST["Game"]);
}

/**
 * 
 * use user name token, 
 * 
 */
public function actionGameData(){
$databaseConnection = new databaseConnetion();
return $databaseConnection->getSelectedGameData($databaseConnection->getUserNameFromToken($_POST["Token"]), $_POST["Game"]);


}
/**
 * 
 * same as above just doesn't use user game token
 * 
 */
public function actionGameDataFromUserName(){
$databaseConnection = new databaseConnetion();
return $databaseConnection->getSelectedGameData($_POST["UserName"], $_POST["Game"]);


}

public function actionGamesFilter(){


$databaseConnection = new databaseConnetion();
//$databaseConnection->getUserNameFromToken($_POST["Token"])
return $databaseConnection->getFilteredGameCollection($databaseConnection->getUserNameFromToken($_POST["Token"]));

}



public function behaviors()
{
    $behaviors = parent::behaviors();

    // remove authentication filter
    $auth = $behaviors['authenticator'];
    unset($behaviors['authenticator']);
    
    // add CORS filter
    $behaviors['corsFilter'] = [
        'class' => \yii\filters\Cors::class,
    ];
    
    // re-add authentication filter
    $behaviors['authenticator'] = $auth;
    // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
    $behaviors['authenticator']['except'] = ['options'];

    return $behaviors;
} 
}
<?php
namespace app\models;

use yii\base\Model;
use Kreait\Firebase\Factory;

class signIn extends Model
{
public function login($userName, $password){
$output="no match";
 $factory = (new Factory)->withServiceAccount("../config/firebase_credentials.json");
        $factory = $factory->withDatabaseUri((new \app\models\DBURL)->URL);
        $database = $factory->createDatabase();


     $snapshot = $database->getReference('/user');
  
//return gettype($snapshot->getValue());

foreach($snapshot->getValue() as $user){


          if($user["userName"] == $userName ){
                
            if($user["password"] == $password){
                    $output ="";
           
                }else{
                    $output="password doesn't match";
                }
                break;
            
                }


                }
 
        return $output;
    
}
}
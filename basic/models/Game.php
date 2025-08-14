<?php
namespace app\models;

use yii\base\Model;

class Game extends Model
{
    
        public $name ="ticket to ride";
        public $playerCount = "5";
        public $description ="With elegantly simple gameplay, Ticket to Ride can be learned in under 15 minutes.
         Players collect cards of various types of train cars they then use to claim railway routes in North America. 
         The longer the routes, the more points they earn. 
         Additional points come to those who fulfill Destination Tickets – goal cards that connect distant cities; 
         and to the player who builds the longest continuous route.";
    
        public $imgAlt="tikcet to ride box";
        public $base64;
        public function __construct(Type $var = null) {
            
        $path = '../tempImg/ttr.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $this->base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } 


    
}
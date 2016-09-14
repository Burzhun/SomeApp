<?php

  class toastMessageWidget extends CWidget{
      

      public $message; 
      
      

      public $type='Success'; 
      
      protected $assets; 
      
      
      
      public function init(){

           $this->assets = Yii::app()->assetManager->publish(dirname(__DIR__).DIRECTORY_SEPARATOR.'toastMessage'.DIRECTORY_SEPARATOR.'assets'); 
          
          
          cs()->registerScriptFile($this->assets.'/jquery.toastmessage.js'); 
          cs()->registerCssFile($this->assets.'/css/jquery.toastmessage.css'); 
          
      }
      
      
      
      public function run(){
        cs()->registerScript("toast-message","
                 $().toastmessage('show".$this->type."Toast', '$this->message');"); 
     
      
//      cs()->registerScript('mbn',"
//      
//       $().toastmessage({
//                            text     : ".$this->message.",
//                            sticky   : true,
//                            position : 'middle-right',
//                            type     : ".$this->type.",
//
//                        });");
      
      }
  }
?>

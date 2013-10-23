<?

/*
 * __PocketMine Plugin__
 * name=ConsolePro
 * version=1.0
 * description=Let's you send console messages in-game
 * author=Glitchmaster_PE
 * class=Console
 * apiversion=10
 */

 class Console implements Plugin{
     
     private $api;
     
     public function __construct(ServerAPI $api, $server = false){
         $this->api = $api;
     }
     
     public function init(){
         $this->api->console->register("console","Use console chat",array($this, "commandHandler"));
     }
     
     public function commandHandler($cmd, $params, $issuer){
         $msg = implode(" ", $params);
                if(trim($s) == ""){
                    $output .= "Usage: /say <message>\n";
                }
                $this->api->chat->broadcast("[Console] ".$msg);
     }
     
     public function __destruct(){
         
     }
 }

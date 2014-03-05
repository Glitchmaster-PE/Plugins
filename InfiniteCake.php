<?php
/*
 * __PocketMine Plugin__
 * name=InfiniteCake
 * version=1.0
 * description=Places a new cake when one is eaten
 * author=Glitchmaster_PE
 * class=Cake
 * apiversion=10
 */

class Cake implements Plugin{
    
    private $api;
    
    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }
    
    public function init(){
        $this->api->addHandler("player.block.touch", array($this, "eventHandler"));
        $this->api->console->register("icake on", "Makes cake infanit!", array($this, "handleCommand"));
        $this->api->console->register("icake off", "Disables infanit cake!", array($this, "handleCommand"));
    }
    /*
    public function eventHandler($data){
        $block = $data["target"]->getID();
        $meta = $data["target"]->getMetadata();
        if($block === 92){
            if($meta === 5){
                $x = $data["target"]->x;
                $y = $data["target"]->y;
                $z = $data["target"]->z;
                $level = $data["target"] -> level;
                $level->setBlock(new Vector3($x, $y, $z), BlockAPI::get(92, 0));
            }
            else{
                return;
            }
        }
        else{
            return;
        }
    }
    */
    
        public function handleCommand($data, $event)
    {
    switch($event)
    {
        case "icake on":
           $output .="[icake] Pleas toch the cake you want to be infanit!\n";
        break;
        case "icake off":
        $output .="[icake] Pleas toch the cake you want to disable infanit on!\n";
        break;
    public function __destruct(){
        
    }
}
?>

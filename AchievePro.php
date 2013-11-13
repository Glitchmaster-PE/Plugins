<?php

/*
 * __PocketMine Plugin__
 * name=AchievePro
 * version=2.0
 * description=Gives achievements to users!
 * author=Glitchmaster_PE
 * class=Achieve
 * apiversion=10
 */

class Achieve implements Plugin
{
    private $api;

    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
    }

    public function init()
    {
        $this -> api -> addHandler("player.block.break", array(
            $this,
            "Handler"
        ));
        $this -> api -> addHandler("player.block.touch", array(
            $this,
            "Handler"
        ));
        $this -> api -> addHandler("player.block.place", array(
            $this,
            "Handler"
        ));
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> handlers = new Config($this -> path, CONFIG_YAML, array(
            "Broadcast" => "true",
            "Achievements" => array(
                "Crafting" => array(
                    "Type" => "touch",
                    "Item" => "58",
                    "sendToMessage" => "Benchmaking!",
                    "BroadcastMessage" => "is Benchmaking!"
                ),
                "Hot Topic!" => array(
                    "Type" => "touch",
                    "Item" => "61",
                    "sendToMessage" => "Hot Topic!",
                    "BroadcastMessage" => "is a Hot Topic"
                ),
                "Taking Inventory" => array(
                    "Type" => "touch",
                    "Item" => "54",
                    "sendToMessage" => "Taking Inventory!",
                    "BroadcastMessage" => "is Taking Inventory"
                ),
                "Getting Wood!" => array(
                    "Type" => "break",
                    "Item" => "17",
                    "sendToMessage" => "Getting Wood!",
                    "BroadcastMessage" => "is Getting Wood!"
                ),
                "Mining Stone" => array(
                    "Type" => "break",
                    "Item" => "1",
                    "sendToMessage" => "Mining Stone!",
                    "BroadcastMessage" => "is Mining Stone!"
                ),
                "Mining Iron" => array(
                    "Type" => "break",
                    "Item" => "15",
                    "sendToMessage" => "Mining Iron!",
                    "BroadcastMessage" => "is Mining Iron!"
                ),
                "Mining Gold" => array(
                    "Type" => "break",
                    "Item" => "14",
                    "sendToMessage" => "Mining Gold!",
                    "BroadcastMessage" => "is Mining Gold!"
                ),
                "Mining Diamond" => array(
                    "Type" => "break",
                    "Item" => "56",
                    "sendToMessage" => "Mining Diamond!",
                    "BroadcastMessage" => "is Mining Diamond!"
                ),
                "Mining Lapis Lazuli" => array(
                    "Type" => "break",
                    "Item" => "21",
                    "sendToMessage" => "Mining Lapis Lazuli!",
                    "BroadcastMessage" => "is Mining Lapis Lazuli!"
                ),
                "Mining Coal!" => array(
                    "Type" => "break",
                    "Item" => "21",
                    "sendToMessage" => "Mining Coal!",
                    "BroadcastMessage" => "is Mining Coal!"
                )
            )
        ));
    }

    public function Handler($event, $data)
    {
        foreach ($this->handlers["Achievements"] as $ding => $dong)
        {

            switch($event)
            {
                case "player.block." . $dong["Type"] :
                    $this -> $dong = array();
                    $target = $data["target"];
                    $issuer = $data["player"];
                    $username = $data["player"] -> username;
                    if ($target -> getID() === $dong["Item"])
                    {
                        $getDong = in_array($username, $this -> $dong);
                        if ($getDong === false)
                        {
                            $issuer -> sendChat("[Achievement Get] " . $ding["sendToMessage"]);
                            $this -> api -> chat -> broadcast($username . " " . $ding["BroadcastMessage"]);
                            array_push($this -> $dong, $username);
                        }
                        else
                        {
                            return;
                        }

                    }
                    break;
            }
        }
    }

    public function __destruct()
    {

    }

}
?>

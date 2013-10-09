<?php

/*
 * __PocketMine Plugin__
 * name=TrollPro
 * description=Troll all your friends
 * version=1.0
 * author=Glitchmaster_PE
 * class=Troll
 * apiversion=10
 */

class Troll implements Plugin
{
    private $api;

    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
    }

    public function init()
    {
        $this -> api -> console -> register("troll", "Troll someone. Usage: /troll <playername>", array(
            $this,
            "Troll"
        ));
        $this -> api -> ban -> cmdWhitelist("troll");
    }

    public function Troll($cmd, $args, $issuer, $target)
    {
        switch($cmd)
        {
            case 'troll' :
                switch($args[0])
                {
                    case "drop" :
                        $target = $this -> api -> player -> get($args[1]);
                        if ($target == false)
                        {
                            $username -> sendChat("Player {$target} not founded");
                            return;
                        }

                        $username = $issuer -> username;
                        $this -> api -> console -> run("tp $target 20 300 20");
                        $this -> api -> chat -> broadcast("<server> $target happened to fall from the sky...");
                        $target -> sendChat("You have been trolled by {$username}");
                        //$this->api->chat->sendTo(false, "You have been trolled
                        // by $username", $target);
                        $this -> api -> chat -> sendTo(false, "You trolled {$target}", $issuer);
                        break;
                    case "void" :
                        $target = $target = $this -> api -> player -> get($args[1]);
                        if ($target == false)
                        {
                            $this -> api -> chat -> sendTo(false, "Player {$target} not founded", $issuer);
                            return;
                        }

                        $username = $issuer -> username;
                        $this -> api -> console -> run("tp $target 0 0 0");
                        $this -> api -> chat -> broadcast("<server> $target happened to fall in the void...");
                        $target -> sendChat("You have been trolled by {$username}");
                        //$this->api->chat->sendTo(false, "You have been trolled
                        // by $username", $target);
                        $ouput = "You trolled {$target}";
                        return $output;
                        break;
                    /*case "trap" :
                        if (!isset($args[1]))
                        {
                            $output = 'Usage: /troll trap <player>';
                            break;
                        }
                        $target = $this -> api -> player -> get($args[1]);
                        if (!$target instanceof Player)
                        {
                            $output = "Player doesn't exist";
                            break;
                        }
                        $x = $target -> x;
                        $y = $target -> y;
                        $z = $target -> z;
                        $level = $target -> level;
                        $level -> setBlock(new Vector3(round($x + 1), round($y), round($z)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x - 1), round($y), round($z)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x), round($y + 2), round($z)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x), round($y - 1), round($z)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x), round($y), round($z + 1)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x), round($y), round($z - 1)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x + 1), round($y + 1), round($z)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x - 1), round($y + 1), round($z)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x), round($y + 1), round($z + 1)), BlockAPI::get(95, 0));
                        $level -> setBlock(new Vector3(round($x), round($y + 1), round($z - 1)), BlockAPI::get(95, 0));
                        break;*/
                    default :
                        console("Usage: /troll <drop|void> <victom name>");
                        break;
                }
                break;
        }
    }

    public function __destruct()
    {

    }

}
?>

<?php

/*
 * __PocketMine Plugin__
 * name=KitPro
 * description=Gives a kit when a command is done
 * version=2.0
 * author=Glitchmaster_PE
 * class=KitPro
 * apiversion=10
 */

/*
 This Plugin was made by me, Glitchmaster_PE, and any unauthorized
 distribution is not allowed, please contact me when using any of
 my code in other plugins. Thank you for choosing to use KitPro
 to enhance your server!
 */

class KitPro implements Plugin
{
    private $api;

    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
        $this -> player = array();
    }

    public function init()
    {

        $this -> api -> console -> register("/basic", "Gives the basic kit", array(
            $this,
            "commandHandler"
        ));
        $this -> api -> console -> register("/chef", "Gives the chef kit", array(
            $this,
            "commandHandler"
        ));
        $this -> api -> console -> register("/warrior", "Gives the warrior kit", array(
            $this,
            "commandHandler"
        ));
        $this -> api -> ban -> cmdWhitelist("/basic");
        $this -> api -> ban -> cmdWhitelist("/chef");
        $this -> api -> ban -> cmdWhitelist("/warrior");
        $this -> api -> console -> register("/pyro", "Gives the pyro kit", array(
            $this,
            "commandHandler"
        ));
        $this -> api -> console -> register("/aqua", "Gives the aqua kit", array(
            $this,
            "commandHandler"
        ));
        $this -> api -> console -> register("/gladiator", "Gives the gladiator kit", array(
            $this,
            "commandHandler"
        ));
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> BasicKit = new Config($this -> path . "BasicKit.yml", CONFIG_YAML, array(
            "Item 1 ID" => "268",
            "Item 1 Amount" => "1",
            "Item 2 ID" => "303",
            "Item 2 Amount" => "1",
            "Item 3 ID" => "305",
            "Item 3 Amount" => "1"
        ));
        $this -> BasicKit = $this -> api -> plugin -> readYAML($this -> path . "BasicKit.yml");
        $this -> ChefKit = new Config($this -> path . "ChefKit.yml", CONFIG_YAML, array(
            "Item 1 ID" => "297",
            "Item 1 Amount" => "3",
            "Item 2 ID" => "298",
            "Item 2 Amount" => "1",
            "Item 3 ID" => "260",
            "Item 3 Amount" => "5"
        ));
        $this -> ChefKit = $this -> api -> plugin -> readYAML($this -> path . "ChefKit.yml");
        $this -> WarroirKit = new Config($this -> path . "WarroirKit.yml", CONFIG_YAML, array(
            "Item 1 ID" => "272",
            "Item 1 Amount" => "1",
            "Item 2 ID" => "299",
            "Item 2 Amount" => "1",
            "Item 3 ID" => "301",
            "Item 3 Amount" => "1"
        ));
        $this -> WarroirKit = $this -> api -> plugin -> readYAML($this -> path . "WarroirKit.yml");
        $this -> PyroKit = new Config($this -> path . "PyroKit[OP].yml", CONFIG_YAML, array(
            "Item 1 ID" => "259",
            "Item 1 Amount" => "1",
            "Item 2 ID" => "315",
            "Item 2 Amount" => "1",
            "Item 3 ID" => "316",
            "Item 3 Amount" => "1"
        ));
        $this -> PyroKit = $this -> api -> plugin -> readYAML($this -> path . "PyroKit[OP].yml");
        $this -> AquaKit = new Config($this -> path . "AquaKit[OP].yml", CONFIG_YAML, array(
            "Item 1 ID" => "326",
            "Item 1 Amount" => "5",
            "Item 2 ID" => "327",
            "Item 2 Amount" => "5",
            "Item 3 ID" => "267",
            "Item 3 Amount" => "1"
        ));
        $this -> AquaKit = $this -> api -> plugin -> readYAML($this -> path . "AquaKit[OP].yml");
        $this -> GladiatorKit = new Config($this -> path . "GladiatorKit[OP].yml", CONFIG_YAML, array(
            "Item 1 ID" => "267",
            "Item 1 Amount" => "1",
            "Item 2 ID" => "307",
            "Item 2 Amount" => "1",
            "Item 3 ID" => "308",
            "Item 3 Amount" => "1"
        ));
        $this -> GladiatorKit = $this -> api -> plugin -> readYAML($this -> path . "GladiatorKit[OP].yml");
        $this->api->addHandler("player.death", array($this, "eventHandler"));

    }

    public function commandHandler($cmd, $args, $issuer)
    {
        $username = $issuer -> username;
        $getKit = in_array($username, $this -> player);
        if ($getKit === true)
        {
            $output = "You already have a kit!";
            return $output;
        }
        else
        {
            switch($cmd)
            {
                case "/basic" :
                    if (!$issuer instanceof Player)
                    {
                        $output = "Please run this command in-game!";
                        return $output;
                    }
                    else
                    {
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> BasicKit["Item 1 ID"] . " " . $this -> BasicKit["Item 1 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> BasicKit["Item 2 ID"] . " " . $this -> BasicKit["Item 2 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> BasicKit["Item 3 ID"] . " " . $this -> BasicKit["Item 3 Amount"]);
                        array_push($this -> player, $username);
                        $output = "[KitPro] Your kit has been given!";
                        return $output;
                    }
                    break;
                case "/chef" :
                    if (!$issuer instanceof Player)
                    {
                        $output = "Please run this command in-game!";
                        return $output;
                    }
                    else
                    {
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> ChefKit["Item 1 ID"] . " " . $this -> ChefKit["Item 1 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> ChefKit["Item 2 ID"] . " " . $this -> ChefKit["Item 2 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> ChefKit["Item 3 ID"] . " " . $this -> ChefKit["Item 3 Amount"]);
                        array_push($this -> player, $username);
                        $output = "[KitPro] Your kit has been given!";
                        return $output;
                    }
                    break;
                case "/warrior" :
                    if (!$issuer instanceof Player)
                    {
                        $output = "Please run this command in-game!";
                        return $output;
                    }
                    else
                    {
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> WarroirKit["Item 1 ID"] . " " . $this -> WarroirKit["Item 1 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> WarroirKit["Item 1 ID"] . " " . $this -> WarroirKit["Item 1 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> WarroirKit["Item 1 ID"] . " " . $this -> WarroirKit["Item 1 Amount"]);
                        array_push($this -> player, $username);
                        $output = "[KitPro] Your kit has been given!";
                        return $output;
                    }
                    break;
                case "/pyro" :
                    if (!$issuer instanceof Player)
                    {
                        $output = "Please run this command in-game!";
                        return $output;
                    }
                    else
                    {
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> PyroKit["Item 1 ID"] . " " . $this -> PyroKit["Item 1 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> PyroKit["Item 2 ID"] . " " . $this -> PyroKit["Item 2 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> PyroKit["Item 3 ID"] . " " . $this -> PyroKit["Item 3 Amount"]);
                        array_push($this -> player, $username);
                        $output = "[KitPro] Your kit has been given!";
                        return $output;
                    }
                    break;
                case "/aqua" :
                    if (!$issuer instanceof Player)
                    {
                        $output = "Please run this command in-game!";
                        return $output;
                    }
                    else
                    {
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> AquaKit["Item 1 ID"] . " " . $this -> AquaKit["Item 1 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> AguaKit["Item 2 ID"] . " " . $this -> AquaKit["Item 2 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> AquaKit["Item 3 ID"] . " " . $this -> AquaKit["Item 3 Amount"]);
                        array_push($this -> player, $username);
                        $output = "[KitPro] Your kit has been given!";
                        return $output;
                    }
                    break;
                case "/gladiator" :
                    if (!$issuer instanceof Player)
                    {
                        $output = "Please run this command in-game!";
                        return $output;
                    }
                    else
                    {
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> GladiatorKit["Item 1 ID"] . " " . $this -> GladiatorKit["Item 1 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> GladiatorKit["Item 2 ID"] . " " . $this -> GladiatorKit["Item 2 Amount"]);
                        $this -> api -> console -> run("give " . $issuer . " " . $this -> GladiatorKit["Item 3 ID"] . " " . $this -> GladiatorKit["Item 3 Amount"]);
                        array_push($this -> player, $username);
                        $output = "[KitPro] Your kit has been given!";
                        return $output;
                    }
                    break;
            }
        }

    }

   public function eventHandler($event, $data){
        $username = $data->player->username;
        $getKit = array_search($username, $this -> player);
        unset($this->player[$getKit]);
        $output = "[KitPro] You have died and may choose a new kit!";
        return $output;
    }

    public function __destruct()
    {

    }

}
?>

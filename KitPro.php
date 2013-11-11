<?php

/*
 __PocketMine Plugin__
 name=KitPro
 description=Gives a kit when a command is done
 version=3.2
 author=Glitchmaster_PE
 class=KitPro
 apiversion=10
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
        $this -> api -> console -> register("kit", "Gives a kit", array(
            $this,
            "commandHandler"
        ));
        $this -> api -> ban -> cmdWhitelist("kit");
        $this -> api -> console -> register("donator", "Give a user donator classes", array(
            $this,
            "commandHandler"
        ));
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> kit = new Config($this -> path . "kit.yml", CONFIG_YAML, array(
            "soldier" => array(
                "Donator" => false,
                "Items" => array(
                    array(
                        272,
                        0,
                        1
                    ), // id , meta, count
                    array(
                        260,
                        0,
                        3
                    ),
                )
            ),
            "wool" => array(
                "Donator" => false,
                "Items" => array(
                    array(
                        35,
                        0,
                        1
                    ),
                    array(
                        35,
                        1,
                        1
                    ),
                    array(
                        35,
                        2,
                        1
                    ),
                )
            ),
            "pyro" => array(
                "Donator" => true,
                "Items" => array(
                    array(
                        259,
                        0,
                        1
                    ),
                    array(
                        51,
                        0,
                        5
                    ),
                    array(
                        10,
                        0,
                        10
                    ),
                )
            ),
        ));
        $this -> kit = $this -> api -> plugin -> readYAML($this -> path . "kit.yml");
        $this -> api -> addHandler("player.death", array(
            $this,
            "playerDeath"
        ));
        $this -> donators = new Config($this -> path . "Donators.yml", CONFIG_YAML, array());
        $this -> donators = $this -> api -> plugin -> readYAML($this -> path . "Donators.yml");
    }

    public function commandHandler($cmd, $args, $issuer)
    {
        $username = $issuer -> username;
        if (in_array($username, $this -> player))
        {
            console("You already have a kit!");
        }
        foreach ($this->kit as $kitName => $kit)
        {
            switch($cmd)
            {
                case "kit" :
                    if (!$issuer instanceof Player)
                    {
                        console("Please run this command in-game!");
                    }
                    switch(strtolower($args[0]))
                    {
                        case strtolower($kitName) :
                            if ($kit["Donator"] == true and !in_array($username, $this -> donators))
                            {
                                $output = "You are not a donator!";
                            }
                            else
                            {
                                $this -> giveKit($kit, $issuer);
                                $output = "[KitPro] Your kit has been given!";
                                array_push($this -> player, $username);
                            }
                            break;
                        default :
                            $normalKits = 'Normal Kits: ';
                            $donatorKits = 'Donator Kits: ';
                            foreach ($this->kit as $name => $kit)
                            {
                                if ($kit['Donator'] == true)
                                {
                                    if ($donatorKits === 'Donator Kits: ')
                                    {
                                        $donatorKits .= $name;
                                    }
                                    else
                                    {
                                        $donatorKits .= ', ' . $name;
                                    }
                                }
                                else
                                {
                                    if ($normalKits === 'Normal Kits: ')
                                    {
                                        $normalKits .= $name;
                                    }
                                    else
                                    {
                                        $normalKits .= ', ' . $name;
                                    }
                                }
                            }
                            if ($normalKits !== 'Normal Kits: ')
                            {
                                $issuer -> sendChat($normalKits);
                            }
                            if ($donatorKits !== 'Donator Kits: ')
                            {
                                $issuer -> sendChat($donatorKits);
                            }
                            break;
                    }
                    break;

                case "donator" :
                    $targetUsername = $args[0];
                    array_push($this -> donators, $targetUsername);
                    $output = "[KitPro] $targetUsername added as a donator!";
                    $this -> api -> plugin -> writeYAML($this -> path . "Donators.yml", $this -> donators);
                    break;
            }
        }
        return $output;
    }

    public function giveKit($kit, $player)
    {
        foreach ($kit['Items'] as $val)
        {
            $player -> addItem($val[0], $val[1], $val[2]);
        }
    }

    public function playerDeath($data)
    {
        $key = array_search($data['player'], $this -> player);
        unset($this -> player[$key]);
    }

    public function __destruct()
    {
    }

}
?>

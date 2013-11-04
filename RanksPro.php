<?php

/*
 * __PocketMine Plugin__
 * name=RanksPro
 * version=1.0
 * description=Let's you give people ranks
 * author=Glitchmaster_PE
 * class=Ranks
 * apiversion=10
 */

class Ranks implements Plugin
{
    private $api;

    public function __construct(ServerAPI $api, $server = false)
    {
        $api = $this -> api;
    }

    public function init()
    {
        $this -> api -> plugin -> register("ranks", "Info on the RanksPro plugin", array(
            $this,
            'Ranks'
        ));
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> ranks = new Config($this -> path . "Ranks.yml", CONFIG_YAML, array(
            "Rank 1" => array(
                "Name" => "Owner",
                "Users" => ""
            ),
            "Rank 2" => array(
                "Name" => "Admins",
                "Users" => ""
            ),
            "Rank 3" => array(
                "Name" => "Mods",
                "Users" => ""
            ),
            "Rank 4" => array(
                "Name" => "Trusted",
                "Users" => ""
            )
        ));
        $this -> ranks = $this -> api -> plugin -> readYAML($this -> path . "Ranks.yml");
        $this -> cmds = new Config($this -> path . "Commands.yml", CONFIG_YAML, array(
            $this -> ranks["Rank 1"]["Name"] => "",
            $this -> ranks["Rank 2"]["Name"] => "",
            $this -> ranks["Rank 3"]["Name"] => "",
            $this -> ranks["Rank 4"]["Name"] => ""
        ));
        $this -> cmds = $this -> api -> plugin -> readYAML($this -> path . "Commands.yml");
    }

    public function Ranks($cmd, $args, $issuer)
    {
        switch($args[0])
        {
            case "add" :
                $rank = $args[1];
                $target = $args[2];
                $rank1 = $this -> ranks["Rank 1"]["Name"];
                $rank2 = $this -> ranks["Rank 2"]["Name"];
                $rank3 = $this -> ranks["Rank 3"]["Name"];
                $rank4 = $this -> ranks["Rank 4"]["Name"];
                $rank1users = $this -> ranks["Rank 1"]["Users"];
                $rank2users = $this -> ranks["Rank 2"]["Users"];
                $rank3users = $this -> ranks["Rank 3"]["Users"];
                $rank4users = $this -> ranks["Rank 4"]["Users"];
                if ($rank == $this -> ranks["Rank 1"]["Name"] or $rank == $this -> ranks["Rank 2"]["Name"] or $rank == $this -> ranks["Rank 3"]["Name"] or $rank == $this -> ranks["Rank 4"]["Name"])
                {
                    if ($rank = $rank1)
                    {
                        array_push($this -> ranks["Rank 1"]["Users"], $target);
                        $this -> api -> plugin -> writeYAML($this -> path . "Ranks.yml", $this -> ranks["Rank 1"]["Users"]);
                    }
                    elseif ($rank = $rank2)
                    {
                        array_push($this -> ranks["Rank 2"]["Users"], $target);
                        $this -> api -> plugin -> writeYAML($this -> path . "Ranks.yml", $this -> ranks["Rank 2"]["Users"]);
                    }
                    elseif ($rank = $rank3)
                    {
                        array_push($this -> ranks["Rank 3"]["Users"], $target);
                        $this -> api -> plugin -> writeYAML($this -> path . "Ranks.yml", $this -> ranks["Rank 3"]["Users"]);
                    }
                    elseif ($rank = $rank4)
                    {
                        array_push($this -> ranks["Rank 4"]["Users"], $target);
                        $this -> api -> plugin -> writeYAML($this -> path . "Ranks.yml", $this -> ranks["Rank 4"]["Users"]);
                    }
                    else
                    {
                        $output = "Usage: /ranks add <" . $this -> ranks["Rank 1"]["Name"] . "|" . $this -> ranks["Rank 2"]["Name"] . "|" . $this -> ranks["Rank 3"]["Name"] . "|" . $this -> ranks["Rank 4"]["Name"] . ">" . " <name>";
                        return $output;
                    }
                }
                else
                {
                    $output = "Usage: /ranks add <" . $this -> ranks["Rank 1"]["Name"] . "|" . $this -> ranks["Rank 2"]["Name"] . "|" . $this -> ranks["Rank 3"]["Name"] . "|" . $this -> ranks["Rank 4"]["Name"] . ">" . " <name>";
                    return $output;
                }
        }
    }

    public function __destruct()
    {

    }

}

<?php

/*
 __PocketMine Plugin__
 name=StaffList
 description=Gives list of Staff
 version=2.1
 author=Glitchmaster_PE
 class=StaffList
 apiversion=10
 */

class StaffList implements Plugin
{
    private $api, $path;
    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
    }

    public function init()
    {
        $this -> api -> console -> register("stafflist", "Gives list of staff", array(
            $this,
            "StaffList"
        ));
        $this -> api -> ban -> cmdwhitelist("stafflist");
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> owner = new Config($this -> path . "owner.yml", CONFIG_YAML, array());
        $this -> admins = new Config($this -> path . "admins.yml", CONFIG_YAML, array());
        $this -> mods = new Config($this -> path . "mods.yml", CONFIG_YAML, array());
        $this -> trusted = new Config($this -> path . "trusted.yml", CONFIG_YAML, array());
        $this -> api -> console -> register("staffadd", "Add a staff member", array(
            $this,
            "Staffadd"
        ));
        $this -> reload();
    }

    public function StaffList($cmd, $args, $issuer)
    {
        if($issuer instanceof Player){
        $this -> reload();
        $username = $issuer -> username;
        $this -> api -> chat -> sendTo(false, $msg, $username);
        $msg1 = "[StaffList] Owners: " . implode(", ", $this -> owner);
        $this -> api -> chat -> sendTo(false, $msg1, $username);
        $msg2 = "[StaffList] Admins: " . implode(", ", $this -> admins);
        $this -> api -> chat -> sendTo(false, $msg2, $username);
        $msg3 = "[StaffList] Moderators: " . implode(", ", $this -> mods);
        $this -> api -> chat -> sendTo(false, $msg3, $username);
        $msg4 = "[StaffList] Trusted: " . implode(", ", $this -> trusted);
        $this -> api -> chat -> sendTo(false, $msg4, $username);
        }
        else{
            $output = "Please run this command in-game until I get time to write this part :p";
            return $output;
        }
    }

    public function Staffadd($cmd, $args, $issuer)
    {
        switch($args[0])
        {
            case "owner" :
            case "o" :
                $target = $args[1];
                array_push($this -> owner, $target);
                $this -> owner = $this -> api -> plugin -> writeYAML($this -> path . "owner.yml", $target);
                return "Added " . $target . " as an owner";
                break;
            case "admins" :
            case "admin" :
            case "a" :
                $target = $args[1];
                array_push($this -> admins, $target);
                $this -> admins = $this -> api -> plugin -> writeYAML($this -> path . "admins.yml", $target);
                return "Added " . $target . " as an admin";
                break;
            case "moderators" :
            case "mod" :
            case "moderator" :
            case "mods" :
            case "m" :
                $target = $args[1];
                array_push($this -> mods, $target);
                $this -> mods = $this -> api -> plugin -> writeYAML($this -> path . "mods.yml", $target);
                return "Added " . $target . " as a moderator";
                break;
            case "trusted" :
            case "t" :
                $target = $args[1];
                array_push($this -> trusted, $target);
                $this -> trusted = $this -> api -> plugin -> writeYAML($this -> path . "trusted.yml", $target);
                return "Added " . $target . " as trusted";
                break;
            default :
                $output = "Usage: /staffadd <o|a|m|t> <full username>";
                return $output;
        }
    }

    public function reload()
    {
        $this -> owner = $this -> api -> plugin -> readYAML($this -> path . "owner.yml");
        $this -> admins = $this -> api -> plugin -> readYAML($this -> path . "admins.yml");
        $this -> mods = $this -> api -> plugin -> readYAML($this -> path . "mods.yml");
        $this -> trusted = $this -> api -> plugin -> readYAML($this -> path . "trusted.yml");
    }

    public function __destruct()
    {

    }

}
?>

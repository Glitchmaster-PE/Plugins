<?php

/*
 __PocketMine Plugin__
 name=ChatPro
 description=Adds new commands for handling the chat
 version=4.4
 author=Glitchmaster_PE
 class=ChatPro
 apiversion=10
 */

/*
 This Plugin was made by me, Glitchmaster_PE, and any unauthorized
 distribution is not allowed, please contact me when using any of
 his code in other plugins. Thank you for choosing to use ChatPro
 to enhance your servers chatting!
 */

class ChatPro implements Plugin
{
    private $api, $lang, $prefix0, $prefix, $path, $config, $user, $secondsLeft, $empty;

    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
        $this -> secondsLeft = 0;
        $this -> empty = false;
    }

    public function init()
    {
        $this -> api -> console -> register("stafflist", "Gives a list of this server's staff", array(
            $this,
            "StaffListPro"
        ));
        $this -> api -> console -> register("prefix", "Set a users prefix. Usage: /prefix <username> [prefix]", array(
            $this,
            "Prefix"
        ));
        $this -> api -> ban -> cmdwhitelist("stafflist");
        $this -> readConfig();
        $this -> api -> addHandler("player.join", array(
            $this,
            "handler"
        ), 5);
        $this -> api -> addHandler("player.chat", array(
            $this,
            "handler"
        ), 5);
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> staffmsgs = new Config($this -> path . "staff.yml", CONFIG_YAML, array(
            "Owner" => "<Insert Here>",
            "Admins" => "<Insert Here>",
            "Moderators" => "<Insert Here>",
            "Trusted" => "<Insert Here>"
        ));
        $this -> staffmsgs = $this -> api -> plugin -> readYAML($this -> path . "staff.yml");
        $this -> api -> console -> register("announce", "Gives server announcements", array(
            $this,
            "Announce"
        ));
        $this -> api -> ban -> cmdwhitelist("announce");
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> announcemsgs = new Config($this -> path . "announcements.yml", CONFIG_YAML, array("Announcements" => "YOUR ANNOUNCEMENTS HERE"));
        $this -> announcemsgs = $this -> api -> plugin -> readYAML($this -> path . "announcements.yml");
        $this -> api -> console -> register("/cphelp", "Displays ChatPro commands", array(
            $this,
            "Help"
        ));
        $this -> api -> ban -> cmdwhitelist("/cphelp");
        $this -> api -> console -> register("rules", "Gives server's rules", array(
            $this,
            "Rules"
        ));
        $this -> api -> ban -> cmdwhitelist("rules");
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> rulesmsgs = new Config($this -> path . "rules.yml", CONFIG_YAML, array(
            "Rule-1" => "Do not grief!",
            "Rule-2" => "Do not abuse OP!",
            "Rule-3" => "Do not swear!",
            "Rule-4" => "Do not troll!"
        ));
        $this -> rulesmsgs = $this -> api -> plugin -> readYAML($this -> path . "rules.yml");
        $this -> api -> console -> register("griefwarn", "Warn a griefer", array(
            $this,
            "Grief"
        ));
        $this -> api -> console -> register("trollwarn", "Warn a troller", array(
            $this,
            "Troll"
        ));
        $this -> api -> console -> register("swearwarn", "Warn a person swearing", array(
            $this,
            "Swear"
        ));
        $this -> griefmsgs = new Config($this -> path . "griefwarn.yml", CONFIG_YAML, array("Grief Warning" => "Griefing is not allowed!"));
        $this -> griefmsgs = $this -> api -> plugin -> readYAML($this -> path . "griefwarn.yml");
        $this -> trollmsgs = new Config($this -> path . "trollwarn.yml", CONFIG_YAML, array("Troll Warning" => "Trolling is not allowed!"));
        $this -> trollmsgs = $this -> api -> plugin -> readYAML($this -> path . "trollwarn.yml");
        $this -> swearmsgs = new Config($this -> path . "swearwarn.yml", CONFIG_YAML, array("Swear Warning" => "Swearing is not allowed!"));
        $this -> swearmsgs = $this -> api -> plugin -> readYAML($this -> path . "swearwarn.yml");
        $this -> api -> console -> register("/opcphelp", "Gives list of ChatPro commands for OP", array(
            $this,
            "OPHelp"
        ));
        $this -> api -> console -> register("afk", "Tells everyone your AFK", array(
            $this,
            "afk"
        ));
        $this -> api -> console -> register("afkoff", "Tells everyone your no longer AFK", array(
            $this,
            "afk"
        ));
        $this -> api -> ban -> cmdwhitelist("afk");
        $this -> api -> ban -> cmdwhitelist("afkoff");
        $this -> api -> schedule(200, array(
            $this,
            'PostingTimer'
        ), array(), true, 'server.schedule');
        $this -> api -> console -> register('removepost', 'Remove an automatically posting message', array(
            $this,
            'RemoveMessage'
        ));
        $this -> api -> console -> register('addpost', 'Add an automatically posting message', array(
            $this,
            'AddMessage'
        ));
        $this -> autopost = new Config($this -> path . "autopost.yml", CONFIG_YAML, array(
            "Minutes for broadcast" => array("Minutes" => 10),
            "Messages" => array(
                "1" => "Default Message",
                "2" => "",
                "3" => "",
                "4" => "",
                "5" => "",
                "6" => "",
                "7" => "",
                "8" => "",
                "9" => "",
                "10" => ""
            )
        ));
    }

    public function StaffListPro($cmd, $args, $issuer)
    {
        if (!$issuer instanceof Player)
        {
            $output = "[ChatPro] Owner: " . $this -> staffmsgs["Owner"] . " Admins: " . $this -> staffmsgs["Admins"] . " Moderators: " . $this -> staffmsgs["Moderators"] . " Trusted: " . $this -> staffmsgs["Trusted"];
            return $output;
        }
        $username = $issuer -> username;
        $this -> api -> chat -> sendTo(false, "[ChatPro] Owner: " . $this -> staffmsgs["Owner"] . " Admins: " . $this -> staffmsgs["Admins"] . " Moderators: " . $this -> staffmsgs["Moderators"] . " Trusted: " . $this -> staffmsgs["Trusted"], $username);
    }

    public function Announce($cmd, $args, $issuer)
    {
        if (!$issuer instanceof Player)
        {
            $output = "[ChatPro] " . $this -> announcemsgs["Announcements"];
            return $output;
        }
        $username = $issuer -> username;
        $this -> api -> chat -> sendTo(false, "[ChatPro] " . $this -> announcemsgs["Announcements"], $username);
    }

    public function Help($cmd, $args, $issuer)
    {
        if (!$issuer instanceof Player)
        {
            $output = "[ChatPro] Commands: /rules, /announce, /stafflist, /afk, /afkoff";
            return $output;
        }
        $username = $issuer -> username;
        $this -> api -> chat -> sendTo(false, "[ChatPro] Commands: /rules, /announce, /stafflist, /afk, /afkoff", $username);
    }

    public function Rules($cmd, $args, $issuer)
    {
        if (!$issuer instanceof Player)
        {
            $output = "[ChatPro] Rules: 1. " . $this -> rulesmsgs["Rule-1"] . " 2." . $this -> rulesmsgs["Rule-2"] . " 3. " . $this -> rulesmsgs["Rule-3"] . " 4. " . $this -> rulesmsgs["Rule-4"];
            return $output;
        }
        $username = $issuer -> username;
        $this -> api -> chat -> sendTo(false, "[ChatPro] Rules: 1. " . $this -> rulesmsgs["Rule-1"] . " 2." . $this -> rulesmsgs["Rule-2"] . " 3. " . $this -> rulesmsgs["Rule-3"] . " 4. " . $this -> rulesmsgs["Rule-4"], $username);
    }

    public function Grief($cmd, $args, $issuer, $target)
    {
        $target = $args[0];
        foreach ($this->griefmsgs as $griefmsg)
        {
            $this -> api -> chat -> sendTo(false, "[ChatPro] " . $griefmsg, $target);
        }
    }

    public function Troll($cmd, $args, $issuer, $target)
    {
        $target = $args[0];
        foreach ($this->trollmsgs as $trollmsg)
        {
            $this -> api -> chat -> sendTo(false, "[ChatPro] " . $trollmsg, $target);
        }
    }

    public function Swear($cmd, $args, $issuer, $target)
    {
        $target = $args[0];
        foreach ($this->swearmsgs as $swearmsg)
        {
            $this -> api -> chat -> sendTo(false, "[ChatPro] " . $swearmsg, $target);
        }
    }

    public function OPHelp($cmd, $args, $issuer)
    {
        if (!$issuer instanceof Player)
        {
            $output = "[ChatPro] OP Commands: /prefix, /griefwarn, /trollwarn, /swearwarn, /addpost, /removepost";
            return $output;
        }
        $username = $issuer -> username;
        $this -> api -> chat -> sendTo(false, "[ChatPro] OP Commands: /prefix, /griefwarn, /trollwarn, /swearwarn, /addpost, /removepost", $username);
    }

    public function __destruct()
    {
    }

    public function readConfig()
    {
        $this -> path = $this -> api -> plugin -> createConfig($this, array("format" => "[{prefix}]<{DISPLAYNAME}> {MESSAGE}", ));
        $this -> config = $this -> api -> plugin -> readYAML($this -> path . "config.yml");
    }

    public function Prefix($cmd, $args)
    {
        switch($cmd)
        {
            case "prefix" :
                $player = $args[0];
                $pref = $args[1];

                $this -> config['player'][$player] = $pref;
                $this -> api -> plugin -> writeYAML($this -> path . "config.yml", $this -> config);
                $output .= "[ChatPro] Gave " . $pref . " to " . $player . ".";
                $this -> api -> chat -> sendTo(false, "[ChatPro] Your prefix is now " . $pref . " !", $player);
                break;

            default :
                $output .= 'ChatPro by Glitchmaster_PE';
                break;
        }
    }

    public function handler(&$data, $event)
    {
        switch($event)
        {
            case "player.join" :
                $user = $data -> username;
                if (!isset($this -> config['player'][$user]))
                {
                    $this -> config['player'][$user] = 'Player';
                    $this -> api -> plugin -> writeYAML($this -> path . "config.yml", $this -> config);
                }
                break;
            case "player.chat" :
                $prefix = $data["player"] -> username;
                $this -> config = $this -> api -> plugin -> readYAML($this -> path . "config.yml");
                $data = array(
                    "player" => $data["player"],
                    "message" => str_replace(array(
                        "{DISPLAYNAME}",
                        "{MESSAGE}",
                        "{prefix}"
                    ), array(
                        $data["player"] -> username,
                        $data["message"],
                        $this -> config["player"][$prefix]
                    ), $this -> config["format"])
                );
                if ($this -> api -> handle("ChatPro." . $event, $data) !== false)
                {
                    $this -> api -> chat -> broadcast($data["message"]);
                }
                return false;
                break;
        }
    }

    public function afk($cmd, $arg, $issuer)
    {
        switch($cmd)
        {
            case "afk" :
                $this -> api -> chat -> broadcast("[ChatPro] User " . $issuer -> username . " is now AFK");
                $this -> api -> chat -> sendTo(false, "[ChatPro] Do /afkoff when done", $issuer -> username);
                break;
            case "afkoff" :
                $this -> api -> chat -> broadcast("[ChatPro] User " . $issuer -> username . " is no longer AFK");
                break;
        }
    }

    public function AddMessage($cmd, $arg, $issuer)
    {
        $cfg = $this -> api -> plugin -> readYAML($this -> path . "autopost.yml");
        switch($cmd)
        {
            case "addpost" :
                $mgs = $arg;
                if ($this -> api -> ban -> isOp($issuer) === true)
                {
                    $empty = false;
                    $mNum = 11;
                    foreach ($cfg as $Messages => $elements)
                    {
                        if ($Messages == "Messages")
                        {
                            while ($empty == false)
                            {
                                if ($mNum != 0)
                                {
                                    --$mNum;
                                    if ($cfg['Messages']["$mNum"] === "")
                                    {
                                        $this -> arrayReplace($mNum, $mgs);
                                        $output .= "Message Added!";
                                        $empty = true;
                                        break;
                                    }
                                }
                                else
                                {
                                    $output .= "[ChatPro] There is no available space to add your message. please delete one!";
                                }
                            }
                        }
                    }
                }
                else
                {
                    $output .= "[ChatPro] You have no permission";
                }
        }
        return $output;
    }

    public function RemoveMessage($cmd, $arg, $issuer)
    {
        switch($cmd)
        {
            case "removepost" :
                if ($this -> api -> ban -> isOp($issuer) === false)
                {
                    $num = $arg[0];
                    $this -> arrayReplace($num, "");
                    $output .= "[ChatPro] Message removed!";
                }
                else
                {
                    $output .= "[ChatPro] You have no permission";
                }
        }
        return $output;
    }

    public function PostingTimer()
    {
        $cfg = $this -> api -> plugin -> readYAML($this -> path . "autopost.yml");
        $minutes = $cfg["Minutes for broadcast"]["Minutes"];
        $seconds = $minutes * 60;
        $checkSeconds = $seconds / 300;
        $this -> secondsLeft = $this -> secondsLeft - 10;
        if (!is_int($checkSeconds))
        {
            console("[ChatPro] Minutes must be at least 5!");
            console("[ChatPro] No message will be broadcasted if the time is not change in the config!");
        }
        else
        {
            if ($this -> secondsLeft <= 0)
            {
                $this -> secondsLeft = $seconds;
                $test = 11;
                while ($this -> empty === false)
                {
                    if ($test === 0)
                    {
                        break;
                        $this -> empty = true;
                    }
                    --$test;
                    if ($cfg["Messages"]["$test"] == "")
                    {
                        $this -> empty = false;
                        break;
                    }
                }
                $success = false;
                while ($success == false)
                {
                    $rand = rand(1, 10);
                    if ($cfg["Messages"]["$rand"] == "")
                    {
                        $success = false;
                        $rand = rand(1, 20);
                    }
                    else
                    {
                        $success = true;
                        $this -> api -> chat -> broadcast("[ChatPro] " . $cfg["Messages"]["$rand"]);
                    }
                }
            }
        }
    }

    private function findKey($num)
    {
        $cfg = $this -> api -> plugin -> readYAML($this -> path . "autopost.yml");
        $text = $cfg["Messages"][$num];
        return $text;
    }

    private function arrayReplace($lineToReplace, $message)
    {
        $array = array("Messages" => array());
        $done = false;
        $nums = 1;
        while ($done == false)
        {
            if ($nums == $lineToReplace)
            {
                $array["Messages"][$lineToReplace] = implode(' ', $message);
            }
            else
            {
                $array["Messages"]["$nums"] = $this -> findKey($nums);
            }
            ++$nums;
            if ($nums == 11)
            {
                break;
            }
        }
        safe_var_dump($array);
        $this -> overwriteConfig($array);
    }

    private function overwriteConfig($dat)
    {
        $cfg = array();
        $cfg = $this -> api -> plugin -> readYAML($this -> path . "autopost.yml");
        $result = array_merge($cfg, $dat);
        $this -> api -> plugin -> writeYAML($this -> path . "autopost.yml", $result);
    }

}
?>

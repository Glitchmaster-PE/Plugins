<?

/*
 * __PocketMine Plugin__
 * name=TagPro
 * version=1.0
 * description=Let's you send tagged messages in-game
 * author=Glitchmaster_PE
 * class=Console
 * apiversion=10
 */

class Console implements Plugin
{

    private $api;

    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
    }

    public function init()
    {
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> tag = new Config($this -> path . "TagInfo.yml", CONFIG_YAML, array(
            "Command" => "tag",
            "Tag" => "[TagPro]"
        ));
        $this -> tag = $this -> api -> plugin -> readYAML($this -> path . "TagInfo.yml");
        $this -> api -> console -> register($this->tag["Command"], "Use tagged chat", array(
            $this,
            "commandHandler"
        ));
    }

    public function commandHandler($cmd, $params, $issuer)
    {
        $msg = implode(" ", $params);
        if (trim($s) == "")
        {
            $output .= "Usage: /say <message>\n";
        }
        $this -> api -> chat -> broadcast($this->tag["Tag"] . " " . $msg);
    }

    public function __destruct()
    {

    }

}

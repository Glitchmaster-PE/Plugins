<?php
/*
 __PocketMine Plugin__
 name=NetherQuick
 description=Tap on Nether Reactor to go to the second world loaded or to the
 default world if already in second world
 version=2.0
 author=Glitchmaster_PE
 class=NetherQuick
 apiversion=10
 */

class NetherQuick implements Plugin
{
    private $api;
    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
    }

    public function init()
    {
        $this -> api -> addHandler("player.block.touch", array(
            $this,
            "touchHandler"
        ));
        if (!file_exists('./worlds/Nether/'))
        {
            $file = file_get_contents("http://forums.pocketmine.net/index.php?attachments/nether-zip.359/");
            file_put_contents('./worlds/netherzip.zip', $file);
            $zip = new ZipArchive;
            $result = $zip -> open('./worlds/netherzip.zip');
            $zip -> extractTo('./worlds/');
            $zip -> close();
            unlink('./worlds/netherzip.zip');
        }
        $this -> path = $this -> api -> plugin -> configPath($this);
        $this -> item = new Config($this -> path . "Item.yml", CONFIG_YAML, array("ItemID" => "247"));
        $this -> item = $this -> api -> plugin -> readYAML($this -> path . "Item.yml");
        $this -> api -> level -> loadLevel("Nether");
    }

    public function touchHandler($data, $event)
    {
        if ($data["target"] -> getID() === $this -> item["ItemID"])
        {
            if ($data["player"] -> level !== $this -> api -> level -> getDefault())
            {
                $data["player"] -> teleport($this -> api -> level -> getDefault() -> getSpawn());
            }
            else
            {
                $data["player"] -> teleport($this -> api -> level -> get("Nether") -> getSpawn());
            }
            return false;
        }
    }

    public function __destruct()
    {
    }

}
?>

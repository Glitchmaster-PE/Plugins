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
		if(!file_exists('./worlds/Nether/')){
			$file = @file_get_contents("http://forums.pocketmine.net/index.php?attachments/nether-zip.359/");
			if($file === false){
				console('[ERROR][NetherQuick] Failed downloading the world, check your internet connection or download the map manualy');
				return false;
			}else{
				file_put_contents('./worlds/netherzip.zip', $file);
				$zip = new ZipArchive;
				$result = $zip->open('./worlds/netherzip.zip');
				$zip->extractTo('./worlds/');
				$zip->close();
				unlink('./worlds/netherzip.zip');
				$this->api->level->loadLevel("Nether");
			}
		}else{
			$this->api->level->loadLevel("Nether");
		}
		$this -> api -> addHandler("player.block.touch", array(
            $this,
            "touchHandler"
        ));
		$this -> path = $this -> api -> plugin -> configPath($this);
        $this -> item = new Config($this -> path . "Item.yml", CONFIG_YAML, array("ItemID" => "247"));
        $this -> item = $this -> api -> plugin -> readYAML($this -> path . "Item.yml");
        $this -> api -> level -> loadLevel("Nether");
		$this -> netherreactor = array(4, 4, 4, 4, 4, 4, 41, 41, 41, 41, 4, 4, 4, 4); // Template of how the nether reactor should look like
    }

    public function touchHandler($data)
    {
        if ($data["target"] -> getID() === $this -> item["ItemID"])
        {
			$x = $data["target"]->x;
			$y = $data["target"]->y;
			$z = $data["target"]->z;
			$player = $data["player"];
			$level = $player->level;
			$blocks = array();
			$blocks[] = $level->getBlock(new Vector3($x, $y - 1, $z))->getID();
			$blocks[] = $level->getBlock(new Vector3($x, $y + 1, $z))->getID();
			$blocks[] = $level->getBlock(new Vector3($x + 1, $y - 1, $z))->getID();
			$blocks[] = $level->getBlock(new Vector3($x - 1, $y - 1, $z))->getID();
			$blocks[] = $level->getBlock(new Vector3($x, $y - 1, $z + 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x, $y - 1, $z + 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x + 1, $y - 1, $z + 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x + 1, $y - 1, $z - 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x - 1, $y - 1, $z + 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x - 1, $y - 1, $z - 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x + 1, $y, $z + 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x + 1, $y, $z - 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x - 1, $y, $z + 1))->getID();
			$blocks[] = $level->getBlock(new Vector3($x - 1, $y, $z - 1))->getID();
			if($this->netherreactor === $blocks){
				if ($level !== $this -> api -> level -> getDefault())
				{
					$player -> teleport($this -> api -> level -> getDefault() -> getSpawn());
				}
				else
				{
					$player -> teleport($this -> api -> level -> get("Nether") -> getSpawn());
				}
			}else{
				$player->sendChat("Incorrect pattern!");
			}
            return false;
        }
    }

    public function __destruct(){}

}
?>

<?php

/*
__PocketMine Plugin__
name=StaffList
description=Gives list of Staff
version=1.3
author=Glitchmaster_PE
class=StaffList
apiversion=10
*/


class StaffList implements Plugin{
	private $api, $path;
	public function __construct (ServerAPI $api, $server = false){
		$this->api = $api;
	}

	public function init(){
	  $this->api->console->register("stafflist", "Gives list of staff", array($this, "StaffList"));
	  $this->api->ban->cmdwhitelist("stafflist");
	  $this->path = $this->api->plugin->configPath($this);
	  $this->msgs = new Config($this->path. "staff.yml", CONFIG_YAML, array(
			"  <STAFF>
---Owner---
(INSERT HERE)
---Admins---
(INSERT HERE)
---Moderators---
(INSERT HERE)
---Trusted---
(INSERT HERE)",
		));
		$this->msgs = $this->api->plugin->readYAML($this->path . "staff.yml");
	}

	public function StaffList($cmd, $args, $issuer){
		$username = $issuer->username;
		foreach($this->msgs as $msg){
			$this->api->chat->sendTo(false, $msg, $username);
		}
	}
	public function __destruct(){

	}
}

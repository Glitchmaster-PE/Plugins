<?php

/*
__PocketMine Plugin__
name=AnnouncePro
description=Gives announcements when a player does command
version=0.1.0
author=Glitchmaster_PE
class=AnnouncePro
apiversion=10
*/


class AnnouncePro implements Plugin{
	private $api, $path;
	public function __construct (ServerAPI $api, $server = false){
		$this->api = $api;
	}
	
	public function init(){
	  $this->api->console->register("announce", "Gives a set announcement", array($this, "AnnouncePro"));
	  $this->api->ban->cmdwhitelist("announce");
	  $this->path = $this->api->plugin->createConfig($this, array("Announcement" => "[AnnouncePro]YOUR ANNOUNCMENT HERE"));
	  $this->msgs = $this->api->plugin->readYAML($this->path . "config.yml");
	  }
	  
	  public function AnnouncePro($cmd, $args, $issuer){
			$username = $issuer->username;
			foreach($this->msgs as $msg){
				$this->api->chat->sendTo(false, $msg, $username);
			}
		}
		public function __destruct(){
		
		}
}
	  
	
?>

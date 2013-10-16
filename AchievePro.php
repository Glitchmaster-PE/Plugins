<?php

/*
 * __PocketMine Plugin__
 * name=AchievePro
 * version=1.0
 * description=Gives achievements to users!
 * author=Glitchmaster_PE
 * class=Achieve
 * apiversion=10
 */

class Achieve implements Plugin
{
    private $api;

    public function __construct(ServerAPI $api, $server = false)
    {
        $this -> api = $api;
        $this -> crafting = array();
        $this -> wood = array();
        $this -> stone = array();
        $this -> iron = array();
        $this -> gold = array();
        $this -> diamond = array();
        $this -> lapis = array();
        $this -> coal = array();
        $this -> oven = array();
        $this -> chest = array();
    }

    public function init()
    {
        $this -> api -> addHandler("player.block.place", array(
            $this,
            "placeHandler"
        ));
        $this -> api -> addHandler("player.block.break", array(
            $this,
            "breakHandler"
        ));
        $this -> api -> addHandler("player.block.touch", array(
            $this,
            "touchHandler"
        ));
    }

    public function touchHandler($data)
    {
        $target = $data["target"];
        $username = $data["username"];
        if ($target -> getID() === 58)
        {
            $getCraft = in_array($username, $this -> crafting);
            if ($getCraft === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Benchmaking!");
                $this -> api -> chat -> broadcast("$username is Benchmaking!");
                array_push($this -> crating, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 61)
        {
            $getOven = in_array($username, $this -> oven);
            if ($getOven === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Hot Topic!");
                $this -> api -> chat -> broadcast("$username is a Hot Topic!");
                array_push($this -> oven, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 54)
        {
            $getChest = in_array($username, $this -> chest);
            if ($getChest === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Taking Inventory!");
                $this -> api -> chat -> broadcast("$username is Taking Inventory!");
                array_push($this -> chest, $username);
            }
            else
            {
                return;
            }

        }

    }

    public function breakHandler($data)
    {
        $target = $data["target"];
        $username = $data["username"];
        if ($target -> getID() === 17)
        {
            $getWood = in_array($username, $this -> wood);
            if ($getWood === false)
            {
                $this -> api -> chat -> sendTo(false, "[Achievement Get] Getting Wood!", $username);
                $this -> api -> chat -> broadcast("$username is Getting Wood!");
                array_push($this -> wood, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 1)
        {
            $getStone = in_array($username, $this -> stone);
            if ($getStone === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Mining Stone!");
                $this -> api -> chat -> broadcast("$username is Mining Stone!");
                array_push($this -> stone, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 15)
        {
            $getIron = in_array($username, $this -> iron);
            if ($getIron === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Mining Iron!");
                $this -> api -> chat -> broadcast("$username is Mining Iron!");
                array_push($this -> iron, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 14)
        {
            $getGold = in_array($username, $this -> gold);
            if ($getGold === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Mining Gold!");
                $this -> api -> chat -> broadcast("$username is Mining Gold!");
                array_push($this -> gold, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 56)
        {
            $getDiamond = in_array($username, $this -> diamond);
            if ($getDiamond === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Mining Diamond!");
                $this -> api -> chat -> broadcast("$username is Mining Diamond!");
                array_push($this -> diamond, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 21)
        {
            $getLapis = in_array($username, $this -> lapis);
            if ($getLapis === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Mining Lapis Lazuli!");
                $this -> api -> chat -> broadcast("$username is Mining Lapis Lazuli!");
                array_push($this -> lapis, $username);
            }
            else
            {
                return;
            }

        }
        elseif ($target -> getID() === 16)
        {
            $getCoal = in_array($username, $this -> coal);
            if ($getCoal === false)
            {
                $this -> api -> chat -> sendTo($username, "[Achievement Get] Mining Coal!");
                $this -> api -> chat -> broadcast("$username is Mining Coal!");
                array_push($this -> coal, $username);
            }
            else
            {
                return;
            }

        }
        else
        {
            return;
        }
    }

    public function __destruct(){
        
    }
}
?>

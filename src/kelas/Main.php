<?php

namespace kelas;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Item\Item;

use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

class Main extends PluginBase implements Listener {

  public function onEnable(){
  	  $this->getLogger()->info("[§l§aENABLE§f] Plugin Kelas");
  }
  
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "kelas":
                if($sender instanceof Player){
                	if($sender->hasPermission("kelas.cmd")){
                  	  $this->Kelas($sender);
                   	 return true;
					}else{
						$sender->sendMessage("§cKamu sudah mempunyai kelas!");
						return true;
					}
                } else {
                    $sender->sendMessage("§cUse Cmd InGame");
                    return true;
          	  } 
        }
     }
  
    public function Kelas($player){
        $form = new CustomForm(function (Player $player, $data){
      	    
            if($data !== null){
                $dropdownIndex = $data[4];
                $myArrayName = ["Kelas_A", "Kelas_B"];
                $dropdownValue = $myArrayName[$dropdownIndex];
                $player->sendMessage("Kamu Sekarang Terdaftar Ke Kelas ".$dropdownValue);
                $this->getServer()->dispatchCommand(new ConsoleCommandSender(), "setgroup ".$player->getName()." ".$dropdownValue);
            }

		});

		$form->setTitle("Pendaftaran");
        $form->addLabel("Silahkan Daftar Nama Dan Gamertag Mu Di Bawah Ini Agar Terdaftar Di Sekolah Ini!\n\n§4Pendaftaran Hanya Bisa Di Lakukan Satu Kali!");
        $form->addInput("Nama Panjang", "Nama Asli ( no Gamertag )");
        $form->addInput("Gamertag", $player->getName(), $player->getName());
        
        $myArrayName = ["Kelas_A", "Kelas_B"];
        $form->addSlider("Umur", 10, 30);
        $form->addDropdown("Pilih Kelas", $myArrayName);
		$form->sendToPlayer($player);
		return true;
    }
    
}

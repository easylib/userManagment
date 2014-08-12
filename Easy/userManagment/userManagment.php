<?php
namespace Easy\userManagment;
class userManagment
{
	private $pdo = NULL;
	public function setPDO($pdo)
	{
		$this->pdo = $pdo;
	}
	public function createUser($user, $pw)
	{
		$pw = hash("sha512", $pw);
		if($this->usernameUsed($user)!==false)
		{
			return false;
		}
		$id = $this->pdo->insertID("INSERT INTO `user`(`username`, `pw`) VALUES (?, ?)", array($user, $pw));
		return $id;
	}
	public function usernameUsed($user)
	{
		$r = $this->pdo->fetchOneEntry("SELECT count(*) FROM `user` WHERE `username` = ?", array($user));
		if($r>0)
		{
			return true;
		}
		return false; 
	}
	public function checkLogin($user, $pw)
	{
		$pw = hash("sha512", $pw);
		$res = $this->pdo->query("SELECT * FROM `user` WHERE `username` = ?", array($user));
		if(count($res)!=1)
		{
			return false;
		}
		if($res[0]["pw"]==$pw)
		{
			return $res[0]["id"];
		}
		return false;
	}
	public function installQuery()
	{
		$querys = array();
		$querys[] = 'CREATE TABLE IF NOT EXISTS `user` (`id` int(255) NOT NULL, `username` varchar(255) NOT NULL, `pw` varchar(255) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
		$querys[] = 'ALTER TABLE `installQuery` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);';
		$querys[] = 'ALTER TABLE `installQuery` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;';
		return array(1, $querys);
	}
}
?>
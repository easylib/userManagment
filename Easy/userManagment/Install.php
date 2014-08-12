<?php
namespace Easy\userManagment;
class Install
{
	public function __construct()
	{
		$this->version = 1;
		$this->querys = array();
		//Querys Version 1
		$this->querys[1][] = 'CREATE TABLE IF NOT EXISTS `user` (`id` int(255) NOT NULL, `username` varchar(255) NOT NULL, `pw` varchar(255) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
		$this->querys[1][] = 'ALTER TABLE `installQuery` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);';
		$this->querys[1][] = 'ALTER TABLE `installQuery` MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;';

	}
	public function installQuery()
	{
		$q = array();
		foreach($this->querys as $vq)
		{
			foreach($vq as $query)
			{
				$q[] = $query;
			}
		}
		return array($this->version, $q);
	}
	public function updateQuery($version = 0)
	{
		$q = array();
		for($i=$version+1;$i<$this->version+1;$i++;)
		{
			if(isset($this->querys[$i]))
			{
				$vq = $this->querys[$i];
				foreach($vq as $query)
				{
					$q[] = $query;
				}
		}
		return array($this->version, $q);
	}
}
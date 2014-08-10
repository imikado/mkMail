<?php
class model_installation extends abstract_model{
	
	protected $sClassRow='row_mails';
	
	protected $sTable='mails';
	protected $sConfig='mkMail';

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}
	
	public function run(){
		$sSql=file_get_contents(_root::getConfigVar('path.data').'sql/tables.sql');
		
		$this->execute($sSql);
	}
	
}

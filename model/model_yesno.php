<?php
class model_yesno extends abstract_model{
	
	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function getSelect(){
		return array('no','yes');
	}
	
}

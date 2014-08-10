<?php
class model_columns extends abstract_model{

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}
	
	public function getSelect(){
		return array(
			'from' => 'from',
			'date' => 'date',
			'subject' => 'subject',
		);
	}
	
}

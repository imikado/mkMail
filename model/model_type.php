<?php
class model_type extends abstract_model{

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}
	
	public function getSelect(){
		return array(
			'table' => 'table',
			'files' => 'files',
			'links' => 'links',
			'complete' => 'complete',
			'contacts' => 'contacts',
		);
	}
	
}

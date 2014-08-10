<?php 
class module_default extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
	}
	
	public function _index(){
	    $oView=new _view('default::index');
		
		$this->oLayout->add('main',$oView);
	}
	
	public function _install(){
		model_installation::getInstance()->run();
		
		_root::redirect('dashboard::index');
	}
	
	public function _reset(){
		model_mails::getInstance()->reset();
		
		print "reset";
	}
	
	public function after(){
		$this->oLayout->show();
	}
}

<?php 
class module_keywords extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	public function _list(){
		
		$tKeywords=model_keywords::getInstance()->findAll();
		
		$oView=new _view('keywords::list');
		$oView->tKeywords=$tKeywords;
		
		

		$this->oLayout->add('main',$oView);
	}

	public function _show(){
		$oKeywords=model_keywords::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('keywords::show');
		$oView->oKeywords=$oKeywords;
		
		
		$this->oLayout->add('main',$oView);
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}


/*variables
#select		$oView->tJoinkeywords=keywords::getInstance()->getSelect();#fin_select
variables*/

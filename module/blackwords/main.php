<?php 
class module_blackwords extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tBlackwords=model_blackwords::getInstance()->findAll();
		
		$oView=new _view('blackwords::list');
		$oView->tBlackwords=$tBlackwords;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oBlackwords=new row_blackwords;
		
		$oView=new _view('blackwords::new');
		$oView->oBlackwords=$oBlackwords;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oBlackwords=model_blackwords::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('blackwords::edit');
		$oView->oBlackwords=$oBlackwords;
		$oView->tId=model_blackwords::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _show(){
		$oBlackwords=model_blackwords::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('blackwords::show');
		$oView->oBlackwords=$oBlackwords;
		
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oBlackwords=model_blackwords::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('blackwords::delete');
		$oView->oBlackwords=$oBlackwords;
		
		

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	

	private function processSave(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$iId=_root::getParam('id',null);
		if($iId==null){
			$oBlackwords=new row_blackwords;	
		}else{
			$oBlackwords=model_blackwords::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('name');
		foreach($tColumn as $sColumn){
			$oBlackwords->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oBlackwords->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('blackwords::list');
		}else{
			return $oBlackwords->getListError();
		}
		
	}
	
	
	public function processDelete(){
		if(!_root::getRequest()->isPost() ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oBlackwords=model_blackwords::getInstance()->findById( _root::getParam('id',null) );
				
		$oBlackwords->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('blackwords::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}


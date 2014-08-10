<?php 
class module_contacts extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tContacts=model_contacts::getInstance()->findAll();
		
		$oView=new _view('contacts::list');
		$oView->tContacts=$tContacts;
		
		
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oContacts=new row_contacts;
		
		$oView=new _view('contacts::new');
		$oView->oContacts=$oContacts;
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oContacts=model_contacts::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('contacts::edit');
		$oView->oContacts=$oContacts;
		$oView->tId=model_contacts::getInstance()->getIdTab();
		
		
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _show(){
		$oContacts=model_contacts::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('contacts::show');
		$oView->oContacts=$oContacts;
		
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oContacts=model_contacts::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('contacts::delete');
		$oView->oContacts=$oContacts;
		
		

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
			$oContacts=new row_contacts;	
		}else{
			$oContacts=model_contacts::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('lastname','firstname','email');
		foreach($tColumn as $sColumn){
			$oContacts->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		$tColumnUpload=array('picture');
		if($tColumnUpload){
			foreach($tColumnUpload as $sColumnUpload){
				$oPluginUpload=new plugin_upload($sColumnUpload);
				if($oPluginUpload->isValid()){
					$sNewFileName=_root::getConfigVar('path.upload').$sColumnUpload.'_'.date('Ymdhis');

					$oPluginUpload->saveAs($sNewFileName);
					$oContacts->$sColumnUpload=$oPluginUpload->getPath();
				}
			}
		}

		
		if($oContacts->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('contacts::list');
		}else{
			return $oContacts->getListError();
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
	
		$oContacts=model_contacts::getInstance()->findById( _root::getParam('id',null) );
				
		$oContacts->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('contacts::list');
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}


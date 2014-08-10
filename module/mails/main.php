<?php 
class module_mails extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('template1');
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	
	
	public function _index(){
	    //on considere que la page par defaut est la page de listage
	    $this->_list();
	}
	
	
	public function _list(){
		
		$tMails=model_mails::getInstance()->findAll();
		
		$oView=new _view('mails::list');
		$oView->tMails=$tMails;
		
				$oView->tJoinmodel_yesno=model_yesno::getInstance()->getSelect();		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		
		$this->oLayout->add('main',$oView);
		 
	}

	
	
	public function _new(){
		$tMessage=$this->processSave();
	
		$oMails=new row_mails;
		
		$oView=new _view('mails::new');
		$oView->oMails=$oMails;
		
				$oView->tJoinmodel_yesno=model_yesno::getInstance()->getSelect();		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _edit(){
		$tMessage=$this->processSave();
		
		$oMails=model_mails::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('mails::edit');
		$oView->oMails=$oMails;
		$oView->tId=model_mails::getInstance()->getIdTab();
		
				$oView->tJoinmodel_yesno=model_yesno::getInstance()->getSelect();		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		$this->oLayout->add('main',$oView);
	}

	public function _showTitle(){
		_root::setConfigVar('site.mode','test');
		
		$this->oLayout->setLayout('frame');
		
		$oMails=model_mails::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('mails::showTitle');
		$oView->oMails=$oMails;
		
				$oView->tJoinmodel_yesno=model_yesno::getInstance()->getSelect();		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		$this->oLayout->add('main',$oView);
	}
	
	public function _show(){
		_root::setConfigVar('site.mode','test');
		
		$this->oLayout->setLayout('empty');
		
		$oMails=model_mails::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('mails::show');
		$oView->oMails=$oMails;
		
				$oView->tJoinmodel_yesno=model_yesno::getInstance()->getSelect();		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		$this->oLayout->add('main',$oView);
	}
	
	public function _showKeywords(){
		_root::setConfigVar('site.mode','test');
		
		$this->oLayout->setLayout('frame');
		
		print 'Keywords:';
		
		$tKeywords=model_mails_keywords::getInstance()->findListByMail(_root::getParam('id') );
		foreach($tKeywords as $oKeywords){
			print $oKeywords->name;
			print ',';
		}
	}
	
	
	public function _showTags(){
		
		
		_root::setConfigVar('site.mode','test');
		
		$this->oLayout->setLayout('frame');
		
		$oView=new _view('mails::showTags');
		
		$tTags=model_mails_tags::getInstance()->findListByMail(_root::getParam('id') );
		$oView->tTags=$tTags;
		
		$this->oLayout->add('main',$oView);
	}
	public function _editTags(){
		
		_root::setConfigVar('site.mode','test');
		
		$this->oLayout->setLayout('frame');
		
		$this->processSaveTags();
		
		$oView=new _view('mails::editTags');
		
		$tTagsMail=model_mails_tags::getInstance()->findListIndexedByMail(_root::getParam('id') );
		$oView->tTagsMail=$tTagsMail;
		
		$oView->tTags=model_tags::getInstance()->findAll();
		
		$this->oLayout->add('main',$oView);
	}
	
	private function processSaveTags(){
		if(!_root::getRequest()->isPost()){
			return null;
		}
		$mail_id=_root::getParam('id');
		
		$tTagsId=_root::getParam('tTagsId');
		
		$sNewTag=_root::getParam('newTag');
		if($sNewTag){
			$oTag=model_tags::getInstance()->findByName($sNewTag);
			if(!$oTag){
				
				$oTag=new row_tags;
				$oTag->name=$sNewTag;
				$oTag->save();
			}
			
			$tTagsId[]=$oTag->id;
		}
		
		model_mails_tags::getInstance()->saveTabForMail($tTagsId,$mail_id);
		
		_root::redirect('mails::showTags',array('id'=>$mail_id));
		
	}
	
	public function _showFiles(){
		_root::setConfigVar('site.mode','test');
		
		$this->oLayout->setLayout('frame');
		
		$oView=new _view('mails::showFiles');
		$oView->tFiles=model_files::getInstance()->findListByMail(_root::getParam('id') );
		
		$this->oLayout->add('main',$oView);
	}

	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oMails=model_mails::getInstance()->findById( _root::getParam('id') );
		
		$oView=new _view('mails::delete');
		$oView->oMails=$oMails;
		
				$oView->tJoinmodel_yesno=model_yesno::getInstance()->getSelect();		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();

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
			$oMails=new row_mails;	
		}else{
			$oMails=model_mails::getInstance()->findById( _root::getParam('id',null) );
		}
		
		$tColumn=array('subject','body','messageId','date','time','active','from_id');
		foreach($tColumn as $sColumn){
			$oMails->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oMails->save()){
			//une fois enregistre on redirige (vers la page liste)
			_root::redirect('mails::list');
		}else{
			return $oMails->getListError();
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
	
		$oMails=model_mails::getInstance()->findById( _root::getParam('id',null) );
				
		$oMails->delete();
		//une fois enregistre on redirige (vers la page liste)
		_root::redirect('mails::list');
		
	}
	
	public function _processIndexation(){
		
		model_mails_keywords::getInstance()->clearAllKeywords();
		
		$tMail=model_mails::getInstance()->findAll();
		foreach($tMail as $oMail){
			$oMail->processIndexation();
		}
	}
	
	public function _processIndexationLinks(){
		
		echo '<textarea style="width:100%;height:500px">';
		
		$i=0;
		$tMail=model_mails::getInstance()->findAllActive();
		foreach($tMail as $oMail){
			
			$oMail->processIndexationLinks();
			$i++;
			
			//if($i > 100){ break;}
		}
		
		exit;
		
	}


	
	public function after(){
		$this->oLayout->show();
	}
	
	
}


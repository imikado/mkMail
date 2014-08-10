<?php 
class module_boxEmbedded extends abstract_moduleembedded{
	
	public static $sModuleName='boxEmbedded';
	public static $sRootModule;
	public static $tRootParams;
	
	public function __construct(){
		self::setRootLink(_root::getParamNav(),null);
	}
	public static function setRootLink($sRootModule,$tRootParams=null){
		self::$sRootModule=$sRootModule;
		self::$tRootParams=$tRootParams;
	}
	public static function getLink($sAction,$tParam=null){
		return parent::_getLink(self::$sRootModule,self::$tRootParams,self::$sModuleName,$sAction,$tParam);
	}
	public static function getParam($sVar,$uDefault=null){
		return parent::_getParam(self::$sModuleName,$sVar,$uDefault);
	}
	public static function redirect($sModuleAction,$tModuleParam=null){
		return parent::_redirect(self::$sRootModule,self::$tRootParams,self::$sModuleName,$sModuleAction,$tModuleParam);
	}
	
	/*
	Pour integrer au sein d'un autre module:
	
	//instancier le module
	$oModuleExamplemodule=new module_boxEmbedded();
	
	//si vous souhaitez indiquer au module integrable des informations sur le module parent
	//$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
	
	//recupere la vue du module
	$oViewModule=$oModuleExamplemodule->_index();
	
	//assigner la vue retournee a votre layout
	$this->oLayout->add('main',$oViewModule);
	*/
	
	
	public function _index(){
		$sAction='_'.self::getParam('Action','list');
		return $this->$sAction();
	}
	
	
	public function _list(){
		
		$tBox=model_box::getInstance()->findAll();
		
		$oView=new _view('boxEmbedded::list');
		$oView->tBox=$tBox;
		
				$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();		$oView->tJoinmodel_type=model_type::getInstance()->getSelect();		$oView->tJoinmodel_columns=model_columns::getInstance()->getSelect();		$oView->tJoinmodel_keywords=model_keywords::getInstance()->getSelect();
		
		return $oView;
		 
	}


	
	
	public function _edit($id){
		$tMessage=$this->processSave($id);
		
		$oBox=model_box::getInstance()->findById( $id );
		
		$oView=new _view('boxEmbedded::edit');
		$oView->oBox=$oBox;
		$oView->tId=model_box::getInstance()->getIdTab();
		
		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelectWithEmpty();		
		$oView->tJoinmodel_type=model_type::getInstance()->getSelect();		
		$oView->tJoinmodel_columns=model_columns::getInstance()->getSelect();		
		$oView->tJoinmodel_keywords=model_keywords::getInstance()->getSelect();
		$oView->tJoinmodel_tags=model_tags::getInstance()->getSelect();
		
		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}

	
	
	public function _show(){
		$oBox=model_box::getInstance()->findById( module_boxEmbedded::getParam('id') );
		
		$oView=new _view('boxEmbedded::show');
		$oView->oBox=$oBox;
		
				$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();		$oView->tJoinmodel_type=model_type::getInstance()->getSelect();		$oView->tJoinmodel_columns=model_columns::getInstance()->getSelect();		$oView->tJoinmodel_keywords=model_keywords::getInstance()->getSelect();
		return $oView;
	}

	
	
	public function _delete(){
		$tMessage=$this->processDelete();

		$oBox=model_box::getInstance()->findById( module_boxEmbedded::getParam('id') );
		
		$oView=new _view('boxEmbedded::delete');
		$oView->oBox=$oBox;
		
				$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();		$oView->tJoinmodel_type=model_type::getInstance()->getSelect();		$oView->tJoinmodel_columns=model_columns::getInstance()->getSelect();		$oView->tJoinmodel_keywords=model_keywords::getInstance()->getSelect();

		$oPluginXsrf=new plugin_xsrf();
		$oView->token=$oPluginXsrf->getToken();
		$oView->tMessage=$tMessage;
		
		return $oView;
	}


	private function processSave($iId){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		
		$oBox=model_box::getInstance()->findById( $iId );
		
		$tColumn=array('from_id','ordered','columns','type','keywords','width','height','tags','title');
		foreach($tColumn as $sColumn){
			$oBox->$sColumn=_root::getParam($sColumn,null) ;
		}
				
		if($oBox->save()){
			//une fois enregistre on redirige (vers la page liste)
			$this->redirect('list');
		}else{
			return $oBox->getListError();
		}
		
	}

	
	
	public function processDelete(){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$oBox=model_box::getInstance()->findById( module_boxEmbedded::getParam('id',null) );
				
		$oBox->delete();
		//une fois enregistre on redirige (vers la page liste)
		$this->redirect('list');
		
	}

	
	
	
}

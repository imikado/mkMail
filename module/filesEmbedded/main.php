<?php 
class module_filesEmbedded extends abstract_moduleembedded{
	
	public static $sModuleName='filesEmbedded';
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
	$oModuleExamplemodule=new module_filesEmbedded();
	
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
		
		$tFiles=model_files::getInstance()->findAll();
		
		$oView=new _view('filesEmbedded::list');
		$oView->tFiles=$tFiles;
		
		
		
		return $oView;
		 
	}

	
	
	
	
	
	
	public function _show(){
		$oFiles=model_files::getInstance()->findById( module_filesEmbedded::getParam('id') );
		
		$oView=new _view('filesEmbedded::show');
		$oView->oFiles=$oFiles;
		
		
		return $oView;
	}

	
	

	private function processSave(){
		if(!_root::getRequest()->isPost() or _root::getParam('formmodule')!=self::$sModuleName ){ //si ce n'est pas une requete POST on ne soumet pas
			return null;
		}
		
		$oPluginXsrf=new plugin_xsrf();
		if(!$oPluginXsrf->checkToken( _root::getParam('token') ) ){ //on verifie que le token est valide
			return array('token'=>$oPluginXsrf->getMessage() );
		}
	
		$iId=module_filesEmbedded::getParam('id',null);
		if($iId==null){
			$oFiles=new row_files;	
		}else{
			$oFiles=model_files::getInstance()->findById( module_filesEmbedded::getParam('id',null) );
		}
		
		$tColumn=array('name','path');
		foreach($tColumn as $sColumn){
			$oFiles->$sColumn=_root::getParam($sColumn,null) ;
		}
		
		
		if($oFiles->save()){
			//une fois enregistre on redirige (vers la page liste)
			$this->redirect('list');
		}else{
			return $oFiles->getListError();
		}
		
	}

	
	
	
	
	
}

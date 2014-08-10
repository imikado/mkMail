<?php 
class module_contactsEmbedded extends abstract_moduleembedded{
	
	public static $sModuleName='contactsEmbedded';
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
	$oModuleContactsEmbedded=new module_contactsEmbedded();
	
	//si vous souhaitez indiquer au module integrable des informations sur le module parent
	//$oModuleContactsEmbedded->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
	
	//recupere la vue du module
	$oViewModule=$oModuleContactsEmbedded->_index();
	
	//assigner la vue retournee a votre layout
	$this->oLayout->add('main',$oViewModule);
	*/
	
	
	public function _index(){
		$sAction='_'.self::getParam('Action','list');
		return $this->$sAction();
	}
	
	public function _list(){
		
		$tContacts=model_contacts::getInstance()->findAll();
		
		$oView=new _view('contactsEmbedded::list');
		$oView->tContacts=$tContacts;
		
		

		return $oView;
	}

	public function _show(){
		$oContacts=model_contacts::getInstance()->findById( module_contactsEmbedded::getParam('id') );
		
		$oView=new _view('contactsEmbedded::show');
		$oView->oContacts=$oContacts;
		
		
		return $oView;
	}
	
	
}

/*variables
#select		$oView->tJoincontacts=contacts::getInstance()->getSelect();#fin_select
#uploadsave $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oContacts->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave
variables*/


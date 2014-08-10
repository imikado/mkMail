<?php 
class module_mailsEmbedded extends abstract_moduleembedded{
	
	public static $sModuleName='mailsEmbedded';
	public static $sRootModule;
	public static $tRootParams;
	
	public static $idMail=0;
	
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
	
	public static function getId(){
		self::$idMail++;
		
		return self::$idMail;
	}
	
	/*
	Pour integrer au sein d'un autre module:
	
	//instancier le module
	$oModuleMailsEmbedded=new module_mailsEmbedded();
	
	//si vous souhaitez indiquer au module integrable des informations sur le module parent
	//$oModuleMailsEmbedded->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
	
	//recupere la vue du module
	$oViewModule=$oModuleMailsEmbedded->_index();
	
	//assigner la vue retournee a votre layout
	$this->oLayout->add('main',$oViewModule);
	*/
	
	
	public function _index(){
		$sAction='_'.self::getParam('Action','list');
		return $this->$sAction();
	}
	
	public function _listByFrom($contact_id){
		
		$oContact=model_contacts::getInstance()->findById($contact_id);
		
		$tFiles=model_files::getInstance()->findAllByFrom($contact_id);
		$tMails=model_mails::getInstance()->findAllByFrom($contact_id);
		
		$oView=new _view('mailsEmbedded::list');
		$oView->tMails=$tMails;
		$oView->oContact=$oContact;
		$oView->tFiles=$tFiles;
		
		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();

		return $oView;
	}
	
	public function _listByKeywords($tKeywords){
		
		$tFiles=model_files::getInstance()->findAllByKeywords($tKeywords);
		$tLinks=model_links::getInstance()->findAllByKeywords($tKeywords);
		
		
		$tMails=model_mails::getInstance()->findAllByKeywords($tKeywords);
		
		$oView=new _view('mailsEmbedded::list');
		$oView->tMails=$tMails;
		
		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		$oView->tFiles=$tFiles;
		$oView->tLinks=$tLinks;

		return $oView;
	}
	
	public function _listByTags($tKeywords){
		
		$tFiles=model_files::getInstance()->findAllByTags($tKeywords);
		
		$tMails=model_mails::getInstance()->findAllByTags($tKeywords);
		
		$oView=new _view('mailsEmbedded::list');
		$oView->tMails=$tMails;
		
		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		$oView->tFiles=$tFiles;

		return $oView;
	}
	
	
	
	public function _list(){
				
		$tMails=model_mails::getInstance()->findAll();
		
		$oView=new _view('mailsEmbedded::list');
		$oView->tMails=$tMails;
		
		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		$oView->tFiles=null;
		


		return $oView;
	}

	public function _show(){
		$oMails=model_mails::getInstance()->findById( module_mailsEmbedded::getParam('id') );
		
		$oView=new _view('mailsEmbedded::show');
		$oView->oMails=$oMails;
		
				$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelect();
		return $oView;
	}
	
	
}

/*variables
#select		$oView->tJoinmails=mails::getInstance()->getSelect();#fin_select
#uploadsave $oPluginUpload=new plugin_upload($sColumn);
			if($oPluginUpload->isValid()){
				$sNewFileName=_root::getConfigVar('path.upload').$sColumn.'_'.date('Ymdhis');

				$oPluginUpload->saveAs($sNewFileName);
				$oMails->$sColumn=$oPluginUpload->getPath();
				continue;	
			}else #fin_uploadsave
variables*/


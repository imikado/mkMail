<?php
class model_files extends abstract_model{
	
	protected $sClassRow='row_files';
	
	protected $sTable='files';
	protected $sConfig='mkMail';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE id=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT files.*,mails.subject FROM '.$this->sTable.' INNER JOIN mails ON files.mails_id=mails.id');
	}
	
	public function findByNameAndMail($mail_id,$name){
		return $this->findOneSimple('SELECT * FROM '.$this->sTable.' WHERE mails_id=? AND name=?',$mail_id,$name );
	}
	
	public function findAllByKeywords($tKeywords){
		if(!$tKeywords){
			return null;
		}
		
		$tFiles = $this->findMany('SELECT files.*,mails.subject FROM files INNER JOIN mails ON files.mails_id=mails.id INNER JOIN mails_keywords ON mails_keywords.mails_id=.files.mails_id WHERE active=1 AND keywords_id in ('.implode(',',$tKeywords).')');
		
		return $tFiles;
	}
	public function findAllByTags($tKeywords){
		if(!$tKeywords){
			return null;
		}else if($tKeywords[0]==''){
			return null;
		}
		
		$tFiles = $this->findMany('SELECT files.*,mails.subject FROM files INNER JOIN mails ON files.mails_id=mails.id INNER JOIN mails_tags ON mails_tags.mails_id=.files.mails_id WHERE active=1 AND tags_id in ('.implode(',',$tKeywords).')');
		
		return $tFiles;
	}
	
	public function findAllByFrom($contact_id){		 
		 $tFiles = $this->findMany('SELECT files.*,mails.subject FROM files INNER JOIN mails ON files.mails_id=mails.id  WHERE active=1 AND from_id =?',$contact_id);
		
		return $tFiles;
	}
	
	
	public function findListByMail($mail_id){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE mails_id=?',$mail_id);
	}
}

class row_files extends abstract_row{
	
	protected $sClassModel='model_files';
	
	/*exemple jointure 
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	/*exemple test validation*/
	private function getCheck(){
		$oPluginValid=new plugin_valid($this->getTab());
		/* renseigner vos check ici
		$oPluginValid->isEqual('champ','valeurB','Le champ n\est pas &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isNotEqual('champ','valeurB','Le champ est &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isUpperThan('champ','valeurB','Le champ n\est pas sup&eacute; &agrave; '.$valeurB);
		$oPluginValid->isUpperOrEqualThan('champ','valeurB','Le champ n\est pas sup&eacute; ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isLowerThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur &agrave; '.$valeurB);
		$oPluginValid->isLowerOrEqualThan('champ','valeurB','Le champ n\est pas inf&eacute;rieur ou &eacute;gal &agrave; '.$valeurB);
		$oPluginValid->isEmpty('champ','Le champ n\'est pas vide');
		$oPluginValid->isNotEmpty('champ','Le champ ne doit pas &ecirc;tre vide');
		$oPluginValid->isEmailValid('champ','L\email est invalide');
		$oPluginValid->matchExpression('champ','/[0-9]/','Le champ n\'est pas au bon format');
		$oPluginValid->notMatchExpression('champ','/[a-zA-Z]/','Le champ ne doit pas &ecirc;tre a ce format');
		*/

		return $oPluginValid;
	}

	public function isValid(){
		return $this->getCheck()->isValid();
	}
	public function getListError(){
		return $this->getCheck()->getListError();
	}
	public function save(){
		if(!$this->isValid()){
			return false;
		}
		parent::save();
		return true;
	}

}

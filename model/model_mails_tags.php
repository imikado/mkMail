<?php
class model_mails_tags extends abstract_model{
	
	protected $sClassRow='row_mails_tags';
	
	protected $sTable='mails_tags';
	protected $sConfig='mkMail';
	
	protected $tId=array('mails_id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE mails_id=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable);
	}
	
	public function clearAllKeywords(){
		$this->execute('DELETE FROM mails_tags WHERE mails_id > 0');
		$this->execute('DELETE FROM tags where ID > 0');
	}
		
	public function clearKeywordsByMail($mail_id){
		$this->execute('DELETE FROM '.$this->sTable.' WHERE mails_id=?',$mail_id);
	}
	
	public function findListByMail($mail_id){
		return $this->findManySimple('SELECT tags.id,tags.name FROM tags INNER join mails_tags ON tags.id=mails_tags.tags_id WHERE mails_id=?',$mail_id);
	}
	
	public function findListIndexedByMail($mail_id){
		$tRow=$this->findListByMail($mail_id);
		$tIndexed=array();
		if($tRow){
			foreach($tRow as $oRow){
				$tIndexed[$oRow->id]=$oRow->id;
			}
		}
		return $tIndexed;
	}
	
	public function saveTabForMail($tTagsId,$mail_id){
		$this->clearKeywordsByMail($mail_id);
		
		if($tTagsId){
			foreach($tTagsId as $tags_id){
				$this->execute('INSERT INTO '.$this->sTable.' (tags_id,mails_id) VALUES ( ?,?)',$tags_id,$mail_id);
			}
		}
	}
	
}

class row_mails_tags extends abstract_row{
	
	protected $sClassModel='model_mails_tags';
	
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

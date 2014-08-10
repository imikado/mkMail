<?php
class model_mails extends abstract_model{
	
	protected $sClassRow='row_mails';
	
	protected $sTable='mails';
	protected $sConfig='mkMail';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE id=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable .' WHERE active=1 ORDER BY date desc,time desc LIMIT 0,1000 ');
	}
	
	public function findAllActive(){
		return $this->findMany('SELECT * FROM '.$this->sTable .' WHERE active=1 ');
	}
	
	public function findByMessageId($messageId){
		return $this->findOneSimple('SELECT * FROM '.$this->sTable.' WHERE messageId=?',$messageId );
	}
	public function findByMessageIdComplete($messageId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE messageId=?',$messageId );
	}
	
	public function findAllByFrom($id){
		return $this->findMany('SELECT * FROM '.$this->sTable.' WHERE active=1 AND from_id=?',$id);
	}
	
	public function findAllByKeywords($tKeywords){
		if(!$tKeywords){
			return null;
		}
		
		return $this->findMany('SELECT * FROM '.$this->sTable.' INNER JOIN mails_keywords ON mails_id=mails.id WHERE active=1 AND keywords_id in ('.implode(',',$tKeywords).')');
	}
	
	public function findAllByTags($tKeywords){
		if(!$tKeywords){
			return null;
		}else if($tKeywords[0]==''){
			return null;
		}
		
		return $this->findMany('SELECT * FROM '.$this->sTable.' INNER JOIN mails_tags ON mails_id=mails.id WHERE active=1 AND tags_id in ('.implode(',',$tKeywords).')');
	}
	
	
	
	public function findLast(){
		return $this->findOneSimple('SELECT * FROM '.$this->sTable.' ORDER BY date desc,time desc LIMIT 1' );
	}
	
	public function reset(){
		$this->execute('
		delete from mails where id>0;
		delete from mails_keywords where mails_id>0;
		delete from mails_tags where mails_id>0;
		delete from tags where id>0;
		');
	}
	
}

class row_mails extends abstract_row{
	
	protected $sClassModel='model_mails';
	
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
	
	private function processWords($tIndexed,$sWords){
		
		$sWords=strip_tags($sWords);
		
		$tBlackwords=model_blackwords::getInstance()->getSelect();
		
		preg_match_all('/[a-zA-Z\@\-]*/',$sWords,$find);
		
		$tWord=$find[0];
		if($tWord){
			foreach($tWord as $sWord){
				$sWord=trim($sWord);
				
				$sWord=trim($sWord);
				if($sWord==''){
					continue;
				}
				
				$sWord=strtolower($sWord);

				
				if(in_array($sWord,$tBlackwords)){
					continue;
				}
				
				if(!in_array($sWord,$tIndexed)){
					$tIndexed[]=$sWord;
				}
				
			}
			
			
		}
		
		return $tIndexed;
	}
	public function processIndexation(){
		
		model_mails_keywords::getInstance()->clearKeywordsByMail($this->id);
		
		$tIndexed=array();
		
		$tIndexed=$this->processWords($tIndexed,$this->body);
		$tIndexed=$this->processWords($tIndexed,$this->subject);
		
		foreach($tIndexed as $sWord){
			$oKeyword=null;
			$oKeyword=model_keywords::getInstance()->findByName($sWord);
			if(!$oKeyword){
				$oKeyword=new row_keywords;
				$oKeyword->name=$sWord;
				$oKeyword->save();
			}
			
			$oMailKeyword=null;
			$oMailKeyword=new row_mails_keywords;
			$oMailKeyword->mails_id=$this->id;
			$oMailKeyword->keywords_id=$oKeyword->id;
			$oMailKeyword->save();
			
			
		}
	}
	
	public function processIndexationLinks(){
		model_links::getInstance()->clearByMail($this->id);
		
		$tLinks=$this->processLinks($this->body);
		if($tLinks){
			
			foreach($tLinks as $sUrl){
			
				$oLink=new row_links;
				$oLink->mails_id=$this->id;
				$oLink->url=$sUrl;
				$oLink->name=$sUrl;
				$oLink->save();
				
				print "$sUrl \n";
			}
			
		}
	}
	private function processLinks($sText){
		
		
		$tIndexed=array();
		
		$find=array();
		
		preg_match_all('/href="([0-9a-zA-Z\:\/\\\.\-\_?\=]*)"/',$sText,$find);
		
		$tWord=$find[1];
		if($tWord){
			foreach($tWord as $sWord){
				$sWord=trim($sWord);
				
				if(!in_array($sWord,$tIndexed)){
					$tIndexed[]=$sWord;
				}
				
				
			}
			
		}
		
		
		
		return $tIndexed;
	}
	
	public function save(){
		if(!$this->isValid()){
			return false;
		}
		parent::save();
		
		if(!isset($this->hasFiles)){
			$this->processIndexation();
		}
		
		return true;
	}

}

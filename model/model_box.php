<?php
class model_box extends abstract_model{
	
	protected $sClassRow='row_box';
	
	protected $sTable='box';
	protected $sConfig='mkMail';
	
	protected $tId=array('id');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE id=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable.' ORDER BY ordered DESC');
	}
	
	
	
}

class row_box extends abstract_row{
	
	protected $sClassModel='model_box';
	
	public function __construct($tRow=null){

		if($tRow){

			//on modifie le champ date avant d'initialiser l'objet
			if(preg_match('/|/',$tRow['columns'])){
				$tColumns=explode('|',$tRow['columns']);
			}else{
				$tColumns=array($tRow['columns']);
			}
			$tRow['columns'] = $tColumns;
			
			//on modifie le champ date avant d'initialiser l'objet
			if(preg_match('/|/',$tRow['tags'])){
				$tColumns=explode('|',$tRow['tags']);
			}else{
				$tColumns=array($tRow['tags']);
			}
			$tRow['tags'] = $tColumns;
			
		}

		//on appel le constructeur normal de la row
		parent::__construct($tRow);
	}
	
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
		
		$tColumns=$this->columns;
		if($tColumns){
			$this->columns=implode('|',$tColumns);
		}else{
			$this->columns=null;
		}
		
		$tTags=$this->tags;
		if($tTags){
			$this->tags=implode('|',$tTags);
		}else{
			$this->tags=null;
		}
		
		parent::save();
		return true;
	}

}

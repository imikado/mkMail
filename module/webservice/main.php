<?php
class module_webservice extends abstract_module{
  
   public function _index(){
	   
	   $sUrl='http://localhost/mkf4builder/data/genere/mkMail/public/webservice.php';
	   
       ini_set("soap.wsdl_cache_enabled","0");

       //creation du plugin wsdl
       $oPluginWsdl=new plugin_wsdl;
       //on indique le nom du webservice
       $oPluginWsdl->setName('mkMail');
       //on indique l'url du webservice
       $oPluginWsdl->setUrl($sUrl);
       //on indique chaque methode disponible
       $oPluginWsdl->addFunction('setContent');
           //ainsi que ses parametres
           $oPluginWsdl->addParameter('messageId','string');
           $oPluginWsdl->addParameter('subject','string');
           $oPluginWsdl->addParameter('body','string');
           $oPluginWsdl->addParameter('from','string');
           $oPluginWsdl->addParameter('nameFrom','string');
           
           
           $oPluginWsdl->addParameter('date','string');
           $oPluginWsdl->addParameter('time','string');
           
           $oPluginWsdl->addReturn('retour','string');
        
        
        //on indique chaque methode disponible
       $oPluginWsdl->addFunction('addFile');
           $oPluginWsdl->addParameter('messageId','string');
           $oPluginWsdl->addParameter('sContent','string');
           $oPluginWsdl->addParameter('sName','string');
          
       $oPluginWsdl->addFunction('getLastDateIntegration');
           $oPluginWsdl->addReturn('datetime','string');
          
           
           //et ses eventuels retours
          // $oPluginWsdl->addReturn('return','string');
          
      
       if(isset($_GET['WSDL'])) {
           //si le wsdl est demande, on l'affiche
           $oPluginWsdl->show();
          
       }else {
          
           //sinon on cree le webservice
           $oServer = new SoapServer( $sUrl.'?WSDL', array('cache_wsdl' => WSDL_CACHE_NONE));
           //on defini la classe a utiliser comme webservice (methode publiques)               
           $oServer->setClass('webservice');
           $oServer->handle();
          
       }
       exit;
   }
}
class webservice{
	
	private $sLog;
	
	public function getLastDateIntegration(){
		$oMail=model_mails::getInstance()->findLast();
		
		if(!$oMail){
			return null;
		}
		
		return $oMail->date.' '.$oMail->time;
	}
	
	public function addFile($messageUId,$sContent,$sName){
		
		$sContent=base64_decode($sContent);
		
		$oMail=model_mails::getInstance()->findByMessageIdComplete($messageUId);
		$oMail->hasFiles=1;
		$oMail->save();
		
		$sFilePath=_root::getConfigVar('path.upload').'message-'.$oMail->id.'-'.$sName;
		
		//sauvegarde du fichier
		file_put_contents($sFilePath,$sContent);
		
		$oFile=model_files::getInstance()->findByNameAndMail($oMail->id,$sName);
		if(!$oFile){
			$oFile=new row_files;
			$oFile->mails_id=$oMail->id;
			$oFile->name=$sName;
			$oFile->path=$sFilePath;
			$oFile->save();
		}
		
		
	}
	
	public function setContent($messageUId,$subject,$body,$from,$nameFrom,$date,$time){

		$body=base64_decode($body);

		$oMail=model_mails::getInstance()->findByMessageId($messageUId);
		if($oMail){
			
			$this->log('subject:"'.$subject);
			$this->log('date'.$date.' '.$time);
			//$this->log('body:"'.$body);
			
			$this->log('messageId:'.$messageUId.' already known');
			
			return 'messageUId '.$messageUId.' already known';
		}else{
			
			$this->log('messageId:'.$messageUId.' new message');

			$oContact=model_contacts::getInstance()->findByEmail($from);
			if(!$oContact){
				$oContact=new row_contacts;
				$oContact->email=$from;
				$oContact->firstname=$nameFrom;
				$oContact->save();
			}

			$oMail=new row_mails;
			$oMail->messageId=$messageUId;
			$oMail->subject=$subject;
			$oMail->body=$body;
			$oMail->from_id=$oContact->id;
			$oMail->date=$date;
			$oMail->time=$time;
			$oMail->save();
			
			return 'messageUId '.$messageUId.' ok';
			
		}

		//return array('return'=>'ok');

	}
	
	private function log($sText){
		
		$this->sLog.=date('H:i:s').' :: '.$sText."\n";
		
		file_put_contents('/tmp/logWSMail.txt',$this->sLog);
	}
}

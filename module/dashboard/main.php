<?php 
class module_dashboard extends abstract_module{
	
	public function before(){
		$this->oLayout=new _layout('dashboard');
		
		
		//$this->oLayout->addModule('menu','menu::index');
	}
	/* #debutaction#
	public function _exampleaction(){
	
		$oView=new _view('examplemodule::exampleaction');
		
		$this->oLayout->add('main',$oView);
	}
	#finaction# */
	
	public function _admin(){
		$this->processAdd();
		
		$tBox=model_box::getInstance()->findAll();
		
		
		$oViewBox=null;
		if(_root::getParam('edit')){
			//instancier le module
			$oModuleBoxembedded=new module_boxEmbedded;

			//si vous souhaitez indiquer au module integrable des informations sur le module parent
			//$oModuleExamplemodule->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));

			//recupere la vue du module
			$oViewBox=$oModuleBoxembedded->_edit(_root::getParam('edit'));

		}
		
		$oView=new _view('dashboard::admin');
		$oView->tBox=$tBox;
		$oView->oViewBox=$oViewBox;
		$oView->tJoinmodel_contacts=model_contacts::getInstance()->getSelectWithEmpty();

		$this->oLayout->add('main',$oView);
	}
	private function processAdd(){
		if(!_root::getRequest()->isPost()){
			return false;
		}
		
		if(_root::getParam('add')==0){
			return false;
		}
		
		$oBox=new row_box;
		$oBox->width='500px';
		$oBox->height='250px';
		$oBox->columns=array('date','subject','from');
		$oBox->save();
	}
	
	public function _index(){
		
		$oView=new _view('dashboard::index');

		$this->oLayout->add('main',$oView);
		
			//instancier le module
		$oModuleMailsEmbedded=new module_mailsEmbedded();
		
		//si vous souhaitez indiquer au module integrable des informations sur le module parent
		//$oModuleMailsEmbedded->setRootLink('module::action',array('parametre'=>_root::getParam('parametre')));
		
		$tIndexedTags=model_tags::getInstance()->getSelect();
		
		$tBox=model_box::getInstance()->findAll();
		foreach($tBox as $oBox){
			
			if($oBox->tags[0]!=''){
				$tWord=array();
				foreach($oBox->tags as $tags_id){
					$tWord[]=$tIndexedTags[$tags_id];
				}
				
				
				$oViewModule=$oModuleMailsEmbedded->_listByTags($oBox->tags);
				
				$oViewModule->subtitle='Mails filtered by tags: '.implode(',',$tWord);
			}else if($oBox->from_id == 0 and $oBox->keywords==''){
				//par contact
				$oViewModule=$oModuleMailsEmbedded->_index();
				
				$oViewModule->subtitle='Mails ';
			}else if($oBox->from_id==0 and $oBox->keywords!=''){
				//tag 1
				$tWord=explode(',',$oBox->keywords);
				$tKeywords=model_keywords::getInstance()->findTabKeyByList($tWord);
				
				$oViewModule=$oModuleMailsEmbedded->_listByKeywords($tKeywords);
				
				$oViewModule->subtitle='Mails filtered by keywords: '.implode(',',$tWord);
				
			}else if($oBox->from_id > 0 and $oBox->keywords==''){
				//par contact
				$oViewModule=$oModuleMailsEmbedded->_listByFrom($oBox->from_id);
				
				$oViewModule->subtitle='Mails filtered by sender : ';
			}else if($oBox->from_id > 0 and $oBox->keywords!=''){
				//par contact
				$oViewModule=$oModuleMailsEmbedded->_listByFrom($oBox->from_id);
				
				$oViewModule->subtitle='Mails filtered by sender : ';
			}
			
			$oViewModule->title=$oBox->title;
			
			
			$oViewModule->width=$oBox->width;
			$oViewModule->height=$oBox->height;
			$oViewModule->tColumn=$oBox->columns;
			$this->oLayout->add('main',$oViewModule);
		}

		
	}
	
	public function _delete(){
		$oMail=model_mails::getInstance()->findById(_root::getParam('id'));
		$oMail->active=0;
		$oMail->save();
		
		_root::redirect('dashboard::index');
	}
	
	public function _search(){
	
		$oView=new _view('dashboard::search');
		
		$this->oLayout->add('main',$oView);
	}
	
	
	public function after(){
		$this->oLayout->show();
	}
	
	
}

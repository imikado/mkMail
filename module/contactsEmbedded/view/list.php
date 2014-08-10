<ul>
	
	<li <?php if(_root::getParam('from')==''):?>class="selectionne"<?php endif;?>><a href="<?php echo _root::getLink('dashboard::index')?>">tous </a>
	
	</li>
	
	<?php if($this->tContacts):?>
	<?php foreach($this->tContacts as $oContacts):?>
		

		<li <?php if($oContacts->id == _root::getParam('from')):?>class="selectionne"<?php endif;?>><a href="<?php echo _root::getLink('dashboard::index',array('from'=>$oContacts->id))?>"><?php 
		
		if($oContacts->firstname !=''){
			echo $oContacts->firstname ;
		}else{
			echo $oContacts->email;
	}
		
		?></a></li>

	
	<?php endforeach;?>
	<?php endif;?>
</ul>


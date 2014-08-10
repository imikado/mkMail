<?php if($this->tTags):?>
<?php foreach($this->tTags as $id => $oTag):?>
	#<?php echo $oTag->name?> 
<?php endforeach;?>
<?php endif;?>

<p style="text-align:right"><a href="<?php echo _root::getLink('mails::editTags',array('id'=>_root::getParam('id')))?>">[EDIT]</a></p>

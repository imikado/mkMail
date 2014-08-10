<form action="" method="POST"/>
<?php if($this->tTags):?>
<?php foreach($this->tTags as $id => $oTag):?>
	<input <?php if(in_array($id,$this->tTagsMail)):?>checked="checked"<?php endif;?> type="checkbox" name="tTagsId[]" value="<?php echo $oTag->id?>"/>#<?php echo $oTag->name?> ,
<?php endforeach;?>
<?php endif;?>

<p>Add <input type="text" name="newTag"/></p>

<p style="text-align:right"><input type="submit" value="Save"/></p>

</form>

<?php 
$oForm=new plugin_form($this->oBox);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >
<input type="hidden" name="formmodule" value="boxEmbedded" />

<table class="tb_new">
	
	<tr>
		<th>from_id</th>
		<td><?php echo $oForm->getSelect('from_id',$this->tJoinmodel_contacts);?></td>
	</tr>

	<tr>
		<th>order</th>
		<td><?php echo $oForm->getInputText('order')?></td>
	</tr>

	<tr>
		<th>type</th>
		<td><?php echo $oForm->getSelect('type',$this->tJoinmodel_type);?></td>
	</tr>

	<tr>
		<th>columns</th>
		<td><?php echo $oForm->getSelect('columns',$this->tJoinmodel_columns);?></td>
	</tr>

	<tr>
		<th>keywords</th>
		<td><?php echo $oForm->getSelect('keywords',$this->tJoinmodel_keywords);?></td>
	</tr>

	<tr>
		<th>width</th>
		<td><?php echo $oForm->getInputText('width')?></td>
	</tr>

	<tr>
		<th>height</th>
		<td><?php echo $oForm->getInputText('height')?></td>
	</tr>

	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Ajouter" /> <a href="<?php echo module_boxEmbedded::getLink('list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<?php echo $oForm->getToken('token',$this->token)?>


</form>


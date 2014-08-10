<?php 
$oForm=new plugin_form($this->oBox);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >
<input type="hidden" name="formmodule" value="boxEmbedded" />

<table class="tb_edit">
	
	<tr>
		<th class="title" colspan="2">Box: </th>
	</tr>
	
	<tr>
		<th>Title</th>
		<td><?php echo $oForm->getInputText('title')?></td>
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
			<th>order</th>
			<td><?php echo $oForm->getInputText('ordered')?></td>
		</tr>
	
	
	<tr>
		<th class="title" colspan="2">Contenu</th>
	</tr>
		<tr>
			<th>Type</th>
			<td><?php echo $oForm->getSelect('type',$this->tJoinmodel_type);?></td>
		</tr>

		<tr>
			<th>Columns</th>
			<td><?php echo $oForm->getListCheckbox('columns',$this->tJoinmodel_columns);?></td>
		</tr>
	
	<tr>
		<th class="title" colspan="2">Filtre</th>
	</tr>
		<tr>
			<th>From</th>
			<td><?php echo $oForm->getSelect('from_id',$this->tJoinmodel_contacts);?></td>
		</tr>
		<tr>
			<th>Keywords*</th>
			<td><?php echo $oForm->getInputText('keywords');?></td>
		</tr>
		
		<tr>
			<th>Tags*</th>
			<td><?php echo $oForm->getListCheckbox('tags',$this->tJoinmodel_tags);?></td>
		</tr>

	

	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Modifier" /> <a href="<?php echo module_boxEmbedded::getLink('list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<p>*mots cl&eacute;s s&eacute;par&eacute;s par des virgules.</p>

<?php echo $oForm->getToken('token',$this->token)?>

</form>


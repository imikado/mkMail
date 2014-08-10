<?php 
$oForm=new plugin_form($this->oContacts);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST"  enctype="multipart/form-data">

<table class="tb_new">
	
	<tr>
		<th>Nom</th>
		<td><?php echo $oForm->getInputText('lastname')?></td>
	</tr>

	<tr>
		<th>Prenom</th>
		<td><?php echo $oForm->getInputText('firstname')?></td>
	</tr>

	<tr>
		<th>Email</th>
		<td><?php echo $oForm->getInputText('email')?></td>
	</tr>

	<tr>
		<th>Photo</th>
		<td><?php echo $oForm->getInputUpload('picture')?></td>
	</tr>

	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Ajouter" /> <a href="<?php echo $this->getLink('contacts::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<?php echo $oForm->getToken('token',$this->token)?>

</form>

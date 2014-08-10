<?php 
$oForm=new plugin_form($this->oMails);
$oForm->setMessage($this->tMessage);
?>
<form action="" method="POST" >
<table class="tb_edit">
	
	<tr>
		<th>subject</th>
		<td><?php echo $oForm->getInputText('subject')?></td>
	</tr>

	<tr>
		<th>body</th>
		<td><?php echo $oForm->getInputTextarea('body')?></td>
	</tr>

	<tr>
		<th>messageId</th>
		<td><?php echo $oForm->getInputText('messageId')?></td>
	</tr>

	<tr>
		<th>date</th>
		<td><?php echo $oForm->getInputText('date')?></td>
	</tr>

	<tr>
		<th>time</th>
		<td><?php echo $oForm->getInputText('time')?></td>
	</tr>

	<tr>
		<th>active</th>
		<td><?php echo $oForm->getSelect('active',$this->tJoinmodel_yesno);?></td>
	</tr>

	<tr>
		<th>from_id</th>
		<td><?php echo $oForm->getSelect('from_id',$this->tJoinmodel_contacts);?></td>
	</tr>

	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Modifier" /> <a href="<?php echo $this->getLink('mails::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>

<?php echo $oForm->getToken('token',$this->token)?>

</form>


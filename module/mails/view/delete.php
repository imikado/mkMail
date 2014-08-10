<form action="" method="POST">
<table class="tb_delete">
	
	<tr>
		<th>subject</th>
		<td><?php echo $this->oMails->subject ?></td>
	</tr>

	<tr>
		<th>body</th>
		<td><?php echo $this->oMails->body ?></td>
	</tr>

	<tr>
		<th>messageId</th>
		<td><?php echo $this->oMails->messageId ?></td>
	</tr>

	<tr>
		<th>date</th>
		<td><?php echo $this->oMails->date ?></td>
	</tr>

	<tr>
		<th>time</th>
		<td><?php echo $this->oMails->time ?></td>
	</tr>

	<tr>
		<th>active</th>
		<td><?php echo $this->tJoinmodel_yesno[$this->oMails->active]?></td>
	</tr>

	<tr>
		<th>from_id</th>
		<td><?php echo $this->tJoinmodel_contacts[$this->oMails->from_id]?></td>
	</tr>

	
	<tr>
		<th></th>
		<td>
			<p>
				<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo $this->getLink('mails::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>


</form>

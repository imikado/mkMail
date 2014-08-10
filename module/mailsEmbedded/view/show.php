<table class="tb_show">
	
	<tr>
		<th>subject</th>
		<td><?php echo $this->oMails->subject ?></td>
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
		<th>from_id</th>
		<td><?php echo $this->tJoinmodel_contacts[$this->oMails->from_id]?></td>
	</tr>

</table>
<p><a href="<?php echo module_mailsEmbedded::getLink('list')?>">Retour</a></p>


<table class="tb_show">
	
	<tr>
		<th>lastname</th>
		<td><?php echo $this->oContacts->lastname ?></td>
	</tr>

	<tr>
		<th>firstname</th>
		<td><?php echo $this->oContacts->firstname ?></td>
	</tr>

	<tr>
		<th>email</th>
		<td><?php echo $this->oContacts->email ?></td>
	</tr>

</table>
<p><a href="<?php echo module_contactsEmbedded::getLink('list')?>">Retour</a></p>


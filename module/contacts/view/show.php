<table class="tb_show">
	
	<tr>
		<th>Nom</th>
		<td><?php echo $this->oContacts->lastname ?></td>
	</tr>

	<tr>
		<th>Prenom</th>
		<td><?php echo $this->oContacts->firstname ?></td>
	</tr>

	<tr>
		<th>Email</th>
		<td><?php echo $this->oContacts->email ?></td>
	</tr>

	<tr>
		<th>Photo</th>
		<td><?php echo $this->oContacts->picture ?></td>
	</tr>

	
	<tr>
		<th></th>
		<td>
			<p>
				<a href="<?php echo $this->getLink('contacts::list')?>">Retour</a>
			</p>
		</td>
	</tr>
</table>

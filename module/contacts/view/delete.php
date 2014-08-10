<form action="" method="POST">
<table class="tb_delete">
	
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
				<input type="submit" value="Confirmer la suppression" /> <a href="<?php echo $this->getLink('contacts::list')?>">Annuler</a>
			</p>
		</td>
	</tr>
</table>


<input type="hidden" name="token" value="<?php echo $this->token?>" />
<?php if($this->tMessage and isset($this->tMessage['token'])): echo $this->tMessage['token']; endif;?>


</form>

<table class="tb_list">
	<tr>
		
		<th>Nom</th>

		<th>Prenom</th>

		<th>Email</th>

		<th>Photo</th>

		<th></th>
	</tr>
	<?php if($this->tContacts):?>
		<?php foreach($this->tContacts as $oContacts):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oContacts->lastname ?></td>

		<td><?php echo $oContacts->firstname ?></td>

		<td><?php echo $oContacts->email ?></td>

		<td><?php echo $oContacts->picture ?></td>

			<td>
				
				
<a href="<?php echo $this->getLink('contacts::edit',array(
										'id'=>$oContacts->getId()
									) 
							)?>">Edit</a>
| 
<a href="<?php echo $this->getLink('contacts::delete',array(
										'id'=>$oContacts->getId()
									) 
							)?>">Delete</a>
| 
<a href="<?php echo $this->getLink('contacts::show',array(
										'id'=>$oContacts->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="5">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a href="<?php echo $this->getLink('contacts::new') ?>">New</a></p>


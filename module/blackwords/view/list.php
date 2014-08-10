<table class="tb_list">
	<tr>
		
		<th>name</th>

		<th></th>
	</tr>
	<?php if($this->tBlackwords):?>
		<?php foreach($this->tBlackwords as $oBlackwords):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oBlackwords->name ?></td>

			<td>
				
				
<a href="<?php echo $this->getLink('blackwords::edit',array(
										'id'=>$oBlackwords->getId()
									) 
							)?>">Edit</a>
| 
<a href="<?php echo $this->getLink('blackwords::delete',array(
										'id'=>$oBlackwords->getId()
									) 
							)?>">Delete</a>
| 
<a href="<?php echo $this->getLink('blackwords::show',array(
										'id'=>$oBlackwords->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="2">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a href="<?php echo $this->getLink('blackwords::new') ?>">New</a></p>


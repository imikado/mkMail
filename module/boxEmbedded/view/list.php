<table class="tb_list">
	<tr>
		
		<th>from_id</th>

		<th>order</th>

		<th>type</th>

		<th>columns</th>

		<th>keywords</th>

		<th>width</th>

		<th>height</th>

		<th></th>
	</tr>
	<?php if($this->tBox):?>
		<?php foreach($this->tBox as $oBox):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php if(isset($this->tJoinmodel_contacts[$oBox->from_id])){ echo $this->tJoinmodel_contacts[$oBox->from_id];}else{ echo $oBox->from_id ;}?></td>

		<td><?php echo $oBox->order ?></td>

		<td><?php if(isset($this->tJoinmodel_type[$oBox->type])){ echo $this->tJoinmodel_type[$oBox->type];}else{ echo $oBox->type ;}?></td>

		<td><?php if(isset($this->tJoinmodel_columns[$oBox->columns])){ echo $this->tJoinmodel_columns[$oBox->columns];}else{ echo $oBox->columns ;}?></td>

		<td><?php if(isset($this->tJoinmodel_keywords[$oBox->keywords])){ echo $this->tJoinmodel_keywords[$oBox->keywords];}else{ echo $oBox->keywords ;}?></td>

		<td><?php echo $oBox->width ?></td>

		<td><?php echo $oBox->height ?></td>

			<td>
				
				
<a href="<?php echo module_boxEmbedded::getLink('edit',array(
										'id'=>$oBox->getId()
									) 
							)?>">Edit</a>
| 
<a href="<?php echo module_boxEmbedded::getLink('delete',array(
										'id'=>$oBox->getId()
									) 
							)?>">Delete</a>
| 
<a href="<?php echo module_boxEmbedded::getLink('show',array(
										'id'=>$oBox->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="8">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>

<p><a href="<?php echo module_boxEmbedded::getLink('new') ?>">New</a></p>



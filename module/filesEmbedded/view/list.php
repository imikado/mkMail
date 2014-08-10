<table class="tb_list">
	<tr>
		
		<th>name</th>

		<th>path</th>

		<th></th>
	</tr>
	<?php if($this->tFiles):?>
		<?php foreach($this->tFiles as $oFiles):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oFiles->name ?></td>

		<td><?php echo $oFiles->path ?></td>

			<td>
				
				
<a href="<?php echo module_filesEmbedded::getLink('show',array(
										'id'=>$oFiles->getId()
									) 
							)?>">Show</a>

				
				
			</td>
		</tr>	
		<?php endforeach;?>
	<?php else:?>
		<tr>
			<td colspan="3">Aucune ligne</td>
		</tr>
	<?php endif;?>
</table>



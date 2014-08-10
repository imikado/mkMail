<table class="tb_list">
	<tr>
		
		<th>name</th>

		<th></th>
	</tr>
	<?php if($this->tKeywords):?>
	<?php foreach($this->tKeywords as $oKeywords):?>
	<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
		
		<td><?php echo $oKeywords->name ?></td>

		<td>
			
			
			<a href="<?php echo $this->getLink('keywords::show',array(
													'id'=>$oKeywords->getId()
												) 
										)?>">Show</a>
			
		</td>
	</tr>	
	<?php endforeach;?>
	<?php endif;?>
</table>


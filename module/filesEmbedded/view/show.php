<table class="tb_show">
	
	<tr>
		<th>name</th>
		<td><?php echo $this->oFiles->name ?></td>
	</tr>

	<tr>
		<th>path</th>
		<td><?php echo $this->oFiles->path ?></td>
	</tr>

	<tr>
		<th></th>
		<td>
			<p><a href="<?php echo module_filesEmbedded::getLink('list')?>">Retour</a></p>
		</td>
	</tr>
</table>

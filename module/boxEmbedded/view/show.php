<table class="tb_show">
	
	<tr>
		<th>from_id</th>
		<td><?php echo $this->tJoinmodel_contacts[$this->oBox->from_id]?></td>
	</tr>

	<tr>
		<th>order</th>
		<td><?php echo $this->oBox->order ?></td>
	</tr>

	<tr>
		<th>type</th>
		<td><?php echo $this->tJoinmodel_type[$this->oBox->type]?></td>
	</tr>

	<tr>
		<th>columns</th>
		<td><?php echo $this->tJoinmodel_columns[$this->oBox->columns]?></td>
	</tr>

	<tr>
		<th>keywords</th>
		<td><?php echo $this->tJoinmodel_keywords[$this->oBox->keywords]?></td>
	</tr>

	<tr>
		<th>width</th>
		<td><?php echo $this->oBox->width ?></td>
	</tr>

	<tr>
		<th>height</th>
		<td><?php echo $this->oBox->height ?></td>
	</tr>

	<tr>
		<th></th>
		<td>
			<p><a href="<?php echo module_boxEmbedded::getLink('list')?>">Retour</a></p>
		</td>
	</tr>
</table>

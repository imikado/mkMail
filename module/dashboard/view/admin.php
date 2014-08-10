<style>
.box{
	float:left;
	border:2px solid #70868e;
	background:#fff;
	margin:2px;
}
.popup{
	border:2px solid gray;
	background:white;
	padding:10px;
	position:absolute;
	top:20px;
	left:20px;
	clear:both;
}
.selected{
	border:1px solid red;
}
body{
	background:#bbc3c6;
}
table th{
	text-align:right;
	width:70px;
}
table th.title{
	text-align:left;
	border-bottom:1px solid gray;
}
.link{
	position:absolute;
	top:0px;
	right:0px;
	background:#fff;
	padding:8px;
	border:2px solid #70868e;
}
h1{
	margin:0px;
	background:#70868e;
	color:white;
	padding:3px;
}
</style>
<?php foreach($this->tBox as $oBox):?>

	<?php $selected=null;?>

	<?php if(_root::getParam('edit')==$oBox->id):?>
		<div class="popup"  >
			<?php echo $this->oViewBox->show();?>
		</div>
		<?php $selected='selected';?>
	<?php endif;?>
	
		<div class="box <?php echo $selected;?>" style="width:<?php echo $oBox->width?>;height:<?php echo $oBox->height?>">
			<h1><?php echo $oBox->title?></h1>
			<div style="padding:4px;">
			<table>
				 
					<tr>
						<th>Width</th>
						<td><?php echo $oBox->width?></td>
					</tr>
					<tr>
						<th>Height</th>
						<td><?php echo $oBox->height?></td>
					</tr>
				
				<tr>
					<th class="title" colspan="2">Contenu</th>
				</tr>
					<tr>
						<th>Type</th>
						<td><?php echo $oBox->type?></td>
					</tr>
					<tr>
						<th>Columns</th>
						<td><?php echo implode(',',$oBox->columns)?></td>
					</tr>
				
				<tr>
					<th class="title" colspan="2">Filtre</th>
				</tr>
					<tr>
						<th>From</th>
						<td><?php if(isset($this->tJoinmodel_contacts[$oBox->from_id])){ echo $this->tJoinmodel_contacts[$oBox->from_id]; }?></td>
					</tr>
					
					<tr>
						<th>Keywords</th>
						<td><?php echo $oBox->keywords?></td>
					</tr>
					
					<tr>
						<th>Tags</th>
						<td><?php echo implode(',',$oBox->tags)?></td>
					</tr>
			</table>
			<p><a href="<?php echo _root::getLink('dashboard::admin',array('edit'=>$oBox->id))?>">Edit</a></p>
			
			</div>
		</div>
	 

<?php endforeach;?>



<form action="" method="POST" onsubmit="return confirm('Confirmez-vous l\'ajout ?')">
	<input type="hidden" name="add" value="1"/>
	<div class="link"><input type="submit" value="Add Box"/>
		<a href="<?php echo _root::getLink('dashboard::index');?>">Retour</a>
	</div>
	
</form>

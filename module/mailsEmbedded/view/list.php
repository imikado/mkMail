<style>
.tb_list td{
	cursor:pointer;
}
h1{
	margin:0px;
	background:#70868e;
	color:white;
	padding:3px;
}
</style>
<div style="background:#fff;float:left;border:2px solid #70868e;;margin:2px;width:<?php echo $this->width?>;min-height:<?php echo $this->height?>">
<h1><?php echo $this->title?></h1>
<h3 style="color:#888"><?php echo $this->subtitle?> <?php if(isset($this->oContact)):?><?php echo $this->oContact->email?><?php endif;?></h3>
<div style="padding:4px;">
<?php
$height=0;
if(isset($this->tFiles) and $this->tFiles){
	$height=54;
}
?>
<div style="overflow:auto;height:<?php echo ($this->height-$height)?>px">
<table class="tb_list">
	<tr>
		<?php if(isset($this->tColumn) and in_array('date',$this->tColumn)):?><th>Date</th><?php endif;?>
		<?php if(isset($this->tColumn) and in_array('from',$this->tColumn)):?><th>From</th><?php endif;?>
		<?php if(isset($this->tColumn) and in_array('subject',$this->tColumn)):?><th>subject</th><?php endif;?>
		<th></th>
	</tr>
	<?php $tmp=null;?>
	<?php if($this->tMails):?>
	<?php foreach($this->tMails as $oMails):?>
	
	<?php if($oMails->subject ==$tmp):?>
	<tr>
		<td colspan="4" style="font-size:1px;padding:0px;">&nbsp;</td>
	</tr>
	<?php continue;?>
	<?php endif;?>
	
	<tr onclick="show(<?php echo $oMails->id?>)" <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
		
		<?php if(isset($this->tColumn) and in_array('date',$this->tColumn)):?>
		<td><?php // echo $oMails->date ; echo $oMails->time ?>
			<?php
			if($oMails->date!='' and $oMails->date!='0000-00-00'){
				$oDate=new plugin_datetime($oMails->date.' '.$oMails->time);
				
				$sDecal=$oDate->toString('P');
				$iDecal=(int)substr($sDecal,1,2);
				
				$oDate->addHour($iDecal);
				
				echo $oDate->toString('Y-m-d H:i');
			}
			?>
		</td><?php endif;?>	
		<?php if(isset($this->tColumn) and in_array('from',$this->tColumn)):?><td><?php if(isset($this->tJoinmodel_contacts[$oMails->from_id])){ echo $this->tJoinmodel_contacts[$oMails->from_id];}else{ echo $oMails->from_id ;}?></td><?php endif;?>
		<?php if(isset($this->tColumn) and in_array('subject',$this->tColumn)):?><td><?php echo $oMails->subject ?></td><?php endif;?>
		<td><?php if($oMails->hasFiles):?><img src="css/images/attachment.png"/><?php endif;?></td>
	</tr>	
	<?php $tmp=$oMails->subject ;?>
	<?php endforeach;?>
	<?php endif;?>
</table>
</div>

<?php $id=module_mailsEmbedded::getId();?>
<?php if(isset($this->tFiles) and $this->tFiles):?>
	<p><a href="#" onclick="showHide('Files<?php echo $id?>');return false;">Afficher les fichiers</a></p>
	<div class="files" id="divFiles<?php echo $id?>" style="display:none">
		<ul>
		<?php foreach($this->tFiles as $oFile):?>
			<li><a title="<?php echo $oFile->subject?>" target="_blank" href="#" onclick="window.open('<?php echo $oFile->path?>','attachment','menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=300');;return false"><?php echo $oFile->name?> (<?php echo substr($oFile->subject,0,30)?>...) </a></li>
		<?php endforeach;?>
		</ul>
	</div>
<?php endif;?>

<?php if(isset($this->tLinks) and $this->tLinks):?>
	<p><a href="#" onclick="showHide('Links<?php echo $id?>');return false;">Afficher les liens</a></p>
	<div class="files" id="divLinks<?php echo $id?>" style="display:none">
		<ul>
		<?php foreach($this->tLinks as $oLink):?>
			<?php
			$url=$oLink->url;
			$sOnclick='';
			if(substr($url,0,4)!='http'){
				$sOnclick='onclick="alert(\'(lien fichier) Faites clic droit copier le lien\')"';
			}
			
			?>
			<li><a <?php echo $sOnclick?> target="_blank" href="<?php echo $url?>" ><?php echo $oLink->name?></a></li>
		<?php endforeach;?>
		</ul>
	</div>
<?php endif;?>
</div>
</div>

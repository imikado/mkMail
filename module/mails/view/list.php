<table class="tb_list">
	<tr>
		
		<th>subject</th>

		<th>body</th>

		<th>messageId</th>

		<th>date</th>

		<th>time</th>

		<th>active</th>

		<th>from_id</th>

		<th></th>
	</tr>
	<?php if($this->tMails):?>
		<?php foreach($this->tMails as $oMails):?>
		<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
			
		<td><?php echo $oMails->subject ?></td>

		<td><?php //echo $oMails->body ?></td>

		<td><?php //echo $oMails->messageId ?></td>

		<td><?php echo $oMails->date ?></td>

		<td><?php echo $oMails->time ?></td>

		<td><?php if(isset($this->tJoinmodel_yesno[$oMails->active])){ echo $this->tJoinmodel_yesno[$oMails->active];}else{ echo $oMails->active ;}?></td>

		<td><?php if(isset($this->tJoinmodel_contacts[$oMails->from_id])){ echo $this->tJoinmodel_contacts[$oMails->from_id];}else{ echo $oMails->from_id ;}?></td>

			<td>
				
				
<a href="<?php echo $this->getLink('mails::edit',array(
										'id'=>$oMails->getId()
									) 
							)?>">Edit</a>
| 
<a href="<?php echo $this->getLink('mails::delete',array(
										'id'=>$oMails->getId()
									) 
							)?>">Delete</a>
| 
<a href="<?php echo $this->getLink('mails::show',array(
										'id'=>$oMails->getId()
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

<p><a href="<?php echo $this->getLink('mails::new') ?>">New</a></p>


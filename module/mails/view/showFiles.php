<?php if($this->tFiles):?>
<ul>
<?php foreach($this->tFiles as $oFile):?>
<li><a target="_blank" href="<?php echo $oFile->path?>"><?php echo $oFile->name?></a></li>
<?php endforeach;?>
</ul>
<?php else:?>
Pas de pi&egrave;ce jointe
<?php endif;?>

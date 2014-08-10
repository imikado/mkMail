<style>
body{
	background:#bbc3c6;
}
.link{
	position:absolute;
	top:0px;
	right:0px;
	background:#fff;
	padding:8px;
	border:2px solid #70868e;
}
#popup{
	top:100px;
	left:100px;
	position:absolute;
	width:650px;
	min-height:538px;
	border:2px solid gray;
	display:none;
	background:#fff;
	padding:0px;
}
#popup hr{
	border:1px solid gray;
}
#iframeSubject,#iframeBody,#iframeKeywords,#iframeFiles,#iframeTags{
	width:100%;
	border:0px solid red	;
}
#iframeSubject{
height:35px;
}
#iframeBody{
height:415px;
	
}
#iframeTags{
height:125px;
}
#diviframeTags{
display:none;
	
}
#iframeFiles{
height:35px;
	
}
#popup p{
	background:gray;
	text-align:right;
	padding:4px;
	margin-top:0px;
}
#popup p a{
	color:white;
}
#popup .delete{
	background:darkred;
	margin:0px;
}
#popup p.adds{
	background:#ccc;
}
#popup p.adds a{
	color:#444;
}
</style>
<script>
function showHide(id){
	var a=getById('div'+id);
	if(a){
		if(a.style.display=='none'){
			a.style.display='block';
		}else{
			a.style.display='none';
			a.style.visibility='none';
		}
	}
}	
	
function closeMail(){
	var a=getById('popup');
	if(a){
		a.style.display='none';
	}else{
		alert('oo');
	}
	
}
var globalMailId;
function show(id){
	globalMailId=id;
	
	var a=getById('popup');
	if(a){
		a.style.display="block";
		
		var b=getById('iframeSubject');
		if(b){
			b.src="<?php echo _root::getLink('mails::showTitle',array('id'=>''),false)?>"+id;
		}
		var b=getById('iframeBody');
		if(b){
			b.src="<?php echo _root::getLink('mails::show',array('id'=>''),false)?>"+id;
		}
		
		var b=getById('iframeTags');
		if(b){
			b.src="<?php echo _root::getLink('mails::showTags',array('id'=>''),false)?>"+id;
		}
		
		
		
		var c=getById('iframeFiles');
		if(c){
			c.src="<?php echo _root::getLink('mails::showFiles',array('id'=>''),false)?>"+id;
		}
		
	}
}
function deleteMail(){
	
	if(!confirm('Confirmez-vous la suppression ?')){
		return false;
	}
	
	var sUrl='<?php echo _root::getLink('dashboard::delete',array('id'=>''),false)?>';
	sUrl+=globalMailId;
	
	document.location.href=sUrl;
}
</script>
<div class="link"><a href="<?php echo _root::getLink('dashboard::admin')?>">[ADMIN]</a></div>
<div id="popup">
	<p><a onclick="closeMail()" href="#">Fermer</a></p>
	<iframe id="iframeSubject" src=""></iframe>
	<hr/>
	<iframe id="iframeBody" src=""></iframe>
	
	<br/>
	<p class="adds"><a href="#" onclick="showHide('iframeTags')" >Tags</a></p>
	<div style="display:none" id="diviframeTags"><iframe id="iframeTags" src=""></iframe></div>
	
	<hr/>
	<iframe id="iframeFiles" src=""></iframe>
	<p class="delete"><a href="#" onclick="deleteMail()">Supprimer</a></p>
</div>

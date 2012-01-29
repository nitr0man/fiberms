{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=foo}
{include file="menu.tpl"}
<div id="boxinv">
<body onload="javascript: GetBoxTypeList(1);">
<div id="backscript">&nbsp;</div>
<script type="text/javascript">

function initscript(block)
{
	lol = block;
	lol = lol.replace(/\#/g,"");
	$(block).replaceWith( "<input id=\""+block+"\" type=\"text\" name=\""+lol+"\" size=\"30\" />" );
}
function setvalues(first,second,third,fourth,fifth,sixs,seventh) {
	$('#marking').replaceWith("<label id=\"marking\" onclick=\"initscript('#marking')\">"+first+"</label>");
	$('#manufacturer').replaceWith("<label id=\"manufacturer\" onclick=\"initscript('#manufacturer')\">"+second+"</label>");
	$('#units').replaceWith("<label id=\"units\" onclick=\"initscript('#units')\">"+third+"</label>");
	$('#width').replaceWith("<label id=\"width\" onclick=\"initscript('#width')\">"+fourth+"</label>");
	$('#height').replaceWith("<label id=\"height\" onclick=\"initscript('#height')\">"+fifth+"</label>");
	$('#length').replaceWith("<label id=\"length\" onclick=\"initscript('#length')\">"+sixs+"</label>");
	$('#diameter').replaceWith("<label id=\"diameter\" onclick=\"initscript('#diameter')\">"+seventh+"</label>");
}
	</script>
<div id="content">
{include file="NetworkBoxType_content.tpl"}
</div>
<br />

</body>
</div>
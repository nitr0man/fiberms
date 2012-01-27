<body onload="javascript: getformfornewbox(1);">
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
	$('#width').replaceWith("<label id=\"width\" onclick=\"initscript('#marking')\">"+fourth+"</label>");
	$('#height').replaceWith("<label id=\"height\" onclick=\"initscript('#marking')\">"+fifth+"</label>");
	$('#length').replaceWith("<label id=\"length\" onclick=\"initscript('#marking')\">"+sixs+"</label>");
	$('#diameter').replaceWith("<label id=\"diameter\" onclick=\"initscript('#marking')\">"+seventh+"</label>");
}
	</script>
<div id="backscript">&nbsp;</div>
<!--<div id="content">-->
<form name="boxtypevalue" onsubmit="return false">
<div id="ololo">
	<table>
		<tr>
		<td><label class="events_anonce">Тип ящика</label></td><td id="newboxform">
		<select name="networkboxtype">
			<option>k;hj</option>
			<option></option>
			</select>
		
		</td>

<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Кол-во:</label></td><td id="inventorynumber"> <a href="#" id="boxinv" onclick="initscript('#inventorynumber')">\получить из базы\</a></td><!--<td><input type="text" name="invmun" size="30" /></td>-->
<br />
		</tr>
		<tr>
		<td><label class="events_anonce">deprecated</label></td><td><input type="hidden" name="whichadded" value="networkbox" size="30" /></td>
		</tr>
		<tr>
		<td><input type="submit" /></td>
		</tr>
	</table>
</div>
</form>

<form name="boxtype" onSubmit="return false">
	<div id="addnewboxtype">
		<table>
		<tr>
		<td><label class="events_anonce">Маркировка</label></td><td> <label id="marking" onclick="initscript('#marking')">\получить из базы\</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>-->
<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <label id="manufacturer" onclick="initscript('#manufacturer')">\получить из базы\</label></td><!--<input type="text" checked name="boxtype" size="30" /></td>--><!--<td><input type="text" name="invmun" size="30" /></td>-->
		<br />
		</tr>
		<tr>
		<td><label class="events_anonce">Units</label></td><td> <label id="units" onclick="initscript('#units')">\получить из базы\</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Width</label></td><td> <label id="width" onclick="initscript('#width')">\получить из базы\</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Height</label></td><td> <label id="height" onclick="initscript('#height')">\получить из базы\</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Length</label></td><td> <label id="length" onclick="initscript('#length')">\получить из базы\</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Diameter</label></td><td> <label id="diameter" onclick="initscript('#diameter')">\получить из базы\</label></td>
		</tr><td><input type="hidden" name="whichadded" id="whichadded" value="networkboxtype" /></td><td><input type="submit" onclick="javascript: addnewboxtype(document.boxtype.marking.value,document.boxtype.manufacturer.value,document.boxtype.units.value,document.boxtype.width.value,document.boxtype.height.value,document.boxtype.length.value,document.boxtype.diameter.value,document.boxtype.whichadded.value)" /></td></form>
		</tr>
		</table>
	</div>
</form>
<br />

</body>

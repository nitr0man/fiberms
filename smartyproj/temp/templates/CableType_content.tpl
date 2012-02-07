<form name="cabletype" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			{html_table loop=$data cols="<a href=\"#\">ID</a>,marking,manufacturer,tubeQuanity,fiberPerTube,tensileStrength,diameter,comment,CableCount,Delete"}
			</td>
		<br />
		</tr>
</div>
</form>
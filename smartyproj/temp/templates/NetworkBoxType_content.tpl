<form name="boxtype" onsubmit="return false">
<div>
	<table>
		<tr>
			<td>
			{html_table loop=$data cols="<a href=\"#\">ID</a>,marking,manufacturer,units,width,height,length,diameter,BoxCount,Change,Delete"}
			</td>
		<br />
		</tr>
</div>
</form>
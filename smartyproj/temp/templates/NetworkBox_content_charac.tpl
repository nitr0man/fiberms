<form name="boxinfo" action="NetworkBox.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<table>		
		<tr>
			<td>
			<label class="events_anonce">Type: </label></td><td><label>{$boxtype}</label>
			</td>
			<br />
		</tr>
		<tr>
			<td>
			<label class="events_anonce">InvNum: </label></td><td> <label>{$invNum}</label>
			</td>
			<br />
		</tr>
		<tr>
		<td>
			<label>Node name: </label>
		</td>
		<td>
			<label>{$nodename}</label>
		</td>
		<br />
		</tr>
</div>
</form>
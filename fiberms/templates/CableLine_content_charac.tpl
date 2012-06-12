<form name="cablelineinfo" action="CableLine.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<center><table id="contable">
		<tr>
		<td><label class="events_anonce">OpenGIS</label></td><td> <label>{$OpenGIS}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">CableType</label></td><td> <label>{$CableType}</label></td>
		</tr>
		<td><label class="events_anonce">length</label></td><td> <label>{$length}</label></td>
		</tr>
		</tr>
		<td><label class="events_anonce">name</label></td><td> <label>{$name}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">comment</label></td><td> <textarea name="comment">{$comment}</textarea></td>
		</tr>
		<!--tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr-->
	</table></center>

	<div>
			{html_table loop=$data table_attr='id="contable"' cols="ID,OpenGIS,CableLine,meterSign,NetworkNode,note,Apartment,Building,SettlementGeoSpatial,Change,Delete"}
			<p style="margin: 20px;">{$AddPoint}</a>
	</div>
	

</div>
</form>
<form name="cablelineinfo" action="CableLine.php" method="post">
<div>
<input type="hidden" value="1" name="mode" />
	<center><table id="contable">
		<tr>
		<td><label class="events_anonce">Имя</label></td><td> <label>{$name}</label></td>
		</tr>		
		<tr>
		<td><label class="events_anonce">Тип кабеля</label></td><td> <label>{$CableType}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Производитель</label></td><td> <label>{$manufacturer}</label></td>
		</tr>
		<td><label class="events_anonce">Длина</label></td><td> <label>{$length}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">OpenGIS</label></td><td> <label>{$OpenGIS}</label></td>
		</tr>
		<tr>
		<td><label class="events_anonce">Примечание</label></td><td> <label>{$comment}</label></td>
		</tr>
		<!--tr>
		<td><input value="Изменить" type="submit" name="ChangeButton" /></td>
		</tr-->		
	</table></center>	

	<div>
			{html_table loop=$data table_attr='id="contable"' cols="ID,OpenGIS,Отметка (м),Узел,Квартира,Здание,SettlementGeoSpatial,Изм.,Удал."}
			<p style="margin: 20px;">{$AddPoint}</a>
			<td>{$ChangeDelete}</td>
	</div>
	

</div>
</form>
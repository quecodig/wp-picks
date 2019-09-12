<style>
	.qcbbcode{
		float: left;
		margin: 0px;
		color: #FFF;
		padding: 10px;
		display: block;
		width: 100% !important;
		border: 1px solid #EBEBEB;
		list-style: outside none none;
		border-radius: 0px 0px 5px 5px;
		background: #455868 none repeat scroll 0% 0%;
	}
	.qcbbcode ul{
		margin: 0px;
		padding: 0px;
		list-style: outside none none;
	}
	.qcbbcode ul li{
		margin: 0 5px;
		text-align: center;
		height: auto;
		padding: 0px;
		box-sizing: border-box;
		display: block;
		float: left;
	}
	.qcbbcode ul li a{
		opacity: 1;
		color: #FFF;
		padding: 2px;
		display: block;
		cursor: pointer;
		font-size: 17px;
		line-height: 5px;
		text-indent: 0px;
		transition: all 0.5s;
		text-decoration: none;
		background: transparent none repeat scroll 0% 0%;
	}
</style>
<script>
	$(document).on("click",'.add-emoji',function(event){
		event.preventDefault();
		var emoji_tag = $(this).attr("data-tag");
		var txt = document.getElementById("event_desc");
		if (document.selection) {
			txt.focus();
			sel = document.selection.createRange();
			sel.text = emoji_tag;
		} else if (txt.selectionStart || txt.selectionStart == '0') {
			txt.focus();
			txt.value = (txt.value).substring(0, txt.selectionStart) + emoji_tag + (txt.value).substring(txt.selectionStart, txt.selectionEnd) + (txt.value).substring(txt.selectionEnd, txt.textLength);
		} else {
			txt.value = emoji_tag;
		}
		txt.focus();
		return;
	});
</script>
<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr>
		<td width="20%">
			<strong>Estado</strong>
		</td>
		<td width="80%">
			<select name="event_state" class="large-text" style="width: 100%">
				<option value="0" <?php if ($event_state == "0"){?> selected="selected" <?php } ?> >En espera</option>
				<option value="1" <?php if ($event_state == "1"){?> selected="selected" <?php } ?> >Perdida</option>
				<option value="2" <?php if ($event_state == "2"){?> selected="selected" <?php } ?> >Reembolso</option>
				<option value="3" <?php if ($event_state == "3"){?> selected="selected" <?php } ?> >Ganada</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Tipo</strong>
		</td>
		<td width="80%">
			<select name="event_type" class="large-text" style="width: 100%">
				<option value="Boleto Sencillo" <?php if ($event_type == "Boleto Sencillo"){?> selected="selected" <?php } ?> >Boleto Sencillo</option>
				<option value="Boleto Combinado" <?php if ($event_type == "Boleto Combinado"){?> selected="selected" <?php } ?> >Boleto Combinado</option>
				<option value="Fun Bet" <?php if ($event_type == "Fun Bet"){?> selected="selected" <?php } ?> >Fun Bet</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width="20%">
			<strong>Deporte</strong>
		</td>
		<td width="80%">
			<select name="event_depo" class="large-text" style="width: 100%">
				<option value="🎾" <?php if ($event_depo == "🎾"){?> selected="selected" <?php } ?> >Tenis</option>
				<option value="⚽" <?php if ($event_depo == "⚽"){?> selected="selected" <?php } ?> >Fútbol</option>
				<option value="🏒" <?php if ($event_depo == "🏒"){?> selected="selected" <?php } ?> >Hockie</option>
				<option value="⚾️" <?php if ($event_depo == "⚾️"){?> selected="selected" <?php } ?> >Béisbol</option>
				<option value="🏀" <?php if ($event_depo == "🏀"){?> selected="selected" <?php } ?> >Baloncesto</option>
				<option value="🏈" <?php if ($event_depo == "🏈"){?> selected="selected" <?php } ?> >Futbol Americano</option>
				<option value="🏆" <?php if ($event_depo == "🏆"){?> selected="selected" <?php } ?> >General</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Descripción</strong>
		</td>
		<td>
			<textarea name="event_desc" id="event_desc" cols="30" rows="10" class="large-text"><?php echo $event_desc;?></textarea>
			<div class="qcbbcode large-text">
				<ul>
					<li><a id="negro" class="add-emoji" data-tag="👨🏽" href="#">👨🏽</a></li>
					<li><a id="cartel" class="add-emoji" data-tag="📋" href="#">📋</a></li>
				</ul>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<strong>Cuota</strong>
		</td>
		<td>
			<input type="text" name="event_price" value="<?php echo sanitize_text_field($event_price);?>" class="large-text" placeholder="Cuota" />
		</td>
	</tr>
	<tr>
		<td>
			<strong>Hora</strong>
		</td>
		<td>
			<input type="text" name="event_date" value="<?php echo sanitize_text_field($event_date);?>" class="large-text" placeholder="Fecha" />
		</td>
	</tr>
	<tr>
		<td>
			<strong>Probabilidad</strong>
		</td>
		<td>
			<input type="text" name="event_aprx" value="<?php echo sanitize_text_field($event_aprx);?>" class="large-text" placeholder="Probabilidad" />
		</td>
	</tr>
	<tr>
		<td>
			<strong>Stake</strong>
		</td>
		<td>
			<input type="text" name="event_stake" value="<?php echo sanitize_text_field($event_stake);?>" class="large-text" placeholder="Stake" />
		</td>
	</tr>
	<tr>
		<td>
			<strong>Análisis</strong>
		</td>
		<td>
			<textarea name="event_anali" cols="30" rows="10" class="large-text"><?php echo $event_anali;?></textarea>
		</td>
	</tr>
</table>
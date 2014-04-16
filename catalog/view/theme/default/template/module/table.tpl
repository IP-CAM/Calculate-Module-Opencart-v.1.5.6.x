<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
<h1><?php echo $title; ?></h1>
<h2 class="send"><?php echo $send_ok; ?></h2>
<table class="gridtable">
<tr>
	<th>№</th>
	<th>Код товара</th>
	<th>Описание товара</th>
	<th>Стоимость</th>
	<th>Количество</th>
	<th>Сумма</th>
</tr>
<tr id="1">
	<td>1</td>
	<td><input type="text" id="artikul" placeholder = "Введите код товара" \></td>
	<td id="art"></td>
	<td id="stoim"></td>
	<td id="kolvo"><input type="number" id="kolvo" value = "0" min="1" disabled \></td>
	<td id="summa" class="b">0</td>
</tr>
</table>
<br/>
<input type="submit" id="reset" value="Сброс">
<input type="submit" id="print" value="Печатать">
<input type="submit" id="send" value="Отправить">
<br/><br/>
<hr>
<br/>
Всего товаров на сумму: <h3 id="allSum"></h3>
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>

<!-- Модальное окно //-->
<div id="openModal" class="modalDialog">
	<div>
		<a href="#" title="Закрыть" class="close">X</a>
		<br/>
		<h2>Заполните форму заказа товаров</h2>
		<br/>
		<form action="http://electro-kontakt.ru/index.php?route=module/table/sendmail" method="post">
		<p>
			<label for="firstname">Имя: </label>
			<input type="text" id="name" name="name" required/><br/>
			<label for="email">E-mail: </label>
			<input type="email" id="email" name="email" required/><br/>
			<label for="email">Телефон: </label>
			<input type="text" id="tel" name="tel" required/><br/>
			<input type="text" id="artikuls" name="artikuls" hidden/>
			<input type="text" id="pieces" name="pieces" hidden/><br/>
			<input type="submit" id="sendform" value="Отправить">
		</p>
		</form>
	</div>
</div>

<!-- Модальное окно //-->
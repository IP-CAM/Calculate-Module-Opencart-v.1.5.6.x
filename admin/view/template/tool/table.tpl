<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/log.png" alt="" /> <?php echo "Заголовок"; ?></h1>
      <div class="buttons"><a href="<?php echo "#" ?>" class="button"><?php echo "Тестовая кнопка"; ?></a></div>
    </div>
    <div class="content">
		<?php if(isset($goods) && $goods!=FALSE){?>
		<?php foreach($goods as $key => $good){ $number = 1;?>
		<hr>
		<h1><?php echo $key; ?></h1>
		<table class="gridtable">
			<tr>
				<th>№</th>
				<th>Артикул</th>
				<th>Описание товара</th>
				<th>Стоимость</th>
				<th>Количество</th>
				<th>Сумма</th>
			</tr>
			<?php $sum = 0; foreach($good as $g){ ?>
			<tr>
				<td><?php echo $number; ?></td>
				<td><?php echo $g['artikul']; ?></td>
				<td><?php echo $g['description']; ?></td>
				<td><?php echo $g['stoimost']; ?></td>
				<td><?php echo $g['kolvo']; ?></td>
				<td><?php echo ($g['stoimost']*$g['kolvo']); ?></td>
			</tr>
			<?php $number++; $sum += ($g['stoimost']*$g['kolvo']);} ?>
		</table>
		<hr>
		Всего на сумму: <h4><?php echo $sum; ?></h4>
		<hr>
		Данные: <h4><?php echo $g['name']; ?>, <?php echo $g['phone']; ?>, <?php echo $key; ?></h4>
		<hr>
		<h4><a style="color:red;" href='<?php echo $delete_link.'&name='.$key; ?>'><?php echo $delete; ?></a></h4>
		<hr>
		<?php } ?>
		<br/>
		<?php }else{ ?>
			<h1>Записей нет</h1>
		<?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>
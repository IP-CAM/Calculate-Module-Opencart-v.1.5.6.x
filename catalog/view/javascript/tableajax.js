$(document).ready(function() {
	num = 1;
	// По нажатию на Enter или событию "focusout" ищем в БД товар по артикулу
	$(document.body).on('focusout keyup', '#artikul', function(e){
		if (e.type == 'focusout' || e.keyCode == '13'){
			val = $(this).val();
			if(val!=''){
				$.ajax({
					type: 'post',
					url: 'index.php?route=module/table/searchGood',
					//add data like this using &
					data: 'data='+val,
					dataType: 'json',
					success: function(json) {
						if(json['artikul']) {
							art = json['material_description'];
							stoim = json['stoimost'];
							//you can use data according to need
							addGoodToTable(art, stoim);
						}else{
							alert('Артикул не найден в базе данных!');
						}
					}
				});
			}else{
				alert('Введите артикул товара!');
			}	
		}
	});
	// Считаем сумму товаров 
	$(document.body).on('focusout keyup', '#kolvo', function(e){
		if (e.type == 'focusout' || e.keyCode == '13'){
			var stoim = $(this).prev().text();
			var kolvo = $(this).children().val();
			var z = Math.round( (stoim*kolvo) * 100 ) / 100;
			$(this).next().text(z);
			calculate();
		}	
	});
	// События по нажатию на кнопки под таблицей
	$(document.body).on('click', '#reset', function(){
		location.reload();
	});
	$(document.body).on('click', '#print', function(){
		window.print();
	});
	$(document.body).on('click', '#send', function(){
		$('.modalDialog').fadeIn(500).css({"pointer-events":"auto"});
		// Тут пишем данные в массив для отправки админу
		artikuls = new Array();
		var i = 0;
		$(':input[id=artikul]').each(function() {
			artikuls[i] = $(this).val();
			i++;
		});
		artikuls.pop();
		kolvo = new Array();
		var i = 0;
		$(':input[type=number]').each(function() {
			kolvo[i] = $(this).val();
			i++;
		});
		kolvo.pop();
		// И добавляем скрытым полем
		$('input#artikuls').val(artikuls);
		$('input#pieces').val(kolvo);
	});
	// Удаляем массив, если юзер закрыл модальное окно
	$(document.body).on('click', 'a.close', function(e){
		$('.modalDialog').css({"display":"none"});
		delete artikuls;
		e.preventDefault();
	});
	// Обработка удаления строки в таблице
	$(document.body).on('click', '#del', function(){
		$(this).parent().remove();
		var tmp = 0;
		$('td#summa').each(function() {
			tmp+=parseFloat($(this).text());
			tmp = Math.round( tmp * 100 ) / 100;
			$('h3#allSum').text(tmp);
		});
		newNum = 1;
		$('tr[id]>td:first-child').each(function() {
			$(this).text(newNum);
			newNum++;
		});
	});
	// Анимашка информации
	if($('h2.send').text()=='Спасибо, ваш заказ успешно отправлен нашим менеджерам. Мы свяжемся с вами в течение ближайшего времени!!!'){
		setTimeout(function(){
			$('h2.send').fadeOut(500);
		},3000);
	}
});

function addGoodToTable(a, s){
	$('input#artikul').attr('disabled','disabled');
	$('<td id=\"del\">-</td>').insertAfter($('td').last());
	$('td#kolvo input').removeAttr('disabled');
	$('#art').text(a);
	$('#stoim').text(s);
	$('#art').removeAttr('id');
	$('#stoim').removeAttr('id');
	$( "<tr id='"+(num+1)+"'><td>"+(num+1)+"</td><td><input type=\"text\" id=\"artikul\" placeholder = \"Введите код товара\" \></td><td id=\"art\"></td><td id=\"stoim\"></td><td id=\"kolvo\"><input type=\"number\" value = \"0\" min=\"1\" disabled \></td><td id=\"summa\">0</td></tr>" ).insertAfter($('tr#'+num+''));
	num++;
	newNum = 1;
	$('tr[id]>td:first-child').each(function() {
		$(this).text(newNum);
		newNum++;
	});
}

function calculate(){
	var tmp = 0;
	$('td#summa').each(function() {
		tmp+=parseFloat($(this).text());
		tmp = Math.round( tmp * 100 ) / 100;
		$('h3#allSum').text(tmp);
	});
}
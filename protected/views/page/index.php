<? if(!empty($page->title))
	$this->pageTitle = $page->title;
else
	$this->pageTitle = "$page->name  / $title ".$this->pageTitle;

if(!empty($page->keywords))
	$this->pageKeywords = $page->keywords;

if(!empty($page->description))
	$this->pageDescription = $page->description;
?>

<p class="bread_crumbs"><? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
		'links'=>array(
				"$page->name",
		),
	'tagName' => 'bread_crumbs',
)); ?>
</p>
<br>

<div class="h1-substrate">
	<h1>
		<strong><?php echo $page->name; ?>    <? if(Yii::app()->session->get("admin") == 1):?>
			<a href = "/admin/page/update/id/<?=$page->id?>" target= "_blank">
				<img src = "/images/edit.png">
			</a>
		<? endif; ?>
		</strong>
	</h1>
</div>

<?=$page->content?>

<? if($page->id == 11)
{?>
	<script>
		function checkCall()
		{
			$.ajax({
				type : 'POST',
				url : '/site/call',
				data : $('#formcall').serialize() ,
				success: function(msg){
					$(".pop_callback").html("<p class='wait'>Спасибо! Ваш заявка принята. В скором времени вам вышлют каталог</p>");
				}
			});
		}
	</script>
	<br>
	<div class='pop_callback'>
		<form id = "formcall">
			<label class='callback'>ФИО получателя* :<br>
			<input class='callback' name = "name" id = "name" type='text' required placeholder="Максим Максимов" size="50"></label><br><br>
			<label class='callback'>Адрес* :<br>
			<input class='callback' name = "address" id = "address" type='text' required placeholder="г.Ростов-на-дону, пр.Мира 134" size="50"></label><br><br>
			<label class='callback'>Email* :<br>
			<input class='callback' name = "email" id = "email" type='text' required placeholder="info@site.ru" size="50"></label><br><br>
			<label class='callback'>Телефон* :<br>
			<input class='callback' name = "phone" id = "phone" type='text' required placeholder="+7 (988) 555-66-12" size="50"></label><br><br>
			<label class='callback'>Название компании :<br>
			<input class='callback' name = "companyName" id = "companyName" type='text' placeholder="Microsoft" size="50"></label><br><br>
			<label class='callback'>Чем занимается компания :<br>
			<textarea class='callback' name = "aboutCompany" id = "aboutCompany" placeholder="Пару слов о вашей компании" cols="51" rows="6"></textarea></label><br><br>
			<?/*<label class='callback'>Город/село :<br>
			<input class='callback' name = "city" id = "city" type='text' placeholder="Microsoft"></label><br><br>
			<label class='callback'>Индекс :<br>
			<input class='callback' name = "index" id = "index" type='text'></label><br><br>*/?>

			<input class='callback' id = "buttcall" type='button' onClick="checkCall()" value='Заказать'><br>
		</form>
	</div>
<? } ?>

<? if($page->id == 12)
{?>
	<script>
		function checkVacancyCall()
		{
			if($('#phone').val() == "")
				alert("Введите телефон!");
			else
			{
				$.ajax({
					type : 'POST',
					url : '/site/vacancycall',
					data : $('#formcall').serialize() ,
					success: function(msg){
						$(".pop_callback").html("<p class='wait'>Спасибо! Ваш заявка принята, и передана на рассмотрение</p>");
					}
				});
			}
		}
	</script>

	<div class='pop_callback'>
		<form id = "formcall">
			<label class='callback'>Ваше ФИО* :<br>
			<input class='callback' name = "name" id = "name" type='text'required></label><br><br>
			<label class='callback'>Город/село:<br>
			<input class='callback' name = "city" id = "city" type='text'></label><br><br>
			<label class='callback'>Должность:<br>
			<input class='callback' name = "doljnost" id = "doljnost" type='text'></label><br><br>
			<label class='callback'>Телефон* :<br>
			<input class='callback' name = "phone" id = "phone" type='text' required></label><br><br>
			<label class='callback'>Email:<br>
			<input class='callback' name = "email" id = "email" type='text'></label><br><br>
			<label class='callback'>Немного о себе:<br>
			<textarea class='callback' name = "about" id = "about" rows="7" cols="75"></textarea></label><br><br>

			<input class='callback' id = "buttcall" type='button' onClick="checkVacancyCall()" value='Заказать'><br>
		</form>
	</div>
<? } ?>



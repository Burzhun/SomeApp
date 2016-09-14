
<?php 
$this->breadcrumbs=array(
	'Админка',
);

$this->pageTitle="Админка - ". Yii::app()->name;
?>


<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Управление сайтом',
)); ?>
 
    <p>Перед вами - администраторская панель сайта <?=Yii::app()->name?>, выберите интересующий вас раздел из верхнего меню</p>
	
	
	
	
		
 
<?php $this->endWidget(); ?>
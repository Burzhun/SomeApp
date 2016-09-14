<?/*
$this->widget('zii.widgets.CBreadcrumbs', array(
	'links'=>array(
		'Профиль'=>array('/user/profile'),
		'Изменить пароль', 
	),
));*/
?>

<h1>Изменить пароль</h1>

<div class="form">
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'oldpassword'); ?>
		<?php echo $form->passwordField($model,'oldpassword', array('placeholder' => 'Старый пароль')); ?>
		<?php echo $form->error($model,'oldpassword'); ?>
	</div>
	<br>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password', array('placeholder' => 'Новый пароль')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div><br>

	<div class="row">
		<?php echo $form->labelEx($model,'dpassword'); ?>
		<?php echo $form->passwordField($model,'dpassword', array('placeholder' => '')); ?>
		<?php echo $form->error($model,'dpassword'); ?>
	</div>
	<button type="submit" class="form_button" >Изменить</button>

<?php $this->endWidget(); ?>
</div>
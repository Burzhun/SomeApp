<div style="font-size: 18px;
font-weight: bold;
color: #27E495;">
<?=Yii::app()->user->getFlash('success')?>
</div>
<h1>Вход на сайт</h1>

<p class = "hint">Введите ваш адрес почты и пароль</p>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe" style='font-size:10px;'>
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<a href="/site/password">Забыли пароль?</a><br><br>

	<div class="row buttons">
				<div  ><button type="submit"   class='reg_button'>Вход</button></div>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
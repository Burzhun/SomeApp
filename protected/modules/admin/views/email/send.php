<?php
$this->breadcrumbs=array(
	'Админка'=>array('/index'),
	'Разослать сообщение',
);

?>
<h1>Разослать сообщение</h1>
<div class="form wide padding-all">
	<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'subject'); ?>
		<?php echo $form->textField($model,'subject') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sender_name'); ?>
		<?php echo $form->textField($model,'sender_name') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sender_email'); ?>
		<?php echo $form->textField($model,'sender_email') ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'body'); ?>
		<?php echo $form->textArea($model,'body', array('class' => 'ckeditor')); ?>
		<span class="required"> *</span>
	</div>

	<div class="row">
		<?php echo $form->label($model,'useHtml'); ?>
		<?php echo $form->checkBox($model,'useHtml') ?>
	</div>

	<div class="row submit">
		<label>&nbsp;</label>
		<?php echo CHtml::submitButton('Отправить всем пользователям', array(
		'confirm'=>'Вы уверены?',
	)); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->


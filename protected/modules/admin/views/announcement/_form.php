<?php
/* @var $this AnnouncementController */
/* @var $model Announcement */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'announcement-form',
	'enableAjaxValidation'=>false,
		    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contacts'); ?>
		<?php echo $form->textArea($model,'contacts',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'contacts'); ?>
	</div>


	<div class="row">
		<? if($model->image): ?>
		
		<img src = "<?=$model->imagePath('small')?>"><br>
		Для изменения загрузите новое
		<? endif; ?>
		<?php echo $form->labelEx($model,'form_image'); ?>
		<?php echo $form->fileField($model,'form_image'); ?>
		<?php echo $form->error($model,'form_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
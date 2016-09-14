<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

  
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password_form'); ?>
		<?php echo $form->textField($model,'password_form',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password_form'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'admin'); ?>
		<?php echo $form->CheckBox($model,'admin'); ?>
		<?php echo $form->error($model,'admin'); ?>
	</div>
  	<div class="row">
		<?php echo $form->labelEx($model,'seehidden'); ?>
		<?php echo $form->CheckBox($model,'seehidden'); ?>
		<?php echo $form->error($model,'seehidden'); ?>
	</div> 
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
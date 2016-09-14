<?php
/* @var $this TireController */
/* @var $model Tire */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tire-form',
	'enableAjaxValidation'=>false,
	    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>



	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		Производитель<br>
		<?php echo $form->dropDownList($model,'manufacter_id', CHtml::listData(TireManufacter::model()->findAll(),'id','name')); ?>
		<?php echo $form->error($model,'manufacter_id'); ?>
	</div>	
		<div class="row">
		Тип шин<br>
		<?php echo $form->dropDownList($model,'type_id', $model->types()); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pr'); ?>
		<?php echo $form->textField($model,'pr',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'models'); ?>
		<?php echo $form->textArea($model,'models',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'models'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
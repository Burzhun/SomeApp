<div class="form">

<?php

 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'manufacter-form',
	'enableAjaxValidation'=>false,
		    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

			<div class="row">
		<?php echo $form->labelEx($model,'image_form'); ?>
		<?php echo $form->fileField($model,'image_form',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image_form'); ?>
		<? if($model->image) :?>
		<br><img src = "/uploads/<?=$model->image?>">
	<? endif;?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
<?php echo $form->textArea($model,'description'); ?>

		<?php echo $form->error($model,'description'); ?>
		<SCRIPT>
CKEDITOR.replace( 'Manufacter_description',
	{
		toolbar : 'Full'
	});
		</SCRIPT>

	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
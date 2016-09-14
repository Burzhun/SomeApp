<div class="form">

<?php
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
	    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Поля, отмеченные  <span class="required">*</span> обязательные</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'short'); ?>
		<?php echo $form->textArea($model,'short',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'short'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content'); ?>	
		<?php echo $form->error($model,'content'); ?>
	</div>
		<SCRIPT>
CKEDITOR.replace( 'Service_content',
	{
		toolbar : 'Full'
	});
		</SCRIPT>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image',array('size'=>60,'maxlength'=>266)); ?>
		<?if(!empty($model->image)):?>
		<br>
		<b>Установленная картинка: </b>
		<?=CHtml::image('/uploads/medium_'.$model->image);?>
	<? endif?>
		<?php echo $form->error($model,'image'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'seotitle'); ?>
		<?php echo $form->textField($model,'seotitle',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seotitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seokeywords'); ?>
		<?php echo $form->textField($model,'seokeywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seokeywords'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'seodescription'); ?>
		<?php echo $form->textField($model,'seodescription',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seodescription'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="form">

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные  <span class="required">*</span> обязательные</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">

		<?php echo $form->labelEx($model,'content'); ?>
<?php echo $form->textArea($model,'content'); ?>	
		<SCRIPT>
CKEDITOR.replace( 'Page_content',
	{
		toolbar : 'Full'
	});
</SCRIPT>
		<?php echo $form->error($model,'content'); ?>
	</div>

	
		<div class="row">
		URL страницы, <i>Пример: about</i>
		<br>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>266)); ?>
		<?php echo $form->error($model,'url'); ?>
		
	</div>
	
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textField($model,'keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>266)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
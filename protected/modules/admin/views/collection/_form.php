<?php
/* @var $this CollectionController */
/* @var $model Collection */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'collection-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div >
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

<?if(!$this->themeId){?>
	<div >
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'ckeditor')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'seo_title'); ?>
		<?php echo $form->textField($model,'seo_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seo_title'); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'seo_keywords'); ?>
		<?php echo $form->textField($model,'seo_keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seo_keywords'); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'seo_description'); ?>
		<?php echo $form->textField($model,'seo_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seo_description'); ?>
	</div>
<?}else{?>

	<div >
		<?php echo $form->labelEx($model,'description_roz'); ?>
		<?php echo $form->textArea($model,'description_roz',array('rows'=>6, 'cols'=>50, 'class'=>'ckeditor')); ?>
		<?php echo $form->error($model,'description_roz'); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'seo_title_roz'); ?>
		<?php echo $form->textField($model,'seo_title_roz',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seo_title_roz'); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'seo_keywords_roz'); ?>
		<?php echo $form->textField($model,'seo_keywords_roz',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seo_keywords_roz'); ?>
	</div>

	<div >
		<?php echo $form->labelEx($model,'seo_description_roz'); ?>
		<?php echo $form->textField($model,'seo_description_roz',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seo_description_roz'); ?>
	</div>
<?}?>
	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
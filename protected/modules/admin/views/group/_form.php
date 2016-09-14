<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>
<?/*
	<div>
		<?php echo $form->labelEx($model,'collection_id'); ?>
		<?php echo $form->textField($model,'collection_id'); ?>
		<?php echo $form->error($model,'collection_id'); ?>
	</div>
*/?>
	<div>
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->textField($model,'image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'ckeditor')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<?if(!$this->themeId){?>
		<div>
			<?php echo $form->labelEx($model,'seo_title'); ?>
			<?php echo $form->textField($model,'seo_title',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'seo_title'); ?>
		</div>

		<div>
			<?php echo $form->labelEx($model,'seo_keywords'); ?>
			<?php echo $form->textField($model,'seo_keywords',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'seo_keywords'); ?>
		</div>

		<div>
			<?php echo $form->labelEx($model,'seo_description'); ?>
			<?php echo $form->textField($model,'seo_description',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'seo_description'); ?>
		</div>
	<?}else{?>
		<div>
			<?php echo $form->labelEx($model,'seotitle'); ?>
			<?php echo $form->textField($model,'seotitle',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'seotitle'); ?>
		</div>

		<div>
			<?php echo $form->labelEx($model,'seokeywords'); ?>
			<?php echo $form->textField($model,'seokeywords',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'seokeywords'); ?>
		</div>

		<div>
			<?php echo $form->labelEx($model,'seodescription'); ?>
			<?php echo $form->textField($model,'seodescription',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'seodescription'); ?>
		</div>
	<?}?>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
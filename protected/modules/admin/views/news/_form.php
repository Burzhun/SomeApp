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
		<?php echo $form->labelEx($model,'long'); ?>
		<?php echo $form->textArea($model,'long'); ?>	
		<?php echo $form->error($model,'long'); ?>
	</div>

	<br>
	<div class='row'>
		<?php echo $form->labelEx($model,'date'); ?>
		<?$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'date',
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat' => 'dd-mm-yy',
				'regional' => 'ru',
			),
			'htmlOptions'=>array(
				'style'=>'height:20px;'
			),
		));?>
	</div>

	<?/*<div class="row">

		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date', array('value'=>$model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', $model->date))); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>*/?>

	<SCRIPT>
		CKEDITOR.replace( 'News_long',
		{
			toolbar : 'Full'
		});
	</SCRIPT>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image',array('size'=>60,'maxlength'=>266)); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
		<?php echo $form->textField($model,'keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'keywords'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
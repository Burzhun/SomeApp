<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('class'=>'ckeditor')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<?/*<div>
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div>
		<?php echo $form->checkBox($model,'main', array('style'=>'position:relative;top:-3px;')); ?>
		<?php echo $model->getAttributeLabel('main'); ?>
		<?php echo $form->error($model,'main'); ?>
	</div>
	<br>*/?>

	<?/*<b>Добавить фото (размер не больше 1000x1000)</b> :<br>
	<?php $this->widget('CMultiFileUpload',array(
		'name'=>'files',
		'accept'=>'jpg|png|jpeg',
		'max'=>2,
		'remove'=>Yii::t('ui','Удалить '),
		'denied'=>'Выберите картинку', //message that is displayed when a file type is not allowed
		'duplicate'=>'Файл уже выбран', //message that is displayed when a file appears twice
		'htmlOptions'=>array('size'=>25),
	)); */?>
	<br>

	<div>
		<?php echo $form->labelEx($model,'seokeywords'); ?>
		<?php echo $form->textField($model,'seokeywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seokeywords'); ?>
	</div>
	<div>
		<?php echo $form->labelEx($model,'seotitle'); ?>
		<?php echo $form->textField($model,'seotitle',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seotitle'); ?>
	</div>
	<div>
		<?php echo $form->labelEx($model,'seodescription'); ?>
		<?php echo $form->textField($model,'seodescription',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seodescription'); ?>
	</div>
	
	<?/*//Дата?><br>
	<div>
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
	<div>
		<?php echo $form->labelEx($model,'file'); ?>
		<?php echo $form->fileField($model,'file'); ?>
		<?php echo $form->error($model,'file'); ?>
	</div>
	<div class='model-image'>
	<?if($model->image){?>
		<span>Установленная картинка</span>
		<img src='<?=Yii::app()->ih->load($model->dir.$model->image)->thumb(150, 150)->cache();?>'>
		<?php echo $form->hiddenField($model,'removeImage', array('id'=>'model-hidden-field-image'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Удалить картинку',
		    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'small', // null, 'large', 'small' or 'mini'
		    'htmlOptions'=>array(
		    		'class'=>'deleteImage',
		    		'data-image'=>$model->image,
		    		),
		)); ?>
	<?}?>
	</div>
	<div>
	<br>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Восстановить картинку',
		    'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'small', // null, 'large', 'small' or 'mini'
		    'htmlOptions'=>array(
		    		'class'=>'restore',
		    		),
		)); ?>	</div>

	<br><br>
<?*/?>	<div>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
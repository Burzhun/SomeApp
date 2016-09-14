<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>false,
)); ?>


	<? foreach ($models as $model)  {?>

	<? $i++;?>

	<?php echo $form->hiddenField($model,'id'); ?>
	<?php echo $form->errorSummary($model); ?>
	
	<div style="font-weight:bold;">

		<?=$model->name?>
	</div>

	<div >
	
		<?php echo $form->textField($model,'value',array('style'=>'width:400px;', 'name'=>'Config[value]['.$model->id.']')); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>
<? } ?>


	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
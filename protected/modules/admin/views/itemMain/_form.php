<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-main-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php echo CHtml::dropDownList('ItemMain[item_id]', '',
	CHtml::listData(Item::model()->findAll(array('order' => 'name ASC')),'id','name'), 
	array('empty'=>'Выбрать')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-form',
	'enableAjaxValidation'=>false,
	    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Поля отмеченные  <span class="required">*</span> обязательные.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>

	</div>
 
<? $attr = Attribute::model()->findAll();?>
<? $attr = CHtml::listData($attr,'id','name');?>

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
		<SCRIPT>
CKEDITOR.replace( 'Catalog_description',
	{
		toolbar : 'Full'
	});
</SCRIPT>
		<?php echo $form->error($model,'description'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>

	</div>
	<div class="row">

<?php if(isset($_GET['parent_id'])){?>
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',
					CHtml::listData(Catalog::model()->findAll(),'id','name'), 
					array('options'=>array($_GET['parent_id']=>array('selected'=>true)))); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	<?php }else{?>
		<?php echo $form->hiddenField($model, 'parent_id');?>
	<?php }?>
</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
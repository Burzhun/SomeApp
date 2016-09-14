<style>
.row {
	margin: 5px;
}
</style>

<div class="form">
	<div style = "padding-left: 20px;">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'item-form',
			'enableAjaxValidation'=>true,
			'htmlOptions' => array(
				'enctype' => 'multipart/form-data')
		)); ?>
	
	
		<b>Добавить фото</b> :<br>
		<?php $this->widget('CMultiFileUpload',array(
			'name'=>'files',
			'accept'=>'jpg|png|jpeg',
			'max'=>10,
			'remove'=>Yii::t('ui','Удалить '),
			'denied'=>'Выберите картинку', //message that is displayed when a file type is not allowed
			'duplicate'=>'Файл уже выбран', //message that is displayed when a file appears twice
			'htmlOptions'=>array('size'=>25),
		)); ?>


		<?if($this->themeId == 1){?>
			
			<div class="row">			
			<label>Коллекции</label>
			<?php
			 $this->widget('ext.select2.ESelect2',array(
				'model'=>$model,
				'attribute'=>'kubachiCollection',
				'data'=> KubachinkaCollection::listData(),
			    'htmlOptions'=>array(
			    	'multiple'=>'multiple',
			    	'style' => "width: 300px;",
			   	),
			 ));
			?>
			</div>
			
			<div class="row">
            <?php echo $form->labelEx($model,'categoryId'); ?>
            <?php echo $form->dropDownList($model,'categoryId',array('0'=>'Выберите категорию')+Category::listData(),array('style'=>'width:250px;')); ?>
            <?php echo $form->error($model,'categoryId'); ?>
        </div>
			<div class="row">
				<?php echo $form->labelEx($info,'name'); ?>
				<?php echo $form->textField($info,'name',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($info,'name'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($info,'description'); ?>
				<?php echo $form->textArea($info,'description',array('class'=>'ckeditor')); ?>
				<?php echo $form->error($info,'description'); ?>
			</div>
		<?}else{?>
			<div class="row">
				<?php echo $form->labelEx($model,'name_full'); ?>
				<?php echo $form->textField($model,'name_full',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'name_full'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($model,'description_main'); ?>
				<?php echo $form->textArea($model,'description_main',array('size'=>60,'maxlength'=>255, 'class'=>'ckeditor')); ?>
				<?php echo $form->error($model,'description_main'); ?>
			</div>
		<?}?>


		<div>
			<?php echo $form->checkBox($info,'main'); ?>
			<?php echo $model->getAttributeLabel('main'); ?>
			<?php echo $form->error($info,'main'); ?>
		</div><br>

	
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>
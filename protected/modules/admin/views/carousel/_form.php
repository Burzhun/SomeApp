<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'carousel-form',
	'enableAjaxValidation'=>true,
    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Поля с  <span class="required">*</span> обязательны для заполнения</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

Начало: <br> <?
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model' => $model,
    'attribute' => 'start',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat' => 'dd-mm-yy',
        'regional' => 'ru',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?> <br>
Конец показа <br>
<?
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model' => $model,
    'attribute' => 'end',
    // additional javascript options for the date picker plugin
    'options'=>array(
        'showAnim'=>'fold',
        'dateFormat' => 'dd-mm-yy',
        'regional' => 'ru',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?> 

	<script>
	function fuckingBlackAndWhiteImages() {
		var id = $('#Carousel_type').val();
		if(id==2)
			$('#fuckingBlackAndWhiteImage').show();
		else
			$('#fuckingBlackAndWhiteImage').hide();
	}
	$(function() {
		fuckingBlackAndWhiteImages();
	});
	</script>


	<div class="">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', $this->themeId ? Carousel::getTypesArrayStore() : Carousel::getTypesArray(),array('onchange' => 'fuckingBlackAndWhiteImages()')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255, 'value' => $model->url ? $model->url : "#",)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class=""> 
 
	<? if(!$model->isNewRecord) {
	
		echo CHtml::image("/uploads/medium_".$model->image); 
			echo "<br>Если вы хотите изменить картинку то загрузите новый файл";}?>
		<?php echo $form->labelEx($model,'image_form'); ?>
		<?php echo $form->fileField($model,'image_form',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image_form'); ?>
	</div>

	<?/*<div class="" style = "display:none;" id = "fuckingBlackAndWhiteImage"> 
		<? if(!$model->isNewRecord) {
			echo CHtml::image("/uploads/medium_".$model->image2); 
				echo "<br>Если вы хотите изменить картинку то загрузите новый файл";
		}?>
		<?php echo $form->labelEx($model,'image_form2'); ?>
		<?php echo $form->fileField($model,'image_form2',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image_form2'); ?>
	</div>*/?>

	<div class=" buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
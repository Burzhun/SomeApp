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

<table width = 800px; valign = "top">
	<th><legend>Основное</legend></th>
	<th><legend>Дополнительные параметры</legend></th>

	<tr>
	<td  style="vertical-align: top; width: 300px; border-right: 2px solid #eee;">	

	<p class="note">Поля, помеченные<span class="required">*</span> обязательные</p>
	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'article'); ?>
		<?php echo $form->textField($model,'article',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'article'); ?>
	</div>	
 
 

		<div class="row">
			<?php echo $form->checkBox($model,'popular'); ?>
			<?php echo $model->getAttributeLabel('popular'); ?>
			<?php echo $form->error($model,'popular'); ?>
	</div>

 


		<div class="row">
			<?php echo $form->checkBox($model,'popular_main'); ?>
			<?php echo $model->getAttributeLabel('popular_main'); ?>
			<?php echo $form->error($model,'popular_main'); ?>
	</div>

		<div class="row">
			<?php echo $form->labelEx($model,'size_id'); ?>
			<?php echo $form->dropDownList($model,'size_id',Size::listData()); ?>
			<?php echo $form->error($model,'size_id'); ?>
	</div>

	  	<div class="row">
		<?php echo $form->labelEx($model,'manufacter_id'); ?>
		<?
$this->widget('ext.select2.ESelect2',array(
  'model' => $model,
  'attribute' => 'manufacter_id',
  'data'=>CHtml::listData(Manufacter::model()->findAll(array('order'=>'name ASC')),'id','name'),
  'htmlOptions'=>array(
  ),
)); ?>
		<?php echo $form->error($model,'manufacter_id'); ?><br>
		Если нужного производителя нет в списке то вам нужно предварительно его <b><?=CHtml::link('добавить', array('/admin/manufacter/create'))?></b>
	</div> 
 

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>	
	</td>
<td  style="vertical-align: top;">
 
<a href="#" onClick="look('div2'); return false;">Характеристики товара</a>
	<div id = "div2" style = "display: none">

<? $groups = AttributeGroup::model()->findAll();
	foreach ($groups as $group) : ?>
<fieldset>
	<b style = ""><?=$group->name; ?></b><br>
		<?foreach ($group->attr as $a):
			if(isset($_POST['StoreAttribute'][$a->unique]))
				$value = $_POST['StoreAttribute'][$a->unique];
			else
				$value = $model->getEavAttribute($a->unique);
			$a->required ? $required = ' <span class="required">*</span>' : $required = null;
			if($a->type==4):
			echo ''.$a->renderField($value).'&nbsp';
			echo $a->name;
			echo " <br>";
			else:	
			echo $a->name; echo '&nbsp'.$a->renderField($value).'';
			echo " <br>";
			endif;	

endforeach;?>

</fieldset>
<? endforeach;?> 
</div>


<div class="row">
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
</div>
	<div class="row">
		Главная категория:<br>
		<?
		$this->widget('ext.select2.ESelect2',array(
		  'model' => $model,
		  'attribute' => 'catalog_id',
		  'data'=>Catalog::listData(),
		  'htmlOptions'=>array(
		  ),
		)); ?>
<br>Дополнительные категории:<br>
<?php
 $this->widget('application.extentions.select2.ESelect2',array(
   'model'=>$model,
   'attribute'=>'catalogs',
  'data'=> Catalog::listData(),
    'htmlOptions'=>array(
     'multiple'=>'multiple',
    'style' => "width: 300px;",
   ),
 ));
?></div>
<!-- 
<br>Размер : Количество пар <br>

<? $template = '<input type="text" name="size[]"  value="" placeholder = "Размер" /><input type="text" name="count[]" value="" placeholder = "Количество" />'; ?>	

<? if(!$model->isNewRecord):?>
<? foreach ($model->sizes as $value) { ?>

<input type="text" name="size[]" value="<?=$value->size?>" placeholder = "Размер" /><input type="text" name="count[]" value="<?=$value->count?>" placeholder = "Количество" /><br>

<? }?>
<? endif; ?>

<div class = "inputs"></div>
<div class = "notice" style = "display:none">Для удаления оставьте значение пустым</div><a id="add" style = "float:right; cursor: pointer;">Добавить размер</a><br>
 -->

<script>
$(document).ready(function(){
var inputHTML = '<?=$template?>';

$(inputHTML).fadeIn('slow').appendTo('.inputs');	

	$('#add').click(function() {
		$(inputHTML).fadeIn('slow').appendTo('.inputs');
		$(".notice").show();

	});
});
</script>






<script>
function look(type){
param=document.getElementById(type);
if(param.style.display == "none") param.style.display = "block";
else param.style.display = "none"
}
</script>
<a href="#" onClick="look('div1'); return false;">Дополнительные параметры  - показать: </a>
<div id="div1" style="display:none">
	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>	


		<div class="row">
		<?php echo $form->labelEx($model,'views'); ?>
		<?php echo $form->textField($model,'views'); ?>
		<?php echo $form->error($model,'views'); ?>
	</div>	
			<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>	
 
 
		<div class="row">
		<?php echo $form->labelEx($model,'seotitle'); ?>
		<?php echo $form->textField($model,'seotitle'); ?>
		<?php echo $form->error($model,'seotitle'); ?>
	</div>
		<div class="row">
		<?php echo $form->labelEx($model,'seokeywords'); ?>
		<?php echo $form->textField($model,'seokeywords'); ?>
		<?php echo $form->error($model,'seokeywords'); ?>
	</div>
		<div class="row">
		<?php echo $form->labelEx($model,'seodescription'); ?>
		<?php echo $form->textField($model,'seodescription'); ?>
		<?php echo $form->error($model,'seodescription'); ?>
	</div>

</div> 


<!-- end of div1 -->
</td>
</tr>
</table>
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description', array('class' => 'ckeditor')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
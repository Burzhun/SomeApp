<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menu-item-form',
	'enableAjaxValidation'=>false,

	    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Поля обозначенные <span class="required">*</span> обязательны для запополнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'image_form'); ?>
		<?php echo $form->fileField($model,'image_form',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'image_form'); ?>
		<? if($model->image) :?>
		<br><img src = "/uploads/<?=$model->image?>">
	<? endif;?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>
	
<? if(!$model->isNewRecord)
	$menu_id = $model->menu_id;
	else
	$menu_id = $_GET['menu_id'];	?>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',  CHtml::listData(MenuItem::model()->findAll('menu_id='.$menu_id." AND parent_id=0"),'id','name'), array('empty'=>'Нет')  ); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class = "row">
	<?if($model->link){
		
		$model->page = Page::model()->find('url=:alias AND theme=:theme', array(':alias'=>$model->link, ':theme'=>$this->themeId))->id;
		
	}
		?>
	или установить ссылку на страницу<br>
	<?php echo $form->dropDownList($model,'page',array('0'=>'Нет страницы')+CHtml::listData(Page::model()->findAll('theme='.$this->themeId), 'id','name')); ?>
	<?//php echo $form->dropDownList($model, 'page', CHtml::listData(Page::model()->findAll('theme='.$this->themeId),'id','name'), array('empty'=>'Выбрать')); ?>
	</div>
		<input type = "hidden" name = "menu_id" value="<?=$_GET['menu_id']?>">

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
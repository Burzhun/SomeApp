<div class="filterOnMain">

<?php
$model = new SearchForm;
 $form=$this->beginWidget('CActiveForm', array(
	//'id'=>'news-form',
	'action' => '/search/searchForm',
	'enableAjaxValidation'=>false,
	    'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
)); ?>

	<span class="filterOnMainHead">Подберите украшение</span>
	<?php echo $form->dropDownList($model,'collection', Collection::ListData()); ?>
	<span class='filterOnMainArrow'>›</span>
	<?php echo $form->dropDownList($model,'group',array('0'=>'Выберите группу')); ?>
	<span class='filterOnMainArrow'>›</span>
	<?php echo $form->dropDownList($model,'type', array('0'=>'Выберите тип')+Goodtype::listData()); ?>
	<span class='filterOnMainArrow'>›</span>
	<input type="submit" value='Подобрать'>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
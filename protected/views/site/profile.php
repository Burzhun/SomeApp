<?
$this->pageTitle = "Мои данные - ".$this->pageTitle;
$breadcrumbs = array('Мои данные');
$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('Главная', array('site/index')),
	'separator' => ' / ',
	'links'=>$breadcrumbs));
?>
<div class="private-office">
	<h1>ЛИЧНЫЙ КАБИНЕТ</h1>
	<div class="private-office-nav">
		<div class="priv-nav-block">
			<a href="/profile" class="active-nav-private" >Мои данные</a> 
			<a href="/office" >Мои заказы</a>
			<?php if(Yii::app()->theme->name != 'roznica') { ?><a href="/discount">Скидки</a><?php } ?>
			<a href="/cart"    >Корзина</a>
		</div>
	</div>

	<?php if(Yii::app()->theme->name != 'roznica') { ?>
		<div style="float:right;font-size:18px;">Размер вашей скидки <?=$model->discount;?>%</div>
		<br><br>
		<div style="float:right;font-size:18px;">Скидка для диллера <?=$model->dealer_discount;?>%</div>
	<?php } ?>
	
	<strong class='fs14'>Заполните пожалуйста следующую информацию:</strong>        

	<div class="form" "data-ajax" = "false">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>true,
		)); ?>


			<?php echo $form->errorSummary($model); ?>

			Ваш Email: <b><?=$model->email;?></b> <a href="/site/ChangePassword">Изменить пароль</a><br><br> 

			<div class="row">
				<?php echo $form->labelEx($model,'password_form'); ?>
				<?php echo $form->textField($model,'password_form'); ?>
				<?php echo $form->error($model,'password_form'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($model,'sname'); ?>
				<?php echo $form->textField($model,'sname', array('placeholder' => '')); ?>
				<?php echo $form->error($model,'sname'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name', array('placeholder' => '')); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'lname'); ?>
				<?php echo $form->textField($model,'lname', array('placeholder' => '')); ?>
				<?php echo $form->error($model,'lname'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'phone'); ?>
				<?php echo $form->textField($model,'phone', array('placeholder' => '')); ?>
				<?php echo $form->error($model,'phone'); ?>
			</div>
			
				<div class="row">
				<?php echo $form->labelEx($model,'region'); ?>
				<?php echo $form->textArea($model,'region', array('rows' => 3,'cols' => 50)); ?>
				<?php echo $form->error($model,'region'); ?>
			</div>
				<div class="row">
				<?php echo $form->labelEx($model,'address'); ?>
				<?php echo $form->textArea($model,'address', array('rows' => 3,'cols' => 50)); ?>
				<?php echo $form->error($model,'address'); ?>
			</div>


				<div class="row">
				<?php echo $form->labelEx($model,'transport'); ?>
				<?php echo $form->textField($model,'transport'); ?>
				<?php echo $form->error($model,'transport'); ?>
			</div>
			<br>
			<div><button type="submit"  class='reg_button'>Сохранить</button></div>
		<?php $this->endWidget(); ?>
	</div> 
</div>
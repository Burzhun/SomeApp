<h1>Восстановление пароля</h1>

<div style="font-size: 18px;
font-weight: bold;
color: #E42727;">
<?=Yii::app()->user->getFlash('error')?>
 
</div>

<div style="font-size: 18px;
font-weight: bold;
color: #27E495;">

 <?=Yii::app()->user->getFlash('success')?>
</div>

<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo CHtml::activeTextField($form,'login_or_email', array('style'=>'color:#fff;')) ?> 
	</div>
	
	<div class="row submit">
		<?php echo CHtml::submitButton("Восстановить",array('class' => 'enter_button')); ?>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
 
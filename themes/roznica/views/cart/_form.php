<div class="order-form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'question-form',
		'enableAjaxValidation'=>false,
	));?>
		<div class="row" style="display:none">
			<?php echo $form->labelEx($model,'sname'); ?>
			<?php echo $form->textField($model,'sname',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'sname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="row" style="display:none">
			<?php echo $form->labelEx($model,'lname'); ?>
			<?php echo $form->textField($model,'lname',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'lname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>
		
		<? if(Yii::app()->user->isGuest):?>
			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
		<? endif; ?>
	 
		<div class="row" style="display:none">
			<?php echo $form->labelEx($model,'index'); ?>
			<?php echo $form->textField($model,'index',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'index'); ?>
		</div>

		<div class="row" style="display:none">
			<?php echo $form->labelEx($model,'region'); ?>
			<?php echo $form->textField($model,'region',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'region'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'address'); ?>
			<?php echo $form->textArea($model,'address',array('cols'=>43,'rows'=>4)); ?>
			<?php echo $form->error($model,'address'); ?>
		</div>

		<div class="row" style="display:none">
			<?php echo $form->labelEx($model,'transport'); ?>
			<?php echo $form->textArea($model,'transport'); ?>
			<?php echo $form->error($model,'transport'); ?>
		</div>

		<?/*<div class="row">
			<?php echo $form->labelEx($model,'manager'); ?>
			<?php echo $form->dropDownList($model,'manager',UserManager::getList()); ?>
			<?php echo $form->error($model,'manager'); ?>
		</div>*/?>

		<?php echo $form->hiddenField($model,'manager', array("value"=>"00202")); ?>

		<div class="row" style="display:none">
			<?php echo $form->labelEx($model,'info'); ?>
			<?php echo $form->textArea($model,'info',array('cols'=>43,'rows'=>4)); ?>
			<?php echo $form->error($model,'info'); ?>
		</div>

		<?/* if(Yii::app()->user->isGuest):?>
			<div class="row">
				<?$this->widget('CCaptcha', array('buttonLabel' => '<br>Обновить код'))?> <br>
				<?php echo $form->labelEx($model,'verifyCode'); ?><?=CHtml::activeTextField($model, 'verifyCode')?>
				<?php echo $form->error($model,'verifyCode'); ?> 
			</div>
		<? endif; */?>
		<button type="submit" class="button reg_button">Оформить заказ</button>
	<?php $this->endWidget(); ?>
	<p class="total-text">Поля, помеченные звездочкой <span>*</span>, обязательны для заполнения.</p>
</div>
<div class="form" "data-ajax" = "false">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-form',
		'enableAjaxValidation'=>true,
	)); ?>

		<script>
			$(function () {
				if ($('#User_type').is(':checked')) {
					$("#ur").show();
				} else {
					$("#ur").hide();
				}
				$('#User_type').click(function () {
					$("#ur").toggle(this.checked);
				});
			});
		</script>

		<p class = "hint">Заполняйте то, что со звездочками</p><br>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name', array('placeholder' => 'Введите ваше имя')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'sname'); ?>
			<?php echo $form->textField($model,'sname', array('placeholder' => 'Введите вашу фамилию')); ?>
			<?php echo $form->error($model,'sname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'lname'); ?>
			<?php echo $form->textField($model,'lname', array('placeholder' => 'Введите ваше отчество')); ?>
			<?php echo $form->error($model,'lname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email', array('placeholder' => 'Введите ваш email')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password', array('placeholder' => 'Пароль')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'Город / Адрес'); ?>
			<?php echo $form->textField($model,'address', array('placeholder' => 'Адрес')); ?>
			<?php echo $form->error($model,'address'); ?>
		</div>
	 
			<div class="row">
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone', array('placeholder' => 'Телефон')); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>
		<div class="row">
			<?php echo $form->checkBox($model,'type', array("style"=>"float:left;")); ?> 
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>

		<div id = "ur">
			<div class="row">
				<?php echo $form->labelEx($model,'name_ur'); ?>
				<?php echo $form->textField($model,'name_ur'); ?>
				<?php echo $form->error($model,'name_ur'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($model,'inn'); ?>
				<?php echo $form->textField($model,'inn' ); ?>
				<?php echo $form->error($model,'inn'); ?>
			</div>
			<div class="row">
				<?php echo $form->labelEx($model,'kpp'); ?>
				<?php echo $form->textField($model,'kpp' ); ?>
				<?php echo $form->error($model,'kpp'); ?>
			</div>
		</div>
		<br>
		<div><button type="submit"  class='reg_button'>РЕГИСТРАЦИЯ</button></div>
	<?php $this->endWidget(); ?>
</div><!-- form -->
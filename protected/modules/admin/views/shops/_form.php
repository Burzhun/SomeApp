<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script type="text/javascript">
	function initialize() {
		var markerMain;
		var mapOptions = {
			<?if($model->map_coords){?>
				center: new google.maps.LatLng(<?=$model->map_coords?>),
			<?}else{?>
				center: new google.maps.LatLng(51.12421275782688, 28.3447265625),
			<?}?>
			zoom: 5,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		var map = new google.maps.Map(document.getElementById("mapsg"),mapOptions);

		<?if($model->map_coords){?>
			var myLatLng = new google.maps.LatLng(<?=$model->map_coords?>);
			placeMarker(myLatLng);
		<?}?>

		google.maps.event.addListener(map, 'click', function(event) {
	    	$("#Shops_map_coords").val(String.prototype.slice.call(event.latLng, 1, -1));
	    	placeMarker(event.latLng);
		});
		
		function placeMarker(location) {
			if(!markerMain){
				var marker = new google.maps.Marker({
					position: location,
					map: map
				});
				markerMain = marker;
			}else{
				markerMain.setPosition(location);
			}

		}
	}
	</script>


<div class="form"  onload="initialize()">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'shops-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div>
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div>
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->dropDownList($model,'city_id', City::listData()); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div>
		<?//php echo $form->labelEx($model,'map_coords'); ?>
		<?php echo $form->hiddenField($model,'map_coords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'map_coords'); ?>
	</div>
	<div style="width: 100%;height: 450px" id="mapsg"></div>
	<br>
	<br>

	
		<div>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
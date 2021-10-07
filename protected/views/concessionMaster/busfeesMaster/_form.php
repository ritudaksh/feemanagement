<?php
/* @var $this BusfeesMasterController */
/* @var $model BusfeesMaster */
/* @var $form CActiveForm */
?>
<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'busfees-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php //echo $form->labelEx($model,'route'); ?>
		<?php //echo $form->textField($model,'route',array('size'=>20,'maxlength'=>20)); ?>
		Route<br/>
		<select id="busno" name="busno" onchange="busdetails()">
		<option id="" value="">Please select route </option>
		<?php for ($i=1;$i<=20;$i++){
		if($busroute==$i){	
		?>	
		<option selected id="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php }else { ?>
		<option id="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>
		<?php }?>
		<?php }?>
		
		</select>
		
		<?php //echo $form->error($model,'route'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destination'); ?>
		<?php echo $form->textField($model,'destination',array('size'=>20,'maxlength'=>20,'name'=>'destination')); ?>
		<?php echo $form->error($model,'destination'); ?>
	</div>
<div class="row">
		<?php echo $form->labelEx($model,'internal'); ?>
		 <?php echo $form->dropDownList($model,'internal',
	array('True' => 'True', 'False' => 'False'		 ),
array('empty' => '--Please select--'),array('size'=>20,'maxlength'=>20)); ?>
		
		<?php echo $form->error($model,'internal'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'bus_fees'); ?>
		<?php echo $form->textField($model,'bus_fees'); ?>
		<?php echo $form->error($model,'bus_fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_driver'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_driver'); ?>
		<?php echo $form->error($modelbusmaster,'bus_driver'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_conductor'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_conductor'); ?>
		<?php echo $form->error($modelbusmaster,'bus_conductor'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_attendant'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_attendant'); ?>
		<?php echo $form->error($modelbusmaster,'bus_attendant'); ?>
	</div>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
function busdetails(){


var route=document.getElementById('busno').value;

var url="<?php echo Yii::app()->createUrl('busfeesMaster/Busdetails'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'route':route},
        success: function(data) {    
        console.log("succes"+data);
	    var busdetails=data.split('&');
        var driver=busdetails[0];
		var conductor=busdetails[1];
		var attendant=busdetails[2];
	    $('#BusMaster_bus_driver').val(driver);
        $('#BusMaster_bus_conductor').val(conductor);
		$('#BusMaster_bus_attendant').val(attendant);


        }
    });
  }


</script>
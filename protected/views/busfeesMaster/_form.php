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
 
	<?php   
//to populate the busroutes from busmaster
//		$listroute = CHtml::listData(busfeesMaster::model()->findAll(), 'bus_id', 'route');
		$list = CHtml::listData(BusMaster::model()->findAll(), 'bus_route', 'bus_route');
	      //print_r($listroute);exit;

	?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'route'); ?>
		 <?php echo $form->dropDownList($model, 'route',$list, array('prompt'=>'Please select bus route')); ?>
		 <?php //echo $form->textField($model,'route',array('size'=>20,'maxlength'=>20)); ?>
		 <?php echo $form->error($model,'route'); ?> 
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destination'); ?>
		<?php echo $form->textField($model,'destination',array('size'=>20,'maxlength'=>20,'name'=>'destination')); ?>
		<?php echo $form->error($model,'destination'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bus_fees'); ?>
		<?php echo $form->textField($model,'bus_fees'); ?>
		<?php echo $form->error($model,'bus_fees'); ?>
	</div>
<?php /*if($this->action->id != 'update'){ ?>
	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_driver'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_driver',array('name'=>'busdriver')); ?>
		<?php echo $form->error($modelbusmaster,'bus_driver'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_conductor'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_conductor',array('name'=>'busconductor')); ?>
		<?php echo $form->error($modelbusmaster,'bus_conductor'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_attendant'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_attendant',array('name'=>'busattendant')); ?>
		<?php echo $form->error($modelbusmaster,'bus_attendant'); ?>
	</div>
	
		<?php }else {
		        $busquery="select * from bus_master where bus_route='".$busroute."'";
				$sqlroute=Yii::app()->db->createCommand($busquery)->queryRow();
				
				$driver=$sqlroute['bus_driver'];
                $conductor=$sqlroute['bus_conductor'];
				$attendant=$sqlroute['bus_attendant'];
				
				
		?>	  

    <div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_driver'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_driver',array('value'=>$driver,'name'=>'busdriver')); ?>
		<?php echo $form->error($modelbusmaster,'bus_driver'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_conductor'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_conductor',array('value'=>$conductor,'name'=>'busconductor')); ?>
		<?php echo $form->error($modelbusmaster,'bus_conductor'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($modelbusmaster,'bus_attendant'); ?>
		<?php echo $form->textField($modelbusmaster,'bus_attendant',array('value'=>$attendant,'name'=>'busattendant')); ?>
		<?php echo $form->error($modelbusmaster,'bus_attendant'); ?>
	</div>
<?php }*/?>
	
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
	    $('#busdriver').val(driver);
        $('#busconductor').val(conductor);
		$('#busattendant').val(attendant);


        }
    });
  }


</script>
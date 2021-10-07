
<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">

<?php
/* @var $this FeesMasterController */
/* @var $model FeesMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fees-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="formConInner" style="border:2px solid black;width:60%;margin-left:140px;overflow:hidden;" >
 <table width="60%"  border="2" cellspacing="5" cellpadding="5" style="margin:auto">
    <tr>
      
	<td valign="top">
		<?php echo $form->labelEx($model,'class_no'); ?>
		<?php echo $form->dropDownList($model,'class_no',
	array('Play-way'=>'Play-way','pre-nursery' => 'Pre-nursery', 'nursery' => 'Nursery', 
	'KG' => 'KG', '1' => '1', '2' => '2', '3' => '3', '4' => '4',
		 '5' => '5',
		 '6' => '6',
		 '7' => '7',
		 '8' => '8',
		 '9' => '9',
		 '10' => '10',
		 '11' => '11',
		 '12' => '12'
		 ),
array('empty' => '--Choose the class no--'),array('size'=>25,'maxlength'=>25)); ?>
		
			
		<?php echo $form->error($model,'class_no'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'annual_fees'); ?>
		<?php echo $form->textField($model,'annual_fees'); ?>
		<?php echo $form->error($model,'annual_fees'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'tuition_fees'); ?>
		<?php echo $form->textField($model,'tuition_fees'); ?>
		<?php echo $form->error($model,'tuition_fees'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'funds_fees'); ?>
		<?php echo $form->textField($model,'funds_fees'); ?>
		<?php echo $form->error($model,'funds_fees'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'sports_fees'); ?>
		<?php echo $form->textField($model,'sports_fees'); ?>
		<?php echo $form->error($model,'sports_fees'); ?>
	</td>
        <td valign="top">
		<?php echo $form->labelEx($model,'activity_fees'); ?>
		<?php echo $form->textField($model,'activity_fees'); ?>
		<?php echo $form->error($model,'activity_fees'); ?>
	</td></tr>
	<tr><td valign="top">
		<?php echo $form->labelEx($model,'admission_fees'); ?>
		<?php echo $form->textField($model,'admission_fees'); ?>
		<?php echo $form->error($model,'admission_fees'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'security_fees'); ?>
		<?php echo $form->textField($model,'security_fees'); ?>
		<?php echo $form->error($model,'security_fees'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'dayboarding_fees'); ?>
		<?php echo $form->textField($model,'dayboarding_fees'); ?>
		<?php echo $form->error($model,'dayboarding_fees'); ?>
	</td>

	
<?php $today=date("d-m-Y");  
$date = explode ("-",$today); 
$lastyear=$date[2]-1;
$validto=$date[2]+1;
//echo $today;

if($this->action->id != 'update'){
?>


	<td valign="top">
		<?php echo $form->labelEx($model,'valid_from'); ?>
		<?php echo $form->textField($model,'valid_from',array('id'=>'validfrom','name'=>'validfrom','value'=>'04-01-'.$date[2])); ?>
		<?php echo $form->error($model,'valid_form'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'valid_to'); ?>
		<?php echo $form->textField($model,'valid_to',array('id'=>'validto','name'=>'validto','value'=>'03-31-'.$validto)); ?>
		<?php echo $form->error($model,'valid_to'); ?>
	</td><td></td></tr>
	
	<?php }
	
	else{
	
	
	?>
	<td valign="top">
		<?php echo $form->labelEx($model,'valid_from'); ?>
		<?php echo $form->textField($model,'valid_from',array('id'=>'validfrom','name'=>'validfrom','value'=>date("m-d-Y",strtotime($model->valid_from)))); ?>
		<?php echo $form->error($model,'valid_form'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'valid_to'); ?>
		<?php echo $form->textField($model,'valid_to',array('id'=>'validto','name'=>'validto','value'=>date("m-d-Y",strtotime($model->valid_to)))); ?>
		<?php echo $form->error($model,'valid_to'); ?>
	</td><td></td></tr>
	
	
	
	<?php }
	
	
	
	
	
	
	?>
	</table>
	</div>


	<div class="row buttons" style="margin-left:370px">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
  $(document).ready(function () {
if(document.getElementById("validfrom")!=null){
var dbdate=document.getElementById("validfrom").value
//alert("dbdate"+dbdate);
var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$2-$1-$3')
document.getElementById("validfrom").value=datenew
}

    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();


//var lastyear=currentYear-1;
//var validto=currentyear+'-03-31';
//var validfrom=lastyear+'04-01'

//document.getElementbyId('validto').value=validto;
//document.getElementbyId('validfrom').value=validfrom;


   // $('#duedate').datepicker({
        
      //  dateFormat: 'yy-mm-dd'
    //});
    $('#validfrom').datepicker({
		dateFormat:'dd-mm-yy'
                


	});
if(document.getElementById("validto")!=null){
var dbdate=document.getElementById("validto").value
//alert("dbdate"+dbdate);
var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$2-$1-$3')
document.getElementById("validto").value=datenew
}
	$('#validto').datepicker({
		dateFormat: 'dd-mm-yy'
                
	});
});
  </script>


		














<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">

<?php
/* @var $this PaymentScheduleMasterController */
/* @var $model PaymentScheduleMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payment-schedule-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php $sqlps="select * from  payment_schedule_master";
      $payseh=Yii::app()->db->createCommand($sqlps)->queryAll();  ?>

<div class="searchbox2">
  
<table  id="table" >
	<tr><th>Fees for Months</th><th>Pay in Month</th><th>Payment Day</th></tr>
	<?php $arr ="";
	$count = count($payseh);
$c = 1;
foreach($payseh as $paydata){
	if($this->action->id != 'update'){
	$arr .= $paydata['fees_for_months'].",";?>
	<?php } else if($this->action->id == 'update' && $_REQUEST["id"] != $paydata["schedule_id"]  ){
		$arr .= $paydata['fees_for_months'].",";}
		$c++;?>
	
	
	
	<tr><td><input type="text" id="feesmonth" name="feesmonth" 
	value="<?php echo($paydata['fees_for_months']); ?>" readonly="true"/></td>
<td><input type="text"
 value="<?php echo($paydata['pay_in_month']); ?>"  name="paymonth" id="paymonth" readonly="true" /></td>
<td><input type="text"
 value="<?php echo($paydata['payment_date']); ?>"  name="paymentdate"  readonly="true"/></td>
</tr>


<?php }?> 
	</table> 


</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'fees_for_months'); ?>
		<?php echo $form->hiddenField($model,'fees_for_months'); ?>


<select name="fees_for_months[]" id="multi" multiple="true"  class="ms"   >
	<option id="" value="">Please select months</option>
 <?php for($i = 1; $i < 13 ; $i++){?>
<?php 


$ids = explode(',',$arr); 
if(!in_array($i, $ids)){
?>
<?php if(in_array($i, explode(',',$model->fees_for_months))){?>
<option  selected="selected" id="<?php echo $i ?>" value="<?php echo $i ?>"><?php echo $i ?></option>
<?php }else{?>
<option id="<?php echo $i ?>" value="<?php echo $i ?>"><?php echo $i ?></option>
<?php }} }?>

        </select>
   
     


		<?php echo $form->error($model,'fees_for_months'); ?>
	</div>

		

	<div class="row">
		<?php echo $form->labelEx($model,'pay_in_month'); ?>
		

 <?php echo $form->dropDownList($model,'pay_in_month',
	array('1' => '1', '2' => '2', 
	'3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7',
		 '8' => '8',
		 '9' => '9',
		 '10' => '10',
		 '11' => '11',
		 '12' => '12'		 
		 ),
array('empty' => 'Choose the Month'),array('size'=>25,'maxlength'=>25)); ?>
		
		
		


		<?php echo $form->error($model,'pay_in_month'); ?>
	</div>



<div class="row">
		<?php echo $form->labelEx($model,'payment_date'); ?>

		
		<?php echo $form->dropDownList($model,'payment_date',
	array('01' => '01', '02' => '02', 
	'03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07',
		 '08' => '08',
		 '09' => '09',
		 '10' => '10',
		 '11' => '11',
		 '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23',
 '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31'		 
		 ),
array('empty' => 'Choose the date'),array('size'=>25,'maxlength'=>25)); ?>
		
		
		
		<?php echo $form->error($model,'payment_date'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script>
  jQuery(function($) {
   

    
   $('#paymentdate').datepicker({
		dateFormat:'yy-mm-dd'
	});
});	
</script>
  <script src="assets/jquery.min.js"></script>

<script>	
    $(function() {
		    $('#multi').change(function() {
            console.log($(this).val());
            
          var d =$("#PaymentScheduleMaster_fees_for_months").val();
           
          if(d!="")
            {
				d = $(this).val();
				
				 
			
				 $('.selected :checked').each(function() {
         //alert($(this).val());
     });
				}
				else{d = $(this).val();}
           $("#PaymentScheduleMaster_fees_for_months").val(d);
             
            
        });
    });
</script>











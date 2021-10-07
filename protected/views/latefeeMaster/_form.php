
<?php
/* @var $this LatefeeMasterController */
/* @var $model LatefeeMaster */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'latefee-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


<?php $sqllf="select * from latefee_master";
      $latefee=Yii::app()->db->createCommand($sqllf)->queryAll();  ?>

<div class="searchbox2">
  
<table  id="table" >
	<tr><th>Days From</th><th>Days To</th><th>Late Fees</th></tr>
<?php $fee=""; $fee1="";$fee3="";
$count = count($latefee);
$c = 1;
foreach($latefee as $latefeedata){
	
$fee=$latefeedata['days_from'];
$fee1=$latefeedata['days_to'];
if($this->action->id !== 'update'  ){
for($j=$fee; $j<=$fee1; $j++){
$fee3 .= $j.",";
}
}
else if($this->action->id == 'update' && $_REQUEST["id"] != $latefeedata["latefee_id"]  )
{
	for($j=$fee; $j<=$fee1; $j++){
$fee3 .= $j.",";
}
	}
$c++;


?>
	<tr><td><input type="text"  name="daysfrom" value="<?php echo($latefeedata['days_from']); ?>" readonly="true" /></td>
<td><input type="text" value="<?php echo($latefeedata['days_to']); ?>"  name="daysto" readonly="true"/></td>
<td><input type="text" value="<?php echo($latefeedata['latefee']); ?>"  name="latefee" id="latefee" readonly="true"/></td>
</tr>


<?php }?> 

	</table> 


</div>


	<div class="row">
		<?php echo $form->labelEx($model,'days_from'); ?>
		
		<select name="daysfrom" id="daysfrom">

<option id="" value="">Please select day</option>
<?php for($i = 1; $i <=31 ; $i++){?>
<?php 


$ids = explode(',',$fee3); 
if(!in_array($i, $ids)){
?>
<?php if($i==$model->days_from){?>
<option  selected="selected" id="<?php echo $i ?>" value="<?php echo $i ?>" ><?php echo $i ?></option>

<?php }else{?>
<option   id="<?php echo $i ?>" value="<?php echo $i ?>" ><?php echo $i ?></option>
<?php }}} ?>


</select>
		<?php echo $form->error($model,'days_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'days_to'); ?>
		<select name="daysto" id="daysto" >
		<option  id="" value="">Please select day</option>
<?php for($i = 1; $i <= 31 ; $i++){?>
<?php 

$ids1 = explode(',',$fee3); 
if(!in_array($i, $ids1)){
?>
<?php if($i==$model->days_to){?>
<option selected="selected" id="<?php echo $i ?>"  value="<?php echo $i ?>"><?php echo $i ?></option>
<?php }else{?>
<option  id="<?php echo $i; ?>"  value="<?php echo $i ?>"><?php echo $i;?></option>
<?php }} }?>

</select>


   
		<?php echo $form->error($model,'days_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'latefee'); ?>
		<?php echo $form->textField($model,'latefee'); ?>
		<?php echo $form->error($model,'latefee'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>



<?php $this->endWidget(); ?>


</div><!-- form -->



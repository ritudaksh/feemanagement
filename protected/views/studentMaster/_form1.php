
 <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css">
 <script type="text/javascript" src="http://www.erichynds.com/examples/jquery-ui-multiselect-widget/src/jquery.multiselect.js"></script>
  <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<div class="form">

	
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-master-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note" style="margin-left:230px">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	
	
	
	
	
	
<div class="form2">
<div class="formConInner" >
 <table width="85%" cellspacing="5" cellpadding="5" style="margin:auto">
    <tr>
      
	<td valign="top"><?php echo $form->labelEx($model,'addmission_no'); ?>
<?php echo $form->textField($model,'addmission_no'
,array('name'=>'admission','readonly'=>'true')); ?></td>

		<?php echo $form->error($model,'addmission_no'); ?></td>
	<?php if($this->action->id != 'update'){?>
	
	<td valign="top">

	
		<?php echo $form->labelEx($model,'class'); ?>
		<select name="class" id ="class">
	<option  id="" value="" selected="selected">Select the class</option>
	
<option id="pre-nursery" value="pre-nursery">Pre-nursery</option>
<option id="LKG" value="LKG">LKG</option>
<option id="UKG" value="UKG">UKG</option>
<option id="1" value="1">1</option>
<option id="2" value="2">2</option>
<option id="3" value="3">3</option>
<option id="4" value="4">4</option>
<option id="5" value="5">5</option>
<option id="6" value="6">6</option>
<option id="7" value="7">7</option>
<option id="8" value="8">8</option>
<option id="9" value="9">9</option>
<option id="10" value="10">10</option>
<option id="11" value="11">11</option>
<option id="12" value="12">12</option>

</select>
		
		
		
		

		
		<?php echo $form->error($model,'class'); ?></td></tr>
<?php	}?>
<?php if($this->action->id != 'update'){?>
<tr><td valign='top'>
		<?php echo $form->labelEx($model,'section'); ?>
<select name="section" id ="section">
	<option  id="" value="" selected="selected">Select the section</option>
	
<option id="A" value="A">A</option>
<option id="B" value="B">B</option>
<option id="C" value="C">C</option>
<option id="D" value="D">D</option>
<option id="E" value="E">E</option>
<option id="F" value="F">F</option>
<option id="G" value="G">G</option>
<option id="H" value="H">H</option>
<option id="I" value="I">I</option>
<option id="J" value="J">J</option>

</select>




		<?php echo $form->error($model,'section'); ?>
	</td>

<?php	}?>
	<td valign="top">
		<?php echo $form->labelEx($model,'student_name'); ?>
		<?php echo $form->textField($model,'student_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'student_name'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'father_name'); ?>
		<?php echo $form->textField($model,'father_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'father_name'); ?></td>
	

	<td valign="top">
		<?php echo $form->labelEx($model,'mother_name'); ?>
		<?php echo $form->textField($model,'mother_name',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mother_name'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'birth_date'); ?>
		<?php echo $form->textField($model,'birth_date',array('name'=>'birthdate','id'=>'datepicker','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'birth_date'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'phone_no'); ?>
		<?php echo $form->textField($model,'phone_no'); ?>
		<?php echo $form->error($model,'phone_no'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'mobile_no'); ?>
		<?php echo $form->textField($model,'mobile_no'); ?>
		<?php echo $form->error($model,'mobile_no'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</td></tr>
	
	
	<tr><td valign="top">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'address'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'city'); ?>
	</td></tr>

	<?php 
	$bussql="select * from busfees_master group by route";
	$querybusno=Yii::app()->db->createCommand($bussql)->queryAll();
	?>
	<tr><td valign="top">
		<?php echo $form->labelEx($model,'bus_no'); ?>
		<select name="busno" id ="busno" onchange="busroute()">
	<option  id="" value="" selected>Please select bus no</option>	
	<?php foreach($querybusno as $busno){
	if($busno['route']==$model->bus_no){
	
	?>
<option selected='selected' id="<?php echo $busno['route']; ?>" value="<?php echo $busno['route']; ?>"><?php echo $busno['route']; ?></option>
<?php }
else{?>
<option id="<?php echo $busno['route']; ?>" value="<?php echo $busno['route']; ?>"><?php echo $busno['route']; ?></option>
<?php }}?>



 </select>
		<?php echo $form->error($model,'bus_no'); ?>
	</td>
	

	
	
	<td valign="top">
	<?php echo $form->labelEx($model,'bus_destination'); ?>
	
	<select name="busdestination" id ="busdestination" selected="true">
	
	<option  id="" value="" selected>Please select destination</option>	
	
	<?php 
    
	if($dest1==$model->bus_destination){?>
	<option selected='selected' id="<?php echo $dest1; ?>" value="<?php echo $dest1; ?>"><?php echo $dest1; ?></option>
	<?php }
	else{?> 
	<option   id="<?php echo $dest1; ?>"
	 value="<?php echo $dest1; ?>"><?php echo $dest1; ?></option>
	<?php }?>

	
</select>
	
<?php //echo $form->dropDownList($model,'bus_destination',array('empty'=>'Select the destination'));?>

	
<?php echo $form->error($model,'bus_destination'); ?>
</td></tr>



	<tr><td valign="top">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender',array('Male'=>'Male','Female'=>'Female'),array('empty'=>'Select the gender'));?>



		<?php echo $form->error($model,'gender'); ?>
	</td>
<?php $today=date("Y-m-d"); ?>
	<td valign="top">
		<?php echo $form->labelEx($model,'admission_date'); ?>
		<?php echo $form->textField($model,'admission_date',array('id'=>'admdate','value'=>$today)); ?>
		<?php echo $form->error($model,'admission_date'); ?>
	</td></tr>
<?php   $sqlcon="select * from  concession_master";    
        
        $querycon=Yii::app()->db->createCommand($sqlcon)->queryAll();
         
        //foreach( $querybusfees as $data1){
        

?>

       <tr><td valign="top">
		<?php echo $form->labelEx($model,'student_concessiontype'); ?>
	


<select name="concessiontype" id ="concessiontype" selected="selected">
<option id="" value="" selected>Please select concession type</option>

<?php foreach( $querycon as $datacon){?>
<?php if($datacon['concession_type'] == $model->student_concessiontype ){ ?>
<option selected='selected' id="<?php echo $datacon['concession_type']; ?>" value="<?php echo $datacon['concession_type']; ?>"><?php echo $datacon['concession_type']; ?></option>
<?php } else{?>
<option id='<?php echo $datacon['concession_type']; ?>' value='<?php echo $datacon['concession_type']; ?>'><?php echo $datacon['concession_type']; ?></option>

<?php }}?>
</select>



		<?php echo $form->error($model,'student_concessiontype'); ?>
	</td><td></td></tr>
</table>
</div>
</div>


	<div class="row buttons" style="margin-left:60%">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
  $(document).ready(function () {
    var date = new Date();
    var currentMonth = date.getMonth();
    var todayDate = date.getDate();
    var currentYear = date.getFullYear();

    $('#datepicker').datepicker({
        
        dateFormat: 'yy-mm-dd'
    });
    $('#admdate').datepicker({
		 
		dateFormat:'yy-mm-dd'
	});
});
  </script>
  <script type="text/javascript">

  function busroute(){
  var bno=document.getElementById('busno').value;

  $("#busdestination").find("option").remove();
  $("#busdestination").append("<option>Please select destination</option>");

var url="<?php echo Yii::app()->createUrl('studentMaster/Busroute'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'bno':bno},
        success: function(data) {    
       // alert("Success"+data);
var h = data.split(',');

for(var i=0;i<h.length-1;i++){



$("#busdestination").append("<option>"+h[i]+"</option>");

}
}
     });
  
  }
</script>

	




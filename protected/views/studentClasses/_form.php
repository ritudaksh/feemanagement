<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css"></link>
<script type="text/javascript" src="./js/jquery.multiselect.js"></script>
<script src="./js/jquery.validate.min.js"></script>
<?php
/* @var $this StudentClassesController */
/* @var $model StudentClasses */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-classes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php if($this->action->id != 'update') {?>
<div class="searchbox2"><table id="table">
<tr><th>Student Name</th><td><input type="text" id="name" name="name"/></td>
<th>Admission</th><td><input type="text" id="admission" name="admission"/></td></tr>
<tr><th>Class</th>
<td>
<select id="cls" name="cls" >
        <option id="" value="">Please select a class</option>
		<option id="Play-way" value="Play-way">Play-way</option>
        <option id="pre-nursery" value="pre-nursery">Pre-nursery</option>
        <option id="nursery" value="nursery">Nursery</option>
	    <option id="KG" value="KG">KG</option>
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
</td>
	
<th>Section</th>
<td>
	<select id="se" name="se" >
        <option id="" value="">Please select a section</option>
	    <option id="A" value="A">A</option>
	    <option id="B" value="B">B</option>
	    <option id="c" value="C">C</option>
	    <option id="D" value="D">D</option>
		<option id="E" value="E">E</option>
		<option id="F" value="F">F</option>
		<option id="G" value="G">G</option>
		<option id="H" value="H">H</option>
	    <option id="I" value="I">I</option>
	    <option id="J" value="J">J</option>		   
</select>
</td>
</tr>
<tr>
<td>
</td>
<td><input type="button" value="Search" align="center" name="search" onclick="getdata()" style="margin-left:50px"/></td>
<th>Select Student</th>
<td>
		<select id="searchstudent" name="searchstudent" onchange="showdata()">
		<option id="" value="">Please select a student</option>
		</select>
</td>
</tr>
</table>
</div>
<?php }?>

<div class="row">
		<?php echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id',array('id'=>'stuid', 'name'=>'stuid', 'readonly'=>'true')); ?>		
		<?php echo $form->error($model,'student_id'); ?>
</div>
<div class="row">
		Admission No<br/>
		<input type="text" value ="<?php if($model!=null && $model->student!=null ){echo $model->student->addmission_no;} ?>" readonly="readonly" id="addmission_no">
</div>

<div class="row">
 		Student Name<br>
		<input type="text" value ="<?php if($model!=null && $model->student!=null ){echo $model->student->student_name;} ?>" readonly="readonly" id="stuname">
</div>

<div class="row">
		<?php echo $form->labelEx($model,'class_no'); ?>
		<?php //echo $form->textField($model,'class_no',array('id'=>'classno','readonly'=>'true')); ?>
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
array('empty' => '--Choose the class no--'),array('size'=>25,'maxlength'=>25));
		?>
		<?php echo $form->error($model,'class_no'); ?>
</div>
	
<div class="row">
	<?php echo $form->labelEx($model,'section'); ?>
   <?php //echo $form->textField($model,'section',array('id'=>'section','name'=>'section'))?>
   <?php 
    echo $form->dropDownList($model,'section',
	array('A' => 'A', 'B' => 'B', 
	'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G',
		 'H' => 'H',
		 'I' => 'I',
		 'J' => 'J'
		 ),
    array('empty' => '--Choose the section--'),array('size'=>25,'maxlength'=>25)); ?>
   <?php echo $form->error($model,'section'); ?>
</div>

<?php if($model->started_on=="0000-00-00"){?>
<div class="row">
		<?php echo $form->labelEx($model,'started_on'); ?>
		<?php echo $form->textField($model,'started_on',array('id'=>'startdate','name'=>'startdate','value'=>'')); ?>
		<?php echo $form->error($model,'started_on'); ?>
</div>
	<?php } else{?>
<div class="row">
		<?php echo $form->labelEx($model,'started_on'); ?>
		<?php echo $form->textField($model,'started_on',array('id'=>'startdate','name'=>'startdate')); ?>
		<?php echo $form->error($model,'started_on'); ?>
</div>
	<?php }?>
   <?php if($model->ended_on=="0000-00-00"){?>
<div class="row">
		<?php echo $form->labelEx($model,'ended_on'); ?>
		<?php echo $form->textField($model,'ended_on',array('id'=>'enddate','name'=>'enddate','value'=>'')); ?>
		<?php echo $form->error($model,'ended_on'); ?>
</div>
<?php } else{ ?>
<div class="row">
		<?php echo $form->labelEx($model,'ended_on'); ?>
		<?php echo $form->textField($model,'ended_on',array('id'=>'enddate','name'=>'enddate')); ?>
		<?php echo $form->error($model,'ended_on'); ?>
</div>
    <?php }?>
<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>
<?php $this->endWidget(); ?>
</div>
<!-- form -->
<script>
$(document).ready(function () {
if(document.getElementById("startdate")!=null){
var dbdate=document.getElementById("startdate").value
//alert("dbdate"+dbdate);
var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1')
document.getElementById("startdate").value=datenew
}

    var date = new Date();
    var currentMonth = date.getMonth();
    var todayDate = date.getDate();
    var currentYear = date.getFullYear();

    $('#startdate').datepicker({
        
        dateFormat: 'dd-mm-yy',
        //altFormat: 'dd-mm-yy'
  
});

	if(document.getElementById("enddate")!=null){
	var dbdate=document.getElementById("enddate").value
	//alert("dbdate"+dbdate);
	var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1')
	document.getElementById("enddate").value=datenew
	}
		$('#enddate').datepicker({
			 
			dateFormat:'dd-mm-yy'
		});
	});
 
function getdata(){
  var name=document.getElementById('name').value;
  var class1=document.getElementById('cls').value;
  var admission=document.getElementById('admission').value;
 
  var section=document.getElementById('se').value;
  $("#searchstudent").find("option").remove();
  $("#searchstudent").append("<option>Please select student</option>");
  
  var url="<?php echo Yii::app()->createUrl('studentClasses/Search'); ?>";


		$.ajax({
			   type: "GET",
			   url:  url,
			   data: {'name':name,'admission':admission,'class1':class1,'section':section},
			
			  success: function(msg){
				   console.log("Success"+msg);
		var h = msg.split(',');

		for(var i=0;i<h.length-1;i++){
		var s=h[i].split('$');
		var c=s[1].split(':');
		$("#searchstudent").append("<option id='"+s[0]+"'>"+c[0]+","+c[1]+"</option>");
		}
		}
		});
alert("Please select the student from drop down");
return false;
}
  
function showdata(){

    var id = $("#searchstudent").find('option:selected').attr('id');
    var url="<?php echo Yii::app()->createUrl('studentClasses/Details'); ?>";
		$.ajax({
		 type: "GET",
				url:url,
				data: {'id':id},
				success: function(data) {    
		console.log("Success"+data);
		var d = data.split(',');

		var startdate = d[3].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');

		$("#startdate").val(startdate); 
		$("#stuname").val(d[5]); 
		$("#stuid").val(d[0]); 
		$("#addmission_no").val(d[6]); 
				}
			 });
    } 
</script>

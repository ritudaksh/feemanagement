<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css"></link>
<script type="text/javascript" src="./js/jquery.multiselect.js"></script>
<script src="./js/jquery.validate.min.js"></script>

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
					<td valign="top">
						<?php echo $form->labelEx($model,'addmission_no'); ?>
						<?php echo $form->textField($model,'addmission_no' ,array('name'=>'admission')); ?>
						<?php echo $form->error($model,'addmission_no'); ?>
					</td>
					
					<?php if($this->action->id != 'update'){?>
						
						<td valign="top">
							
							<?php echo $form->labelEx($modelclass,'class_no'); ?>
							<select name="class" id ="class">
								<option  id="" value="" selected="selected">Select the class</option>
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
							
						<?php echo $form->error($modelclass,'class'); ?></td></tr>
				<?php	}?>
				<?php if($this->action->id != 'update'){?>
					<tr>
						<td valign='top'>
							<?php echo $form->labelEx($modelclass,'section'); ?>
							<select name="section" id ="section" >
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
							
							<?php echo $form->error($modelclass,'section'); ?>
						</td>
						
					<?php	}?>
					<td valign="top">
						<?php echo $form->labelEx($model,'student_name'); ?>
						<?php echo $form->textField($model,'student_name',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'student_name'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php echo $form->labelEx($model,'father_name'); ?>
						<?php echo $form->textField($model,'father_name',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'father_name'); ?>
					</td>
					<td valign="top">
						<?php echo $form->labelEx($model,'mother_name'); ?>
						<?php echo $form->textField($model,'mother_name',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'mother_name'); ?>
					</td>
				</tr>
				<tr>   
					<?php if($model->birth_date=="0000-00-00"){?>
						<td valign="top">
							<?php echo $form->labelEx($model,'birth_date'); ?>
							<?php echo $form->textField($model,'birth_date',array('value'=>'','name'=>'birthdate','id'=>'birthdate','size'=>20,'maxlength'=>20)); ?>
							<?php echo $form->error($model,'birth_date'); ?>
						</td>
						<?php } else{?>
						<td valign="top">
							<?php echo $form->labelEx($model,'birth_date'); ?>
							<?php echo $form->textField($model,'birth_date',array('name'=>'birthdate','id'=>'birthdate','size'=>20,'maxlength'=>20)); ?>
							<?php echo $form->error($model,'birth_date'); ?>
						</td>
					<?php }?>
					
					<td valign="top">
						<?php echo $form->labelEx($model,'phone_no'); ?>
						<?php echo $form->textField($model,'phone_no'); ?>
						<?php echo $form->error($model,'phone_no'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php echo $form->labelEx($model,'mobile_no'); ?>
						<?php echo $form->textField($model,'mobile_no'); ?>
						<?php echo $form->error($model,'mobile_no'); ?>
					</td>
					<td valign="top">
						<?php echo $form->labelEx($model,'email'); ?>
						<?php echo $form->textField($model,'email'); ?>
						<?php echo $form->error($model,'email'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<?php echo $form->labelEx($model,'address'); ?>
						<?php echo $form->textField($model,'address',array('size'=>20,'maxlength'=>20)); ?>
						<?php echo $form->error($model,'address'); ?>
					</td>
					<td valign="top">
						<?php echo $form->labelEx($model,'gender'); ?>
						<?php echo $form->dropDownList($model,'gender',array('Male'=>'Male','Female'=>'Female'),array('empty'=>'Select the gender'));?>
						<?php echo $form->error($model,'gender'); ?>
					</td>
				</tr>
				<td valign="top">
					<?php echo $form->labelEx($model,'city'); ?>
					<?php echo $form->textField($model,'city',array('size'=>20,'maxlength'=>20)); ?>
					<?php echo $form->error($model,'city'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<?php echo $form->labelEx($model,'route'); ?>
					<?php $listbusroute = CHtml::listData(BusfeesMaster::model()->findAllbySql("SELECT bus_id,route FROM busfees_master where route!='' group by route order by route asc"), 'route', 'route'); ?>
					<?php echo $form->dropDownList($model, 'route',$listbusroute, array('options' => array($route=>array('selected'=>true)), 'prompt'=>'Please select Route')); ?>
					<?php echo $form->error($model,'route'); ?> 
				</td>
				
				<?php  
					if($route>0) {
						$dest=BusfeesMaster::model()->findAll(array("condition"=>"route = ".$route));
						$listbusdest = CHtml::listData($dest,'bus_id','destination'); 
					}
					else{
						$dest=array();
						$listbusdest=CHtml::listData($dest,'bus_id','destination');
					}
				?>
				<td valign="top">
					<?php echo $form->labelEx($model,'destination'); ?>
					<?php echo $form->dropDownList($model, 'destination',$listbusdest, array('options' => array($model['bus_id']=>array('selected'=>true)),'prompt'=>'Please select Destination'),array('name'=>'bus_id')); ?>
					<?php echo $form->error($model,'destination'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<?php echo $form->labelEx($model,'admission_date'); ?>
					<?php echo $form->textField($model,'admission_date',array('id'=>'admdate','name'=>'admdate','value'=>$admdate)); ?>
					<?php echo $form->error($model,'admission_date'); ?>
				</td>
				<?php   $listconc = CHtml::listData(ConcessionMaster::model()->findAll(), 'concession_id', 'concession_type'); ?>
				
				<td valign="top">
					<?php echo $form->labelEx($model,'concession_id'); ?>
					<?php echo $form->dropDownList($model, 'concession_id',$listconc, array('prompt'=>'Please select concession type')); ?>
					<?php echo $form->error($model,'concession_id'); ?>
				</td>
			</tr>
			<tr>
				
				<td valign="top">
					<?php echo $form->labelEx($model,'status'); ?>
					<?php echo $form->dropDownList($model,'status',array('current' => 'current', 'passed out' => 'passed out'),array('onchange'=> 'statchange()','id'=>'status')); ?>
					<?php echo $form->error($model,'status'); ?>
				</td>
				<td valign="top">
					<?php echo $form->labelEx($model,'category'); ?>
					<?php echo $form->dropDownList($model,'category',array('ews' => 'ews', 'obc' => 'obc','general'=>'general','sc'=>'sc'),array('onchange'=> 'catchange()','id'=>'category')); ?>
					<?php echo $form->error($model,'general'); ?>
				</td>
			</tr>
			<tr>				
				<?php if($this->action->id != 'update'){ ?>
					<td valign="top">
						<?php echo $form->labelEx($model,'passedout_date'); ?>
						<?php echo $form->textField($model,'passedout_date',array('id'=>'passoutdate','name'=>'passoutdate','value'=>'')); ?>
						<?php echo $form->error($model,'passedout_date'); ?>
					</td>
					<?php } else {
						
						$passdate=$model->passedout_date;
						$passdatenew = date("d-m-Y", strtotime($passdate));  
						if($model->passedout_date==null){
						?>
						<td valign="top">
							<?php echo $form->labelEx($model,'passedout_date'); ?>
							<?php echo $form->textField($model,'passedout_date',array('id'=>'passoutdate','name'=>'passoutdate','value'=>'')); ?>
							<?php echo $form->error($model,'passedout_date'); ?>
						</td>
						
						<?php }
						else{ ?>
						<td valign="top">
							<?php echo $form->labelEx($model,'passedout_date'); ?>
							<?php echo $form->textField($model,'passedout_date',array('id'=>'passoutdate','name'=>'passoutdate','value'=>$passdatenew)); ?>
							<?php echo $form->error($model,'passedout_date'); ?>
						</td>
						
					<?php }}?>
					
					<?php 
						$date=date("d-m-Y");
						$year = explode("-",$date);
						$sessstart='01-04-'.$year[2];
					?>
					<?php if($this->action->id != 'update'){?>
						<td>
							Session starts from<br/>
							<input type="text" name="sessstart" value="<?php echo $sessstart; ?>" id="sessstart"/>
						</td>
					<?php } ?>
			</tr>
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
		
		if(document.getElementById("birthdate")!=null){
			var dbdate=document.getElementById("birthdate").value
			//alert("dbdate"+dbdate);
			var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1')
			document.getElementById("birthdate").value=datenew
		}
		
		var date = new Date();
		var currentMonth = date.getMonth();
		var todayDate = date.getDate();
		var currentYear = date.getFullYear();
		
		$('#birthdate').datepicker({
			
			dateFormat: 'dd-mm-yy',
			//altFormat: 'dd-mm-yy'
			
		});
		
		
		$('#sessstart').datepicker({
			
			dateFormat: 'dd-mm-yy',
			//altFormat: 'dd-mm-yy'
			
		});
		$('#passoutdate').datepicker({
			
			dateFormat: 'dd-mm-yy',
			//altFormat: 'dd-mm-yy'
			
		});
		
		
		if(document.getElementById("admdate")!=null){
			var dbdate=document.getElementById("admdate").value
			var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1')
			document.getElementById("admdate").value=datenew
		}
		else{
			var dbdate=document.getElementById("admdate").value
			var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$1-$2-$3')
			document.getElementById("admdate").value=datenew
		}
		$('#admdate').datepicker({
			
			dateFormat:'dd-mm-yy'
		});
		
	});
	
	
	$('#StudentMaster_route').change(function(){
		var busid=document.getElementById('StudentMaster_route').value;
		$("#StudentMaster_destination").find("option").remove();
		$("#StudentMaster_destination").append("<option>Please select destination</option>");
		
		var url="<?php echo Yii::app()->createUrl('studentMaster/Busroute'); ?>";
		$.ajax({
			type: "GET",
			url:url,
			data: {'busid':busid},
			success: function(data) {    
//				alert("Success"+data);
				var h = data.split('$');
				
				for(var i=0;i<h.length-1;i++){
					var bid=h[i].split(',');
					$("#StudentMaster_destination").append("<option id="+bid[0]+" value="+bid[0]+">"+bid[1]+"</option>");
				}
			}
		});
	});
	
	
	function statchange(){
		
		var a=$('#status :selected').text();
		if(a=="passed out"){
			document.getElementById("passoutdate").disabled = false;
			
		}
		
		else{
			document.getElementById("passoutdate").value(null);
			document.getElementById("passoutdate").disabled = true;
		}
	
	}
	
	
	$('#student-master-form').submit(function()
	
	{   
    var passoutdate="";
    if(document.getElementById("class")!=null){
	var clas=document.getElementById('class').value;
	}
	if(document.getElementById("section")!=null){
	var sec=document.getElementById('section').value;
	}
	if(document.getElementById("passoutdate")!=null){
	var passoutdate=document.getElementById('passoutdate').value;
	if(document.getElementById("category")!=null){
	var category=document.getElementById('category').value;
	}
	
	var stat=$('#status :selected').text();
	
	if(clas==""){
	alert("Class should not be empty");
	return false;
	}
	if(sec==""){
	alert("Section should not be empty");
	return false;
	}
	if(stat=="passed out" && passoutdate==""){
	alert("Please fill passed out date");
	return false;
	}
	
	//strange this is not gettning posted not as part of the studentMaster, but full form
//    var cat = document.getElementById('bus_id').value;    
    return true;
	
}	
	});
	</script>
	

	
	
	

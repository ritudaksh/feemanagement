<!--
//queries 5/04/2016
ALTER TABLE `student_fees` ADD `year` VARCHAR(50) NULL AFTER `fees_period_month`;
ALTER TABLE `busfees_master` ADD `driver` VARCHAR(100) NULL AFTER `bus_fees`;
ALTER TABLE `busfees_master` ADD `conductor` VARCHAR(100) NULL AFTER `driver`;
ALTER TABLE `busfees_master` ADD `attendant` VARCHAR(100) NULL AFTER `conductor`;
-->
<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<script type="text/javascript" src="./js/jquery.multiselect.js"></script>
<script src="./js/jquery.validate.min.js"></script> 
<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */
/* @var $form CActiveForm */
?>
<style>
.table_head th
{
	background-color:#EFEFEF;
}
#previousrecord {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

#previousrecord th, td {
    text-align: left;
    padding: 8px;
}
#previousrecord  {
	height:210px;
	overflow:auto;
	overflow-x:hidden;
	display:block;
	width:100%;
}
</style>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-fees-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note" >Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	 <?php  

	$stuid="";
	$stuid="";
	$stuclas="";
	$an="";
	$tu="";
	$fu="";
	$sp="";
	$ad="";
	$se="";
	$da="";
	$bu="";
	$lf="";
	$cp="";
	$ct="";
	$totalamt="";
	$concession="";
	$amtpaid="";
	$concessiontype="";
	?>
<div class="form1">
<input type="hidden" id="fees" value='<?php echo $fees ?>'>
<?php if($fees=='b') {?>
<div class="search1">
<div class="searchbox">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><th>Student Name</th><th>Admission</th></tr>
	<tr><td><input type="text" id="name" name="name"/></td>
	<td><input type="text" id="admission" name="admission"/></td></tr>
	<tr><th>Class</th><th>Section</th></tr>
	<tr>
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
<input type="button" value="Search" align="center" name="search" onclick="getdata()" style="margin-left:50px"/>
</td>
<th>Select Student</th>
</tr>
<tr>
<td>
<input  disabled type="button" value="Show previous fees" id="showprevfees"
 align="center" name="showpreviousfees" onclick="getprefees()" style="margin-left:20px" />
</td>
<td>
<select id="searchstudent" name="searchstudent" onchange="showfees()">
<option id="" value="">Please select a student</option>
</select>
</td>
</tr>
</table>
</div>

<div class="searchbox1" style="margin-left:20px"><div class="feessection"><h3>Previous Fees Record</h3></div>
<table id="previousrecord" style="border: 1px solid black;width:95%;margin-top:-15px;margin-left:10px; margin-bottom: 10px;">
<thead class="table_head"><th>Class</th><th>Fees for month</th><th>Fees paid for month</th><th>Payment Date</th><th>Amount Paid</th><th>Not Paid</th></thead>
<tbody></tbody>
</table>
</div>
<?php } else{?>
<div class="searchbox1" style="width:700px"><input type="button" name="prevfees" id="prevfees" value="Show previous fees" style="margin-left:280px" 
onclick="preupdate()"/>

<table id="prevrec" style="border: 1px solid black;width:430px;margin-left:120px;">
<tr><th>Class</th><th>Fees for months</th><th>Fees paid for month</th><th>Payment date</th><th>Amount Paid</th></tr>
</table>
</div>
<?php }?>
</div>
<div class="fees1" style="margin-top:10px;">
<div class="formConInner"><h2 align="center">Student Details</h2>
<table width="85%" cellspacing="5" cellpadding="5" >
	
	<?php if($this->action->id != 'update'){ ?>
<tr>
	
	    <?php //echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->hiddenField($model,'student_id',array('id'=>'studentid','readonly'=>true,'name'=>'stuid')); ?>
		<?php echo $form->error($model,'student_id'); ?>
	
	
	<td valign="top">
		Admission No.
		<input type="text" value ="" readonly="readonly" id="admno" name="admno"> 
	</td>
	
	
<td valign="top">
         Name
		 <input type="text" value ="" readonly="readonly" id="studentname" name="studentname"> 
</td>
<td valign="top">
	    Father name
		<input type="text" value ="" readonly="readonly" id="fathername" name="fathername"> 
</td>
</tr>
<tr>
<td valign="top">
		<?php echo $form->labelEx($model,'student_class'); ?>
		<?php echo $form->textField($model,'student_class'); ?>
		<?php echo $form->error($model,'student_class'); ?>
</td>
<td valign="top">
		<?php echo $form->labelEx($model,'student_section'); ?>
		<?php echo $form->textField($model,'student_section'); ?>
		<?php echo $form->error($model,'student_section'); ?>
</td>
<?php $y1=date('Y'); 
      $y2=$y1-1;
      $y3=$y1-2;
	  $y4=$y1-3;
	  $y5=$y1+1;
?>
<td valign="top">
	    <?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->dropDownList($model,'year',array($y5=>$y5,$y1=>$y1,$y2=>$y2,$y3=>$y3,$y4=>$y4),array('name'=>'year','id'=>'year','options' => array('2018'=>array('selected'=>true))));?>
		<?php echo $form->error($model,'year'); ?>	
</td>

</tr>
	<?php } else{
	 $model1=new StudentMaster;
	 $stuid=$model->student_id;
	 $admno = $model1->findByPk($stuid)->addmission_no;
	 $studentname = $model1->findByPk($stuid)->student_name;
	 $fname = $model1->findByPk($stuid)->father_name;
	 //$stuclsid =$model2->findColumn('student_id');
	 
	?>
	
<tr>
	
	    <?php //echo $form->labelEx($model,'student_id'); ?>
		<?php echo $form->hiddenField($model,'student_id',array('id'=>'studentid','readonly'=>true,'name'=>'stuid')); ?>
		<?php echo $form->error($model,'student_id'); ?>
<td valign="top">
		Admission No.
		<input type="text" value ="<?php echo $admno; ?>" readonly="readonly" id="admno" name="admno"> 	
</td>
<td valign="top">
         Name
		 <input type="text" value ="<?php echo $studentname; ?>" readonly="readonly" id="studentname" name="studentname"> 
</td>
<td valign="top">
	    Father name
		<input type="text" value ="<?php echo $fname; ?>" readonly="readonly" id="fathername" name="fathername"> 
</td>
</tr>
<tr>
<td valign="top">
		<?php echo $form->labelEx($model,'student_class'); ?>
		<?php echo $form->textField($model,'student_class'); ?>
		<?php echo $form->error($model,'student_class'); ?>
</td>
<td valign="top">
		<?php echo $form->labelEx($model,'student_section'); ?>
		<?php echo $form->textField($model,'student_section'); ?>
		<?php echo $form->error($model,'student_section'); ?>
</td>
<?php $y1=date('Y'); 
      $y2=$y1-3;
      $y1=$y1+1;
?>
<td valign="top">
    year<br/>
	<select id="year" name="year">
	<?php for($year=$y1; $year>=$y2; $year--) {
	if($model->year==$year){ ?>
	<option selected id="<?php echo $year; ?>" value="<?php echo $year; ?>"><?php echo $year; ?></option>
	<?php } else {?>
	<option  id="<?php echo $year; ?>" value="<?php echo $year; ?>"><?php echo $year; ?></option>
	<?php }}?>
	</select>
</td>
</tr>
	<?php }?>
</table>
</div>
</div>
<?php   $sqlfees="select * from payment_schedule_master";    
        
        $queryfees=Yii::app()->db->createCommand($sqlfees)->queryAll();
               
?>

<div class="fees1" style="margin-top:10px" ><div class="formConInner">
<h2 align="center">Fees Section</h2>
<table width='85%' cellspacing="5" cellpadding="5" style="margin:auto">
<tr>
<td valign="top">	
<?php  $datevalue=date("m")-1; 

$newdate=$datevalue+1;

?>	
	<?php echo $form->labelEx($model,'fees_for_months'); ?>
	<select name="monthfees" id ="monthfees" multiple="multiple" style="width:165px" onchange="feespay()">
    <option id="" value="">Please select months</option>

	<?php  foreach( $queryfees as $datafees){ 
	  if($m=="as"){  ?>
	<?php $datevar=$datafees['fees_for_months'] ;
	$datevalue= explode(',', $datevar);

	if (in_array($newdate, $datevalue)){
	?>
<option selected="selected" id="<?php echo $datafees['fees_for_months']; ?>" value="<?php echo $datafees['fees_for_months']; ?>"><?php echo $datafees['fees_for_months']; ?></option>

<?php }else{?>
<option  id="<?php echo $datafees['fees_for_months']; ?>" value="<?php echo $datafees['fees_for_months']; ?>"><?php echo $datafees['fees_for_months']; ?></option>
<?php }
}
else{
          
    $z=explode("-",$m);
     if($z[1]==$datafees['fees_for_months']){ ?>

<option selected id="<?php echo $datafees['fees_for_months']; ?>" value="<?php echo $datafees['fees_for_months']; ?>"><?php echo $datafees['fees_for_months']; ?></option>
 	 
<?php }
else {
     
 
?>

<option id="<?php echo $datafees['fees_for_months']; ?>" value="<?php echo $datafees['fees_for_months']; ?>"><?php echo $datafees['fees_for_months']; ?></option>


<?php }



} }?>

</select>

		<?php echo $form->error($model,'fees_for_months'); ?>
	</td>
	
	
<td valign="top">
		<?php echo $form->labelEx($model,'fees_period_month'); 
		
		?>
		
		<select multiple="multiple" name="payfeesmonth[]" id ="payfeesmonth"  style="width:160px;height:50px" onchange="feesformonths($('#payfeesmonth :selected').length,document.getElementById('payfeesmonth').value);">
		<option id="" value="">Please select fees pay month</option>
		
		<?php for($i = 1; $i < 13 ; $i++){?>

<?php if(in_array($i, explode(',',$model->fees_period_month))){?>
		<option selected id="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>
		
		<?php }else{?>
		<option id="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>
		
		<?php }
		
		
		 }?>
		</select>
		<?php echo $form->error($model,'fees_period_month'); ?>
	</td>
	<td valign="top">
		<?php echo $form->labelEx($model,'annual_fees_paid'); ?>
		<?php echo $form->textField($model,'annual_fees_paid',array('class'=>'feeschange','id'=>'annualfees', 'name'=>'annualfees')); ?>
		<?php echo $form->error($model,'annual_fees_paid'); ?>
	</td></tr>
    <tr>
	<td valign="top">
		<?php echo $form->labelEx($model,'tuition_fees_paid'); ?>
		<?php echo $form->textField($model,'tuition_fees_paid',array('class'=>'feeschange','id'=>'tutionfees','name'=>'tutionfees')); ?>
		<?php echo $form->error($model,'tuition_fees_paid'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'funds_fees_paid'); ?>
		<?php echo $form->textField($model,'funds_fees_paid',array('class'=>'feeschange','id'=>'fundfees','name'=>'fundfees')); ?>
		<?php echo $form->error($model,'funds_fees_paid'); ?>
	</td>
	<td valign="top">
		<?php echo $form->labelEx($model,'sports_fees_paid'); ?>
		<?php echo $form->textField($model,'sports_fees_paid',array('class'=>'feeschange','id'=>'sportsfees','name'=>'sportsfees')); ?>
		<?php echo $form->error($model,'sports_fees_paid'); ?>
	</td>
	</tr>
	<tr>
	<td valign="top">
		<?php echo $form->labelEx($model,'activity_fees'); ?>
		<?php echo $form->textField($model,'activity_fees',array('class'=>'feeschange','id'=>'activityfees','name'=>'activityfees')); ?>
		<?php echo $form->error($model,'activity_fees'); ?>
	</td>
	
	
	
	
	<td valign="top">
		<?php echo $form->labelEx($model,'admission_fees_paid'); ?>
		<?php echo $form->textField($model,'admission_fees_paid',array('class'=>'feeschange','id'=>'admfees','name'=>'admfees')); ?>
		<?php echo $form->error($model,'admission_fees_paid'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'security_paid'); ?>
		<?php echo $form->textField($model,'security_paid',array('class'=>'feeschange','class'=>'feeschange','id'=>'securityfees','name'=>'securityfees')); ?>
		<?php echo $form->error($model,'security_paid'); ?>
	</td></tr>
	<tr><td valign="top">
		<?php echo $form->labelEx($model,'late_fees_paid'); ?>
		<?php echo $form->textField($model,'late_fees_paid',array('class'=>'feeschange','id'=>'latefees','name'=>'latefees')); ?>
		<?php echo $form->error($model,'late_fees_paid'); ?>
	</td>

	<td valign="top">
		<?php echo $form->labelEx($model,'dayboarding_fees_paid'); ?>
		<?php echo $form->textField($model,'dayboarding_fees_paid',array('class'=>'feeschange','id'=>'dayboardfees','name'=>'dayboardfees')); ?>
		<?php echo $form->error($model,'dayboarding_fees_paid'); ?>
	</td>
	<td valign="top">
		<?php echo $form->labelEx($model,'bus_fees_paid'); ?>
		<?php echo $form->textField($model,'bus_fees_paid',array('class'=>'feeschange','id'=>'busfees','name'=>'busfees')); ?>
		<?php echo $form->error($model,'bus_fees_paid'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'concession_type_id'); ?>
		<?php echo $form->textField($model,'concession_type_id',array('id'=>'concessiontype','size'=>20,'maxlength'=>20,'name'=>'concessiontype' ,'readonly'=>'true','value'=>$contyp)); ?>
	</td>
	<td valign="top">
		<?php echo $form->labelEx($model,'concession_applied'); ?>
		<?php echo $form->textField($model,'concession_applied',array('class'=>'feeschange','id'=>'concession','name'=>'concession')); ?>
		<?php echo $form->error($model,'concession_applied'); ?>
	</td>

	

	<td valign="top">
		<?php echo $form->labelEx($model,'Total_amount'); ?>
		<?php echo $form->textField($model,'Total_amount',array('id'=>'totamt','name'=>'totamt','readonly'=>'true')); ?>
		<?php echo $form->error($model,'Total_amount'); ?>
	</td>
	</tr>
	<tr>
	<td><input type="hidden" id="concessiontypeid" name="concessiontypeid"></td>
	<td valign="top">
		<?php echo $form->hiddenField($model,'isdefault',array('id'=>'isdefault','name'=>'isdefault','value'=>'true')); ?>
		<?php echo $form->error($model,'isdefault'); ?>
	</td>
	<td valign="top">
		<?php echo $form->hiddenField($model,'bus_id',array('id'=>'busid','name'=>'busid','value'=>'')); ?>
		<?php echo $form->error($model,'bus_id'); ?>
	</td>
	</tr>
	
	</table>
	</div>	
</div>


<?php $today=date("d-m-Y"); ?>
<div class="fees1" style="margin-top:10px" ><div class="formConInner"><h2 align="center">Payment Section</h2>
	<table width='400' cellspacing="5" cellpadding="5" style="margin:auto">
    <tr>
      
	<?php if($m=="as"){?>
	<td valign="top">
		<?php echo $form->labelEx($model,'date_payment'); ?>
		<?php echo $form->textField($model,'date_payment',array('id'=>'paymentdate','value'=>$today,'name'=>'paymentdate')); ?>
		<?php echo $form->error($model,'date_payment'); ?>
	</td>
<?php }  else { 

$updateDate = date("d-m-Y", strtotime($model->date_payment));

?>
<td valign="top">
		<?php echo $form->labelEx($model,'date_payment'); ?>
		<?php echo $form->textField($model,'date_payment',array('id'=>'paymentdate','value'=>$updateDate,'name'=>'paymentdate')); ?>
		<?php echo $form->error($model,'date_payment'); ?>
	</td>

<?php } ?>
	
<td  valign="top" style="width:100px">
		<?php echo $form->labelEx($model,'payment_mode'); ?>

		<?php echo $form->dropDownList($model,'payment_mode',array('Cheque'=>'Cheque','Cash'=>'Cash','Online'=>'Online'),array( 'name'=>'paymentmode','id'=>'paymentmode','onchange'=>"selectmode()")); ?>
		
		
<!--<select name="paymentmode" id ="paymentmode">
<option id="01" value="Cheque">Cheque</option>
<option id="02" value="Cash" selected>Cash</option>


</select>-->

		<?php echo $form->error($model,'payment_mode'); ?>
	</td>
	<td valign="top">
		<?php echo $form->labelEx($model,'cheq_no',array('id'=>'cheqlabel')); ?>
		<?php echo $form->textField($model,'cheq_no',array('id'=>'cheqno','size'=>20,'maxlength'=>20,'name'=>'cheqno')); ?>
		<?php echo $form->error($model,'cheq_no'); ?>
	</td></tr>

	<tr><td valign="top">
		<?php echo $form->labelEx($model,'bank_name',array('id'=>'banklabel')); ?>
		<?php echo $form->dropDownList($model,'bank_name',array(null=>'Select Bank', 'ALLAHABAD BANK'=>'ALLAHABAD BANK (ALB)','ANDHRA BANK'=>'ANDHRA BANK (ANB)','AXIS BANK'=>'AXIS BANK (AXS)','BOB'=>'BOB','BOI'=>'BOI','BOM'=>'BOM',
			'CANARA BANK'=>'CANARA BANK (CAB)','CBOI'=>'CBOI (CBI)','CITY'=>'CITY','COOPERATION BANK'=>'COOPERATION BANK','COOPERATIVE BANK'=>'COOPERATIVE BANK (COB)','DENA BANK'=>'DENA BANK (DEB)','DCB'=>'DCB','EQUITAS'=>'EQUITAS','FEDERAL BANK'=>'FEDERAL BANK (FB)','GPO FEDERAL BANK'=>'GPO FEDERAL BANK (GPO)',
			'HDFC'=>'HDFC (HDF)','ICICI'=>'ICICI (ICI)','IDBI'=>'IDBI (IDB)','IDL'=>'IDL','INDIAN BANK'=>'INDIAN BANK (INB)','INDUSIND'=>'INDUSIND (IDS)','IOB'=>'IOB',
			'J&K BANK'=>'J&K BANK','KOTAK'=>'KOTAK (KOT)','KARNATAKA BANK'=>'KARNATAKA BANK (KBL)','OBOC'=>'OBOC',
			'PGB'=>'PGB','PNB'=>'PNB','P&SB'=>'P&SB (PSB)','OBOC'=>'OBOC (OBC)',
			'SBI'=>'SBI','STANDARD CHARTED'=>'STANDARD CHARTED','SYNDICATE BANK'=>'SYNDICATE BANK (SYB)','SOUTH INDIAN'=>'SOUTH INDIAN',
			'UBOI'=>'UBOI (UBI)','UNI'=>'UNI','UCO'=>'UCO','VIJAYA BANK'=>'VIJAYA BANK (VJB)','YES BANK'=>'YES BANK','YES PROPERTY'=>'YES PROPERTY','OTHER'=>'OTHER'),
			array( 'name'=>'bankname','id'=>'bankname','onchange'=>'getval(value)')); ?>
		<?php echo $form->error($model,'bank_name'); ?>
	
	</td>
<td valign="top">
		<?php echo $form->labelEx($model,'branch_name'); ?>
		<?php echo $form->textField($model,'branch_name',array('id'=>'branchname','name'=>'branchname')); ?>
		<?php echo $form->error($model,'branch_name'); ?>
	</td>	
	<td valign="top">
		<?php echo $form->labelEx($model,'amount_paid'); ?>
		<?php echo $form->textField($model,'amount_paid',array('id'=>'amtpaid','name'=>'amtpaid','readonly'=>'true')); ?>
		<?php echo $form->error($model,'amount_paid'); ?>
	</td>
	</tr>
	<tr>
<!-- realized_date starts here-->	
	<td valign="top">
		<?php echo $form->labelEx($model,'realized_date'); ?>
		<?php echo $form->textField($model,'realized_date',array('id'=>'realizeddate','name'=>'realizeddate')); ?>
		<?php echo $form->error($model,'realized_date'); ?>
	</td>

	</br>
<!-- realized_date ends here-->		
<!-- cheque_status added here-->	
	<td>
		<?php echo $form->labelEx($model,'cheque_status'); ?>
		<?php echo $form->dropDownList($model,'cheque_status',array('Open'=>'Open','Rejected'=>'Rejected','Realized'=>'Realized'),array( 'name'=>'chequestatus','id'=>'chequestatus','onchange'=>'selection')); ?>
		<?php echo $form->error($model,'cheque_status'); ?>
	</td>
<!--cheque_status ends here-->	
		<?php if($this->action->id != 'update'){ ?>

	<td>

		<?php echo $form->hiddenField($model,'entry_date',array('id'=>'entrydate','name'=>'entrydate','value'=>$today)); ?>
		<?php echo $form->error($model,'entry_date'); ?>
	</td>
	<?php }  ?>
	</tr>
	</table>
	</div>

</div>

	<div class="row buttons" style="margin-left:250px">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
		array('class'=>'btn')); ?>
	
	
	
	<input type="button" value="Reset"  name="cancel" 
	style="margin-top:-25px;margin-left:100px" onclick="resetfees()"/></div>
	
 
<?php $this->endWidget(); ?>
</div>
</div><!-- form -->
<script>
  $(document).ready(function () {
if(document.getElementById("paymentdate")!=null){
var dbdate=document.getElementById("paymentdate").value
//alert("dbdate"+dbdate);
var datenew = dbdate.replace(/(\d*)-(\d*)-(\d*)/,'$1-$2-$3')
document.getElementById("paymentdate").value=datenew
}
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $('#paymentdate').datepicker({
        
        dateFormat: 'dd-mm-yy'
    
      
      });
      
 $('#entrydate').datepicker({
        
        dateFormat: 'dd-mm-yy'
    
      
      });

    $('#realizeddate').datepicker({        
        dateFormat: 'dd-mm-yy'
      });      
  });

  </script>


<script type="text/javascript">


function getdata(){

var name=document.getElementById('name').value;
var class1=document.getElementById('cls').value;
var admission=document.getElementById('admission').value;
var section=document.getElementById('se').value;

$("#searchstudent").find("option").remove();
  $("#searchstudent").append("<option>Please select student</option>");
if(name!="" || class1!="" || admission!="" || section!=""){
var url="<?php echo Yii::app()->createUrl('studentFees/Search'); ?>";


		$.ajax({
			type: "GET",
			url:  url,
            data: {'name':name,'class1':class1,'admission':admission,'section':section},
    
			success: function(msg){
           console.log("Sucess"+msg);
			if(msg!=""){
			var h = msg.split(',');
			for(var i=0;i<h.length-1;i++){
			var s=h[i].split('$');
			var c=s[1].split(':');




			if(admission !=null){
			$("#searchstudent").append("<option  selected =selected id='"+s[0]+"'>"+c[0]+","+c[1]+"</option>");




			}
			else{
			$("#searchstudent").append("<option id='"+s[0]+"'>"+c[0]+","+c[1]+"</option>");

			}

			}
showfees();
}
else{

alert("No results found");
}


          }
    
    });
//alert("Please select the student from drop down");
document.getElementById("showprevfees").disabled = true;
}
else{
alert("Please fill the required fields for search");
}

return false;
}


function showfees(){
	
	$(".add_data").remove();
	 $("#previousrecord").css('border-color','#000000');
document.getElementById("showprevfees").disabled = false;

//var id=document.getElementById('searchstudent').value;
var id = $("#searchstudent").find('option:selected').attr('id');

var url="<?php echo Yii::app()->createUrl('studentFees/Details'); ?>";

$.ajax({
 type: "GET",
        url:url,
        data: {'id':id},
        success: function(data) {    
console.log("SuccessDetails"+data);
//var data1=data.split('&');
//var d = data1[0].split('-')
var d = data.split('$');
var id=document.getElementById("studentid").setAttribute('value',d[0]);
var sn=document.getElementById("studentname").setAttribute('value',d[2]);
var sec=document.getElementById("StudentFees_student_section").setAttribute('value',d[3]);
$("#fathername").val(d[4]); 
$("#admno").val(d[5]);
document.getElementById("StudentFees_student_class").setAttribute('value',d[1]);
var elements = document.getElementById("payfeesmonth").selectedOptions;

feespay();
// for pervious fees
var sid = $("#searchstudent").find('option:selected').attr('id');

var url="<?php echo Yii::app()->createUrl('studentFees/Previousfees'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'sid':sid},
        success: function(data) {    
//console.log("Success->prevfees->"+data);
if(data!=""){
var h = data.split('&');
for(var i=0;i<h.length-1;i++){
var s=h[i].split('$');
//comes in as fees_for_months, date_payment,amount_paid,fees_period_month,student_class
//display as Class	Fees for month	Fees paid for month	Payment Date	Amount Paid
//var pd =s[1].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');
if(s[5]!='')
{
	$("#previousrecord").css('border-color','#ff0000');

}
$("#previousrecord tbody").append("<tr class='add_data'><td>"+s[4]+"</td><td>"+s[0]+"</td><td>"+s[3]+"</td><td>"+s[1]+"</td><td>"+s[2]+"</td><td style='color:red;'>"+s[5]+"</td></tr>");

}
}

else{
//alert("No previous fees");
}
        }
     });
document.getElementById("showprevfees").disabled = true;




}

});
	
}
  

  
function resetfees(){
	$("#monthfees").val("Please select months"); 
	$("#payfeesmonth").find("option").remove();
	$("#payfeesmonth").append("<option>Please select fees pay month</option>");
	$("#annualfees").val('0'); 
	$("#tutionfees").val('0'); 
	 $("#fundfees").val('0'); 
	 $("#sportsfees").val('0'); 
	 $("#admfees").val('0'); 
	 $("#securityfees").val('0'); 
	  $("#dayboardfees").val('0');
	 $("#busfees").val('0'); 
	 $("#latefees").val('0'); 
	 $("#activityfees").val('0'); 
	 $("#concessiontypeid").val(''); 
	  $("#concession").val('0'); 
	  $("#concessiontype").val(''); 
	  $("#totamt").val('0');
     $("#amtpaid").val('0');
		 
}

function getprefees(){


var sid = $("#searchstudent").find('option:selected').attr('id');

var url="<?php echo Yii::app()->createUrl('studentFees/Previousfees'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'sid':sid},
        success: function(data) {    
console.log("Success"+data);
if(data!=""){
var h = data.split('&');
for(var i=0;i<h.length-1;i++){
var s=h[i].split('$');

var pd =s[1].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');
$("#previousrecord").append("<tr><td>"+s[4]+"</td><td>"+s[0]+"</td><td>"+s[3]+"</td><td>"+s[1]+"</td><td>"+s[2]+"</td></tr>");

}
}

else{
alert("No previous fees");
}
        }
     });
document.getElementById("showprevfees").disabled = true;
}


var slectedmonth=null;
var slectedfees=null;

var tmpVar="";
function  feespay(){
var fm=document.getElementById("monthfees").value;
var sid = $("#searchstudent").find('option:selected').attr('id');

if(fm==""){
$("#payfeesmonth").find("option").remove();
$("#annualfees").val('0'); 
	$("#tutionfees").val('0'); 
	 $("#fundfees").val('0'); 
	 $("#sportsfees").val('0'); 
	 $("#admfees").val('0'); 
	 $("#securityfees").val('0'); 
	  $("#dayboardfees").val('0');
	 $("#busfees").val('0'); 
	 $("#latefees").val('0'); 
	 $("#activityfees").val('0'); 
	 $("#concessiontypeid").val(''); 
	  $("#concession").val('0'); 
	  $("#concessiontype").val(); 
	  $("#totamt").val('0');
     $("#amtpaid").val('0');
}
else{


	var x=document.getElementById("monthfees");
	 for (var i = 0; i < x.options.length; i++) {
	 $("#payfeesmonth").find("option").remove();
     if(x.options[i].selected ==true){
		tmpVar=x.options[i].value;
		monthdata(tmpVar);
	}
  }

}


var b= tmpVar; 

var feesmonth= tmpVar.split(",");
var a=feesmonth.length;

feesformonths(a,b);	 
}

 function monthdata(tmpVar){
	var fm = tmpVar;
	var sid = $("#searchstudent").find('option:selected').attr('id');
	var url="<?php echo Yii::app()->createUrl('studentFees/Payfees'); ?>";
		$.ajax({
		 type: "GET",
        url:url,
        data: {'fm':fm,'sid':sid},
        success: function(data) {    
		console.log("Success"+data);
		var b1=data.split('&');
		console.log("b1.."+b1);
		var b=b1[0].split('$');
		
		var h = b[0].split(',');
		
		for(var i=0;i<h.length;i++){
		$("#payfeesmonth").append("<option selected id='"+h[i]+"'>"+h[i]+"</option>");
		}
		if(b1[1]>0){

		$("#latefees").val(b1[1]);

		}
		else{
		var l=0;
		$("#latefees").val('0');

		}

		}
 
     });
}

function feesformonths(a,b){
	var count=a;
	var sessmon=b;
	
//var sid = $("#searchstudent").find('option:selected').attr('id');
 var sid=document.getElementById('studentid').value;

var mf=document.getElementById('monthfees').value;
var cls=document.getElementById('StudentFees_student_class').value;
var feesid=document.getElementById("fees").value;

if(mf!=""){
	if(feesid!='a'){
	
	var url="<?php echo Yii::app()->createUrl('studentFees/Calculatefees'); ?>";
/*
data comes in thes order: annual,tutionfee,funds,sports,adm,security,dayboard,busfee,concpercetn(=amount/percent),conctype(=sibling/halffee),activityfee,concamt, concession_id
*/
	$.ajax({
	 type: "GET",
        url:url,
        data: {'sid':sid,'cls':cls},
        success: function(data) {   
			
			
		if(data!='-----------'){
			
		var d = data.split('|')
		
		if(d[1]==""){
		alert("Fees is not inserted");
		}
		if(sessmon=='4'){
		$("#annualfees").val(d[0]);
		}
		else{
		$("#annualfees").val('0');
		}
		$("#tutionfees").val(count * d[1]);
		$("#fundfees").val(count * d[2]);

		$("#sportsfees").val(count * d[3]);

		if(sessmon=='4'){
		$("#admfees").val(d[4]);

		}
		else{
		$("#admfees").val('0');

		}
		$("#securityfees").val(d[5]);
			
		$("#dayboardfees").val(count * parseInt(d[6]));
		if(d[7]>0){	
			$("#busfees").val(count * parseInt(d[7]));
		}
		else{
			$("#busfees").val(0);
		}
		var bf=document.getElementById("busfees").value;
		$("#activityfees").val(count * parseInt(d[10]));
		//calculate concession
		$("#concessiontypeid").val(d['cid']); //concession id
		$("#concessiontype").val(d[9]);
		var concessiontype=d[9];
		var concession_percenttype=d[8]; //stores "amount" or "percent"
		var concession_amount=d[11];
		var tutionfees=document.getElementById("tutionfees").value;
		var concamt = 0;
                if(concession_amount!="" && concession_amount>0 && concession_percenttype!=""){
			if(concession_percenttype=="amount" ){
			   concamt = concession_amount; //full amount	
			}
			else{
			   concamt = (tutionfees * concession_amount )/100;				
			}
                  }

		$("#concession").val(concamt);

//calculate total
		var annualfees = document.getElementById("annualfees").value;
		var fundfees=document.getElementById("fundfees").value;
		var sportfees=document.getElementById("sportsfees").value;
		var activityfees=document.getElementById("activityfees").value;
		var admfees=document.getElementById("admfees").value;
		var securityfees=document.getElementById("securityfees").value;
		var dayboardfees=document.getElementById("dayboardfees").value;
		var busfees=document.getElementById("busfees").value;
		var latefees=document.getElementById("latefees").value;

		var tot=parseInt(annualfees) + parseInt(tutionfees) + parseInt(fundfees) + parseInt(sportfees) 
			+ parseInt(activityfees)
			 + parseInt(admfees) + parseInt(securityfees) + parseInt(dayboardfees) 
			     + parseInt(busfees) + parseInt(latefees) - parseInt(concamt);

		$("#totamt").val(tot);
		$("#amtpaid").val(tot);

		}
		else{
		alert("Fees is not inserted for this class");
		}
		}
     });
 }
}
  

else{
alert("Please select fees for months first.");

}
}








$( ".feeschange" ).change(function() {
  document.getElementById('isdefault').value="false";

var thisid = $(this).attr('id');
var thisval=$("#"+thisid).val();
//set total amount
/*var totamt = $("#totamt");
totamt = totamt - oldval + thisval;
alert("changed total val="+totamt);
$("#totamt").val(totamt); */
var annualfees = document.getElementById("annualfees").value;
var tutionfees=document.getElementById("tutionfees").value;
var fundfees=document.getElementById("fundfees").value;
var sportfees=document.getElementById("sportsfees").value;
var activityfees=document.getElementById("activityfees").value;
var admfees=document.getElementById("admfees").value;
var securityfees=document.getElementById("securityfees").value;
var dayboardfees=document.getElementById("dayboardfees").value;
var busfees=document.getElementById("busfees").value;
var concession=document.getElementById("concession").value;
var latefees=document.getElementById("latefees").value;

var tot=parseInt(annualfees) + parseInt(tutionfees) + parseInt(fundfees) + parseInt(sportfees) + parseInt(activityfees)
		 + parseInt(admfees) + parseInt(securityfees) + parseInt(dayboardfees) 
             + parseInt(busfees) + parseInt(latefees) - parseInt(concession);
$("#totamt").val(tot);  
$("#amtpaid").val(tot);
});

function preupdate(){

var id=document.getElementById('studentid').value;

var url="<?php echo Yii::app()->createUrl('studentFees/Prevfeesupdate'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'id':id},
        success: function(data) {    
console.log("Success"+data);
if(data!=""){
var h = data.split('&');
for(var i=0;i<h.length-1;i++){
var s=h[i].split('$');

var pd =s[1].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');

$("#prevrec").append("<tr><td>"+s[4]+"</td><td>"+s[0]+"</td><td>"+s[3]+"</td><td>"+pd+"</td><td>"+s[2]+"</td></tr>");
}
}

else{
alert("No previous fees");
}
        }
     });
document.getElementById("prevfees").disabled = true;




}




</script>
<script>
   
 $('#student-fees-form').submit(function()

{
 var cat = document.getElementById('paymentmode').value;    
    if (cat == "Cheque") {
		 var b=document.getElementById("cheqno").value;
		 var c=document.getElementById("bankname").value;
		 var d=document.getElementById("branchname").value;
		if (b ==""){
			alert("Cheque Number cannot be blank");
			return false;
		}
		if (c ==""){
			alert("Bank Name cannot be blank");
			return false;
		}
	}

return true;
});

  $("#student-fees-form").validate({
     rules: {
            "latefees": {
                //required: true
            },
            "tutionfees": {
                required: true,
                
            },
            "fundfees": {
               // required: true
            },
            "sportsfees": {
               // required: true,
                
            },
            "activityfees": {
              //  required: true
            },
            "admfees": {
               // required: true,
                
            },
            "securityfees": {
              //  required: true
            },
            "dayboardfees": {
              //  required: true,
                
            },
            "busfees": {
               // required: true
            }
        },
       
  });

function selectmode()
{
	var paymentmode = document.getElementById("paymentmode").value;
	if(paymentmode=='Cheque')
	{
		document.getElementById("bankname").disabled = false;	
		document.getElementById("branchname").disabled = false;
		document.getElementById("cheqno").disabled = false;	
	}
	else 
	{
		document.getElementById("bankname").disabled = true;	
		document.getElementById("branchname").disabled = true;
		document.getElementById("cheqno").disabled = true;
	}
}
function getval(val)
{
	if(val=='OTHER')
	{
		
		$('#bankname').prop('disabled', 'disabled');
		$("#bankname").after("<BR/><input type='text' id='bankname' name='bankname'>");
	}
}
	 </script>

<script>
$(".btn ").click(function(){
	$('#loader_img').css("display","block");
});

  </script>













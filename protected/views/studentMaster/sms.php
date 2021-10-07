<?php
	/* @var $this StudentMasterController */
	/* @var $model StudentMaster */
	
	$this->breadcrumbs=array(
	'Student Records'=>array('admin'),
	'Manage',
	);
	
	$this->menu=array(
	
	array('label'=>'Create Student', 'url'=>array('create')),
	);
	
	Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
	});
	$('.search-form form').submit(function(){
	$('#student-master-grid').yiiGridView('update', {
	data: $(this).serialize()
	});
	return false;
	});
	");
?>
<style>
.sms {
  background-color: #76ACC7;
  border: 1px none #000000;
  border-radius: 4px 4px 4px 4px;
  color: #FFFFFF;
  font-weight: bold;
  padding: 10px 20px;
  text-transform: uppercase;
}
#studenttable {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}
#studenttable #td1, #studenttable #th1 {
    font-size: 1em;
    border: 1px solid white;
    padding: 3px 7px 2px 7px;
}
#studenttable #th1 {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color:#76ACC7;
    color: #ffffff;
}
#studenttable tr.alt #td1 {
    color: #000000;
    background-color:#CEE1EB;
}
</style>
<h1>Send SMS</h1>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>

<div id="statusMsg">
	<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
	<?php endif; ?>
	
	<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
	</div>
	<?php endif; ?>
</div>
<table style="width:400px;margin:10px auto;">


<tr>
<th>Select Class</th>
<th>Select Section</th></tr>
<tr><td><select id="class" name="class">
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

</select></td>
<td><select id="section" name="section">
<option id="" value="">Please select a Section</option>
		<option value="A" id="A">A</option>
	<option value="B" id="B">B</option>
	<option value="C" id="c">C</option>
	<option value="D" id="D">D</option>
    <option value="E" id="E">E</option>
	<option value="F" id="F">F</option>
    <option value="G" id="G">G</option>
    <option value="H" id="H">H</option>
	<option value="I" id="I">I</option>
	<option value="J" id="J">J</option>
</select></td>
<td><input type="button" onclick="showdata()" value="Search" name="search" id="search"></td>
<td><input class="sms" type="button" value="SMS Export" name="excelbtn" id="excelbtn" onclick="generateexcel()"/></td>
</tr>
</table>

<div id="reporttable">
<table id="studenttable" style="width:700px;margin-left:100px;border:1px solid white;">
<tr>
<th id="th1">Admission No</th><th id="th1">Student name</th>
<th id="th1">Class</th><th id="th1">Section</th><th id="th1">Mobile No.</th>
</tr>
</table>
</div>
<script>
function showdata(){
var c=document.getElementById('class').value;
var s=document.getElementById('section').value;
//alert(s+" and "+c);
var myTable = document.getElementById("studenttable");
var rowCount = myTable.rows.length;
for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
}
var url="<?php echo Yii::app()->createUrl('site/getbyclass'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'class':c,'section':s},
        success: function(data) { 
//alert(data);		
        console.log("success"+data);

if(data=="")
{
	//alert("No results found");
$("#studenttable").append("No results found");
}  else{ var h = data.split('$');

for(var z=0;z<h.length-1;z++){
var tmpfm="";
var tmpfm1="";
var tmpfm2="";
var s=h[z].split('*');
//var m=s[4].split(',');

$("#studenttable").append("<tr class='alt'><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1' >"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]
	+"</td></tr>");

}}  

}       
});
}



function generateexcel(){
/*var c=document.getElementById('class').value;
var datefrom=document.getElementById('datefrom').value;
var dateto=document.getElementById('dateto').value;
var year=document.getElementById('year').value;


window.location.href = "<?php echo Yii::app()->createUrl('site/Transportdefexcel'); ?>&datefrom="+datefrom+"&dateto="+dateto+"&c="+c+"&year="+year;*/

    var data=$('#reporttable').html();
	//alert(data);
	console.log(data);
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(data));
}

</script>
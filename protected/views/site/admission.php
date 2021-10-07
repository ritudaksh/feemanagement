
<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css">
 <script type="text/javascript" src="http://www.erichynds.com/examples/jquery-ui-multiselect-widget/src/jquery.multiselect.js"></script>
  <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
-->
<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
  
  
  
  <?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Admission',
);
?>

<style>
	#admtable {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
    
}
#admtable #td1, #admtable #th1 {
    font-size: 1em;
    border: 1px solid white;
    padding: 3px 7px 2px 7px;
    
}
#admtable #th1 {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color:#76ACC7;
    color: #ffffff;
	
}
#admtable tr.alt #td1 {
    color: #000000;
    background-color:#CEE1EB;
}
</style>









<table style="width:400px;margin-left:80px;">
<tr>


<th>Select Class</th>
<td><select id="class" name="class">
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
</tr>
</table>
<?php $date=date('d-m-Y')?>

<table style="width:600px;margin-left:80px;">
<tr>
<th>Date from <input type="text" id="datefrom" name="datefrom"/></th>
<th >Date to <input type="text"  id="dateto" name="dateto" value="<?php echo $date; ?>" /></th>
<th><input type="button" name="btn" value="Search" id="btn" onclick="showdata()"/></th>
</tr>
</table>




<div style="margin-left:650px;margin-top:-20px;overflow:hidden;">
<input type="button" value="Download this table as excel file" name="excelbtn" id="excelbtn" onclick="generateexcel()"/>
</div>
<br>
<div>
<table id="admtable"  style="width:790px;margin-left:50px;border:2px solid white;" >
<tr>
<th id="th1">Admission No.</th>
<th id="th1">Admission date</th>
<th id="th1">Student Name</th>
<th id="th1">Date of Birth</th>
<th id="th1">Class</th>
<th id="th1">Section</th>
<th id="th1">Father's Name</th>
<th id="th1">Mother's name</th>
<th id="th1">Address</th>
</tr>

</table>
</div>
 <script type="text/javascript">
                   $("#datefrom").click(function() {
                        $("#btn").attr("disabled", false);
                        
                    });
 		$("#dateto").click(function() {
                        $("#btn").attr("disabled", false);
                        
                    });
 		$("#class").click(function() {
                        $("#btn").attr("disabled", false);
                        
                    });

                    $("#btn").click(function() {
                        $("#btn").attr("disabled", true);
                        
                    });
    </script>

<script>
$(document).ready(function () {
    var date = new Date();
  

    $('#datefrom').datepicker({
        
        dateFormat: 'dd-mm-yy'
    
      
      });
      
 $('#dateto').datepicker({
        
        dateFormat: 'dd-mm-yy'
    
      
      });
      
  });

</script>


<script>
function showdata(){

var datefrom=document.getElementById('datefrom').value;
var dateto=document.getElementById('dateto').value;
var cls=document.getElementById('class').value;


var myTable = document.getElementById("admtable");
var rowCount = myTable.rows.length;
for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
}
var url="<?php echo Yii::app()->createUrl('site/Admissiondetail'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'datefrom':datefrom,'dateto':dateto,'cls':cls},
        success: function(data) {    
     // alert("succes"+data);
	 if(data==""){
alert("No results found");
document.getElementById("excelbtn").disabled = true;

}
	 
else{

document.getElementById("excelbtn").disabled = false;


var data1 = data.split('$');



for(var i=0;i<data1.length-1;i++){
var s = data1[i].split('&');


if(s[4]=='0000-00-00'){
var addate = s[2].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');
if(s[9]==","){
$("#admtable").append("<tr><td id='td1'>"+s[1]+"</td><td id='td1'>"+addate+"</td><td id='td1'>"+s[3]+"</td><td id='td1'></td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td id='td1'>"+s[8]+"</td><td id='td1'></td></tr>");
}
else{
$("#admtable").append("<tr><td id='td1'>"+s[1]+"</td><td id='td1'>"+addate+"</td><td id='td1'>"+s[3]+"</td><td id='td1'></td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td>"+s[8]+"</td><td id='td1'>"+s[9]+"</td></tr>");
}
}


else{
var admdate = s[2].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');
var bdate = s[4].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');
if(s[9]==","){
$("#admtable").append("<tr><td id='td1'>"+s[1]+"</td><td id='td1'>"+admdate+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+bdate+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td>"+s[8]+"</td><td id='td1'></td></tr>");
}
else{
$("#admtable").append("<tr><td id='td1'>"+s[1]+"</td><td id='td1'>"+admdate+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+bdate+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td>"+s[8]+"</td><td id='td1'>"+s[9]+"</td></tr>");
}


}
}
}


 }



 }      
);

}

function generateexcel(){
var datefrom=document.getElementById('datefrom').value;
var dateto=document.getElementById('dateto').value;
var cls=document.getElementById('class').value;


window.location.href = "<?php echo Yii::app()->createUrl('site/Exceladmission'); ?>&datefrom="+datefrom+"&dateto="+dateto+"&cls="+cls;

/*var url="<?php echo Yii::app()->createUrl('site/Exceladmission'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'datefrom':datefrom,'dateto':dateto,'cls':cls},
        success: function(data) {    
console.log("success"+data);





}
        
     });*/

}












</script>







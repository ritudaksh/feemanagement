
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
	'Transport defaulter report',
);
?>
<style>
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



<?php
      
	   $cd = date('Y-m-d');
	   $cdm = explode("-",$cd);
		// $cdm1 =ltrim($cdm[1],'0');
	   $cdy = ltrim($cdm[0],'0');
	   $y1=$cdy; 
       $y2=$y1-6;
      
?>
<table style="width:400px;margin-left:80px;">
<tr>
<th>Select Class</th>
	<td><select id="class" name="class" >
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
<th>Year</th>
 <td>
	<select id="year" name="year">
	<?php for($year=$y1; $year>=$y2; $year--) { ?>
	<option  id="<?php echo $year; ?>" value="<?php echo $year; ?>"><?php echo $year; ?></option>
    <?php }?>
	
	</select>
	</td>
</tr>
</table>

<table style="width:600px;margin-left:80px;">
<tr>
<?php 

$date=date('d-m-Y') ?>


<!--<th>Date from <input type="text" id="datefrom" name="datefrom"/></th>-->
<!--<th>Date to <input type="text"  id="dateto" name="dateto" value="<?php //echo $date; ?>"/></th>-->
	
	
	<td><input type="button" id="search" name="search" value="Search" onclick="showdata()"></td>
	
	</tr>
</table>

<div style="margin-left:600px;margin-top:-10px;">
<input type="button" value="Download this table as excel file" name="excelbtn" id="excelbtn" onclick="generateexcel()"/>
</div>
<br>

<div id="reporttable">
<table id="studenttable" style="width:700px;margin-left:100px;border:1px solid white;">
<tr>
<th id="th1">Admission no</th><th id="th1">Student name</th>
<th id="th1">Class</th><th id="th1">Section</th><th id="th1">Route</th><th id="th1">Destination</th><th id="th1">Busfees unpaid for months</th>
</tr>
</table>
</div>

<script type="text/javascript">
                   $("#class,#year").click(function() {
                        $("#search").attr("disabled", false);
                        
                    });
					
                    $("#search").click(function() {
                        $("#search").attr("disabled", true);
                        
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
//var year=document.getElementById('year').value;
var c=document.getElementById('class').value;
//var datefrom=document.getElementById('datefrom').value;
//var dateto=document.getElementById('dateto').value;
var year=document.getElementById('year').value;
var radioval=$('input[name=passed]:checked').val();

var myTable = document.getElementById("studenttable");
var rowCount = myTable.rows.length;
for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
}



document.getElementById("excelbtn").disabled = false;

var url="<?php echo Yii::app()->createUrl('site/TransportDefaultersData'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'c':c,'radioval':radioval,'year':year},
        success: function(data) {    
        console.log("success"+data);

if(data!="!"){

var h = data.split('$');

for(var z=0;z<h.length-1;z++){
var tmpfm="";
var tmpfm1="";
var tmpfm2="";
var s=h[z].split('*');
//var m=s[4].split(',');

$("#studenttable").append("<tr class='alt'><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1' >"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]
	+"</td><td id='td1'>"+s[5]+"</td>"+"</td><td id='td1'>"+s[6]+"</td></tr>");

}
}
else{
alert("No results found");
document.getElementById("excelbtn").disabled = true;
}
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
	console.log(data);
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(data));
}

</script>




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
	'Transport',
);
?>
<style>
	#transportrp {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}
#transportrp #td1, #transportrp #th1 {
    font-size: 1em;
    border: 1px solid white;
    padding: 3px 7px 2px 7px;
}
#transportrp #th1 {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color:#76ACC7;
    color: #ffffff;
}
#transportrp tr.alt #td1 {
    color: #000000;
    background-color:#CEE1EB;
}

</style>

<h1>Transport Report</h1>



<table  style="width:700px;margin-left:30px;">

<tr>
<th>
Bus Route</th><td><select name="busno" id ="busno">
	<option id="" value="" >Please select bus route</option>	
	<option id="1" value="1" >1</option>	
	<option id="2" value="2" >2</option>	
	<option id="3" value="3" >3</option>	
	<option id="4" value="4" >4</option>	
	<option id="5" value="5" >5</option>	
	<option id="6" value="6" >6</option>	
	<option id="7" value="7" >7</option>	
	<option id="8" value="8" >8</option>	
	<option id="9" value="9" >9</option>	
	<option id="10" value="10">10</option>	
	<option id="11" value="11" >11</option>	
	<option id="12" value="12" >12</option>	
	<option id="13" value="13" >13</option>	
	<option id="14" value="14" >14</option>	
	<option id="15" value="15" >15</option>	
	<option id="16" value="16" >16</option>	
	<option id="17" value="17" >17</option>	
	<option id="18" value="18" >18</option>	
	<option id="19" value="19" >19</option>	
	<option id="20" value="20">20</option>	
	
	


</select></td>

<td style="align:left"><input   type="button"  name="btn" value="Search" id="btn" onclick="displayData()" /></td>
<td style="float:right"><input type="button" value="Download this table as excel file" name="excelbtn" id="excelbtn" onclick="generateexcel1()"/></td>
</tr>
</table>

<table  id="transportrp" style="width:700px;margin-left:30px;border:1px solid black;">
<tr>
<th id="th1">Student name</th><th id="th1">Addmission No.</th>
<th id="th1">Class</th><th id="th1">Section</th><th id="th1">Destination</th>
<th id="th1">Route</th>
</tr>

</table>
 <script type="text/javascript">
                   $("#busno").click(function() {
                        $("#btn").attr("disabled", false);
                        
                    });
                    $("#btn").click(function() {
                        $("#btn").attr("disabled", true);
                        
                    });
    </script>


<script type="text/javascript">
function displayData(){
var busno=document.getElementById('busno').value;

//alert(busno);
var myTable = document.getElementById("transportrp");
var rowCount = myTable.rows.length;
for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
}

var url="<?php echo Yii::app()->createUrl('/site/Busno'); ?>";

$.ajax({
  type: "GET",
        url:url,
        data: {'busno':busno},
        success: function(data) {    

document.getElementById("excelbtn").disabled = false;

var h = data.split('&');
for(var i=0;i<h.length-1;i++){
var s=h[i].split('*');
$('#transportrp').append("<tr class='alt'><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"
+s[5]+"</td><td id='td1'>"+s[6]+"</td></tr>");
//$("#transportrp").append("<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>");


}




}
        
  });


}

function generateexcel1(){

var busno=document.getElementById('busno').value;


window.location.href = "<?php echo Yii::app()->createUrl('site/CreateExcel'); ?>&busno="+busno;
/*var url="<?php echo Yii::app()->createUrl('site/CreateExcel'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'busno':busno},
        success: function(data) {    
console.log("success"+data);





}
        
     });*/

}

</script>


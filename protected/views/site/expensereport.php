
<!--<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css">
-->
<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
  
  
  <?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Expensereport',
);
?>

<style>
	#exptable {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
    
}
#exptable #td1, #exptable #th1 {
    font-size: 1em;
    border: 1px solid white;
    padding: 3px 7px 2px 7px;
    
}
#exptable #th1 {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color:#76ACC7;
    color: #ffffff;
	
}
#exptable tr.alt #td1 {
    color: #000000;
    background-color:#CEE1EB;
}
</style>





<table style="width:400px;margin-left:80px;">
<tr>

<th>Select Account</th>
<td><select id="accselect" name="accselect" multiple>
<option id="" value="">Please select a account</option>
<?php foreach($list as $acc){?>
	   <option id="<?php echo $acc['account_id']; ?>" value="<?php echo $acc['account_id']; ?>"><?php echo $acc['account_name']; ?></option>
	   
<?php }?>
</select></td>
</tr>
</table>





<table style="width:600px;margin-left:80px;">
<tr>
<th>Date from <input type="text" id="datefrom" name="datefrom"/></th>
<th >Date to <input type="text"  id="dateto" name="dateto" /></th>
<th><input type="button" name="btn" value="Search" id="btn" onclick="showdata()"/></th>
</tr>

</table>




<div style="margin-left:650px;margin-top:-20px;overflow:hidden;">
<input type="button" value="Download this table as excel file" name="excelbtn" id="excelbtn" onclick="generateexcel()"/>
</div>
<br>
<div>
<table id="exptable"  style="width:790px;margin-left:50px;border:2px solid white;" >
<tr>
<th id="th1">Account name</th>
<th id="th1">Account description</th>
<th id="th1">Expense description</th>
<th id="th1">Expense date</th>
<th id="th1">Amount</th>
<th id="th1">Paid to</th>
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
var accval1 = $('#accselect').val();
var accval = accval1.toString();



var myTable = document.getElementById("exptable");
var rowCount = myTable.rows.length;
for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
}
if(datefrom=="" || dateto=="" || accval1==""){
alert("please fill all fields");
}
else{
var url="<?php echo Yii::app()->createUrl('site/Expensedata'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'datefrom':datefrom,'dateto':dateto,'accval':accval},
        success: function(data) {    
        console.log("succes"+data);
	 if(data==""){
alert("No results found");
document.getElementById("excelbtn").disabled = true;

}
	 
else{

document.getElementById("excelbtn").disabled = false;


var data1 = data.split('&');



for(var i=0;i<data1.length-1;i++){
var s = data1[i].split('*');

$("#exptable").append("<tr><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'></td></tr>");

}
}


 }
 });
 }

}

function generateexcel(){
var datefrom=document.getElementById('datefrom').value;
var dateto=document.getElementById('dateto').value;
var accval1 = $('#accselect').val();
var accval = accval1.toString();

window.location.href = "<?php echo Yii::app()->createUrl('site/Expenseexcel'); ?>&datefrom="+datefrom+"&dateto="+dateto+"&accval="+accval;


}












</script>








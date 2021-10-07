
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
	'Collection',
);
?>

<style>

	#cheqtable {
   
    width: 80%;
    border-collapse: collapse;
    
}
#cheqtable #td1, #cheqtable #th1 {
    font-size: 0.9em;
    border: 1px solid white;
    padding: 3px 7px 2px 7px;
    
}
#cheqtable #th1 {
    font-size: 0.8em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color:#76ACC7;
    color: #ffffff;
}
#cheqtable #tr.alt #td1 {
    color: #000000;
    background-color:#CEE1EB;
}
</style>
<?php $date=date('d-m-Y')?>
<h5 align="center">
Shishu Niketan Public School <br>
Sector – 66, Mohali<br>
<br>State Bank of Patiala, Phase – 7, Mohali OD Account No. 65274303453<br></h5>
<h5 style="width:600px;margin-left:180px;">Tel: 9815094449 <span style="float:right"><u>Date:</u>
<?php echo date("d-m-Y");?>
</span></h5>



<div>



<table style="width:600px;margin-left:180px;align:center;">
</tr>
<tr>
<th>Date from <input type="text" id="datefrom" name="datefrom"/></th>
<th>Date to <input type="text"  id="dateto" name="dateto" value="<?php echo $date; ?>"/></th>
<th><input type="button" name="btn" value="Search" id="btn" onclick="showdata()"/></th>
</tr>
</table>




<div style="margin-left:650px;margin-top:-20px;overflow:hidden;">
<input type="button" value="Download this table as excel files" name="excelbtn" id="excelbtn" onclick="generateexcel()"/>
</div>
<br>
<div id="reporttable">
<table id="cheqtable"  style="width:780px;margin-left:180px;border:2px solid white;" >
<tbody>
<tr>

<th id="th1">Sr No.</th>
<th id="th1">Name</th>
<th id="th1">Admission Number(s)</th>
<th id="th1">Class</th>
<th id="th1">Section</th>
<th id="th1">Phone No.</th>
<th id="th1">Bank</th>
<th id="th1">Branch</th>
<th id="th1">Cheque No.</th>
<th id="th1">Amount</th>
</tr>
</tbody>
</table>
</div>
</div>
<script type="text/javascript">
                   $("#datefrom").click(function() {
                        $("#btn").attr("disabled", false);
                        
                    });
                    $("#dateto").click(function() {
                        $("#btn").attr("disabled", false);
                        
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

var myTable = document.getElementById("cheqtable");
var rowCount = myTable.rows.length;
for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
}
var url="<?php echo Yii::app()->createUrl('site/chequedepositview'); ?>";


$.ajax({
 type: "GET",
        url:url,
        data: {'datefrom':datefrom,'dateto':dateto},
        success: function(data) {    
document.getElementById("excelbtn").disabled = false;

var h = data.split('||');
var totchq=0;


for(var i=0;i<h.length-1;i++){

var s = h[i].split('!');

totchq += s[8]; //total of cheque
console.log(totchq);



$("#cheqtable").append("<tr><td id='td1'>"+(i+1)+"</td><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td id='td1'>"+s[8]+"</td></tr>");
}
var x = h[i].split('$');
var z=x.toString();

if(data!=''){
	
  $("#cheqtable").append("<tr><th id='th1'>Total Collection</th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'>"+z.slice(1)+"</th></tr>");
}
else{
  alert("No results found");
  document.getElementById("excelbtn").disabled = true;

}

 }



 }      
);

}

function generateexcel(){

var datefrom=document.getElementById('datefrom').value;
var dateto=document.getElementById('dateto').value;
//var radioval=$('input[name=feestype]:checked').val();


window.location.href = "<?php echo Yii::app()->createUrl('site/chequedepositexcel'); ?>&datefrom="+datefrom+"&dateto="+dateto;


}



</script>




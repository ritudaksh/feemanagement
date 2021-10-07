
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

	#feestable {
   
    width: 80%;
    border-collapse: collapse;
    
}
#feestable #td1, #feestable #th1 {
    font-size: 0.9em;
    border: 1px solid white;
    padding: 3px 7px 2px 7px;
    
}
#feestable #th1 {
    font-size: 0.8em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color:#76ACC7;
    color: #ffffff;
}
#feestable #tr.alt #td1 {
    color: #000000;
    background-color:#CEE1EB;
}
</style>
<?php $date=date('d-m-Y')?>
<div>



<table style="width:600px;margin-left:80px;">
<tr><td><input type="radio" class="radiobtns" name="feestype" value="advancedfees">Advanced fees</td>
<td><input type="radio" class="radiobtns" name="feestype" value="totalfees" checked>Total fees</td>
</tr>
<tr>
<th>Date from <input type="text" id="datefrom" name="datefrom"/></th>
<th>Date to <input type="text"  id="dateto" name="dateto" value="<?php echo $date; ?>"/></th>
<th><input type="button" name="btn" value="Search" id="btn" onclick="showdata()"/></th>
</tr>
</table>




<div style="margin-left:650px;margin-top:-20px;overflow:hidden;">
<input type="button" value="Download this table as excel file" name="excelbtn" id="excelbtn" onclick="generateexcel()"/>
</div>
<br>
<div id="reporttable">
<table id="feestable"  style="width:780px;border:2px solid white;" >
<tbody>
<tr>
<th id="th1">Admission no</th>
<th id="th1">Student Name</th>
<th id="th1">Class</th>
<th id="th1">Section</th>
<th id="th1">Fees for months</th>
<th id="th1">Fees paid for months</th>
<th id="th1">Annual fees</th>
<th id="th1">Tution fees</th>
<th id="th1">Concession applied</th>
<th id="th1">Net tution fees</th>
<th id="th1">Fund fees</th>
<th id="th1">Sports fees</th><th id="th1">Activity fees</th>
<th id="th1">Admission fees</th><th id="th1">Security fees</th>
<th id="th1">Late fees</th><th id="th1">Dayboarding fees</th>
<th id="th1">Bus fees</th>
<th id="th1">Payment date</th>
<th id="th1">Payment mode</th>
<th id="th1">Cheque no.</th>
<th id="th1">Bank name</th>
<th id="th1">Concession type</th>
<th id="th1">Total amount</th>
<th id="th1">Amount paid</th>
<th id="th1">Cheque Status</th>
<th id="th1">Realized Date</th>
<!-- cheque_status and realized_date added -->

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
                    $("#btn").click(function() {
                        $("#btn").attr("disabled", true);
                        
                    });
					
					$(".radiobtns").change(function() {
					  
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

var radioval=$('input[name=feestype]:checked').val();

var myTable = document.getElementById("feestable");
var rowCount = myTable.rows.length;
for (var x=rowCount-1; x>0; x--) {
   myTable.deleteRow(x);
}
var url="<?php echo Yii::app()->createUrl('site/fees'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'datefrom':datefrom,'dateto':dateto,'radioval':radioval},
        success: function(data) {    
     // alert("succes"+data);
	 
document.getElementById("excelbtn").disabled = false;
	 
var totamt=data.split('$');

var h = data.split('||');
var tottutfees=0;
var totconc=0;

for(var i=0;i<h.length-1;i++){
var s=h[i].split('!');

if(s[7]==0){
s[21]=0; //concession applied
}
var nettutionfees=s[7]-s[21]; //net tution fees
tottutfees += +nettutionfees;  //total tution fees
totconc += +s[21]; //total concession

//whats happening here var pd = s[17].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');
 var pd = s[17];
$("#feestable").append("<tr><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td id='td1'>"+s[21]+"</td><td id='td1'>"+nettutionfees+"</td><td>"+s[8]+"</td><td id='td1'>"+s[9]+"</td><td id='td1'>"+s[10]+"</td><td id='td1'>"+s[11]+"</td><td id='td1'>"+s[12]+"</td><td id='td1'>"+s[13]+"</td><td id='td1'>"+s[14]+"</td><td id='td1'>"+s[15]+"</td><td id='td1'>"+pd+"</td><td id='td1'>"+s[18]+"</td><td id='td1'>"+s[19]+"</td><td id='td1'>"+s[20]+"</td><td id='td1'>"+s[22]+"</td><td id='td1'>"+s[23]+"</td><td id='td1'>"+s[16]+"</td id='td1'><td id='td1'>"+s[24]+"</td id='td1'><td id='td1'>"+s[25]+"</tr>");

}
/* s[24]cheque_status and s[25]realized_date added */
if(data!=''){
//$("#feestable").append("<tr><th id='th1'>Total Collection</th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'>"+totamt[2]+"</th><th id='th1'>"+totamt[3]+"</th><th id='th1'>"+totamt[4]+"</th><th id='th1'>"+totamt[5]+"</th><th id='th1'>"+totamt[6]+"</th><th id='th1'>"+totamt[7]+"</th><th id='th1'>"+totamt[8]+"</th><th id='th1'>"+totamt[9]+"</th><th id='th1'>"+totamt[10]+"</th><th id='th1'>"+totamt[11]+"</th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'>"+totamt[12]+"</th><th id='th1'>"+totamt[1]+"</th></tr>");


$("#feestable").append("<tr><th id='th1'>Total Collection</th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'>"+totamt[2]+"</th><th id='th1'>"+totamt[3]+"</th><th id='th1'>"+totconc+"</th><th id='th1'>"+tottutfees+"</th><th id='th1'>"+totamt[4]+"</th><th id='th1'>"+totamt[5]+"</th><th id='th1'>"+totamt[6]+"</th><th id='th1'>"+totamt[7]+"</th><th id='th1'>"+totamt[8]+"</th><th id='th1'>"+totamt[9]+"</th><th id='th1'>"+totamt[10]+"</th><th id='th1'>"+totamt[11]+"</th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'></th><th id='th1'>"+totamt[12]+"</th><th id='th1'>"+totamt[1]+"</th><th id='th1'></th><th id='th1'></th></tr>");
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
var radioval=$('input[name=feestype]:checked').val();


window.location.href = "<?php echo Yii::app()->createUrl('site/Excelcollection'); ?>&datefrom="+datefrom+"&dateto="+dateto+"&radioval="+radioval;

/*var url="<?php echo Yii::app()->createUrl('site/Excelcollection'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'datefrom':datefrom,'dateto':dateto},
        success: function(data) {    
     console.log("succes"+data);
	 


 }



 }      
);*/
}



</script>




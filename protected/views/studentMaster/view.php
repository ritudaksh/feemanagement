
<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
  
  <?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'View',
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
<?php $date=date('d-m-Y')

?>

<div>
<table style="height:80px;width:280px">
<tr><th >Admission no:</th><td><?php echo $model->addmission_no; ?></td></tr>
<tr><th >Student name:</th><td><?php echo $model->student_name; ?></td></tr>
<tr><th >Father name:</th><td><?php echo $model->father_name; ?></td></tr>


</table>
</div>
<div>

<table id="feestable"  style="width:780px;border:2px solid white;" >
<tbody>
<tr>


<th id="th1">Fees paid for months</th>
<th id="th1">Annual fees</th>
<th id="th1">Tution fees</th>
<th id="th1">Concession applied</th>
<th id="th1">Fund fees</th>
<th id="th1">Sports fees</th>
<th id="th1">Activity fees</th>
<th id="th1">Admission fees</th>
<th id="th1">Security fees</th>
<th id="th1">Late fees</th>
<th id="th1">Dayboarding fees</th>
<th id="th1">Bus fees</th>
<th id="th1">Payment date</th>
<th id="th1">Payment mode</th>
<th id="th1">Cheque no.</th>
<th id="th1">Bank name</th>
<th id="th1">Total amount</th>
<th id="th1">Amount paid</th>
</tr>





</tbody>
</table>

</div>

<script>
$(document).ready(function () {
   
	 var stufees = "<?php echo $feedetails; ?>";
	 
     var h = stufees.split('&');

for(var i=0;i<h.length-1;i++){
var s=h[i].split('!');

//$("#feestable").append("<tr><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td id='td1'>"+s[8]+"</td><td id='td1'>"+s[9]+"</td><td id='td1'>"+s[10]+"</td><td id='td1'>"+s[11]+"</td id='td1'></tr>");


var pd = s[13].replace(/(\d*)-(\d*)-(\d*)/,'$3-$2-$1');
$("#feestable").append("<tr><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[17]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td>"+s[8]+"</td><td id='td1'>"+s[9]+"</td><td id='td1'>"+s[10]+"</td><td id='td1'>"+s[11]+"</td><td id='td1'>"+pd+"</td><td id='td1'>"+s[14]+"</td><td id='td1'>"+s[15]+"</td><td id='td1'>"+s[16]+"</td><td id='td1'>"+s[18]+"</td><td id='td1'>"+s[12]+"</td></tr>");

} 
  
  
  
  });

</script>













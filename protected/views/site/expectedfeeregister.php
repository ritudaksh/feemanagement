<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">

<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
  'fee account register',
);
?>

<style>
  #finalreptable {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
  width:790px;
  margin-left:50px;
  border:2px solid white;
    
}
#finalreptable #td1, #finalreptable #th1 {
    font-size: 1em;
    border: 1px solid white;
    padding: 3px 7px 2px 7px;
    
}
#finalreptable #th1 {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color:#76ACC7;
    color: #ffffff;
  
}
#finalreptable tr.alt #td1 {
    color: #000000;
    background-color:#CEE1EB;
}
</style>





<table style="width:400px;margin-left:80px;">
<tr>

<th>
Select year:
</th>
<td>
<select  id="year" name="year">
<option id="" value="">Please select a year</option>

<?php 
$year=date('Y')+1;
for($i=$year;$i>=2014;$i--){ ?>

  <option id="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>

<?php } ?>

</select></td>

<th><input type="button" value="Export to excel" name="excelbtn" id="excelbtn" onclick="generateexcel()"/></th>
</tr>

</table>




<br>
<div id="reporttable">


</div>
 <script type="text/javascript">

function generateexcel(){
var year = $('#year').val();
if(year==""){
alert("please select year fields");
}
else {
window.location.href = "<?php echo Yii::app()->createUrl('site/expectedfeeexcel'); ?>&year="+year;
}
  
  
}



</script>






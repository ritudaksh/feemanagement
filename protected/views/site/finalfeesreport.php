<script type="text/javascript" src="./js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">

<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'finalfeesreport',
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

<th>Select report type:</th>
<td><select id="reporttype" name="reporttype">
<option id="" value="">Please select a report type</option>
<option id="sum" value="summaryreport">Summary report</option>
<option id="act" value="actualreport">Actual report</option>

</select></td>
</tr>
</table>





<table style="width:610px;margin-left:80px;">
<tr>
<th>
Select year:
</th>
<td>
<select  id="year" name="year">
<option id="" value="">Please select a year</option>

<?php 
$year=date('Y')+1;
for($i=$year;$i>=2000;$i--){ ?>

	<option id="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $i; ?></option>

<?php } ?>

</select></td>

<th><input type="button" name="btn" value="Search" id="btn" onclick="showdata()"/></th>
<th><input type="button" value="Export to excel" name="excelbtn" id="excelbtn" onclick="generateexcel()"/></th>
</tr>

</table>





<br>
<div id="reporttable">

<!--<table id="tbl1">
  <tr>
    <td>Name</td>
    <td>Birthday</td>
    <td>Amount</td>
    <td>Rebate (10%)</td>
  </tr>
  <tr>
    <td>Smith</td>
    <td data-type="DateTime" data-style="Date" data-value="1980-03-23">Mar 23 1980</td>
    <td data-type="Number" data-style="Currency" data-value="1234.56">$ 1,234.56</td>
    <td data-formula="=RC[-1]/10" data-type="Number" data-style="Currency">$ 123.45</td>
  </tr>
  <tr>
    <td>Doe</td>
    <td data-type="DateTime" data-style="Date" data-value="1978-11-05">Nov 05 1978</td>
    <td data-type="Number" data-style="Currency" data-value="2345.67">$ 2,345.67</td>
    <td data-formula="=RC[-1]/10" data-type="Number" data-style="Currency">$ 234.56</td>
  </tr>
</table>
<hr>
<table id="tbl2">
  <tr>
    <td>Product</td>
    <td>Price</td>
    <td>Available</td>
    <td>Count</td>
  </tr>
  <tr>
    <td>Bred</td>
    <td data-type="Number" data-style="Currency" data-value="1.89">$ 1.89</td>
    <td data-type="Boolean" data-value="1">yes</td>
    <td data-type="Number" data-value="123">123</td>
  </tr>
  <tr>
    <td>Butter</td>
    <td data-type="Number" data-style="Currency" data-value=".89">$ .89</td>
    <td data-type="Boolean" data-value="0">no</td>
    <td data-type="Number" data-value="0">0</td>
  </tr>
</table>


<button  onclick="tablesToExcel(['tbl1','tbl2'], ['Customers','Products'], 'TestBook.xls', 'Excel')">Export to Excel</button>
-->

</div>
 <script type="text/javascript">
                   

                    $("#btn").click(function() {
                        $("#btn").attr("disabled", true);
                        
                    });
					
					
					$('#reporttype').change(function(){
					
					
					if(document.getElementById('reporttype').value=="detailedreport" || document.getElementById('reporttype').value=="actualreport"){
                     document.getElementById("btn").disabled = true;
					 document.getElementById("reporttable").innerHTML = "";

					}
					else{
                    document.getElementById("btn").disabled = false;
					}
					});
					
					$('#year').change(function(){
					
					if(document.getElementById('reporttype').value=="detailedreport" || document.getElementById('reporttype').value=="actualreport"){
                     document.getElementById("btn").disabled = true;
					 document.getElementById("reporttable").innerHTML = "";

					}
					else{
					$("#btn").attr("disabled", false);
					document.getElementById("reporttable").innerHTML = "";
                    }

					});
					
					
					
    </script>




<script>
function showdata(){

var reporttype = $('#reporttype').val();
var year = $('#year').val();
/*var month="";
if(reporttype=="detailedreport"){
month=document.getElementById('month').value;
}*/


if(reporttype=="" || year==""){
alert("please fill all fields");
}
else{
var url="<?php echo Yii::app()->createUrl('site/calfeesreport'); ?>";
$.ajax({
 type: "GET",
        url:url,
        data: {'reporttype':reporttype,'year':year},
        success: function(data) {    
       // console.log("succes"+data);
		
				
		
		
		if(reporttype=="summaryreport"){


document.getElementById("excelbtn").disabled = false;

$('#reporttable').append('<table id="finalreptable"><tr><th id="th1" >Class</th><th id="th1" >Annual fees</th><th id="th1" >Tution fees</th><th id="th1" >Funds fees</th><th id="th1" >Sports fees</th><th id="th1" >Activity fees</th><th id="th1" >Admission fees</th><th id="th1" >Security fees</th><th id="th1" >Late fees</th><th id="th1" >Dayboarding fees</th><th id="th1" >Bus fees</th><th id="th1" >Total fees</th><th id="th1" >Amount paid after concession</th></tr></table>');

var data1 = data.split('$');
var annual=0;
var tution=0;
var funds=0;
var sports=0;
var actfees=0;
var admfees=0;
var secfees=0;
var latefees=0;
var dayboarding=0;
var busfees=0;
var totamt=0;
var amtpaid=0;



for(var i=0;i<data1.length-1;i++){
var s = data1[i].split(',');

 annual+= +s[1];
 tution += +s[2];
 funds += +s[3];
 sports += +s[4];
 actfees += +s[5];
 admfees += +s[6];
 secfees += +s[7];
 latefees += +s[8];
 dayboarding += +s[9];
 busfees += +s[10];
 totamt += +s[11];
 amtpaid += +s[12];




$("#finalreptable").append("<tr><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td id='td1'>"+s[8]+"</td><td id='td1'>"+s[9]+"</td><td id='td1'>"+s[10]+"</td><td id='td1'>"+s[11]+"</td><td id='td1'>"+s[12]+"</td></tr>");

}


$("#finalreptable").append("<tr><th id='th1'>Total</th><th id='th1'>"+annual+"</th><th id='th1'>"+tution+"</th><th id='th1'>"+funds+"</th><th id='th1'>"+sports+"</th><th id='th1'>"+actfees+"</th><th id='th1'>"+admfees+"</th><th id='th1'>"+secfees+"</th><th id='th1'>"+latefees+"</th><th id='th1'>"+dayboarding+"</th><th id='th1'>"+busfees+"</th><th id='th1'>"+totamt+"</th><th id='th1'>"+amtpaid+"</th></tr>");

 }
 
else if(reporttype=="detailedreport" || reporttype=="actualreport"){
    
 
 document.getElementById("excelbtn").disabled = false;
/* 
var conc=data.split('*');
var ct=conc[1];

var conctyps=ct.split('%');
var q=conctyps[0].split('#');
var tab='';
var tab1='';
for(var c=0; c<=q.length-1; c++){
tab+='<th id="th1">'+q[c]+'</th>';
tab1+='<th id="th1"></th>';

}

$('#reporttable').append('<table id="finalreptable"><tr><th id="th1">Class</th><th id="th1">No. of student</th><th id="th1">Admissions</th><th id="th1">Left students</th><th id="th1">No concession</th>'+tab+'<th id="th1" >Annual fees</th><th id="th1" >Tution fees</th><th id="th1" >Funds fees</th><th id="th1" >Sports fees</th><th id="th1" >Activity fees</th><th id="th1" >Admission fees</th><th id="th1" >Security fees</th><th id="th1">Dayboarding fees</th><th id="th1" >Total fees</th></tr></table>');



var data1 = conc[0].split('^');
var det=data1[0];

var totstu=0;
var annual=0;
var tution=0;
var funds=0;
var sports=0;
var actfees=0;
var admfees=0;
var secfees=0;
var latefees=0;
var dayboarding=0;
var busfees=0;
var totamt=0;
var amtpaid=0;
var totadm=0;
var left=0;

var da = conc[0].split('$');

for(var i=0;i<da.length-1;i++){
var s = da[i].split(',');

 //check if number of admissions are not zero
 if(s[12]!=0){
 s[11]=s[12]*s[11];
 }
 
 totstu+= +s[1];
 annual+= +s[3];
 tution += +s[4];
 funds += +s[5];
 sports += +s[6];
 actfees += +s[7];
 admfees += +s[8];
 secfees += +s[9];
 dayboarding += +s[10];
 totamt += +s[11];
 totadm += +s[12];
 left += +s[13];
 
 
var conctyps=data1[1].split('!');

var c='';
var k = conctyps[i].split('@');
for(var z=0;z<=k.length-2;z++){
c+='<td id="td1">'+k[z]+'</td>';
}


//$("#finalreptable").append("<tr><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[2]+"</td><td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td id='td1'>"+s[8]+"</td><td id='td1'>"+s[9]+"</td><td id='td1'>"+s[10]+"</td><td id='td1'>"+s[11]+"</td><td id='td1'>"+s[12]+"</td><td id='td1'>"+s[13]+"</td></tr>");

$("#finalreptable").append("<tr><td id='td1'>"+s[0]+"</td><td id='td1'>"+s[1]+"</td><td id='td1'>"+s[12]+"</td><td id='td1'>"+s[13]+"</td><td id='td1'>"+s[2]+"</td>"+c+"<td id='td1'>"+s[3]+"</td><td id='td1'>"+s[4]+"</td><td id='td1'>"+s[5]+"</td><td id='td1'>"+s[6]+"</td><td id='td1'>"+s[7]+"</td><td id='td1'>"+s[8]+"</td><td id='td1'>"+s[9]+"</td><td id='td1'>"+s[10]+"</td><td id='td1'>"+s[11]+"</td></tr>");

}

$("#finalreptable").append("<tr><th id='th1'>Total</th><th id='th1'>"+totstu+"</th><th id='th1'>"+totadm+"</th><th id='th1'>"+left+"</th><th id='th1'></th>"+tab1+"<th id='th1'>"+annual+"</th><th id='th1'>"+tution+"</th><th id='th1'>"+funds+"</th><th id='th1'>"+sports+"</th><th id='th1'>"+actfees+"</th><th id='th1'>"+admfees+"</th><th id='th1'>"+secfees+"</th><th id='th1'>"+dayboarding+"</th><th id='th1'>"+totamt+"</th></tr>");

*/
}
 
 
 }
 
 
 });
 }
 }


function generateexcel(){
var reporttype = $('#reporttype').val();
var year = $('#year').val();



window.location.href = "<?php echo Yii::app()->createUrl('site/feesexcel'); ?>&reporttype="+reporttype+"&year="+year;
    
/*generating excel code*/	
	//var data=$('#reporttable').html();
    //window.open('data:application/vnd.ms-excel,' + encodeURIComponent(data));
	
	
}

//code for generating excel directly from html content:

  /* var tablesToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , tmplWorkbookXML = '<?xml version="1.0"?><?mso-application progid="Excel.Sheet"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">'
      + '<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office"><Author>Axel Richter</Author><Created>{created}</Created></DocumentProperties>'
      + '<Styles>'
      + '<Style ss:ID="Currency"><NumberFormat ss:Format="Currency"></NumberFormat></Style>'
      + '<Style ss:ID="Date"><NumberFormat ss:Format="Medium Date"></NumberFormat></Style>'
      + '</Styles>' 
      + '{worksheets}</Workbook>'
    , tmplWorksheetXML = '<Worksheet ss:Name="{nameWS}"><Table>{rows}</Table></Worksheet>'
    , tmplCellXML = '<Cell{attributeStyleID}{attributeFormula}><Data ss:Type="{nameType}">{data}</Data></Cell>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(tables, wsnames, wbname, appname) {
      var ctx = "";
      var workbookXML = "";
      var worksheetsXML = "";
      var rowsXML = "";

      for (var i = 0; i < tables.length; i++) {
        if (!tables[i].nodeType) tables[i] = document.getElementById(tables[i]);
        for (var j = 0; j < tables[i].rows.length; j++) {
          rowsXML += '<Row>'
          for (var k = 0; k < tables[i].rows[j].cells.length; k++) {
            var dataType = tables[i].rows[j].cells[k].getAttribute("data-type");
            var dataStyle = tables[i].rows[j].cells[k].getAttribute("data-style");
            var dataValue = tables[i].rows[j].cells[k].getAttribute("data-value");
            dataValue = (dataValue)?dataValue:tables[i].rows[j].cells[k].innerHTML;
            var dataFormula = tables[i].rows[j].cells[k].getAttribute("data-formula");
            dataFormula = (dataFormula)?dataFormula:(appname=='Calc' && dataType=='DateTime')?dataValue:null;
            ctx = {  attributeStyleID: (dataStyle=='Currency' || dataStyle=='Date')?' ss:StyleID="'+dataStyle+'"':''
                   , nameType: (dataType=='Number' || dataType=='DateTime' || dataType=='Boolean' || dataType=='Error')?dataType:'String'
                   , data: (dataFormula)?'':dataValue
                   , attributeFormula: (dataFormula)?' ss:Formula="'+dataFormula+'"':''
                  };
            rowsXML += format(tmplCellXML, ctx);
          }
          rowsXML += '</Row>'
        }
        ctx = {rows: rowsXML, nameWS: wsnames[i] || 'Sheet' + i};
        worksheetsXML += format(tmplWorksheetXML, ctx);
        rowsXML = "";
      }

      ctx = {created: (new Date()).getTime(), worksheets: worksheetsXML};
      workbookXML = format(tmplWorkbookXML, ctx);

console.log(workbookXML);

      var link = document.createElement("A");
      link.href = uri + base64(workbookXML);
      link.download = wbname || 'Workbook.xls';
      link.target = '_blank';
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  })();*/



</script>






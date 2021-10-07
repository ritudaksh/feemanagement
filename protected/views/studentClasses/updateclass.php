<?php 
//$conn = mysqli_connect("localhost", "root", "root", "fees_management");
$link = mysql_connect("localhost", "root", "root");
mysql_select_db("fees_management", $link);

$qry = "select * from student_master";
$result = mysql_query($qry, $link);

		

$row = mysql_fetch_array($result);
			
while($row=mysql_fetch_array($result)){
 

$studentid=( $row['student_id']);

$query1="select * from student_classes where student_id=".$studentid. " order by started_on DESC limit 1" ;
 $result1 = mysql_query($query1, $link);

while($row1=mysql_fetch_array($result1)){
 
	
 $added_on=$row1['started_on'];

 date_default_timezone_set('Australia/Melbourne');
$date = date('Y-m-d', time());//2015-03-11

$date1=date_create($date);
$date2=date_create($added_on);

$diff=date_diff($date1,$date2);


if($diff->format("%a")!='712'){
	
	$classon=( $row1['class_no']+1);


//

//INSERT INTO student_classes (student_id, class_no, `section`,`started_on`,`ended_on`)
//VALUES ($row1['student_id'], $classon, $row1['section'],$row1['started_on'],$row1['ended_on'])
//$query2=" insert into  student_classes  class_on=".$classon ;
	$query2="INSERT INTO student_classes (student_id, class_no, `section`,`started_on`,`ended_on`)
VALUES ('".$row1['student_id']."','". $classon."',' ". $row1['section']."','".$row1['started_on']."',' ".$row1['ended_on']."')";
	
	//echo "111";
	if (mysql_query($query2, $link)) {
    //echo "New record created successfully";
	} else {
   // echo "Error: " . $query2 . "<br>" . mysqli_error($link);
	}
	
	$query3="UPDATE student_classes SET class_no=".$classon." WHERE student_id=".$studentid;
	// $result3 = mysql_query($query3, $link);
	print_r($query3);
	if (mysql_query($query3, $link)) {
    echo "New record updated successfully";
	} else {
    echo "Error: " . $query3 . "<br>" . mysqli_error($link);
	}
}
}
 }


?>

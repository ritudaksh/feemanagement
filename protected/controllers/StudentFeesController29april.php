<?php

class StudentFeesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','search','Details','Resetfees','Previousfees','Payfees','Calculatefees','Prevfeesupdate'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate()
	{
		$model=new StudentFees;	
        

$query="SELECT a.*, m.an, m.tu,m.fu,m.sp,m.ad,m.se,m.da,b.bu,c.cp,l.lf FROM student_master a
LEFT JOIN (select class_no,annual_fees as an, tuition_fees as tu , funds_fees as fu, sports_fees as sp,admission_fees as ad, security_fees as se,dayboarding_fees as da from  fees_master) as m ON (m.class_no = a.class )  LEFT JOIN (select concession_id,concession_type,concession_persent as cp from concession_master) as c ON (a.student_concessiontype=c.concession_type) LEFT JOIN(select route , destination,bus_fees as bu from busfees_master) as b ON(a.city=b.destination) LEFT JOIN(select days_from,days_to,latefee as lf from latefee_master) as l ON(20 BETWEEN days_from  AND days_to) WHERE a.student_name ='preeti' and a.class='2' and a.addmission_no='1'";
		
              if(isset($_POST['StudentFees']))
		{
			$model->attributes=$_POST['StudentFees'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->student_fee_id));
		}
                $query1=Yii::app()->db->createCommand($query)->queryAll();
          
		$this->render('create',array(
			'model'=>$model,'query1'=>$query1
		));
	}*/


public function actionCreate()
	{           
	            $count=0;
                $query=null;
                $model=new StudentFees;	
                $today=date("Y-m-d");
	            $fees="b";
                $m="as";
				$contyp="";
               if(isset($_POST['StudentFees']))
		      {

	         $model->attributes=$_POST['StudentFees'];
           
                 if(isset($_POST['paymentmode'])){
                     $model->payment_mode=$_POST['paymentmode'];

                        }
                 if(isset($_POST['paymentdate']))
                $paydate = $_POST['paymentdate'];
                $originalDate = $paydate;
                $newDate = date("Y-m-d", strtotime($originalDate));
                $model->date_payment=$newDate;
		{ 
               //$model->birth_date=$_POST['birthdate'];   
        	}
						if(isset($_POST['stuid'])){
                     $model->student_id=$_POST['stuid'];
                        }
						 if(isset($_POST['stuname'])){
                     $model->student_name=$_POST['stuname'];
                        }
						 if(isset($_POST['fathername'])){
                     $model->fathers_name=$_POST['fathername'];
                        }
						
						
						
						
						 if(isset($_POST['stusec'])){
                     $model->section=$_POST['stusec'];
                        }
                 if(isset($_POST['monthfees'])){
                     $model->fees_for_months=$_POST['monthfees'];
                        }
						 if(isset($_POST['payfeesmonth'])){
						 
                     $model->fees_period_month=implode(', ',$_POST['payfeesmonth'] );
                        }
                 if(isset($_POST['totamt'])){
                     $model->Total_amount=$_POST['totamt'];
                        }
                 if(isset($_POST['amtpaid'])){
                     $model->amount_paid=$_POST['amtpaid'];
                        }
                
				if(isset($_POST['concessiontype'])){
	$sql="select * from concession_master where concession_type='".$_POST['concessiontype']."'";
	  $query=Yii::app()->db->createCommand($sql)->queryRow();
                     $model->concession_type_id=$query['concession_id'];
                        }
		if(isset($_POST['concession'])){
                     $model->concession_applied=$_POST['concession'];
                        }
						if(isset($_POST['bankname'])){
                     $model->bank_name=$_POST['bankname'];
                        }
						if(isset($_POST['cheqno'])){
                     $model->cheq_no=$_POST['cheqno'];
                        }
						if(isset($_POST['busfees'])){
                     $model->bus_fees_paid=$_POST['busfees'];
                        }
						if(isset($_POST['dayboardfees'])){
                     $model->dayboarding_fees_paid=$_POST['dayboardfees'];
                        }
						if(isset($_POST['latefees'])){
                     $model->late_fees_paid=$_POST['latefees'];
                        }
						if(isset($_POST['securityfees'])){
                     $model->security_paid=$_POST['securityfees'];
                        }
						if(isset($_POST['admfees'])){
                     $model->admission_fees_paid=$_POST['admfees'];
                        }
						if(isset($_POST['activityfees'])){
                     $model->activity_fees=$_POST['activityfees'];
                        }
						if(isset($_POST['sportsfees'])){
                     $model->sports_fees_paid=$_POST['sportsfees'];
                        }
						if(isset($_POST['fundfees'])){
                     $model->funds_fees_paid=$_POST['fundfees'];
                        }
						if(isset($_POST['tutionfees'])){
                     $model->tuition_fees_paid=$_POST['tutionfees'];
                        }
						if(isset($_POST['annualfees'])){
                     $model->annual_fees_paid=$_POST['annualfees'];
                        }
                       if(isset($_POST['isdefault'])){
                     $model->isdefault=$_POST['isdefault'];
                        }
			/*$sql="select * from student_fees where student_id='".$_POST['stuid']."' and fees_for_months='".$_POST['']."'";	
			$query=Yii::app()->db->createCommand($sql)->queryAll();	
            foreach(){
			}*/
			
                
			if($model->save())
				$this->redirect(array('admin','id'=>$model->student_fee_id));
		}

   
   
    $this->render('create',array('model'=>$model,'fees'=>$fees,'m'=>$m,'contyp'=>$contyp,));       
          
	
}

public function actionSearch($name=null,$class1=null,$admission=null,$section=null)
	{      
                $query=null;
                $model=new StudentFees;	
               
		
/*if($name!="" || $admission!=""){
$query="select * from student_master where";
if($name!="")
$query=$query." student_name LIKE '".$name."%'  OR";
$query=$query." addmission_no='".$admission."'";
}
else{
$query="select sc.student_id,sm.student_name from student_classes sc LEFT JOIN(select student_id as student_id , student_name as student_name from student_master)as sm ON(sm.student_id=sc.student_id) where class_no='".$class1."' OR section='".$section."'";
}*/

$query="select   DISTINCT  a.student_id, a.student_name   from student_master a 
LEFT JOIN  student_classes 
sc ON(a.student_id=sc.student_id) where 1=1 ";
$tmpI=0;
if($admission!=""){
$query=$query."  and a.addmission_no ='".$admission."'";
}
if($class1!=""){
	$query=$query." and sc.class_no='".$class1."'";
	}
if($section!=""){
	$query=$query." and sc.section='".$section."'";
	}

if($name!=""){
	$query=$query." and a.student_name LIKE '".$name."%'"; 
}


$query1=Yii::app()->db->createCommand($query)->queryAll();
$q = "";

foreach($query1 as $h)
{
$sql="SELECT * from  student_classes as cls 
 where cls.student_class_id = (select max(student_class_id) 
from student_classes where student_id = '".$h['student_id']."')"; 
if($class1!=""){
	$sql=$sql." and cls.class_no='".$class1."'"; 
}

$querycls=Yii::app()->db->createCommand($sql)->queryAll();
foreach($querycls as $c)
{
$q .= $h['student_id']."$".$h['student_name'].":".$c['class_no'].",";
}}
echo $q;
}


public function actionDetails($id)
	{      
                $query=null;
                $model=new StudentFees;	
                $today=date("Y-m-d");
                $date=explode("-",$today);
				
		
$query1="SELECT  max(student_class_id) FROM student_classes where student_id='".$id."'";
$query2=Yii::app()->db->createCommand($query1)->queryAll();
	foreach($query2 as $row1){
	$stuclsid=$row1['max(student_class_id)'];
	
	}	
	
	
	$query3="select class_no,section from student_classes where student_class_id='".$stuclsid."'";
    $query4=Yii::app()->db->createCommand($query3)->queryAll();
	foreach($query4 as $row2){
	$section=$row2['section'];
	$stucls=$row2['class_no'];
	}		
		
		$query5="select addmission_no,student_id,student_name,father_name from student_master where student_id='".$id."'";
$query6=Yii::app()->db->createCommand($query5)->queryAll();
	foreach($query6 as $row3){
	$stuname=$row3['student_name'];
	$stuid=$row3['student_id'];
	$stufather=$row3['father_name'];
	$stuadm=$row3['addmission_no'];
	}	
		
		
  $details=$stuid."$".$stucls."$".$stuname."$".$section."$".$stufather."$".$stuadm;	
	
/*$query2="SELECT a.* ,max(c.cl),c.se FROM student_master a
 LEFT JOIN(select student_id , class_no as cl,section as se from student_classes) as c ON(a.student_id=c.student_id) WHERE a.student_id ='".$id."'";
$query3=Yii::app()->db->createCommand($query2)->queryAll();

foreach($query3 as $d)
{

$details=$d['student_id']."-".$d['max(c.cl)']."-".$d['student_name']."-".$d['se'];

}*/

/*$maxcls="";
$sql="select max(class_no) from student_classes where student_id='".$id."'";
$sql1=Yii::app()->db->createCommand($sql)->queryAll();
foreach($sql1 as $c){
$maxcls=$c['max(class_no)'];
}

$fees="select * from student_fees where student_id='".$id."' and student_class_id='".$maxcls."'";



$feesdata=Yii::app()->db->createCommand($fees)->queryAll();

$a="";
 foreach($feesdata as $rowdata){
		 $a=$a.$rowdata['fees_for_months'].'-'.$rowdata['fees_period_month'].'$';
		 }
     

echo $details."&".$a;*/

echo $details;

}
public function actionResetfees($id=null)
	{      
                $query2=null;
                $model=new StudentFees;	
                $today=date("Y-m-d");
				$date=explode("-",$today);
		
/*$query2="SELECT a.*, m.an, m.tu,m.fu,m.sp,m.af,m.ad,m.se,m.da,b.bu,c.cp,c.ct,c.ca FROM student_master a
LEFT JOIN (select class_no,annual_fees as an, tuition_fees as tu , funds_fees as fu, sports_fees as sp,activity_fees as af,
admission_fees as ad, security_fees as se,dayboarding_fees as da from  fees_master) as m ON (m.class_no = a.class )  
LEFT JOIN (select concession_id,concession_type as ct,concession_persent as cp, concession_amount as ca from 
concession_master) as c ON (a.student_concessiontype=c.ct) LEFT JOIN(select route , destination,internal,bus_fees 
as bu from busfees_master) as b ON(a.bus_destination=b.destination)  WHERE a.student_id ='".$id."'";
*/
$query2="SELECT a.*, m.an, m.tu,m.fu,m.sp,m.af,m.ad,m.se,m.da,b.bu,c.cp,c.ct,c.ca FROM student_master a
LEFT JOIN(select student_id,class_no as cls,section as sec from student_classes) as sc ON(sc.student_id=a.student_id)
LEFT JOIN (select class_no,annual_fees as an, tuition_fees as tu , funds_fees as fu, sports_fees as sp,activity_fees as af,
admission_fees as ad, security_fees as se,dayboarding_fees as da from  fees_master) as m ON (m.class_no = sc.cls )  
LEFT JOIN (select concession_id,concession_type as ct,concession_persent as cp, concession_amount as ca from 
concession_master) as c ON (a.student_concessiontype=c.ct) LEFT JOIN(select route , destination,internal,bus_fees 
as bu from busfees_master) as b ON(a.bus_destination=b.destination) WHERE a.student_id ='".$id."'";

$query3=Yii::app()->db->createCommand($query2)->queryAll();

foreach($query3 as $d)
{

//$details= $d['student_id']."-".$d['class']."-".$d['an']."-".$d['tu']."-".$d['fu']."-".$d['sp']."-".$d['ad']."-".$d['se']."-".$d['da']."-".$d['bu']."-".$d['cp']."-".$d['ct']."-".$d['af']."-".$d['student_name']."-".$d['section']."-".$d['ca'];

$details= $d['an']."-".$d['tu']."-".$d['fu']."-".$d['sp']."-".$d['ad']."-".$d['se']."-".$d['da']."-".$d['bu']."-".$d['cp']."-".$d['ct']."-".$d['af']."-".$d['ca'];

}



//$fees="select * from student_fees where student_id='".$id."'";
//$feesdata=Yii::app()->db->createCommand($fees)->queryAll();

//$a="";
 //foreach($feesdata as $rowdata){
		// $a=$a.$rowdata['fees_for_months'].'-'.$rowdata['fees_period_month'].'$';
		// }
     
//echo $details."&".$a;
echo $details;

}

public function actionPreviousfees($sid=null){

$maxclasid="";
$sql1="select max(student_class_id) from student_classes where student_id='".$sid."'";
$sql2=Yii::app()->db->createCommand($sql1)->queryAll();
foreach($sql2 as $c2){
$maxclasid=$c2['max(student_class_id)'];
}

$currentclas="";
$sql2="select class_no from student_classes where student_class_id='".$maxclasid."'";
$sql3=Yii::app()->db->createCommand($sql2)->queryAll();
foreach($sql3 as $c3){
$currentclas=$c3['class_no'];
}



$querystfees="select * from student_fees where student_id='".$sid."' and student_class_id='".$currentclas."'";
//$querystfees="select * from student_fees where student_id='".$sid."'";
$stfees=Yii::app()->db->createCommand($querystfees)->queryAll();

$a="";
 foreach($stfees as $row){
		 $a=$a.$row['fees_for_months'].'$'.$row['date_payment'].'$'.$row['amount_paid'].'$'.$row['fees_period_month'].'&';
		 }
        echo $a;
}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $fees="a";
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	  /* $maxcls="";
       $sql="select max(student_class_id),student_id from student_fees where student_fee_id='".$id."'";
       $sql1=Yii::app()->db->createCommand($sql)->queryAll();
       foreach($sql1 as $c){
       $maxcls=$c['max(student_class_id)'];
	   $stuid=$c['student_id'];
        }*/
	
         $sql="select * from student_fees where student_fee_id='".$id."'";
		 $query=Yii::app()->db->createCommand($sql)->queryRow();
		 $m= $query['fees_period_month'].'-'.$query['fees_for_months'].'-'.$query['student_id'];
		$sid=$query['student_id'];
		
	$sql1="select co.typ from student_fees a LEFT JOIN (select concession_id as id,
concession_type as typ	from concession_master)as co ON(a.concession_type_id=co.id) where student_fee_id='".$id."'";
	$query1=Yii::app()->db->createCommand($sql1)->queryRow();
     $contyp=$query1['typ'];	
	
	
		if(isset($_POST['StudentFees']))
		{
		
		
						  if(isset($_POST['paymentmode'])){
                     $model->payment_mode=$_POST['paymentmode'];

                        }
                  if(isset($_POST['paymentdate']))
                $paydate = $_POST['paymentdate'];
                $originalDate = $paydate;
                $newDate = date("Y-m-d", strtotime($originalDate));
                $model->date_payment=$newDate;
		{ 
               //$model->birth_date=$_POST['birthdate'];   
        	}
		 if(isset($_POST['stuname'])){
                     $model->student_name=$_POST['stuname'];
                        }
						
						
						
						 if(isset($_POST['stusec'])){
                     $model->section=$_POST['stusec'];
                        }
                 if(isset($_POST['monthfees'])){
                     $model->fees_for_months=$_POST['monthfees'];
                        }
                     if(isset($_POST['payfeesmonth'])){
						 
                     $model->fees_period_month=implode(', ',$_POST['payfeesmonth'] );
					
                        }
                 if(isset($_POST['totamt'])){
                     $model->Total_amount=$_POST['totamt'];
                        }
                 if(isset($_POST['amtpaid'])){
                     $model->amount_paid=$_POST['amtpaid'];
                        }
						
						if(isset($_POST['concessiontype'])){
                     $model->concession_type_id=$_POST['concessiontype'];
                        }
		if(isset($_POST['concession'])){
                     $model->concession_applied=$_POST['concession'];
                        }
						if(isset($_POST['bankname'])){
                     $model->bank_name=$_POST['bankname'];
                        }
						if(isset($_POST['cheqno'])){
                     $model->cheq_no=$_POST['cheqno'];
                        }
						if(isset($_POST['busfees'])){
                     $model->bus_fees_paid=$_POST['busfees'];
                        }
						if(isset($_POST['dayboardfees'])){
                     $model->dayboarding_fees_paid=$_POST['dayboardfees'];
                        }
						if(isset($_POST['latefees'])){
                     $model->late_fees_paid=$_POST['latefees'];
                        }
						if(isset($_POST['securityfees'])){
                     $model->security_paid=$_POST['securityfees'];
                        }
						if(isset($_POST['admfees'])){
                     $model->admission_fees_paid=$_POST['admfees'];
                        }
						if(isset($_POST['activityfees'])){
                     $model->activity_fees=$_POST['activityfees'];
                        }
						if(isset($_POST['sportsfees'])){
                     $model->sports_fees_paid=$_POST['sportsfees'];
                        }
						if(isset($_POST['fundfees'])){
                     $model->funds_fees_paid=$_POST['fundfees'];
                        }
						if(isset($_POST['tutionfees'])){
                     $model->tuition_fees_paid=$_POST['tutionfees'];
                        }
						if(isset($_POST['annualfees'])){
                     $model->annual_fees_paid=$_POST['annualfees'];
                        }
					
		
			$model->attributes=$_POST['StudentFees'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->student_fee_id));
		}

		$this->render('update',array(
			'model'=>$model,'fees'=>$fees,'m'=>$m,'contyp'=>$contyp,
		));
	}

      public function actionPayfees($fm=null,$sid=null){
	   
	            $today=date("Y-m-d");
                $date=explode("-",$today);
	            
	   $q="select * from payment_schedule_master where fees_for_months='".$fm."'";
	  $query=Yii::app()->db->createCommand($q)->queryRow();
	   $data=$query['fees_for_months'].'$'.$query['pay_in_month'].'$'.$query['payment_date'];
	 
	     $paymentdate=$date['0'].'-'.$query['pay_in_month'].'-'.$query['payment_date'];
	     
		 
	  $now=strtotime($today);
     $your_date = strtotime($paymentdate);
     $datediff = $now- $your_date;
     $days=floor($datediff/(60*60*24));
	  // echo $data.','.$days;
	   
	
	    $q1="SELECT * FROM latefee_master WHERE days_from <= ".$days." AND days_to >=  ".$days."";
	    $query1=Yii::app()->db->createCommand($q1)->queryRow();
		$lf=$days*$query1['latefee'];
		
		
		$q2="SELECT a.*,c.cp,c.ct,c.ca FROM student_master a  
LEFT JOIN (select concession_id,concession_type as ct,concession_persent as cp, concession_amount as ca from 
concession_master) as c ON (a.student_concessiontype=c.ct) WHERE a.student_id ='".$sid."'";
      $query2=Yii::app()->db->createCommand($q2)->queryRow();
	

		
		
	    $detail=$data.'&'.$lf.'&'.$query2['cp'].'&'.$query2['ca'].'&';
		
		echo  $detail;
	  }
	
	
	public function actionCalculatefees($sid=null,$cls=null){
	
	
	/*$query2="SELECT a.*, m.an, m.tu,m.fu,m.sp,m.af,m.ad,m.se,m.da,b.bu,c.cp,c.ct,c.ca FROM student_master a
LEFT JOIN(select student_id,class_no as cls,section as sec from student_classes) as sc ON(sc.student_id=a.student_id)
LEFT JOIN (select class_no,annual_fees as an, tuition_fees as tu , funds_fees as fu, sports_fees as sp,activity_fees as af,
admission_fees as ad, security_fees as se,dayboarding_fees as da from  fees_master) as m ON (m.class_no = '".$cls."' )  
LEFT JOIN (select concession_id,concession_type as ct,concession_persent as cp, concession_amount as ca from 
concession_master) as c ON (a.student_concessiontype=c.ct) LEFT JOIN(select route , destination,internal,bus_fees 
as bu from busfees_master) as b ON(a.bus_destination=b.destination) WHERE a.student_id ='".$sid."'";
*/


$query2="SELECT a.*, m.an, m.tu,m.fu,m.sp,m.af,m.ad,m.se,m.da,b.bu,c.cp,c.ct,c.ca FROM student_master a
LEFT JOIN(select student_id,class_no as cls,section as sec , started_on as so  from student_classes) as sc ON(sc.student_id=a.student_id)
LEFT JOIN (select class_no,annual_fees as an, tuition_fees as tu , funds_fees as fu, sports_fees as sp,activity_fees as af,
admission_fees as ad, security_fees as se,dayboarding_fees as da,valid_from as vf , valid_to as vt from  fees_master) as m ON (m.class_no = '".$cls."' and sc.so between m.vf and m.vt)  
LEFT JOIN (select concession_id,concession_type as ct,concession_persent as cp, concession_amount as ca from 
concession_master) as c ON (a.student_concessiontype=c.ct) LEFT JOIN(select route , destination,internal,bus_fees 
as bu from busfees_master) as b ON(a.bus_destination=b.destination) WHERE a.student_id ='".$sid."'";


 $query3=Yii::app()->db->createCommand($query2)->queryAll();


   foreach($query3 as $d)
  {
  
$details= $d['an']."-".$d['tu']."-".$d['fu']."-".$d['sp']."-".$d['ad']."-".$d['se']."-".$d['da']."-".$d['bu']."-".$d['cp']."-".$d['ct']."-".$d['af']."-".$d['ca'];
}
   echo $details;
	
	}
	
	public function actionPrevfeesupdate($id=null){

$maxclasid="";
$sql1="select max(student_class_id) from student_classes where student_id='".$id."'";
$sql2=Yii::app()->db->createCommand($sql1)->queryAll();
foreach($sql2 as $c2){
$maxclasid=$c2['max(student_class_id)'];
}

$currentclas="";
$sql2="select class_no from student_classes where student_class_id='".$maxclasid."'";
$sql3=Yii::app()->db->createCommand($sql2)->queryAll();
foreach($sql3 as $c3){
$currentclas=$c3['class_no'];
}


$querystfees="select * from student_fees where student_id='".$id."' and student_class_id='".$currentclas."'";
//$querystfees="select * from student_fees where student_id='".$sid."'";
$stfees=Yii::app()->db->createCommand($querystfees)->queryAll();

$a="";
 foreach($stfees as $row){
		 $a=$a.$row['fees_for_months'].'$'.$row['date_payment'].'$'.$row['amount_paid'].'$'.$row['fees_period_month'].'&';
		 }
        echo $a;
}
	
	
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('StudentFees');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StudentFees('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StudentFees']))
			$model->attributes=$_GET['StudentFees'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StudentFees the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StudentFees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StudentFees $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='student-fees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

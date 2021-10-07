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
				'actions'=>array('create','update','search','Details','chequestatus','Resetfees','Previousfees','Payfees','Calculatefees','Prevfeesupdate'),
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
public function actionCreate()
{           
	       
	            $count=0;
                $query=null;
                $model=new StudentFees;	
                $today=date("Y-m-d");
	            $fees="b";
                $m="as";
				$contyp="";
				
            if(isset($_POST['yt0']))
		    {  //echo "<pre>"; print_r($_POST);die;
				$year= $_POST['year'];
				if(date('m')<'04'){
					$year= $_POST['year']-1;
				}
		// echo "selected year=".$year;die;
				 $montharray = $this->get_months_array($year);
				 $months = implode(",",$montharray);
				 $stuid = $_POST['stuid'];
				 $class = $_POST['cls'];
if(!empty($class))
{
				 $query = "select group_concat(trim(fees_period_month) order by fees_period_month+0)as months_paid from student_fees where student_id=".$stuid." AND student_class =".$class." AND year=".$year;
	
}
else {
 $query = "select group_concat(trim(fees_period_month) order by fees_period_month+0)as months_paid from student_fees where student_id=".$stuid." AND student_class ='' AND year=".$year; 
}
			
				 $query1=Yii::app()->db->createCommand($query)->queryAll();
			//echo "<pre>";print_r($query1);die;
				 foreach($query1 as $row1){
					 $mp=$row1['months_paid'];
				 }	
				$mp2 =array_map('trim', explode(',', $mp));
				$tmp = array_diff($montharray,$mp2);
				$tmpval  = implode(",",$tmp);
				$alert_message = '';
				if($tmpval!=0)
			    {  
					$alert_message = 'fee pending for '.$tmpval.' month ';
					echo $alert_message;
				}
                if(isset($_POST['paymentmode'])){
                $model->payment_mode=$_POST['paymentmode'];
		//if cheque, set to open
				if($model->payment_mode=='Cheque' && empty($model->cheque_status)){
				   $model->cheque_status='Open';
				}
            }
				
            if(isset($_POST['paymentdate'])){
                $paydate = $_POST['paymentdate'];
                $newDate = date("Y-m-d", strtotime($paydate));
                $model->date_payment=$newDate;
			}
			//if not cheque, set realized date to payment_date
			if($model->payment_mode!='Cheque'){
			   $model->realized_date=$model->date_payment;
			}
		
				if(isset($_POST['entrydate'])){
				$entrydate = $_POST['entrydate'];
				$newentrydate = date("Y-m-d", strtotime($entrydate));
				$model->entry_date=$newentrydate;
				}
		
				if(isset($_POST['stuid'])){
                $model->student_id=$_POST['stuid'];
				$sqlbusid="select * from student_master where student_id='".$_POST['stuid']."'";
	            $querybusid=Yii::app()->db->createCommand($sqlbusid)->queryRow();
				if($querybusid !=null && isset($querybusid) && $querybusid['bus_id']>0){
				        $model->bus_id=$querybusid['bus_id'];
				}
	                }
						
				if(isset($_POST['student_class'])){
                $model->student_class=$_POST['student_class'];
                }
				if(isset($_POST['student_section'])){
                $model->student_section=$_POST['student_section'];
                }
				
                if(isset($_POST['monthfees'])){
                $model->fees_for_months=$_POST['monthfees'];
                }
				if(isset($_POST['payfeesmonth'])){	 
                $model->fees_period_month=implode(', ',$_POST['payfeesmonth'] );
                }
				if(isset($_POST['year'])){	 
                $model->year=$_POST['year'];
                }
                if(isset($_POST['totamt'])){
                $model->Total_amount=$_POST['totamt'];
                }
                if(isset($_POST['amtpaid'])){
                $model->amount_paid=$_POST['amtpaid'];
                }
//get concesstion type if concession > 0
                if(isset($_POST['concession']) && $_POST['concession']>0){
			$model->concession_applied=$_POST['concession'];
	        	$model->concession_type_id=$_POST['concessiontypeid'];
	        }
		else{
	        	$model->concession_type_id=null;
//set type also to null
			$model->concession_applied=null;

		}				
						if(isset($_POST['bankname'])){
                        $model->bank_name=$_POST['bankname'];
                        }
                        if(isset($_POST['branchname'])){
                        $model->branch_name=$_POST['branchname'];
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
						  /*if($_POST['concession']==$_POST['tutionfees']){
						  $model->tuition_fees_paid=0;
						   }
						   else{
                           $model->tuition_fees_paid=$_POST['tutionfees'];
						   }*/
						   $model->tuition_fees_paid=$_POST['tutionfees'];
                        }
						if(isset($_POST['annualfees'])){
                        $model->annual_fees_paid=$_POST['annualfees'];
                        }
                        if(isset($_POST['isdefault'])){
                        $model->isdefault=$_POST['isdefault'];
                        }
			$model->attributes=$_POST['StudentFees']; //to save student_class and section
						
		
			    if($model->save())
				$this->redirect(array('admin','id'=>$model->student_fee_id));
		
            }
	
    $this->render('create',array('model'=>$model,'fees'=>$fees,'m'=>$m,'contyp'=>$contyp,));       	
}

public function actionSearch($name=null,$class1=null,$admission=null,$section=null)
{      
            $query=null;
            $model=new StudentFees;	


			$query="select   DISTINCT  a.student_id, a.student_name   from student_master a 
			LEFT JOIN  student_classes 
			sc ON(a.student_id=sc.student_id)  where 1=1 ";
			$tmpI=0;
			if($admission!=""){
			$query=$query."  and a.addmission_no ='".$admission."'";
			}
			if($class1!=""){
				$query=$query." and sc.class_no='".$class1."' ";
				}
			if($section!=""){
				$query=$query." and sc.section='".$section."'";
				}

			if($name!=""){
				$query=$query." and a.student_name LIKE '".$name."%'"; 
			}
			$query=$query."  order by a.student_name asc";


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
				
			  echo $details;

}


public function actionResetfees($id=null)
{      
                $query2=null;
                $model=new StudentFees;	
                $today=date("Y-m-d");
				$date=explode("-",$today);
	
			$query2="SELECT a.*, m.an, m.tu,m.fu,m.sp,m.af,m.ad,m.se,m.da,b.bu,c.cp,c.ct,c.ca FROM student_master a
			LEFT JOIN(select student_id,class_no as cls,section as sec from student_classes) as sc ON(sc.student_id=a.student_id)
			LEFT JOIN (select class_no,annual_fees as an, tuition_fees as tu , funds_fees as fu, sports_fees as sp,activity_fees as af,
			admission_fees as ad, security_fees as se,dayboarding_fees as da from  fees_master) as m ON (m.class_no = sc.cls )  
			LEFT JOIN (select concession_id as cid,concession_type as ct,concession_persent as cp, concession_amount as ca from 
			concession_master) as c ON (a.concession_id=c.cid) LEFT JOIN(select route , destination,bus_fees 
			as bu from busfees_master) as b ON(a.bus_id=b.bus_id) WHERE a.student_id ='".$id."'";

			$query3=Yii::app()->db->createCommand($query2)->queryAll();

			foreach($query3 as $d)
			{

			$details= $d['an']."-".$d['tu']."-".$d['fu']."-".$d['sp']."-".$d['ad']."-".$d['se']."-".$d['da']."-".$d['bu']."-".$d['cp']."-".$d['ct']."-".$d['af']."-".$d['ca'];

			}
			echo $details;

}

public function actionPreviousfees($sid=null)
{
/*$query="select * from  payment_schedule_master";
  $result=Yii::app()->db->createCommand($query)->queryAll();
  $schedule = array();
	  foreach($result as $row )
	{
		$schedule[] = $row['fees_for_months'];
	}
	//print_r($schedule);
		$a="";
			$querystfees="select * from student_fees where student_id='".$sid."' order by date_payment desc";
			$stfees=Yii::app()->db->createCommand($querystfees)->queryAll();
			$last_record =  end($stfees); 
			$first_time_fee = $last_record['year'];
			for($i = $first_time_fee; $i<= date('Y'); $i++)
			{
			
				 $get_by_class="select * from student_fees where student_id='".$sid."' AND year='".$i."'";
				$res=Yii::app()->db->createCommand($get_by_class)->queryAll();
				   foreach( $res as $row )
					{
						$schedule_fee[] = $row['fees_for_months'];
					}
					
					 $check_diff = array_diff($schedule,$schedule_fee);
					 //print_r($check_diff);die;
				$check  = implode(",",$check_diff);
					if($check!=0)
						{
							
									$a=$a.$check.'$'.'-'.'$'.'-'.'$'.'-'.'$'.$row['student_class'].'$'.$check.'&';
							
						}
							
							
			}*/

			//$querystfees="select * from student_fees where student_id='".$sid."' and student_class='".$currentclas."'";
			$querystfees="select * from student_fees where student_id='".$sid."' order by date_payment desc";
			$stfees=Yii::app()->db->createCommand($querystfees)->queryAll();

			$a="";
			 foreach($stfees as $row){
				 
				 $paid_months = explode(', ',$row['fees_period_month']);
				 $array_check = explode(',',$row['fees_for_months']);
				 $tmp = array_diff($array_check,$paid_months);
				 //echo "<pre>";print_r($tmp);
				$tmpval  = implode(",",$tmp);
				//echo $tmpval.'<br/>';
				
					 if($tmpval!=0)
							{
								$a=$a.$row['fees_for_months'].'$'.$row['date_payment'].'$'.$row['amount_paid'].'$'.$row['fees_period_month'].'$'.$row['student_class'].'$'.$tmpval.'&';
								
							}
							else{ $tmpval = '';
								$a=$a.$row['fees_for_months'].'$'.$row['date_payment'].'$'.$row['amount_paid'].'$'.$row['fees_period_month'].'$'.$row['student_class'].'$'.$tmpval.'&';
							}
							
								
					 
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
        $sql="select * from student_fees where student_fee_id='".$id."'";
		$query=Yii::app()->db->createCommand($sql)->queryRow();
		$m= $query['fees_period_month'].'-'.$query['fees_for_months'].'-'.$query['student_id'];
		$sid=$query['student_id'];
		
		$sql1="select co.typ from student_fees a LEFT JOIN (select concession_id as id,
		concession_type as typ	from concession_master)as co ON(a.concession_type_id=co.id) where student_fee_id='".$id."'";
		$query1=Yii::app()->db->createCommand($sql1)->queryRow();
		$contyp=$query1['typ'];	
	
		if(isset($_POST['yt0']))
		{
//print_r($_POST); exit;
/** status of cheque starts here**/
				if(isset($_POST['paymentmode'])){
                	$model->payment_mode=$_POST['paymentmode'];
                }
				if(isset($_POST['chequestatus'])){
                	$model->cheque_status=$_POST['chequestatus'];
                }
				if($model->payment_mode=='Cheque' && empty($model->cheque_status)){
				   $model->cheque_status='Open';
				}
				if(isset($_POST['bankname'])){
                $model->bank_name=$_POST['bankname'];
                }/* branch name */
                if(isset($_POST['branchname'])){
                $model->branch_name=$_POST['branchname'];
                }
			    if(isset($_POST['cheqno'])){
                $model->cheq_no=$_POST['cheqno'];
                }
                if(isset($_POST['paymentdate'])){
                $paydate = $_POST['paymentdate'];
                $originalDate = $paydate;
                $newDate = date("Y-m-d", strtotime($originalDate));
                $model->date_payment=$newDate;
				}
/*--starts here realized_date--*/
				//if not cheque, set realized date to payment_date
				if($model->payment_mode!='Cheque'){
				   $model->cheque_status='';
 				   $model->cheq_no='';
				   $model->bank_name='';
				   $model->realized_date=$model->date_payment;
				}
                else if(isset($_POST['realizeddate']) && !empty($_POST['realizeddate'])){
					$realizeddate = $_POST['realizeddate'];
					$realized_date = date("Y-m-d", strtotime($realizeddate));
					$model->realized_date=$realized_date;
				}

				if(isset($_POST['entrydate'])){
                $entrydate = $_POST['entrydate'];
                $newentrydate = date("Y-m-d", strtotime($entrydate));
                $model->entry_date=$newentrydate;
		        }
					
                if(isset($_POST['monthfees'])){
                $model->fees_for_months=$_POST['monthfees'];
                }
                if(isset($_POST['payfeesmonth'])){		 
                $model->fees_period_month=implode(', ',$_POST['payfeesmonth'] );
                }
				
				if(isset($_POST['year'])){	 
                $model->year=$_POST['year'];
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
					
		
			$model->attributes=$_POST['StudentFees']; //to save student_class and section
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
	 
	   
	
	    $q1="SELECT * FROM latefee_master WHERE days_from <= ".$days." AND days_to >=  ".$days."";
	    $query1=Yii::app()->db->createCommand($q1)->queryRow();
		$lf=$days*$query1['latefee'];
		
		
			$q2="SELECT a.*,c.cp,c.ct,c.ca FROM student_master a  
	             LEFT JOIN (select concession_id,concession_type as ct,concession_persent as cp, concession_amount as ca from 
	             concession_master) as c ON (a.concession_id=c.concession_id) WHERE a.student_id ='".$sid."'";
		  $query2=Yii::app()->db->createCommand($q2)->queryRow();
	
	      $detail=$data.'&'.$lf.'&'.$query2['cp'].'&'.$query2['ca'].'&';
		
		  echo  $detail;
 }
	
	
	public function actionCalculatefees($sid=null,$cls=null){
	
	$query2="SELECT a.*, m.an, m.tu,m.fu,m.sp,m.af,m.ad,m.se,m.da,b.bu,c.cp,c.ct,c.ca,c.cid FROM student_master a
	LEFT JOIN(select student_id,class_no as cls,section as sec , started_on as so  from student_classes) as sc ON(sc.student_id=a.student_id)
	LEFT JOIN (select class_no,annual_fees as an, tuition_fees as tu , funds_fees as fu, sports_fees as sp,activity_fees as af,
	admission_fees as ad, security_fees as se,dayboarding_fees as da,valid_from as vf , valid_to as vt from  fees_master) as m ON (m.class_no = '".$cls."' and sc.so between m.vf and m.vt)  
	LEFT JOIN (select concession_id as cid,concession_type as ct,concession_persent as cp, concession_amount as ca from 
	concession_master) as c ON (a.concession_id=c.cid) LEFT JOIN(select bus_id, route , destination,bus_fees 
	as bu from busfees_master) as b ON(a.bus_id=b.bus_id) WHERE a.student_id ='".$sid."'";


	$query3=Yii::app()->db->createCommand($query2)->queryAll();


	   foreach($query3 as $d)
	{
	$details= $d['an']."|".$d['tu']."|".$d['fu']."|".$d['sp']."|".$d['ad']."|".$d['se']."|".$d['da']."|".$d['bu']."|".$d['cp']."|".$d['ct']."|".$d['af']."|".$d['ca']."|".$d['cid'];
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

		
		//$querystfees="select * from student_fees where student_id='".$id."' and student_class='".$currentclas."'";
		$querystfees="select * from student_fees where student_id='".$id."' order by date_payment desc";
		$stfees=Yii::app()->db->createCommand($querystfees)->queryAll();

		$a="";
		 foreach($stfees as $row){
				 $a=$a.$row['fees_for_months'].'$'.$row['date_payment'].'$'.$row['amount_paid'].'$'.$row['fees_period_month'].'$'.$row['student_class'].'&';
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
		
		if (isset($_GET['StudentFees']))
        {
                $model->attributes = $_GET['StudentFees'];
                Yii::app()->user->setState('StudentFeesSearchParams', $_GET['StudentFees']);
        }
        else
        {
                $searchParams = Yii::app()->user->getState('StudentFeesSearchParams');
                if ( isset($searchParams) )
                {
                        $model->attributes = $searchParams;
                }
        }
		$this->render('admin',array(
			'model'=>$model,
		));
	}

/* function called for updating the cheque status and realization data
    params: feesids: comma separated student_fees_id
            chngst: can be received or rejected
            entdate: date when the cheque status was confirmed
	    show fee records with 'open' cheque_status and payment_mode='cheque' on load
*/
    public function actionChequestatus($feesids=null,$chngst=null,$entdate=null)
	{
	
		$model = new StudentFees('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StudentFees']))
        {  //print_r($_GET['StudentFees']); die;
                $model->attributes = $_GET['StudentFees'];
                Yii::app()->user->setState('StudentFeesSearchParams', $_GET['StudentFees']);
        }
        else
        {
                $searchParams = Yii::app()->user->getState('StudentFeesSearchParams');
                if ( isset($searchParams) )
                {
                        $model->attributes = $searchParams;
                }
        }
              if(isset($feesids)){
			
			$arr=explode(",",$feesids);
			
           $connection=Yii::app()->db;
            foreach($arr as $fee_id)
            {
				$sql = "UPDATE student_fees SET cheque_status = '$chngst', realized_date = '$entdate' WHERE student_fee_id = '$fee_id'";
				$command = $connection->createCommand($sql);
				$command->execute();

		   }
		}
	         
      
		$this->render('chequestatus',array(
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
	/*get months array*/
	private function get_months_array($year){
			 $datefrom=$year."0401";
			 $dateto=($year+1)."0331"; //last day of selected year, so for 2016, it is 20170331
			 $datefrom1 = date("Y-m-d", strtotime($datefrom)); // this is  the first date of the selected year 
			 $dateto1 = date("Y-m-d", strtotime($dateto));     // this is  the last date of the selected year
//			 echo "datefrom1=".$datefrom1;
			 $montharray=array();
			 $currentdate=date('Y-m-d');
			 if($currentdate<$dateto1) {
				$dateto1=$currentdate; //if financial year is not over yet, set it to today
				//set the onth array to how many months have passed till now
				// create a time stamp of the date
				$time = strtotime($datefrom1);
				$to_month= date('m', strtotime($dateto1));
				for($i=0;$i<12;$i++){
					// convert timestamp back to date string
					$cur_month = date('m', $time); 
					if($cur_month==$to_month){ //stop when last month is reached
						break;
					}
					$montharray[] = ltrim($cur_month, '0'); //strip the leading zeroes from the month because db has sotred as 1,2
					// move to next timestamp
					$time = strtotime('+1 month', $time);
				 }
				 //sort the array for months to be in ascending order
				 sort($montharray);
			 }
			 else{
				$montharray = Array (1,2,3,4,5,6,7,8,9,10,11,12); // array of all 12 months
			 }
//			 echo "dateto1=".$dateto1;
//			print_r($montharray);
			return $montharray;
		}
}

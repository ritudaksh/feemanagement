<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
         //$this->render('index');
		 $this->redirect(array('/studentMaster/admin'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	public function actionReport(){
          
	  
	  
	  $this->render('report');
	
	}
	
	
	public function actionData($datefrom=null,$c=null,$dateto=null){
		 
		 
        //$yearstart=$year."-04-01";
		//$y=$year+1; 
	    //$yearend=$y."-03-31";
		 $datefrom1 = date("Y-m-d", strtotime($datefrom));
	     $dateto1 = date("Y-m-d", strtotime($dateto));
		 $df1="";
		 $dt1="";
		 $df=explode('-', $datefrom);
		 $dt=explode('-', $dateto);
		 if($df[1]<10 ){
		 $df1= ltrim($df[1], '0');
		 } 
		 else{
		 $df1=$df[1];
		 }
		if($dt[1]<10){
		$dt1= ltrim($dt[1], '0');
		}
		else{
		$dt1=$dt[1];
		}
		
		
		
		$tmparray=array();
		 $tmp="";
		 if($dt1 > 3 && $dt1 <= 12){
		 for($j=$df1;$j<=$dt1;$j++){
		 $tmp.=$j;
		   array_push($tmparray,$j);
			if($j!=$dt1)
				$tmp.=",";
		 
		 }
		 }
		 elseif ($dt1 < 4){
		 
		 for($q=$df1;$q<=12;$q++){
		    $tmp.=$q;
			$tmp.=",";
		 
		 }
		  for($k=1;$k<=$dt1;$k++){
		  $tmp.=$k;
			if($k!=$dt1)
				$tmp.=",";
		 
		 }
		 }
		if($c!=""){
		
/*$query="SELECT  stu.* , cls.*
FROM   student_master as stu LEFT outer JOIN  student_classes as cls 
ON cls.student_id=stu.student_id where cls.student_class_id = (select max(student_class_id) 
from student_classes where student_id = stu.student_id)
and cls.class_no!='NULL'  
and stu.student_id NOT IN (SELECT student_id FROM student_fees) and (passedout_date is null or passedout_date > '".$dateto1."') order by stu.addmission_no";


$query1=Yii::app()->db->createCommand($query)->queryAll();
  
      $details="";
	  foreach($query1 as $data){
	  if($data['class_no']==$c){
 $details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'&';

	}
	
	  }*/
	   

	 
	/* $query2="SELECT sf.student_id, sc.class_no,sc.section, sm.student_name,sm.addmission_no, 
GROUP_CONCAT(sf.fees_period_month SEPARATOR ', ') as fpm FROM 
student_fees sf LEFT JOIN student_classes sc on (sc.student_id=sf.student_id and sc.class_no='".$c."') 
LEFT JOIN student_master sm on (sm.student_id=sf.student_id) 
WHERE sf.fees_period_month between '".$df1."' and '".$dt1."' and (passedout_date is null or passedout_date > '".$dateto1."')  GROUP BY sf.student_id order by sm.addmission_no";*/
	
	$feesrecord="";	
	$query="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") group by sm.addmission_no ORDER BY sm.student_id ASC";


	$query1=Yii::app()->db->createCommand($query)->queryAll();
	
		  $feesrecord="";
		  foreach($query1 as $data){
		  if($data['class_no']==$c){
	 $feesrecord=$feesrecord.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'*'.$tmp.'$';

		}	
    }
	
	$query2="SELECT sf.*,sm.*, sc.section,GROUP_CONCAT(DISTINCT sf.fees_period_month SEPARATOR ', ') as fpm from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where sf1.fees_period_month in (".$tmp.") and sf1.student_class=".$c." group by sf1.student_id , sf1.fees_period_month having sum(sf1.tuition_fees_paid)=0) and fees_period_month in (".$tmp.") and student_class=".$c." and tuition_fees_paid=0 and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."') group by sf.student_id ORDER BY `sf`.`student_id` ASC";
	
	
	
	  $query3=Yii::app()->db->createCommand($query2)->queryAll();
	 
	  foreach($query3 as $data1)
	  {
	  $sql="SELECT cls.* , sm.addmission_no from  student_classes as cls LEFT JOIN student_master sm on (sm.student_id=cls.student_id) 
      where cls.student_class_id = (select max(student_class_id) 
      from student_classes where student_id = '".$data1['student_id']."') and cls.class_no='".$data1['student_class']."'"; 
	  
        $querycls=Yii::app()->db->createCommand($sql)->queryAll();
	    foreach($querycls as $cls)
           {
	            if($cls['class_no']==$c){
	 
	  
	           $feesrecord=$feesrecord.$cls['addmission_no'].'*'.$data1['student_name'].'*'.$data1['student_class'].'*'.$data1['section'].'*'.$data1['fpm'].'$';
	                                                          }
	       }    
	  }
	 echo $feesrecord;
	 
	   // echo $details.'!'.$feesrecord;
		
	}
	 
	 else{
	 
	 /*$query="SELECT  stu.* , cls.*
FROM   student_master as stu LEFT outer JOIN  student_classes as cls 
ON cls.student_id=stu.student_id where cls.student_class_id = (select max(student_class_id) 
from student_classes where student_id = stu.student_id)
and cls.class_no!='NULL' and stu.student_id NOT IN (SELECT student_id FROM student_fees) and (passedout_date is null or passedout_date > '".$dateto1."') order by cls.class_no";


$query1=Yii::app()->db->createCommand($query)->queryAll();
  
      $details="";
	  foreach($query1 as $data){
	 
 $details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'&';

	  }*/
	   

	 
	 /*$query2="SELECT sf.student_id, sc.class_no,sc.section, sm.student_name,sm.addmission_no, 
GROUP_CONCAT(sf.fees_period_month SEPARATOR ', ') as fpm FROM 
student_fees sf LEFT JOIN student_classes sc on (sc.student_id=sf.student_id) 
LEFT JOIN student_master sm on (sm.student_id=sf.student_id) 
WHERE sf.fees_period_month between '".$df1."' and '".$dt1."' and (passedout_date is null or passedout_date > '".$dateto1."') GROUP BY sf.student_id order by sc.class_no";*/
	
	$feesrecord="";	
	$query="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") group by sm.addmission_no ORDER BY sm.student_id ASC";


	$query1=Yii::app()->db->createCommand($query)->queryAll();
	  
		  $feesrecord="";
		  foreach($query1 as $data){
		 
	 $feesrecord=$feesrecord.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'*'.$tmp.'$';

		
		
    }
	
	
	
	$query2="SELECT sf.*,sm.*, sc.section,GROUP_CONCAT(DISTINCT sf.fees_period_month SEPARATOR ', ') as fpm from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where sf1.fees_period_month in (".$tmp.")  group by sf1.student_id , sf1.fees_period_month having sum(sf1.tuition_fees_paid)=0) and fees_period_month in (".$tmp.")  and tuition_fees_paid=0 and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."') group by sf.student_id ORDER BY `sf`.`student_id` ASC";
	 
	 $query3=Yii::app()->db->createCommand($query2)->queryAll();
	  
	  foreach($query3 as $data1)
	  {
	  $sql="SELECT cls.* , sm.addmission_no from  student_classes as cls LEFT JOIN student_master sm on (sm.student_id=cls.student_id) 
      where cls.student_class_id = (select max(student_class_id) 
      from student_classes where student_id = '".$data1['student_id']."') and cls.class_no='".$data1['student_class']."'"; 
      $querycls=Yii::app()->db->createCommand($sql)->queryAll();
	    foreach($querycls as $cls)
           {
	           
	           $feesrecord=$feesrecord.$cls['addmission_no'].'*'.$data1['student_name'].'*'.$data1['student_class'].'*'.$data1['section'].'*'.$data1['fpm'].'$';
	                                                        
	       }    
	    }
	 
	    //echo $details.'!'.$feesrecord;
	    echo $feesrecord;
	 
	 
	 }
	 
	}
	
	
	
	
	
	public function actionExcel($datefrom=null,$c=null,$dateto=null){
	
	    
		$datefrom1 = date("Y-m-d", strtotime($datefrom));
	     $dateto1 = date("Y-m-d", strtotime($dateto));
		 $df1="";
		 $dt1="";
		 $df=explode('-', $datefrom);
		 $dt=explode('-', $dateto);
		 if($df[1]<10 ){
		 $df1= ltrim($df[1], '0');
		 } 
		 else{
		 $df1=$df[1];
		 }
		if($dt[1]<10){
		$dt1= ltrim($dt[1], '0');
		}
		else{
		$dt1=$dt[1];
		}
		
		
		
		$tmparray=array();
		 $tmp="";
		 if($dt1 > 3 && $dt1 <= 12){
		 for($j=$df1;$j<=$dt1;$j++){
		 $tmp.=$j;
		   array_push($tmparray,$j);
			if($j!=$dt1)
				$tmp.=",";
		 
		 }
		 }
		 elseif ($dt1 < 4){
		 
		 for($q=$df1;$q<=12;$q++){
		    $tmp.=$q;
			$tmp.=",";
		 
		 }
		  for($k=1;$k<=$dt1;$k++){
		  $tmp.=$k;
			if($k!=$dt1)
				$tmp.=",";
		 
		}
	}
	
	
    if($c!=""){
		 
/*$query="SELECT  stu.* , cls.*
FROM   student_master as stu LEFT outer JOIN  student_classes as cls 
ON cls.student_id=stu.student_id where cls.student_class_id = (select max(student_class_id) 
from student_classes where student_id = stu.student_id)
and cls.class_no!='NULL'  
and stu.student_id NOT IN (SELECT student_id FROM student_fees) and (passedout_date is null or passedout_date > '".$dateto1."') order by stu.addmission_no";


$query1=Yii::app()->db->createCommand($query)->queryAll();
  
      $details="";
	  foreach($query1 as $data){
	  if($data['class_no']==$c){
 $details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'&';

	}
	
	  }*/
	   

	 
	/* $query2="SELECT sf.student_id, sc.class_no,sc.section, sm.student_name,sm.addmission_no, 
GROUP_CONCAT(sf.fees_period_month SEPARATOR ', ') as fpm FROM 
student_fees sf LEFT JOIN student_classes sc on (sc.student_id=sf.student_id and sc.class_no='".$c."') 
LEFT JOIN student_master sm on (sm.student_id=sf.student_id) 
WHERE sf.fees_period_month between '".$df1."' and '".$dt1."' and (passedout_date is null or passedout_date > '".$dateto1."')  GROUP BY sf.student_id order by sm.addmission_no";*/
	$query="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") group by sm.addmission_no ORDER BY sm.student_id ASC";


	$query1=Yii::app()->db->createCommand($query)->queryAll();
	
	
	$query2="SELECT sf.*,sm.*, sc.section,GROUP_CONCAT(DISTINCT sf.fees_period_month SEPARATOR ', ') as fpm from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where sf1.fees_period_month in (".$tmp.") and sf1.student_class=".$c." group by sf1.student_id , sf1.fees_period_month having sum(sf1.tuition_fees_paid)=0) and fees_period_month in (".$tmp.") and student_class=".$c." and tuition_fees_paid=0 and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."') group by sf.student_id ORDER BY `sf`.`student_id` ASC";
	
	
	  $query3=Yii::app()->db->createCommand($query2)->queryAll();
	
	  Yii::import('ext.phpexcel.XPHPExcel');    
	 
	 
	  $objPHPExcel= XPHPExcel::createPHPExcel();
	  
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
        

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Admission no')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Class')
            ->setCellValue('D1', 'Section')
			->setCellValue('E1', 'Tution Fees unpaid for months');
			
		$i=2;
			
			foreach($query3 as $defrep){
               
			
			
	 $sql="SELECT cls.* , sm.addmission_no from  student_classes as cls LEFT JOIN student_master sm on (sm.student_id=cls.student_id) 
      where cls.student_class_id = (select max(student_class_id) 
      from student_classes where student_id = '".$defrep['student_id']."') and cls.class_no='".$defrep['student_class']."'"; 
      $querycls=Yii::app()->db->createCommand($sql)->queryAll();
	   
	   foreach($querycls as $cls)
           {    
		   
		       
	            if($cls['class_no']==$c){
                
			    //$fpm=explode(', ',$defrep['fpm']);
				
	           // $result = array_diff($list ,$fpm);
				
	           // $result1= implode(',',$result);
	  
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $defrep['addmission_no'])
		->setCellValue('B'.$i, $defrep['student_name'])
		->setCellValue('C'.$i, $cls['class_no'])
		->setCellValue('D'.$i, $defrep['section'])
		->setCellValue('E'.$i, $defrep['fpm']);
			
			$i++;
			}
			
		}
			
	}
			
			foreach($query1 as $defrep1){
			if($defrep1['class_no']==$c){
			//$months= implode(',',$list);
			 
			$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $defrep1['addmission_no'])
		->setCellValue('B'.$i, $defrep1['student_name'])
		->setCellValue('C'.$i, $defrep1['class_no'])
		->setCellValue('D'.$i, $defrep1['section'])
		->setCellValue('E'.$i, $tmp);
			
			$i++;
			
			}
			
		}
		}	
		else{
		
		 /*$query="SELECT  stu.* , cls.*
FROM   student_master as stu LEFT outer JOIN  student_classes as cls 
ON cls.student_id=stu.student_id where cls.student_class_id = (select max(student_class_id) 
from student_classes where student_id = stu.student_id)
and cls.class_no!='NULL' and stu.student_id NOT IN (SELECT student_id FROM student_fees) and (passedout_date is null or passedout_date > '".$dateto1."') order by cls.class_no";


$query1=Yii::app()->db->createCommand($query)->queryAll();
  
      $details="";
	  foreach($query1 as $data){
	 
 $details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'&';

	  }*/
	   

	 
	 /*$query2="SELECT sf.student_id, sc.class_no,sc.section, sm.student_name,sm.addmission_no, 
GROUP_CONCAT(sf.fees_period_month SEPARATOR ', ') as fpm FROM 
student_fees sf LEFT JOIN student_classes sc on (sc.student_id=sf.student_id) 
LEFT JOIN student_master sm on (sm.student_id=sf.student_id) 
WHERE sf.fees_period_month between '".$df1."' and '".$dt1."' and (passedout_date is null or passedout_date > '".$dateto1."') GROUP BY sf.student_id order by sc.class_no";*/
	
	
	$query="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") group by sm.addmission_no ORDER BY sm.student_id ASC";


	$query1=Yii::app()->db->createCommand($query)->queryAll();
	
	$query2="SELECT sf.*,sm.*, sc.section,GROUP_CONCAT(DISTINCT sf.fees_period_month SEPARATOR ', ') as fpm from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where sf1.fees_period_month in (".$tmp.")  group by sf1.student_id , sf1.fees_period_month having sum(sf1.tuition_fees_paid)=0) and fees_period_month in (".$tmp.")  and tuition_fees_paid=0 and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."') group by sf.student_id ORDER BY `sf`.`student_id` ASC";
	 
	 $query3=Yii::app()->db->createCommand($query2)->queryAll();
	
	
	
	
	  Yii::import('ext.phpexcel.XPHPExcel');    
	 
	 
	  $objPHPExcel= XPHPExcel::createPHPExcel();
	  
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
        

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Admission no')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Class')
            ->setCellValue('D1', 'Section')
			->setCellValue('E1', 'Tution Fees unpaid for months');
			
		$i=2;
			
			foreach($query3 as $defrep){
               
			
			
	  $sql="SELECT cls.* , sm.addmission_no from  student_classes as cls LEFT JOIN student_master sm on (sm.student_id=cls.student_id) 
      where cls.student_class_id = (select max(student_class_id) 
      from student_classes where student_id = '".$defrep['student_id']."') and cls.class_no='".$defrep['student_class']."'"; 
      $querycls=Yii::app()->db->createCommand($sql)->queryAll();
	   
	   foreach($querycls as $cls)
           {    
		      
			    //$fpm=explode(', ',$defrep['fpm']);
				
	            //$result = array_diff($list ,$fpm);
				
	            //$result1= implode(',',$result);
	  
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $defrep['addmission_no'])
		->setCellValue('B'.$i, $defrep['student_name'])
		->setCellValue('C'.$i, $cls['class_no'])
		->setCellValue('D'.$i, $defrep['section'])
		->setCellValue('E'.$i, $defrep['fpm']);
			
			$i++;
			
			
		}
			
	}
			
			foreach($query1 as $defrep1){
			
			//$months= implode(',',$list);
			 
			$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $defrep1['addmission_no'])
		->setCellValue('B'.$i, $defrep1['student_name'])
		->setCellValue('C'.$i, $defrep1['class_no'])
		->setCellValue('D'.$i, $defrep1['section'])
		->setCellValue('E'.$i, $tmp);
			
			$i++;
			
			}
		
	}
								
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->setActiveSheetIndex(0);

 

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="defaulterreport.xls"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

   Yii::app()->end();


}
	
	public function actionCollection(){
          
	  $this->render('collection');
	
	}
	
	public function actionfees($datefrom=null,$dateto=null,$radioval=null){
	
	
      $datefrom1 = date("Y-m-d", strtotime($datefrom));
	  $dateto1 = date("Y-m-d", strtotime($dateto));
	  $date=date('Y');
	  $sessionstarts=$date."-04-01";
     //echo $datefrom1.",".$dateto1;
	  
	  
	//$q="select a.* ,sm.addmission_no,sm.student_name, con.concession_type from student_fees a LEFT JOIN student_master sm on (sm.student_id=a.student_id) LEFT JOIN concession_master as con ON(con.concession_id=a.concession_type_id) WHERE a.date_payment between '".$datefrom1."' and '".$dateto1."'";
	
	$q="";
	if($radioval=='advancedfees'){
	
	$q="select cls.*,sf.*,sm.addmission_no , sm.student_name,con.concession_type from student_classes cls right join student_fees sf on (sf.student_id=cls.student_id and date_payment between '".$datefrom1."' and '".$dateto1."') right join student_master sm on (sm.student_id=cls.student_id) left join concession_master as con ON(con.concession_id=sf.concession_type_id) where cls.started_on >= ".$sessionstarts;
	
	}
	
    else{
	
	$q="select a.* ,cls.*, sm.addmission_no,sm.student_name, con.concession_type from 
	student_fees a LEFT JOIN student_master sm on (sm.student_id=a.student_id) 
	left JOIN concession_master as con ON(con.concession_id=a.concession_type_id)
    LEFT outer JOIN   student_classes as cls
    ON (sm.student_id =cls.student_id)	
	WHERE a.date_payment between '".$datefrom1."' and '".$dateto1."' 
	and cls.student_class_id=(select max(student_class_id) 
    from student_classes where student_id = sm.student_id) order by sm.addmission_no";
    }
	
	
	
	$qf=Yii::app()->db->createCommand($q)->queryAll();
	
	 $feedetails="";
	 $amount="";
	 $totanualfees="";$tottutfees=""; $totfundfees="";$totsportsfees="";$totactfees="";
	 $totadmfees="";$totsecfees="";$totlatefees=""; $totdayboardfees="";$totbusfees="";$totfees="";
   foreach($qf as $fee){
   
	  
      $feedetails=$feedetails.$fee['addmission_no'].'!'.$fee['student_name'].'!'.$fee['class_no'].'!'.$fee['section'].'!'.$fee['fees_for_months'].'!'.$fee['fees_period_month'].'!'.$fee['annual_fees_paid'].'!'.$fee['tuition_fees_paid'].'!'.$fee['funds_fees_paid'].'!'.$fee['sports_fees_paid'].'!'.$fee['activity_fees'].'!'.$fee['admission_fees_paid'].'!'.$fee['security_paid'].'!'.$fee['late_fees_paid'].'!'.$fee['dayboarding_fees_paid'].'!'.$fee['bus_fees_paid'].'!'.$fee['amount_paid'].'!'.$fee['date_payment'].'!'.$fee['payment_mode'].'!'.$fee['cheq_no'].'!'.$fee['bank_name'].'!'.$fee['concession_applied'].'!'.$fee['concession_type'].'!'.$fee['Total_amount'].'&';
	   
	   
	  
	  $amount+=$fee['amount_paid'];
	  $totanualfees+=$fee['annual_fees_paid'];
	  $tottutfees+=$fee['tuition_fees_paid'];
	  $totfundfees+=$fee['funds_fees_paid'];
	  $totsportsfees+=$fee['sports_fees_paid'];
	  $totactfees+=$fee['activity_fees'];
	  $totadmfees+=$fee['admission_fees_paid'];
	  $totsecfees+=$fee['security_paid'];
	  $totlatefees+=$fee['late_fees_paid'];
	  $totdayboardfees+=$fee['dayboarding_fees_paid'];
	  $totbusfees+=$fee['bus_fees_paid'];
	  $totfees+=$fee['Total_amount'];
   }
   
   
   echo $feedetails.'$'.$amount.'$'. $totanualfees.'$'. $tottutfees.'$'. $totfundfees.'$'. $totsportsfees.'$'. $totactfees
   .'$'. $totadmfees.'$'. $totsecfees.'$'. $totlatefees.'$'. $totdayboardfees.'$'. $totbusfees.'$'. $totfees;
	
	}	

	
	public function actionExcelcollection($datefrom=null,$dateto=null,$radioval=null){
	 
	 $datefrom1 = date("Y-m-d", strtotime($datefrom));
	 $dateto1 = date("Y-m-d", strtotime($dateto));
	 $date=date('Y');
	 $sessionstarts=$date."-04-01";
	 $q="";
	 $filename="";
	 
	if($radioval=='advancedfees'){
	$filename="Advanced fees collection.xls";
	$q="select cls.*,sf.*,sm.addmission_no , sm.student_name,con.concession_type from student_classes cls right join student_fees sf on (sf.student_id=cls.student_id and date_payment between '".$datefrom1."' and '".$dateto1."') right join student_master sm on (sm.student_id=cls.student_id) left join concession_master as con ON(con.concession_id=sf.concession_type_id) where cls.started_on >= ".$sessionstarts;
	
	}
	
	else{
	$filename="Total fees collection.xls";
	$q="select a.* ,cls.*, sm.addmission_no,sm.student_name, con.concession_type from 
	student_fees a LEFT JOIN student_master sm on (sm.student_id=a.student_id) 
	LEFT JOIN concession_master as con ON(con.concession_id=a.concession_type_id)
    LEFT outer JOIN   student_classes as cls
    ON (sm.student_id =cls.student_id)	
	WHERE a.date_payment between '".$datefrom1."' and '".$dateto1."' 
	and cls.student_class_id=(select max(student_class_id) 
    from student_classes where student_id = sm.student_id) order by sm.addmission_no";
    }
	
	$qc=Yii::app()->db->createCommand($q)->queryAll();
	
	if(!empty($qc)){
      Yii::import('ext.phpexcel.XPHPExcel');    
	  $objPHPExcel= XPHPExcel::createPHPExcel();
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
        

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Admission no')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Class')
            ->setCellValue('D1', 'Section')
			->setCellValue('E1', 'Fees for months')
			->setCellValue('F1', 'Fees paid for month')
			->setCellValue('G1', 'Annual fees')
			->setCellValue('H1', 'Tution fees')
			->setCellValue('I1', 'Fund fees')
			->setCellValue('J1', 'Sports fees')
			->setCellValue('K1', 'Activity fees')
			->setCellValue('L1', 'Admission fees')
			->setCellValue('M1', 'Security fees')
			->setCellValue('N1', 'Late fees')
			->setCellValue('O1', 'Dayboarding fees')
			->setCellValue('P1', 'Bus fees')
			->setCellValue('Q1', 'Payment date')
			->setCellValue('R1', 'Payment mode')
			->setCellValue('S1', 'Chequeno')
			->setCellValue('T1', 'Bank Name')
			->setCellValue('U1', 'Concession applied')
			->setCellValue('V1', 'Concession type')
			->setCellValue('W1', 'Total amount')
			->setCellValue('X1', 'Amount paid');
			
			
			$i=2;
	     $amount="";
	    $totanualfees="";$tottutfees=""; $totfundfees="";$totsportsfees="";$totactfees="";
	    $totadmfees="";$totsecfees="";$totlatefees=""; $totdayboardfees="";$totbusfees="";$totfees="";
           
		   foreach($qc as $collectionrp){
			
	  $amount+=$collectionrp['amount_paid'];
	  $totanualfees+=$collectionrp['annual_fees_paid'];
	  $tottutfees+=$collectionrp['tuition_fees_paid'];
	  $totfundfees+=$collectionrp['funds_fees_paid'];
	  $totsportsfees+=$collectionrp['sports_fees_paid'];
	  $totactfees+=$collectionrp['activity_fees'];
	  $totadmfees+=$collectionrp['admission_fees_paid'];
	  $totsecfees+=$collectionrp['security_paid'];
	  $totlatefees+=$collectionrp['late_fees_paid'];
	  $totdayboardfees+=$collectionrp['dayboarding_fees_paid'];
	  $totbusfees+=$collectionrp['bus_fees_paid'];
	  $totfees+=$collectionrp['Total_amount'];
			
			
			
			$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $collectionrp['addmission_no'])
		->setCellValue('B'.$i, $collectionrp['student_name'])
		->setCellValue('C'.$i, $collectionrp['class_no'])
		->setCellValue('D'.$i, $collectionrp['section'])
		->setCellValue('E'.$i, $collectionrp['fees_for_months'])
		->setCellValue('F'.$i, $collectionrp['fees_period_month'])
		->setCellValue('G'.$i, $collectionrp['annual_fees_paid'])
		->setCellValue('H'.$i, $collectionrp['tuition_fees_paid'])
		->setCellValue('I'.$i, $collectionrp['funds_fees_paid'])
		->setCellValue('J'.$i, $collectionrp['sports_fees_paid'])
		->setCellValue('K'.$i, $collectionrp['activity_fees'])
		->setCellValue('L'.$i, $collectionrp['admission_fees_paid'])
		->setCellValue('M'.$i, $collectionrp['security_paid'])
		->setCellValue('N'.$i, $collectionrp['late_fees_paid'])
		->setCellValue('O'.$i, $collectionrp['dayboarding_fees_paid'])
		->setCellValue('P'.$i, $collectionrp['bus_fees_paid'])
		->setCellValue('Q'.$i, $collectionrp['date_payment'])
		->setCellValue('R'.$i, $collectionrp['payment_mode'])
		->setCellValue('S'.$i, $collectionrp['cheq_no'])
		->setCellValue('T'.$i, $collectionrp['bank_name'])
		->setCellValue('U'.$i, $collectionrp['concession_applied'])
		->setCellValue('V'.$i, $collectionrp['concession_type'])
		->setCellValue('W'.$i, $collectionrp['Total_amount'])
		->setCellValue('X'.$i, $collectionrp['amount_paid']);	
$i++;
}
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, 'Total Collection')
		->setCellValue('G'.$i, $totanualfees)
		->setCellValue('H'.$i,  $tottutfees)
		->setCellValue('I'.$i, $totfundfees)
		->setCellValue('J'.$i,  $totsportsfees)
		->setCellValue('K'.$i, $totactfees)
		->setCellValue('L'.$i, $totadmfees)
		->setCellValue('M'.$i, $totsecfees)
		->setCellValue('N'.$i, $totlatefees)
		->setCellValue('O'.$i, $totdayboardfees)
		->setCellValue('P'.$i, $totbusfees)
		->setCellValue('W'.$i,  $totfees)
		->setCellValue('X'.$i, $amount);	

		
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->setActiveSheetIndex(0);


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

   Yii::app()->end();

/*$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$filename='Collectionreport.xls';

$objWriter->save($filename);
   
	
    echo $filename;*/
	}
	}
	
 public function actionTransport(){
          
	  $this->render('transport');
	
	}
	
	public function actionBusno($busno=null){
	

/*$q1="SELECT stu.*, cls.* FROM  student_master as stu
LEFT outer JOIN   student_classes as cls
ON stu.student_id =cls.student_id
WHERE  bus_id ='".$busno."' and cls.student_class_id=(select max(student_class_id) 
from student_classes where student_id = stu.student_id) order by stu.addmission_no";*/

$q1="SELECT stu.*, cls.*,bf.route,bf.destination FROM  student_master as stu
LEFT outer JOIN   student_classes as cls
ON stu.student_id =cls.student_id right join busfees_master bf on (bf.bus_id=stu.bus_id and route='".$busno."')
WHERE  cls.student_class_id=(select max(student_class_id) 
from student_classes where student_id = stu.student_id) order by stu.addmission_no";


	$qf1=Yii::app()->db->createCommand($q1)->queryAll();

	
	$trdetails="";
	
   foreach($qf1 as $transportrp){
  

  $trdetails=$trdetails.$transportrp['student_id'].'*'.$transportrp['student_name'].
  '*'.$transportrp['addmission_no'].'*'.$transportrp['class_no'].
  '*'.$transportrp['section'].'*'.$transportrp['destination'].'*'.$transportrp['route'].'&';
  
   }
   
   
   echo $trdetails;
	}
	
public function actionCreateExcel($busno=null){
	

 
/*$q1="SELECT stu.*, cls.* FROM  student_master as stu
LEFT outer JOIN   student_classes as cls
ON stu.student_id =cls.student_id
WHERE  bus_no ='".$busno."' and cls.student_class_id=(select max(student_class_id) 
from student_classes where student_id = stu.student_id) order by stu.addmission_no";*/

$q1="SELECT stu.*, cls.*,bf.route,bf.destination FROM  student_master as stu
LEFT outer JOIN   student_classes as cls
ON stu.student_id =cls.student_id right join busfees_master bf on (bf.bus_id=stu.bus_id and route='".$busno."')
WHERE  cls.student_class_id=(select max(student_class_id) 
from student_classes where student_id = stu.student_id) order by stu.addmission_no";

	$qf1=Yii::app()->db->createCommand($q1)->queryAll();

	if(!empty($qf1)){
      Yii::import('ext.phpexcel.XPHPExcel');    
	  $objPHPExcel= XPHPExcel::createPHPExcel();
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
        

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Student Name')
            ->setCellValue('B1', 'Admission No.')
            ->setCellValue('C1', 'Class')
			->setCellValue('D1', 'Section')
			->setCellValue('E1', 'Destination')
			->setCellValue('F1', 'Route');
			
			
			$i=2;
			foreach($qf1 as $transportrp){
			
	        $objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $transportrp['student_name'])
		->setCellValue('B'.$i, $transportrp['addmission_no'])
		->setCellValue('C'.$i, $transportrp['class_no'])
		->setCellValue('D'.$i, $transportrp['section'])
		->setCellValue('E'.$i, $transportrp['destination'])
		->setCellValue('F'.$i, $transportrp['route']);
		
		
		
$i++;
			}
				
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->setActiveSheetIndex(0);


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Transportreport.xls"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

   Yii::app()->end();

/*$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$filename='Transportreport.xls';

$objWriter->save($filename);
   
    echo $filename;*/
	
	
    }
	}
		
	
	public function actionAdmission(){
          
	  
	  
	  $this->render('admission');
	
	}
	
	public function actionAdmissiondetail($datefrom=null,$dateto=null,$cls=null){
         
	   $record="";
	   $datefrom1 = date("Y-m-d", strtotime($datefrom));
	   $dateto1 = date("Y-m-d", strtotime($dateto));
	  
	  if($cls!=""){
	  
	 $sql="SELECT stu.*,cls.* from student_master as stu LEFT outer join student_classes as cls 
          on cls.student_id = stu.student_id where cls.student_class_id = (select max(student_class_id) 
         from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no='".$cls."'  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no";
         }
		 else{
     $sql="SELECT stu.*,cls.* from student_master as stu LEFT outer join student_classes as cls 
          on cls.student_id = stu.student_id where cls.student_class_id = (select max(student_class_id) 
         from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no in ('Pre-nursery','nursery','KG','1','2','3','4','5','6','7','8','9','10','11','12')  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no";
		 }
		 
	  
	  $query=Yii::app()->db->createCommand($sql)->queryAll();
	  
	  
	  foreach($query as $data){

$record=$record.$data['addmission_no'].'&'.$data['addmission_no'].'&'.$data['admission_date'].'&'.$data['student_name'].'&'.$data['birth_date'].'&'.$data['class_no'].'&'.$data['section'].'&'.$data['father_name'].'&'.$data['mother_name'].'&'.$data['address'].','.$data['city'].'$';
	  
	  }
	echo $record;
	
	
	
	}
	
	
	
	public function actionExceladmission($datefrom=null,$dateto=null,$cls=null){
	
 
	   $datefrom1 = date("Y-m-d", strtotime($datefrom));
	   $dateto1 = date("Y-m-d", strtotime($dateto));
	  
	  
	  
	if($cls!=""){
	  
	 $sql="SELECT stu.*,cls.* from student_master as stu LEFT outer join student_classes as cls 
          on cls.student_id = stu.student_id where cls.student_class_id = (select max(student_class_id) 
         from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no='".$cls."'  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no";
         }
		 else{
     	
     $sql="SELECT stu.*,cls.* from student_master as stu LEFT outer join student_classes as cls 
          on cls.student_id = stu.student_id where cls.student_class_id = (select max(student_class_id) 
         from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no in ('Pre-nursery','nursery','KG','1','2','3','4','5','6','7','8','9','10','11','12')  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no";
		}
	  
	  $query=Yii::app()->db->createCommand($sql)->queryAll();
	  

      
	if(!empty($query)){
      Yii::import('ext.phpexcel.XPHPExcel');    
	  $objPHPExcel= XPHPExcel::createPHPExcel();
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
        

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Admission No.')
            ->setCellValue('B1', 'Admission date')
            ->setCellValue('C1', 'Student Name')
			->setCellValue('D1', 'DOB')
			->setCellValue('E1', 'Class')
			->setCellValue('F1', 'Section')
			->setCellValue('G1', 'Father Name')
			->setCellValue('H1', 'Mother Name')
			->setCellValue('I1', 'Address');
			
			$i=2;
			foreach($query as $admrp){
			if($admrp['address']!="" || $admrp['city']!=""){
			$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $admrp['addmission_no'])
		->setCellValue('B'.$i, $admrp['admission_date'])
	    ->setCellValue('C'.$i, $admrp['student_name'])
		->setCellValue('D'.$i, $admrp['birth_date'])
		->setCellValue('E'.$i, $admrp['class_no'])
		->setCellValue('F'.$i, $admrp['section'])
		->setCellValue('G'.$i, $admrp['father_name'])
		->setCellValue('H'.$i, $admrp['mother_name'])
		->setCellValue('I'.$i, $admrp['address'].','.$admrp['city']);
		
$i++;
	}		
	
	else{
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $admrp['addmission_no'])
		->setCellValue('B'.$i, $admrp['admission_date'])
	    ->setCellValue('C'.$i, $admrp['student_name'])
		->setCellValue('D'.$i, $admrp['birth_date'])
		->setCellValue('E'.$i, $admrp['class_no'])
		->setCellValue('F'.$i, $admrp['section'])
		->setCellValue('G'.$i, $admrp['father_name'])
		->setCellValue('H'.$i, $admrp['mother_name'])
		->setCellValue('I'.$i, '');
		
$i++;
	
	
	}
	
	
	
	
	}
				
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Admissionreport.xls"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

   Yii::app()->end();

    }
	}
	
	public function actionAccountheads(){
	
	$model=new AccountHeads;
	
	$qry = "Select max(account_code) as account_code from account_heads";
	$com = Yii::app()->db->createCommand($qry)->queryRow();
	$max_id = $com["account_code"];	
	$model->account_code = $max_id + 1;
	
	
	$accountheads=new AccountHeads('search');
		$accountheads->unsetAttributes();  // clear any default values
		if(isset($_GET['AccountHeads']))
			$accountheads->attributes=$_GET['AccountHeads'];

		$list = CHtml::listData(AccountHeads::model()->findAll(), 'account_id', 'account_name');
		
	if(isset($_POST['AccountHeads'])){
	
	
	
	 $model->attributes = $_POST['AccountHeads'];
		 if(!$model->validate())
	{
				
      }
	else{
		 $model->save();
		  $this->redirect(array('site/accountheads'));
		}
    
	 
	}
	
	$this->render('accountheads',array(
			'model'=>$model,'accountheads'=>$accountheads,'list'=>$list));
	
    }
	
	
	public function actionSaveAccounts($id,$desc=null,$paccname=null){
	 
            if(isset($_POST['AccountHeads'])) {
		
            $model1 = AccountHeads::model()->findByPk($id);
            $model1->attributes = $_POST['AccountHeads'];
			$model1->account_desc=$desc;
			$model1->parentaccount_id=$paccname;
			
            $model1->save();
			
			
		    $this->redirect(array('site/accountheads'));
         }
		 
    }
	
	
	public function actionDeleteAccounts($id){
	        
            $model = AccountHeads::model()->findByPk($id);
            $model->delete();
		    $this->redirect(array('site/accountheads'));
       	 
    }
	
	
	public function actionExpenses(){
	
	$model=new Expenses;
	$Expenses=new Expenses('search');
		$Expenses->unsetAttributes();  // clear any default values
		if(isset($_GET['Expenses']))
			$Expenses->attributes=$_GET['Expenses'];
    
	$list = CHtml::listData(AccountHeads::model()->findAll(), 'account_id', 'account_name');
		
		
	if(isset($_POST['Expenses'])){
	
	
	  $model->attributes = $_POST['Expenses'];
	  $model->expense_date = date("Y-m-d", strtotime($model->expense_date));
	  
	 if(!$model->validate())
	{
				
      }
	else{
		 $model->save();
         $this->redirect(array('site/expenses'));
		}
	 
	}
	
	$this->render('expenses',array(
			'model'=>$model,'Expenses'=>$Expenses,'list'=>$list));
	
    }
	
	
	public function actionSaveExpense($id,$expdate=null,$accname=null,$desc=null){
	
            if(isset($_POST['Expenses'])) {
		   
            $model1 = Expenses::model()->findByPk($id);
			
            $model1->attributes = $_POST['Expenses'];
			$model1->expense_date=$expdate;
			$model1->account_id=$accname;
			$model1->expense_desc=$desc;
            $model1->save();
			
		    $this->redirect(array('site/expenses'));
         }
		 
    }
	
	
	public function actionDeleteExpense($id){
	        
            $model = Expenses::model()->findByPk($id);
            $model->delete();
		    $this->redirect(array('site/expenses'));
       	 
    }
	
	public function actionExpensereport(){
     
     $list = AccountHeads::model()->findAll();    
	 $this->render('expensereport',array(
			'list'=>$list));
	
	}
	
	public function actionExpensedata($datefrom=null,$dateto=null,$accval=null){
	
	   $datefrom1 = date("Y-m-d", strtotime($datefrom));
	   $dateto1 = date("Y-m-d", strtotime($dateto));

$qexp="SELECT ah.*, exp.* FROM  expenses as exp
LEFT outer JOIN   account_heads as ah
ON exp.account_id =ah.account_id
WHERE  exp.account_id in (".$accval.") and  exp.expense_date between '".$datefrom1."' and '".$dateto1."'";



	$qf1=Yii::app()->db->createCommand($qexp)->queryAll();
    
	
	$expdetails="";
	
   foreach($qf1 as $expenserp){
  

  $expdetails=$expdetails.$expenserp['account_name'].'*'.$expenserp['account_desc'].
  '*'.$expenserp['expense_desc'].'*'.$expenserp['expense_date'].
  '*'.$expenserp['amount'].'*'.$expenserp['paid_to'].'&';
  
   }
   echo $expdetails;
	}
	
	
	
	
	
public function actionExpenseexcel($datefrom=null,$dateto=null,$accval=null){
	

 
       $datefrom1 = date("Y-m-d", strtotime($datefrom));
	   $dateto1 = date("Y-m-d", strtotime($dateto));

$qexp="SELECT ah.*, exp.* FROM  expenses as exp
LEFT outer JOIN   account_heads as ah
ON exp.account_id =ah.account_id
WHERE  exp.account_id in (".$accval.") and exp.expense_date between '".$datefrom1."' and '".$dateto1."'";
    
	$qf1=Yii::app()->db->createCommand($qexp)->queryAll();

      
	if(!empty($qf1)){
      Yii::import('ext.phpexcel.XPHPExcel');    
	  $objPHPExcel= XPHPExcel::createPHPExcel();
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
   

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Account name')
            ->setCellValue('B1', 'Account description')
            ->setCellValue('C1', 'Expense description')
            ->setCellValue('D1', 'Expense date')
			->setCellValue('E1', 'Amount')
			->setCellValue('F1', 'Paid to');
			
			
			$i=2;
			foreach($qf1 as $expenserp){
			
			$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $expenserp['account_name'])
		->setCellValue('B'.$i, $expenserp['account_desc'])
		->setCellValue('C'.$i, $expenserp['expense_desc'])
		->setCellValue('D'.$i, $expenserp['expense_date'])
		->setCellValue('E'.$i, $expenserp['amount'])
		->setCellValue('F'.$i, $expenserp['paid_to']);
		
$i++;
			}
				
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->setActiveSheetIndex(0);


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Expensereport.xls"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

   Yii::app()->end();

	
    }
	}
	
	
	public function actionFinalfeesreport(){
     
    
	 $this->render('finalfeesreport');
	
	}
	
	public function actionCalfeesreport($reporttype=null,$year=null){
     
	
	if($reporttype=="summaryreport"){
	
	$toyear=$year+1;
	$from=$year."-04-01";
	$to=$toyear."-03-31";
	$sumdetails="";
	
    $sqlsum="select student_class,sum(annual_fees_paid),sum(tuition_fees_paid),sum(funds_fees_paid),sum(sports_fees_paid),sum(activity_fees),sum(admission_fees_paid),sum(security_paid),sum(late_fees_paid),sum(dayboarding_fees_paid),sum(bus_fees_paid),sum(Total_amount),sum(amount_paid) from student_fees where date_payment between  '".$from."' and '".$to."' group by student_class order by student_class+0 asc";
	
	$qsum=Yii::app()->db->createCommand($sqlsum)->queryAll();
	
	foreach($qsum as $sumdata){
	
	$sumdetails.=$sumdata['student_class'].",".$sumdata['sum(annual_fees_paid)'].",".$sumdata['sum(tuition_fees_paid)'].",".$sumdata['sum(funds_fees_paid)'].",".$sumdata['sum(sports_fees_paid)'].",".$sumdata['sum(activity_fees)'].",".$sumdata['sum(admission_fees_paid)'].",".$sumdata['sum(security_paid)'].",".$sumdata['sum(late_fees_paid)'].",".$sumdata['sum(dayboarding_fees_paid)'].",".$sumdata['sum(bus_fees_paid)'].",".$sumdata['sum(Total_amount)'].",".$sumdata['sum(amount_paid)']."$";
	
	}
	
	echo $sumdetails;
	
	
	}
	}
	
	
	
	
	public function actionFeesexcel($reporttype=null,$year=null){
	
	if($reporttype=="summaryreport"){
	
	$toyear=$year+1;
	$from=$year."-04-01";
	$to=$toyear."-03-31";
	$sumdetails="";
	
    $sqlsum="select student_class,sum(annual_fees_paid),sum(tuition_fees_paid),sum(funds_fees_paid),sum(sports_fees_paid),sum(activity_fees),sum(admission_fees_paid),sum(security_paid),sum(late_fees_paid),sum(dayboarding_fees_paid),sum(bus_fees_paid),sum(Total_amount),sum(amount_paid) from student_fees where date_payment between  '".$from."' and '".$to."' group by student_class order by student_class+0 asc";
	
	$qsum=Yii::app()->db->createCommand($sqlsum)->queryAll();
	
	
	
	if(!empty($qsum)){
			  Yii::import('ext.phpexcel.XPHPExcel');    
			  $objPHPExcel= XPHPExcel::createPHPExcel();
			  $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
						
		   

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Class')
					->setCellValue('B1', 'Annual')
					->setCellValue('C1', 'Tution')
					->setCellValue('D1', 'Funds')
					->setCellValue('E1', 'Sports')
					->setCellValue('F1', 'Activity')
					->setCellValue('G1', 'Admission')
					->setCellValue('H1', 'Security')
					->setCellValue('I1', 'late')
					->setCellValue('J1', 'Dayboarding')
					->setCellValue('K1', 'Bus')
					->setCellValue('L1', 'Total')
					->setCellValue('M1', 'total fees after concession');
					
					
					
				  $i=2;
				  $totanualfees=0;
				  $tottutfees=0;
				  $totfundfees=0;
				  $totsportsfees=0;
				  $totactfees=0;
				  $totadmfees=0;
				  $totsecfees=0;
				  $totlatefees=0;
				  $totdayboardfees=0;
				  $totbusfees=0;
				  $totfees=0;
				  $amount=0;
				  
					foreach($qsum as $sumdata){
					
				  $totanualfees+=$sumdata['sum(annual_fees_paid)'];
				  $tottutfees+=$sumdata['sum(tuition_fees_paid)'];
				  $totfundfees+=$sumdata['sum(funds_fees_paid)'];
				  $totsportsfees+=$sumdata['sum(sports_fees_paid)'];
				  $totactfees+=$sumdata['sum(activity_fees)'];
				  $totadmfees+=$sumdata['sum(admission_fees_paid)'];
				  $totsecfees+=$sumdata['sum(security_paid)'];
				  $totlatefees+=$sumdata['sum(late_fees_paid)'];
				  $totdayboardfees+=$sumdata['sum(dayboarding_fees_paid)'];
				  $totbusfees+=$sumdata['sum(bus_fees_paid)'];
				  $totfees+=$sumdata['sum(Total_amount)'];
				  $amount+=$sumdata['sum(amount_paid)'];

					
					
					
					
					$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $sumdata['student_class'])
				->setCellValue('B'.$i, $sumdata['sum(annual_fees_paid)'])
				->setCellValue('C'.$i, $sumdata['sum(tuition_fees_paid)'])
				->setCellValue('D'.$i, $sumdata['sum(funds_fees_paid)'])
				->setCellValue('E'.$i, $sumdata['sum(sports_fees_paid)'])
				->setCellValue('F'.$i, $sumdata['sum(activity_fees)'])
				->setCellValue('G'.$i, $sumdata['sum(admission_fees_paid)'])
				->setCellValue('H'.$i, $sumdata['sum(security_paid)'])
				->setCellValue('I'.$i, $sumdata['sum(late_fees_paid)'])
				->setCellValue('J'.$i, $sumdata['sum(dayboarding_fees_paid)'])
				->setCellValue('K'.$i, $sumdata['sum(bus_fees_paid)'])
				->setCellValue('L'.$i, $sumdata['sum(Total_amount)'])
				->setCellValue('M'.$i, $sumdata['sum(amount_paid)']);
				
		$i++;
					}
					
				  
					
					$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, 'Total')
				->setCellValue('B'.$i, $totanualfees)
				->setCellValue('C'.$i, $tottutfees)
				->setCellValue('D'.$i, $totfundfees)
				->setCellValue('E'.$i, $totsportsfees)
				->setCellValue('F'.$i, $totactfees)
				->setCellValue('G'.$i, $totadmfees)
				->setCellValue('H'.$i,  $totsecfees)
				->setCellValue('I'.$i, $totlatefees)
				->setCellValue('J'.$i, $totdayboardfees)
				->setCellValue('K'.$i, $totbusfees)
				->setCellValue('L'.$i, $totfees)
				->setCellValue('M'.$i, $amount);
					
					
		$sheetname="summary".$year;			
						
		$objPHPExcel->getActiveSheet()->setTitle($sheetname);

		$objPHPExcel->setActiveSheetIndex(0);
       
	    $filename="Actualclasswise_yearlyreport".$year.".xls";

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='.$filename);
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

		   Yii::app()->end();

	
    }
	
	
	}
	
	else if($reporttype=="detailedreport"){
	
	Yii::import('ext.phpexcel.XPHPExcel');    
			  $objPHPExcel= XPHPExcel::createPHPExcel();
			  $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
						
		   
    $toyear=$year+1;
	$from=$year."-04-01";
	$to=$toyear."-03-31";
	$sumdetails="";
	
    /*$sqlsum="select student_class,sum(annual_fees_paid),sum(tuition_fees_paid),sum(funds_fees_paid),sum(sports_fees_paid),sum(activity_fees),sum(admission_fees_paid),sum(security_paid),sum(late_fees_paid),sum(dayboarding_fees_paid),sum(bus_fees_paid),sum(Total_amount),sum(amount_paid) from student_fees where date_payment between  '".$from."' and '".$to."' group by student_class order by student_class+0 asc";*/
	
	$sqlsum="select sc.class_no,count(sc.student_class_id),sum(fm.annual_fees) ,sum(fm.tuition_fees) ,sum(fm.funds_fees),sum(fm.sports_fees),sum(fm.activity_fees) ,sum(fm.admission_fees) ,sum(fm.security_fees) ,sum(fm.dayboarding_fees),(sum(fm.annual_fees)+sum(fm.tuition_fees)+sum(fm.funds_fees)+sum(fm.sports_fees)+sum(fm.activity_fees)+sum(fm.admission_fees)+sum(fm.security_fees)+sum(fm.dayboarding_fees)) as total from student_classes sc left join fees_master fm on(fm.class_no=sc.class_no) where sc.started_on >= '".$from."' and sc.ended_on <= '".$to."' group by sc.class_no order by sc.class_no+0 asc";
	
	$qsum=Yii::app()->db->createCommand($sqlsum)->queryAll();
    
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Class')
					->setCellValue('B1', 'Total students')
					->setCellValue('C1', 'Annual')
					->setCellValue('D1', 'Tution')
					->setCellValue('E1', 'Funds')
					->setCellValue('F1', 'Sports')
					->setCellValue('G1', 'Activity')
					->setCellValue('H1', 'Admission')
					->setCellValue('I1', 'Security')
					->setCellValue('J1', 'Dayboarding')
					->setCellValue('K1', 'Total');
					
					
					
				  $k=2;
				  $totanualsum=0;
				  $tottutsum=0;
				  $totfundsum=0;
				  $totsportssum=0;
				  $totactsum=0;
				  $totadmsum=0;
				  $totsecsum=0;
				  $totdayboardsum=0;
				  $totfeessum=0;
				  $amountsum=0;
				  $totalstu=0;
				  
					foreach($qsum as $sumdata){
					
					
				  $totalstu+=$sumdata['count(sc.student_class_id)'];
				  $totanualsum+=$sumdata['sum(fm.annual_fees)']*12;
				  $tottutsum+=$sumdata['sum(fm.tuition_fees)']*12;
				  $totfundsum+=$sumdata['sum(fm.funds_fees)']*12;
				  $totsportssum+=$sumdata['sum(fm.sports_fees)']*12;
				  $totactsum+=$sumdata['sum(fm.activity_fees)']*12;
				  $totadmsum+=$sumdata['sum(fm.admission_fees)']*12;
				  $totsecsum+=$sumdata['sum(fm.security_fees)']*12;
				  $totdayboardsum+=$sumdata['sum(fm.dayboarding_fees)']*12;
				  $totfeessum=$totanualsum+$tottutsum+$totfundsum+$totsportssum+$totactsum+$totadmsum+$totsecsum+$totdayboardsum;
				 
                  $amountsum+=$totfeessum;
					
					
					
					
					$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$k, $sumdata['class_no'])
				->setCellValue('B'.$k, $sumdata['count(sc.student_class_id)'])
				->setCellValue('C'.$k, $sumdata['sum(fm.annual_fees)']*12)
				->setCellValue('D'.$k, $sumdata['sum(fm.tuition_fees)']*12)
				->setCellValue('E'.$k, $sumdata['sum(fm.funds_fees)']*12)
				->setCellValue('F'.$k, $sumdata['sum(fm.sports_fees)']*12)
				->setCellValue('G'.$k, $sumdata['sum(fm.activity_fees)']*12)
				->setCellValue('H'.$k, $sumdata['sum(fm.admission_fees)']*12)
				->setCellValue('I'.$k, $sumdata['sum(fm.security_fees)']*12)
				->setCellValue('J'.$k, $sumdata['sum(fm.dayboarding_fees)']*12)
				->setCellValue('K'.$k, $totfeessum);
				
				
		$k++;
					}
					
				  
					
					$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$k, 'Total')
				->setCellValue('B'.$k, $totalstu)
				->setCellValue('C'.$k, $totanualsum)
				->setCellValue('D'.$k, $tottutsum)
				->setCellValue('E'.$k, $totfundsum)
				->setCellValue('F'.$k, $totsportssum)
				->setCellValue('G'.$k, $totactsum)
				->setCellValue('H'.$k, $totadmsum)
				->setCellValue('I'.$k,  $totsecsum)		
				->setCellValue('J'.$k, $totdayboardsum)		
				->setCellValue('K'.$k, $amountsum);
				
					
					
		$sheetname="summary".$year;			
						
		$objPHPExcel->getActiveSheet()->setTitle($sheetname);

		$objPHPExcel->setActiveSheetIndex(0);
	
	
	$array=array("P1","Q1","R1","S1","T1","U1","V1","W1","X1","Y1","Z1");
	$array1=array("P","Q","R","S","T","U","V","W","X","Y","Z");
	//$tmparray = array();
	$tmparray2 = array();
	
	
	for($j=1;$j<=12;$j++){
	
	
	if($j<10){
	   $month=$j+3;
	   $nextyear=$year;
	   }
	   if($j>9){
	   $month=$j-9;
	   $nextyear=$year+1;
	   }
	     
	  //$date="01-".$month."-".$nextyear;
	    $date=$year."-04-01";
	   
	$sqlconc="select * from concession_master";
	$qconc=Yii::app()->db->createCommand($sqlconc)->queryAll();
	
	$sqldetail="select sc.class_no, COUNT(sc.student_class_id),fm.annual_fees ,fm.tuition_fees ,fm.funds_fees,fm.sports_fees,fm.activity_fees ,fm.admission_fees ,fm.security_fees ,fm.dayboarding_fees ,COUNT(sm.student_id) as conc_none,";
	
	
	foreach($qconc as $concdata){
	
	$concname=preg_replace("/[^a-zA-Z]/", "", $concdata['concession_type']); 
	
	$sqldetail.=" COUNT(".$concname.".student_id) as ".$concname." ,";
	
	}
	
	$sqldetail= substr($sqldetail, 0, -1);
	
	
	$sqldetail.=" from student_classes sc left join fees_master fm on(fm.class_no=sc.class_no) 
	
	left join student_master sm on(sm.student_id=sc.student_id and sm.concession_id is null)"; 
	
	foreach($qconc as $concdata){
	
	$concname=preg_replace("/[^a-zA-Z]/", "", $concdata['concession_type']); 
	$sqldetail.=" left join student_master ".$concname." on(".$concname.".student_id=sc.student_id and ".$concname.".concession_id='".$concdata['concession_id']."')";
	
	}
	
	$sqldetail.=" where sc.started_on='".$date."'
	group by sc.class_no order by sc.class_no+0 asc";
	
	$qdetail=Yii::app()->db->createCommand($sqldetail)->queryAll();
	
	   $objWorkSheet = $objPHPExcel->createSheet(); 
	   $objPHPExcel->setActiveSheetIndex($j)->setCellValue('A1', 'Class');
		 $objPHPExcel->setActiveSheetIndex($j)->setCellValue('B1', 'No. of student');
		 $objPHPExcel->setActiveSheetIndex($j)->setCellValue('C1', 'Admissions');
		 $objPHPExcel->setActiveSheetIndex($j)->setCellValue('D1', 'Left students');
		 $objPHPExcel->setActiveSheetIndex($j)->setCellValue('E1', 'Total students');	

		 $objPHPExcel->setActiveSheetIndex($j)->setCellValue('F1', 'Annual fees');
		 $objPHPExcel->setActiveSheetIndex($j)->setCellValue('G1', 'Tution fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('H1', 'Funds fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('I1', 'Sports fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('J1', 'Activity fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('K1', 'Admission fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('L1', 'Security fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('M1', 'Dayboarding fees');
	    $objPHPExcel->setActiveSheetIndex($j)->setCellValue('N1', 'Total Expected fees');
	    $objPHPExcel->setActiveSheetIndex($j)->setCellValue('O1', 'No concession');
	  
	    for($col=0; $col<count($qconc); $col++ ){
		   
		  //$conctype=implode("",$qconc[$col]['concession_type']);
		  $conctype=$qconc[$col]['concession_type'];
		  $conctype=preg_replace("/[^a-zA-Z]/", "", $conctype);
	      $objPHPExcel->setActiveSheetIndex($j)->setCellValue($array[$col], $conctype);	
		}
		
		if($month=='4'){
		$worksheet='April'.$year;
		}
		if($month=='5'){
		$worksheet='May'.$year;
		}
		if($month=='6'){
		$worksheet='June'.$year;
		}
		if($month=='7'){
		$worksheet='July'.$year;
		}
		if($month=='8'){
		$worksheet='Aug'.$year;
		}
		if($month=='9'){
		$worksheet='Sep'.$year;
		}
		if($month=='10'){
		$worksheet='Oct'.$year;
		}
		if($month=='11'){
		$worksheet='Nov'.$year;
		}
		if($month=='12'){
		$worksheet='Dec'.$year;
		}
		if($month=='1'){
		$worksheet='Jan'.$nextyear;
		}
		if($month=='2'){
		$worksheet='Feb'.$nextyear;
		}
		if($month=='3'){
		$worksheet='March'.$nextyear;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle($worksheet);
		$objPHPExcel->setActiveSheetIndex($j);
	
	
	$i=2;
	$totanualfees=0;
	$tottutfees=0;
	$totfundfees=0;
	$totsportsfees=0;
	$totactfees=0;
	$totadmfees=0;
	$totsecfees=0;
	$totdayboardfees=0;
	$totfees=0;
	$totstu=0;
	$admstu=0;
	$leftstu=0;
		
    $anualfees=0;$tutfees=0;$fundfees=0;$sportsfees=0;$actfees=0;$admfees=0;$secfees=0;$dayboardfees=0;$fees=0;$stu=0;
	$adms=0;$lefts=0;	

    $class="";
    $concnone=0;	
					
	$totadm=0;
    $left=0;
	$afees=0;
	$tstu=0;
	$totalstudents=0;
	$noconcession=0;
	$totalconcession=0;
	$tot=0;
	$m=0;
	
	$tmparray=array();
	
	foreach($qdetail as $detdata){
	  
	$sqladm="select  count(sc.student_class_id) as adms  from  student_master sm left join student_classes sc on (sc.student_id=sm.student_id and sc.class_no='".$detdata['class_no']."')  where  month(sm.admission_date) in ('".$month."') and year(sm.admission_date) in ('".$nextyear."')";
	
	
	/*$sqladm="select sm.student_id,sm.student_name,sm.student_concessiontype from student_master sm left join student_classes sc on (sc.student_id=sm.student_id) where month(sm.admission_date) in ('".$month."') and year(sm.admission_date) in ('".$nextyear."') and sc.class_no='".$detdata['class_no']."'";*/
	
    $qadm=Yii::app()->db->createCommand($sqladm)->queryAll();
   
	//$totadm=count($qadm);
	//$countnewadmconc=0;
	foreach($qadm as $adm){
	$totadm=$adm['adms'];
	//if($adm['student_concessiontype']==""){
	//$countnewadmconc++;
	//}
	}
	
	
	$sqlleft="select  count(sc1.student_class_id) as leftstu  from  student_master sm1 left join student_classes sc1 on (sc1.student_id=sm1.student_id and sc1.class_no='".$detdata['class_no']."')  where  month(sm1.passedout_date) in ('".$month."') and year(sm1.passedout_date) in ('".$nextyear."')";
	
    $qleft=Yii::app()->db->createCommand($sqlleft)->queryAll();
   
	
	foreach($qleft as $totleft){
	$left=$totleft['leftstu'];
	}
	
	             //calculate new admissions and left students 
				  $class=$detdata['class_no'];
				  $adms=$totadm;
	              $lefts=$left;
                  $concnone=$detdata['conc_none'];
				  
				  if($j=='1'){
				  $stu=$detdata['COUNT(sc.student_class_id)'];
				  /*calculate total no. of students after new admissions and left.*/ 
				  $tstu= $stu+$adms-$lefts; 
				  array_push($tmparray,$tstu);
				  }
				  else{
				  $stu=$tmparray2[$m];
				  /*calculate total no. of students after new admissions and left.*/
				  $tstu=$stu+$adms-$lefts;
				  array_push($tmparray,$tstu);
				  }
				    
	              $totalstudents+=$tstu;
				  $noconcession=$concnone+$adms-$lefts;
				  $totalconcession+=$noconcession;
				  
				  
				  //calculate concession amount for subtracting from tution fees
				  $camt=0;
				  $cpercent=0;
				  $concstu=0;
				   for($col=0; $col<count($qconc); $col++ ){
		  
					//$conctyp=implode("",$qconc[$col]['concession_type']);
					$conctyp=$qconc[$col]['concession_type'];
					$conctyp1=preg_replace("/[^a-zA-Z]/", "", $conctyp);
					
					$concstu=$detdata[$conctyp1];
					
				    $sqlc="select * from concession_master where concession_type='".$conctyp."'";
					
			        $qc=Yii::app()->db->createCommand($sqlc)->queryAll();
					
					foreach($qc as $ct){
					
					if($ct['concession_persent']=='amount'){
					 $camt+=$ct['concession_amount']*$concstu;
					}
					else {
					$cpercent+=$ct['concession_amount']*$concstu;
					}
					}
		           }
				 
				
				  //calculate fees 
				  $anualfees=$detdata['annual_fees']*($stu+$adms);
				  $tutfees=$detdata['tuition_fees']*($stu+$adms);
				  //subtract concession from tution fees
				  $tutfees=$tutfees-(($cpercent/100*$tutfees)+$camt);
				  if($tutfees<0){
				  $tutfees=0;
				  }
				  $fundfees=$detdata['funds_fees']*($stu+$adms);
				  $sportsfees=$detdata['sports_fees']*($stu+$adms);
				  $actfees=$detdata['activity_fees']*($stu+$adms);
				  $admfees=$detdata['admission_fees']*($stu+$adms);
				  $secfees=$detdata['security_fees']*($stu+$adms);
				  $dayboardfees=$detdata['dayboarding_fees']*($stu+$adms);
				  $tot=($anualfees+$tutfees+$fundfees+$sportsfees+$actfees+$admfees+$secfees+$dayboardfees);
				  
				  //sum of all fees for all classes
				  $totanualfees+=$anualfees;
				  $tottutfees+=$tutfees;
				  $totfundfees+=$fundfees;
				  $totsportsfees+=$sportsfees;
				  $totactfees+=$actfees;
				  $totadmfees+=$admfees;
				  $totsecfees+= $secfees;
				  $totdayboardfees+=$dayboardfees;
				  $totstu+=$detdata['COUNT(sc.student_class_id)'];
	              $admstu+=$totadm;
	              $leftstu+=$left;
				  $totfees+=$tot;
				  
		
				 /* $afees=$detdata['total']/$detdata['COUNT(sc.student_class_id)']*$adms;
				  
				  $fees=$detdata['total']+ $afees;
				  $totfees+=$fees;*/
				  
				  
				  
	$objPHPExcel->setActiveSheetIndex($j)
				->setCellValue('A'.$i, $class)
				->setCellValue('B'.$i, $stu)
				->setCellValue('C'.$i, $adms)
				->setCellValue('D'.$i, $lefts)
				->setCellValue('E'.$i, $tstu)
				->setCellValue('F'.$i, $anualfees)
				->setCellValue('G'.$i, $tutfees)
				->setCellValue('H'.$i, $fundfees)
				->setCellValue('I'.$i, $sportsfees)
				->setCellValue('J'.$i, $actfees)
				->setCellValue('K'.$i, $admfees)
				->setCellValue('L'.$i, $secfees)
				->setCellValue('M'.$i, $dayboardfees)
				->setCellValue('N'.$i, $tot)
				->setCellValue('O'.$i, $noconcession);
				
		 for($col=0; $col<count($qconc); $col++ ){
		  
		    //$conctyp=implode("",$qconc[$col]['concession_type']);
			$conctyp=$qconc[$col]['concession_type'];
		    $conctyp=preg_replace("/[^a-zA-Z]/", "", $conctyp);

	        $objPHPExcel->setActiveSheetIndex($j)->setCellValue($array1[$col].$i, $detdata[$conctyp]);	
		    
		}	
				
				
						
		$i++;
	    $m++;
	
	
	}
	
	 
				  
	              
    
	 $objPHPExcel->setActiveSheetIndex($j)
				->setCellValue('A'.$i, 'Total')
				->setCellValue('B'.$i, $totstu)
				->setCellValue('C'.$i, $admstu)
				->setCellValue('D'.$i,  $leftstu)
				->setCellValue('E'.$i, $totalstudents)
				->setCellValue('F'.$i, $totanualfees)
				->setCellValue('G'.$i, $tottutfees)
				->setCellValue('H'.$i, $totfundfees)
				->setCellValue('I'.$i,  $totsportsfees)
				->setCellValue('J'.$i,  $totactfees)
				->setCellValue('K'.$i, $totadmfees)
				->setCellValue('L'.$i, $totsecfees)
				->setCellValue('M'.$i, $totdayboardfees)
				->setCellValue('N'.$i, $totfees)
				->setCellValue('O'.$i, $totalconcession);
				
	     $tmparray2=$tmparray; 
		  
        }
		
		/*$objWorkSheet = $objPHPExcel->createSheet();            
        $objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Class')
					->setCellValue('B1', 'Annual')
					->setCellValue('C1', 'Tution')
					->setCellValue('D1', 'total fees after concession');
		
		
		$sheet = $objPHPExcel->getSheet(0);
        $sheet->setCellValue('A2', '1')
				->setCellValue('B2', '2000')
				->setCellValue('C2', '4000')
				->setCellValue('D2', '355555');

		
		$objWorkSheet = $objPHPExcel->createSheet();            
        $objPHPExcel->setActiveSheetIndex(1)
		            ->setCellValue('A1', 'test1')
					->setCellValue('B1', 'test2')
					->setCellValue('C1', 'test3')
					->setCellValue('D1', 'test4');
		
		
		$sheet = $objPHPExcel->getSheet(1);
        $sheet->setCellValue('A2', '1')
				->setCellValue('B2', '2000')
				->setCellValue('C2', '4000')
				->setCellValue('D2', '355555');*/
		
	
		$filename="Expectedclasswise_monthlyreport".$year.".xls";
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='.$filename);
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

		   Yii::app()->end();
	
	}
	
	}
	
	public function actionActivityfeesreport(){
            
	  $this->render('activityreport');
	
	}
	
	
	public function actionActivitydata($datefrom=null,$c=null,$dateto=null){
		 
		 $datefrom1 = date("Y-m-d", strtotime($datefrom));
	     $dateto1 = date("Y-m-d", strtotime($dateto));
		 $df1="";
		 $dt1="";
		 $df=explode( '-', $datefrom);
		 $dt=explode( '-', $dateto);
		 if($df[1]<10 ){
		 $df1= ltrim($df[1], '0');
		 } 
		 else{
		 $df1=$df[1];
		 }
		 
		 if($dt[1]<10){
		 $dt1= ltrim($dt[1], '0');
		 }
		 else{
		 $dt1=$dt[1];
		 }
		 
		 $tmparray=array();
		 $tmp="";
		 if($dt1 > 3 && $dt1 <= 12){
		 for($j=$df1;$j<=$dt1;$j++){
		 $tmp.=$j;
		   array_push($tmparray,$j);
			if($j!=$dt1)
				$tmp.=",";
		 
		 }
		 }
		 elseif ($dt1 < 4){
		 
		 for($q=$df1;$q<=12;$q++){
		    $tmp.=$q;
			$tmp.=",";
		 
		 }
		  for($k=1;$k<=$dt1;$k++){
		  $tmp.=$k;
			if($k!=$dt1)
				$tmp.=",";
		 
		 }
		}
		
		 
		
		if($c!=""){
		
/*$query="SELECT  sf.*,sm.*, GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months, sc.section from student_fees sf left join student_master sm on (sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where fees_period_month in (".$tmp.") and activity_fees=0 and student_class=".$c." group by sf.student_id order by sm.addmission_no asc";*/


//$query="SELECT sf.*,sm.*, GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months, sc.section from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where sf1.fees_period_month in (".$tmp.") and sf1.student_class='".$c."' group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0) and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."')  group by sf.student_id order by sm.addmission_no asc";

 

$query5="SELECT sf.*,sm.*, GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months, sc.section from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select distinct student_id from student_fees sf1 where sf1.fees_period_month in (".preg_replace("/\s\s+/", " ",$tmp).") and sf1.student_class=".preg_replace("/\s\s+/", " ",$c)." group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0) and fees_period_month in (".preg_replace("/\s\s+/", " ",$tmp).") and student_class='".$c."' and (sm.passedout_date is null or sm.passedout_date > '".preg_replace("/\s\s+/", " ",$dateto1)."') group by sf.student_id ORDER BY sf.student_id ASC";

$query5=preg_replace("/\s\s+/", " ", $query5);
//print_r(Yii::app()->db);
//echo $query5;
$query1=Yii::app()->db->createCommand($query5)->queryAll();
//print_r($query1);
/*$connection = Yii::app()->db;
try{
		$command = $connection->createCommand($query);
		$list = $command->query();
		}catch(\yii\db\Exception $e) {
			print_r($e);

        }    

print_r($list);
while ($list->nextResult()){
				print_r($list);
	
			}
exit;*/

      $details="";
	  foreach($query1 as $data){
	    
	    //$feespaid=explode(",",$data['months']);
		//$feespaid=array_map('trim',$feespaid);
		//$arr = array_intersect($tmparray, $feespaid);
		//$result = array_diff($tmparray, $arr);
	    //$feesunpaid=implode(",",$result);
	  echo $data['student_id']."-------".$data['addmission_no'].'*'.$data['student_name'].'*'.$data['student_class'].'*'.$data['section'].'*'.$data['fees_period_month'].'&<br/>';
	 
 $details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['student_class'].'*'.$data['section'].'*'.$data['fees_period_month'].'&';
	
	  }
		
	 }
	 
	 else{
	 
	/* $query="SELECT  sf.*,sm.*, sc.* ,GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months from student_fees sf left join student_master sm on (sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where fees_period_month in (".$tmp.") and activity_fees=0 group by sf.student_id order by sm.addmission_no asc";
   
  
//$query="SELECT sf.*,sm.*, GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months, sc.section from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where sf1.fees_period_month in (".$tmp.")   group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0) and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."')  group by sf.student_id order by sm.addmission_no asc";

$query="SELECT sf.*,sm.*, GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months, sc.section from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where fees_period_month in (".$tmp.") group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0) and fees_period_month in (".$tmp.") and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."')  group by sf.student_id ORDER BY `sf`.`student_id` ASC";

$query1=Yii::app()->db->createCommand($query)->queryAll();
  
      $details="";
	  foreach($query1 as $data){
	  
	    /*$feespaid=explode(",",$data['months']);
		$feespaid=array_map('trim',$feespaid);
		$arr = array_intersect($tmparray, $feespaid);
		$result = array_diff($tmparray, $arr);
	    $feesunpaid=implode(",",$result);
	 
 $details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'*'.$data['fees_period_month'].'&';

	  }
	    */
	 }
	  echo $details;
	}
	
	
	
	
	
	public function actionActivityexcel($datefrom=null,$c=null,$dateto=null){
	
	    
		 $datefrom1 = date("Y-m-d", strtotime($datefrom));
	     $dateto1 = date("Y-m-d", strtotime($dateto));
		 $df1="";
		 $dt1="";
		 $df=explode( '-', $datefrom);
		 $dt=explode( '-', $dateto);
		 
		 if($df[1]<10 ){
		 $df1= ltrim($df[1], '0');
		 } 
		 else{
		 $df1=$df[1];
		 }
		 
		 if($dt[1]<10){
		 $dt1= ltrim($dt[1], '0');
		 }
		 else{
		 $dt1=$dt[1];
		 }
		 
		 $tmparray=array();
		 $tmp="";
		 
		 if($dt1 > 3 && $dt1 <= 12){
		 for($j=$df1;$j<=$dt1;$j++){
		 $tmp.=$j;
		   array_push($tmparray,$j);
			if($j!=$dt1)
				$tmp.=",";
		 
		 }
		 }
		
		elseif ($dt1 < 4){
		 
		 for($q=$df1;$q<=12;$q++){
		    $tmp.=$q;
			$tmp.=",";
		 
		 }
		  for($k=1;$k<=$dt1;$k++){
		  $tmp.=$k;
			if($k!=$dt1)
				$tmp.=",";
		 
		 }
		}
		
		
    if($c!=""){
		 
/*$query="SELECT  sf.*,sm.*, sc.section,GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months from student_fees sf left join student_master sm on (sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where fees_period_month in (".$tmp.") and activity_fees=0 and student_class=".$c." group by sf.student_id order by sm.addmission_no asc";*/

$query="SELECT sf.*,sm.*, GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months, sc.section from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where sf1.fees_period_month in (".$tmp.") and sf1.student_class=".$c." group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0) and fees_period_month in (".$tmp.") and student_class=".$c." and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."') group by sf.student_id ORDER BY `sf`.`student_id` ASC";


$query1=Yii::app()->db->createCommand($query)->queryAll();

     
	
	  Yii::import('ext.phpexcel.XPHPExcel');    
	 
	 
	  $objPHPExcel= XPHPExcel::createPHPExcel();
	  
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
        

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Admission no')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Class')
            ->setCellValue('D1', 'Section')
			->setCellValue('E1', 'ActivityFees unpaid for months');
			
		$i=2;
			
			foreach($query1 as $actrep){
                
			    /*$feespaid=explode(",",$data['months']);
				$feespaid=array_map('trim',$feespaid);
				$arr = array_intersect($tmparray, $feespaid);
				$result = array_diff($tmparray, $arr);
				$feesunpaid=implode(",",$result);*/
	  
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $actrep['addmission_no'])
		->setCellValue('B'.$i, $actrep['student_name'])
		->setCellValue('C'.$i, $actrep['student_class'])
		->setCellValue('D'.$i, $actrep['section'])
		->setCellValue('E'.$i,$actrep['fees_period_month']);
			
			$i++;
			}
			
			
			
			
		}	
		else{
		
		//$query="SELECT  sf.*,sm.*, sc.*,GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months from student_fees sf left join student_master sm on (sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where fees_period_month in (".$tmp.") and activity_fees=0 group by sf.student_id order by sm.addmission_no asc";

		$query="SELECT sf.*,sm.*, GROUP_CONCAT(DISTINCT fees_period_month SEPARATOR ', ') AS months, sc.section from student_fees sf left join student_master sm on(sm.student_id=sf.student_id) left join student_classes sc on (sc.student_id=sm.student_id) where sf.student_id in (select student_id from student_fees sf1 where fees_period_month in (".$tmp.") group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0) and fees_period_month in (".$tmp.") and (sm.passedout_date is null or sm.passedout_date > '".$dateto1."')  group by sf.student_id ORDER BY `sf`.`student_id` ASC";


        $query1=Yii::app()->db->createCommand($query)->queryAll();

	
	  Yii::import('ext.phpexcel.XPHPExcel');    
	 
	 
	  $objPHPExcel= XPHPExcel::createPHPExcel();
	  
      $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                            ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");
				
        

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Admission no')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Class')
            ->setCellValue('D1', 'Section')
			->setCellValue('E1', 'ActivityFees unpaid for months');
			
		$i=2;
			
			foreach($query1 as $actrep){
			
			    /*$feespaid=explode(",",$data['months']);
				$feespaid=array_map('trim',$feespaid);
				$arr = array_intersect($tmparray, $feespaid);
				$result = array_diff($tmparray, $arr);
				$feesunpaid=implode(",",$result);*/
               
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $actrep['addmission_no'])
		->setCellValue('B'.$i, $actrep['student_name'])
		->setCellValue('C'.$i, $actrep['class_no'])
		->setCellValue('D'.$i, $actrep['section'])
		->setCellValue('E'.$i, $actrep['fees_period_month']);
			
			$i++;
			
			
			}
			
		}
			
							
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->setActiveSheetIndex(0);

 

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Activityreport.xls"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

   Yii::app()->end();


}


	
}	
	
	


	




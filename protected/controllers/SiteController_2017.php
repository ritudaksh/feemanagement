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
		
		/* get the fee defaulter data
			lloks at the tuitionfees_sportsfees+funds
			year is the financial year, and defaulters list ignores students who phave passe dout date < today
		*/
		public function actionDefaultersData($c=null,$radioval=null,$year=null)
		{
			$feesrecord="";
			if($year==null or $year==""){
				$year=(date('m')<'04') ? date('Y',strtotime('-1 year')) : date('Y');
			}
//			 echo "selected year=".$year;
			 $currentdate=date('Y-m-d');
			 $montharray = $this->get_months_array($year);
			 $months = implode(",",$montharray);
			 
			
			//this query returns students who have paid
			$query = "select student_fees.student_id,group_concat(trim(student_fees.fees_period_month) order by student_fees.fees_period_month+0) 
			as months_paid,student_fees.student_class,student_master.addmission_no,student_master.admission_date,student_master.passedout_date,
			student_master.student_name,student_classes.section from student_fees LEFT JOIN student_master ON student_fees.student_id = student_master.student_id 
			LEFT JOIN student_classes ON student_fees.student_id=student_classes.student_id  and student_classes.class_no=student_class"; // students who have to deposit fees
			$where = " where student_fees.year='".$year."' and(ifnull(student_fees.tuition_fees_paid,0) +ifnull(student_fees.funds_fees_paid,0)+ 
			ifnull(student_fees.sports_fees_paid,0))>0 ";
			$orderby = " group by student_fees.student_id having months_paid !='".$months."' order by student_fees.student_class,section,student_master.addmission_no";
			
			//if class selected, add class to where clause
			if($c!=""  )
			{
				$where .= " and student_class='".$c."'";
			}
			//build the query
			$query .= $where.$orderby;
//			echo $query;
			$query1=Yii::app()->db->createCommand($query)->queryAll();
			$mp='';
			foreach($query1 as $data)
			{
				$feesrecord='';
				$mp  = $data['months_paid'];
				$passedout_date  = $data['passedout_date'];
				//some data in fee_period_months has gone in with spaces like "1, 2, 3", sp spaces need to be removed
				$mp2 =array_map('trim', explode(',', $mp));
				//get the diff of the months not paid for
				$tmp = array_diff($montharray,$mp2);
				$tmpval  = implode(",",$tmp);
				if($tmpval==0 or ($radioval!='withpassedout' and ($passedout_date != null and $passedout_date!='' and $passedout_date< $currentdate)) ) //all months paid for student passed out
				{
					//				print_r('no value');
				}
				else
				{
					$feesrecord=$feesrecord.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['student_class'].'*'.$data['section'].'*'.$tmpval.'$';
					echo $feesrecord; 
				}
			}
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
				
				$q="select cls.*,sf.*,sm.addmission_no , sm.student_name,con.concession_type from student_classes cls right join student_fees sf on (sf.student_id=cls.student_id and date_payment between '".$datefrom1."' and '".$dateto1."') right join student_master sm on (sm.student_id=cls.student_id) left join concession_master as con ON(con.concession_id=sf.concession_type_id) where cls.started_on >= ".$sessionstarts." order by sf.date_payment desc,sm.addmission_no";
				
			}
			
			else{
				
				$q="select a.* ,cls.*, sm.addmission_no,sm.student_name, con.concession_type from 
				student_fees a LEFT JOIN student_master sm on (sm.student_id=a.student_id) 
				left JOIN concession_master as con ON(con.concession_id=a.concession_type_id)
				LEFT outer JOIN   student_classes as cls
				ON (sm.student_id =cls.student_id)	
				WHERE a.date_payment between '".$datefrom1."' and '".$dateto1."' 
				and cls.student_class_id=(select max(student_class_id) 
				from student_classes where student_id = sm.student_id) 
				order by a.date_payment desc,sm.addmission_no"; 
/* wo class join				$q="select a.* ,sm.addmission_no,sm.student_name, con.concession_type from 
				student_fees a LEFT JOIN student_master sm on (sm.student_id=a.student_id) 
				left JOIN concession_master as con ON(con.concession_id=a.concession_type_id)
				WHERE a.date_payment between '".$datefrom1."' and '".$dateto1."' 
				order by a.date_payment desc,sm.addmission_no"; */
			}
			
			
			
			$qf=Yii::app()->db->createCommand($q)->queryAll();
			
			$feedetails="";
			$amount="";
			$totanualfees=0;$tottutfees=0; $totfundfees=0;$totsportsfees=0;$totactfees=0;
			$totadmfees=0;$totsecfees=0;$totlatefees=0; $totdayboardfees=0;$totbusfees=0;$totfees=0;$totconc=0;
			foreach($qf as $fee){
				
				
//without class join				$feedetails=$feedetails.$fee['addmission_no'].'!'.$fee['student_name'].'!'.$fee['student_class'].'!'.''.'!'.$fee['fees_for_months'].'!'.$fee['fees_period_month'].'!'.$fee['annual_fees_paid'].'!'.$fee['tuition_fees_paid'].'!'.$fee['funds_fees_paid'].'!'.$fee['sports_fees_paid'].'!'.$fee['activity_fees'].'!'.$fee['admission_fees_paid'].'!'.$fee['security_paid'].'!'.$fee['late_fees_paid'].'!'.$fee['dayboarding_fees_paid'].'!'.$fee['bus_fees_paid'].'!'.$fee['amount_paid'].'!'.$fee['date_payment'].'!'.$fee['payment_mode'].'!'.$fee['cheq_no'].'!'.$fee['bank_name'].'!'.(is_numeric($fee['concession_applied'])?$fee['concession_applied']:0).'!'.$fee['concession_type'].'!'.$fee['Total_amount'].'&';
				$feedetails=$feedetails.$fee['addmission_no'].'!'.$fee['student_name'].'!'.$fee['class_no'].'!'.$fee['section'].'!'.$fee['fees_for_months'].'!'.$fee['fees_period_month'].'!'.$fee['annual_fees_paid'].'!'.$fee['tuition_fees_paid'].'!'.$fee['funds_fees_paid'].'!'.$fee['sports_fees_paid'].'!'.$fee['activity_fees'].'!'.$fee['admission_fees_paid'].'!'.$fee['security_paid'].'!'.$fee['late_fees_paid'].'!'.$fee['dayboarding_fees_paid'].'!'.$fee['bus_fees_paid'].'!'.$fee['amount_paid'].'!'.$fee['date_payment'].'!'.$fee['payment_mode'].'!'.$fee['cheq_no'].'!'.$fee['bank_name'].'!'.$fee['concession_applied'].'!'.$fee['concession_type'].'!'.$fee['Total_amount'].'!'.$fee['cheque_status'].'!'.$fee['realized_date'].'||';
				
/* cheque_status and realized_date added */								
				
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
				$totconc+=is_numeric($fee['concession_applied'])?$fee['concession_applied']:0;
				
			}
			
			
			echo $feedetails.'$'.$amount.'$'. $totanualfees.'$'. $tottutfees.'$'. $totfundfees.'$'. $totsportsfees.'$'. $totactfees
			.'$'. $totadmfees.'$'. $totsecfees.'$'. $totlatefees.'$'. $totdayboardfees.'$'. $totbusfees.'$'. $totfees.'$'.$totconc;
			
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
				$q="select cls.*,sf.*,sm.addmission_no , sm.student_name,con.concession_type from student_classes cls right join student_fees sf on (sf.student_id=cls.student_id and date_payment between '".$datefrom1."' and '".$dateto1."') right join student_master sm on (sm.student_id=cls.student_id) left join concession_master as con ON(con.concession_id=sf.concession_type_id) where cls.started_on >= ".$sessionstarts." order by sf.date_payment desc,sm.addmission_no";
				
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
				from student_classes where student_id = sm.student_id) order by a.date_payment desc,sm.addmission_no";
			}
			
			$qc=Yii::app()->db->createCommand($q)->queryAll();
			
			if(!empty($qc)){
				Yii::import('ext.phpexcel.XPHPExcel');    
				$objPHPExcel= XPHPExcel::createPHPExcel();
				$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali Fee Collection")
				->setSubject("SNPS Mohali Fee Collection")
				->setDescription("SNPS Mohali Fee Collection")
				->setKeywords("SNPS Mohali")
				->setCategory("SNPS Mohali");

				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Admission no')
				->setCellValue('B1', 'Name')
				->setCellValue('C1', 'Class')
				->setCellValue('D1', 'Section')
				->setCellValue('E1', 'Fees for months')
				->setCellValue('F1', 'Fees paid for month')
				->setCellValue('G1', 'Annual fees')
				->setCellValue('H1', 'Tution fees')
				->setCellValue('I1', 'Concession applied')
				->setCellValue('J1', 'Net tution fees')
				->setCellValue('K1', 'Fund fees')
				->setCellValue('L1', 'Sports fees')
				->setCellValue('M1', 'Activity fees')
				->setCellValue('N1', 'Admission fees')
				->setCellValue('O1', 'Security fees')
				->setCellValue('P1', 'Late fees')
				->setCellValue('Q1', 'Dayboarding fees')
				->setCellValue('R1', 'Bus fees')
				->setCellValue('S1', 'Payment date')
				->setCellValue('T1', 'Payment mode')
				->setCellValue('U1', 'Chequeno')
				->setCellValue('V1', 'Bank Name')
				->setCellValue('W1', 'Concession type')
				->setCellValue('X1', 'Total amount')
				->setCellValue('Y1', 'Amount paid')
				->setCellValue('Z1', 'Cheque status')
				->setCellValue('AA1', 'Realized date');

				
				$i=2;
				$amount=0;
				$totanualfees=0;$tottutfees=0; $totfundfees=0;$totsportsfees=0;$totactfees=0;
				$totadmfees=0;$totsecfees=0;$totlatefees=0; $totdayboardfees=0;$totbusfees=0;$totfees=0;$totconc=0;$tutfees=0;
				
				foreach($qc as $collectionrp){
					
					if($collectionrp['tuition_fees_paid']==0){
						$collectionrp['concession_applied']=0;
					}
					
					$nettutfees=$collectionrp['tuition_fees_paid']-$collectionrp['concession_applied'];
					$tutfees+=$nettutfees;
					$totconc+=$collectionrp['concession_applied'];
					
					
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
					->setCellValue('I'.$i, $collectionrp['concession_applied'])
					->setCellValue('J'.$i, $nettutfees)
					->setCellValue('K'.$i, $collectionrp['funds_fees_paid'])
					->setCellValue('L'.$i, $collectionrp['sports_fees_paid'])
					->setCellValue('M'.$i, $collectionrp['activity_fees'])
					->setCellValue('N'.$i, $collectionrp['admission_fees_paid'])
					->setCellValue('O'.$i, $collectionrp['security_paid'])
					->setCellValue('P'.$i, $collectionrp['late_fees_paid'])
					->setCellValue('Q'.$i, $collectionrp['dayboarding_fees_paid'])
					->setCellValue('R'.$i, $collectionrp['bus_fees_paid'])
					->setCellValue('S'.$i, $collectionrp['date_payment'])
					->setCellValue('T'.$i, $collectionrp['payment_mode'])
					->setCellValue('U'.$i, $collectionrp['cheq_no'])
					->setCellValue('V'.$i, $collectionrp['bank_name'])
					->setCellValue('W'.$i, $collectionrp['concession_type'])
					->setCellValue('X'.$i, $collectionrp['Total_amount'])
					->setCellValue('Y'.$i, $collectionrp['amount_paid'])	
					->setCellValue('Z'.$i, $collectionrp['cheque_status'])
					->setCellValue('AA'.$i, $collectionrp['realized_date']);
					$i++;
				}
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, 'Total Collection')
				->setCellValue('G'.$i, $totanualfees)
				->setCellValue('H'.$i,  $tottutfees)
				->setCellValue('I'.$i,  $totconc)
				->setCellValue('J'.$i,  $tutfees)
				->setCellValue('K'.$i, $totfundfees)
				->setCellValue('L'.$i,  $totsportsfees)
				->setCellValue('M'.$i, $totactfees)
				->setCellValue('N'.$i, $totadmfees)
				->setCellValue('O'.$i, $totsecfees)
				->setCellValue('P'.$i, $totlatefees)
				->setCellValue('Q'.$i, $totdayboardfees)
				->setCellValue('R'.$i, $totbusfees)
				->setCellValue('X'.$i,  $totfees)
				->setCellValue('Y'.$i, $amount);
					

				
				
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
			
			if($busno>0){
			$q1="SELECT stu.*, cls.*,bf.route,bf.destination FROM  student_master as stu
			LEFT outer JOIN   student_classes as cls
			ON stu.student_id =cls.student_id right join busfees_master bf on (bf.bus_id=stu.bus_id and route='".$busno."')
			WHERE  cls.student_class_id=(select max(student_class_id) 
			from student_classes where student_id = stu.student_id) order by bf.route,cls.class_no";
			}
			else{
			$q1="SELECT stu.*, cls.*,bf.route,bf.destination FROM  student_master as stu
			LEFT outer JOIN   student_classes as cls
			ON stu.student_id =cls.student_id right join busfees_master bf on (bf.bus_id=stu.bus_id )
			WHERE  cls.student_class_id=(select max(student_class_id) 
			from student_classes where student_id = stu.student_id) order by bf.route,cls.class_no";
			}
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
			
			if($busno>0){
			$q1="SELECT stu.*, cls.*,bf.route,bf.destination FROM  student_master as stu
			LEFT outer JOIN   student_classes as cls
			ON stu.student_id =cls.student_id right join busfees_master bf on (bf.bus_id=stu.bus_id and route='".$busno."')
			WHERE  cls.student_class_id=(select max(student_class_id) 
			from student_classes where student_id = stu.student_id) order by bf.route,cls.class_no";
			}
			else{
			$q1="SELECT stu.*, cls.*,bf.route,bf.destination FROM  student_master as stu
			LEFT outer JOIN   student_classes as cls
			ON stu.student_id =cls.student_id right join busfees_master bf on (bf.bus_id=stu.bus_id )
			WHERE  cls.student_class_id=(select max(student_class_id) 
			from student_classes where student_id = stu.student_id) order by bf.route,cls.class_no";
			}
			
			if(!empty($qf1)){
				Yii::import('ext.phpexcel.XPHPExcel');    
				$objPHPExcel= XPHPExcel::createPHPExcel();
				$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali  Document")
				->setSubject("SNPS Mohali Document")
				->setDescription("Document for SNPS Mohali")
				->setKeywords("SNPS Mohali")
				->setCategory("SNPS Mohali");
/*
$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali Actual Fees Report")
				->setSubject("SNPS Mohali Actual Fees Report")
				->setDescription("SNPS Mohali Actual Fees Report")
				->setKeywords("SNPS Mohali Actual Fees Report")
				->setCategory("SNPS Mohali Actual Fees Report");
*/
				
				
				
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
				from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no='".$cls."'  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no desc";
			}
			else{
				$sql="SELECT stu.*,cls.* from student_master as stu LEFT outer join student_classes as cls 
				on cls.student_id = stu.student_id where cls.student_class_id = (select max(student_class_id) 
				from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no in ('Play-way','Pre-nursery','nursery','KG','1','2','3','4','5','6','7','8','9','10','11','12')  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no desc";
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
				from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no='".$cls."'  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no desc";
			}
			else{
				
				$sql="SELECT stu.*,cls.* from student_master as stu LEFT outer join student_classes as cls 
				on cls.student_id = stu.student_id where cls.student_class_id = (select max(student_class_id) 
				from student_classes where student_id = stu.student_id) and cls.class_no!='NULL' and cls.class_no in ('Play-way','Pre-nursery','nursery','KG','1','2','3','4','5','6','7','8','9','10','11','12')  and stu.admission_date between '".$datefrom1."' and '".$dateto1."' order by stu.addmission_no desc";
			}
			
			$query=Yii::app()->db->createCommand($sql)->queryAll();
			
			
			
			if(!empty($query)){
				Yii::import('ext.phpexcel.XPHPExcel');    
				$objPHPExcel= XPHPExcel::createPHPExcel();
				$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali Admission Report")
				->setSubject("SNPS Mohali Admission Report")
				->setDescription("SNPS Mohali Admission Report")
				->setKeywords("SNPS Mohali Admission Report")
				->setCategory("SNPS Mohali Admission Report");
				
				
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
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali")
				->setSubject("SNPS Mohali Expense Excel")
				->setDescription("SNPS Mohali Expense Excel")
				->setKeywords("SNPS Mohali Expense Excel")
				->setCategory("SNPS Mohali Expense Excel");

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
		
		
		
		//final fees report for 2: summary and actual
		// summary and actual is on actual receipts for date_payment between 1/4 to 31/3
		public function actionFeesexcel($reporttype=null,$year=null){
			
			if($reporttype=="summaryreport"){
				
				$toyear=$year+1;
				$from=$year."-04-01";
				$to=$toyear."-03-31";
				$sumdetails="";
				
				$sqlsum="select student_class,sum(annual_fees_paid),sum(tuition_fees_paid),sum(funds_fees_paid),sum(sports_fees_paid),sum(activity_fees),sum(admission_fees_paid),sum(security_paid),sum(late_fees_paid),sum(dayboarding_fees_paid),sum(bus_fees_paid),sum(Total_amount),sum(amount_paid) from student_fees where year=$year and date_payment between  '".$from."' and '".$to."' group by student_class order by student_class+0 asc";
				
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
			
			else if($reporttype=="actualreport"){
				/* for 2018 data */
				Yii::import('ext.phpexcel.XPHPExcel');    
				$objPHPExcel= XPHPExcel::createPHPExcel();
				$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali Actual Fees Report")
				->setSubject("SNPS Mohali Actual Fees Report")
				->setDescription("SNPS Mohali Actual Fees Report")
				->setKeywords("SNPS Mohali Actual Fees Report")
				->setCategory("SNPS Mohali Actual Fees Report");
				
				
				$toyear=$year+1;
				$from=$year."-04-01";
				$to=$toyear."-03-31";
				$sumdetails="";
				
				//for all; if cheque, only realized
/*				$sqlsum="select student_class,count(distinct student_id),sum(annual_fees_paid) as annual_fees_paid ,sum(tuition_fees_paid)  as tuition_fees_paid ,sum(funds_fees_paid) as funds_fees_paid,sum(sports_fees_paid) as sports_fees_paid,sum(activity_fees)  as activity_fees ,sum(admission_fees_paid) as admission_fees_paid ,sum(security_paid) as security_paid ,sum(late_fees_paid) as late_fees_paid,sum(dayboarding_fees_paid) as dayboarding_fees_paid ,sum(bus_fees_paid) as busfees,sum(concession_applied) as concession_applied, sum(amount_paid) as amount_paid,
				sum(IF((payment_mode='Cash'),amount_paid,0)) as cash ,
				sum(if(payment_mode='Cheque',if(cheque_status!='realized',0,amount_paid),0) ) as cheque ,
				sum(if(payment_mode='Online',amount_paid,0) ) as online 
				from student_fees where
				(year='".$year
				."' or (year = '".($year-1)."' and month(date_payment)=4)) and date_payment between  '".$from."' and '".$to
				."' group by student_class order by student_class+0 asc";
*/				//below woithout concessional students who have paid cash
				//also year can be this year 2016 also defaulters fees paid for year 2015, hence year <= currentyear in the query 
/*				$sqlsum="select student_class,count(distinct f.student_id),
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6 ),0,annual_fees_paid)) as annual_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6 ),0,tuition_fees_paid)) as tuition_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6),0,funds_fees_paid)) as funds_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6),0,sports_fees_paid)) as sports_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6),0,late_fees_paid)) as late_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6),0,admission_fees_paid)) as admission_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6),0,security_paid)) as security_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0 and student_class < 6),0,dayboarding_fees_paid)) as dayboarding_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6 ),0,activity_fees)) as activity_fees ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,bus_fees_paid)) as busfees ,
				sum(concession_applied) as concession_applied,  
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,amount_paid)) as amount_paid,
				sum(IF((payment_mode='Cash'),(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6 ),0,amount_paid)),0)) as cash ,
				sum(if(payment_mode='Cheque',if(cheque_status!='realized',0,amount_paid),0) ) as cheque ,
				sum(if(payment_mode='Online',amount_paid,0) ) as online 
				from student_fees f left join student_master m on f.student_id=m.student_id 
				where (year='".$year
				."' or (year = '".($year-1)."' and month(date_payment)=4)) and date_payment between  '".$from."' and '".$to
				."' group by student_class order by student_class+0 asc"; */
				/* for advances paid for 2019 session, ignoring concessional < 6, also original for adm fee and security  
					*/
					$sqlsum="select student_class,count(distinct f.student_id),
					sum(IF((payment_mode='Cash' and concession_applied > 0 ),0,annual_fees_paid)) as annual_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0 ),0,tuition_fees_paid)) as tuition_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,funds_fees_paid)) as funds_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,sports_fees_paid)) as sports_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,late_fees_paid)) as late_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,admission_fees_paid)) as admission_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,security_paid)) as security_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,dayboarding_fees_paid)) as dayboarding_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0 ),0,activity_fees)) as activity_fees ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,bus_fees_paid)) as busfees ,
					sum(concession_applied) as concession_applied,  
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,amount_paid)) as amount_paid,
					sum(IF((payment_mode='Cash'),(IF((payment_mode='Cash' and concession_applied > 0 ),0,amount_paid)),0)) as cash ,
					sum(if(payment_mode='Cheque',if(cheque_status!='realized',0,amount_paid),0) ) as cheque ,
					sum(if(payment_mode='Online',amount_paid,0) ) as online 
					from student_fees f left join student_master m on f.student_id=m.student_id left join busfees_master b on b.bus_id=m.bus_id 
					where year='2018' and date_payment < '2018-04-01' 
					group by student_class order by student_class+0 asc"; 
				
				
				$qsum=Yii::app()->db->createCommand($sqlsum)->queryAll();
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Class')
				//					->setCellValue('B1', 'Total students')
				->setCellValue('C1', 'Annual')
				->setCellValue('D1', 'Tuition')
				->setCellValue('E1', 'Funds')
				->setCellValue('F1', 'Sports')
				->setCellValue('G1', 'Admission')
				->setCellValue('H1', 'Security')
				->setCellValue('I1', 'Latefees')
				->setCellValue('J1', 'Busfees')
				->setCellValue('K1', 'DB')
				->setCellValue('L1', 'Activity')
				//					->setCellValue('K1', 'Concession')
				->setCellValue('N1', 'Total')
				->setCellValue('O1', 'Amountpaid by Cash')
				->setCellValue('P1', 'Amountpaid by Cheque')
				->setCellValue('Q1', 'Amountpaid online');
				
				
				
				$k=2;
				$totanualsum=0;
				$tottutsum=0;
				$totfundsum=0;
				$totsportssum=0;
				$totadmsum=0;
				$totsecsum=0;
				$totlatesum=0;
				$totbussum=0;
				$totdbsum=0;
				$totactsum=0;
				$totconcessionsum=0;
				$amountpaidcash=0;
				$amountpaidchq=0;
				$amountsum=0;
				$totamountsum=0;
				$totamountchq=0;
				$amountpaidonline=0;
				$totamountonline=0;
				
				foreach($qsum as $sumdata){
					
					$class =$sumdata['student_class'];
					$totanualsum +=$sumdata['annual_fees_paid'];
					$tottutsum +=$sumdata['tuition_fees_paid'];
					$totfundsum +=$sumdata['funds_fees_paid'];
					$totsportssum +=$sumdata['sports_fees_paid'];
					$totadmsum +=$sumdata['admission_fees_paid'];
					$totsecsum +=$sumdata['security_paid'];
					$totlatesum +=$sumdata['late_fees_paid'];
					$totbussum +=$sumdata['busfees'];
					$totdbsum +=$sumdata['dayboarding_fees_paid'];
					$totactsum +=$sumdata['activity_fees'];
					$temptotal=$sumdata['annual_fees_paid']+$sumdata['tuition_fees_paid']+$sumdata['funds_fees_paid']+$sumdata['sports_fees_paid']
					+$sumdata['admission_fees_paid']+$sumdata['security_paid']+$sumdata['late_fees_paid']+$sumdata['busfees']
					+$sumdata['dayboarding_fees_paid']+$sumdata['activity_fees'];
//180220					$amountsum +=$sumdata['amount_paid'];
					$amountsum +=$temptotal;
//180220					$totamountsum += $sumdata['amount_paid'];
					$totamountsum += $temptotal;
//180220					$amountpaidcash +=$sumdata['cash'];
					$amountpaidcash +=$temptotal - $sumdata['cheque'] - $sumdata['online'];
					$amountpaidchq +=$sumdata['cheque'];
					$totamountchq +=$sumdata['cheque'];
					$amountpaidonline +=$sumdata['online'];
					$totamountonline +=$sumdata['online'];
					
					$concession= $sumdata['concession_applied'];
					$totconcessionsum +=$concession;	
					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$k, $sumdata['student_class'])
					//				->setCellValue('B'.$k, $sumdata['count(distinct student_id)'])
					->setCellValue('C'.$k, $sumdata['annual_fees_paid'])
					->setCellValue('D'.$k, $sumdata['tuition_fees_paid'])
					->setCellValue('E'.$k, $sumdata['funds_fees_paid'])
					->setCellValue('F'.$k, $sumdata['sports_fees_paid'])
					->setCellValue('G'.$k, $sumdata['admission_fees_paid'])
					->setCellValue('H'.$k, $sumdata['security_paid'])
					->setCellValue('I'.$k, $sumdata['late_fees_paid'])
					->setCellValue('J'.$k, $sumdata['busfees'])
					->setCellValue('K'.$k, $sumdata['dayboarding_fees_paid'])
					->setCellValue('L'.$k, $sumdata['activity_fees'])
//					->setCellValue('M'.$k, $sumdata['concession_applied'])
//180220					->setCellValue('N'.$k, $sumdata['amount_paid'])
					->setCellValue('N'.$k, $temptotal)
					//assume cash = total - cheque - online
//180220					->setCellValue('O'.$k, $sumdata['cash'])
					->setCellValue('O'.$k, $amountpaidcash)
					->setCellValue('P'.$k, $sumdata['cheque'])
					->setCellValue('Q'.$k, $sumdata['online']);
					
					
					$k++;
				}
				

				
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$k, 'Date')
				//				->setCellValue('B'.$k, $totalstu)
				->setCellValue('C'.$k, $totanualsum)
				->setCellValue('D'.$k, $tottutsum)
				->setCellValue('E'.$k, $totfundsum)
				->setCellValue('F'.$k, $totsportssum)
				->setCellValue('G'.$k, $totadmsum)
				->setCellValue('H'.$k, $totsecsum)
				->setCellValue('I'.$k, $totlatesum)
				->setCellValue('J'.$k, $totbussum)
//				->setCellValue('M'.$k, $totconcessionsum)
				->setCellValue('N'.$k, $totamountsum)
				->setCellValue('O'.$k, $totamountsum - $totamountchq - $totamountonline)
				->setCellValue('P'.$k, $totamountchq)
				->setCellValue('Q'.$k, $totamountonline);
				
				
				
				$sheetname="summary".$year;			
				
				$objPHPExcel->getActiveSheet()->setTitle($sheetname);
				
				$objPHPExcel->setActiveSheetIndex(0);
				
				
				
				
				
				for($j=1;$j<=12;$j++){
					
					
					if($j<10){
						$month=$j+3;
						$nextyear=$year;
						$newmonth="0".$month;
					}
					if($j>9){
						$month=$j-9;
						$nextyear=$year+1;
						$newmonth=$month;
					}
					
					//$date="01-".$month."-".$nextyear;
					$date=$year."-04-01";
					//all students
/*					$sqldetail="select date_payment as date_paymentm,sum(annual_fees_paid) as annual_fees_paid ,sum(tuition_fees_paid)  as tuition_fees_paid ,sum(funds_fees_paid) as funds_fees_paid,sum(sports_fees_paid) as sports_fees_paid,sum(activity_fees)  as activity_fees ,sum(admission_fees_paid) as admission_fees_paid ,sum(security_paid) as security_paid ,sum(late_fees_paid) as late_fees_paid,sum(dayboarding_fees_paid) as dayboarding_fees_paid ,sum(bus_fees_paid) as busfees,
					sum(concession_applied) as concession_applied, sum(amount_paid) as amount_paid, 
					sum(IF((payment_mode='Cash'),amount_paid,0)) as cash ,
					sum(if(payment_mode='Cheque',if(cheque_status!='realized',0,amount_paid),0) ) as cheque ,
					sum(if(payment_mode='Online',amount_paid,0) ) as online 
					from student_fees f left join student_master m on f.student_id=m.student_id 
					where (year='".$year
					."' or (year = '".($year-1)."' and month(date_payment)=4)) and date_payment between  '".$from."' and '".$to
					."' ";
					$sqldetail .= " and (month(date_payment) in ('".$newmonth."') ) ";
					$sqldetail .= " and year(date_payment)='".$nextyear 
					."'  group by date_paymentm order by date_paymentm asc"; 
*/				//below woithout concessional students who have paid cash
					//also year can be this year 2016 also defaulters fees paid for year 2015, hence year <= current year in the query 
/*				$sqldetail="select date_payment as date_paymentm,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6 ),0,annual_fees_paid)) as annual_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6 ),0,tuition_fees_paid)) as tuition_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,funds_fees_paid)) as funds_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,sports_fees_paid)) as sports_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,late_fees_paid)) as late_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,admission_fees_paid)) as admission_fees_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,security_paid)) as security_paid ,
				sum(IF((payment_mode='Cash' and concession_applied > 0  and student_class < 6),0,dayboarding_fees_paid)) as dayboarding_fees_paid ,
				sum(activity_fees) as activity_fees ,
				sum(bus_fees_paid) as busfees ,
				sum(concession_applied) as concession_applied,  
				sum(IF((payment_mode='Cash' and concession_applied > 0 ),0,amount_paid)) as amount_paid,
				sum(IF((payment_mode='Cash'),(IF((payment_mode='Cash' and concession_applied > 0 ),0,amount_paid)),0)) as cash ,
				sum(if(payment_mode='Cheque',if(cheque_status!='realized',0,amount_paid),0) ) as cheque ,
				sum(if(payment_mode='Online',amount_paid,0) ) as online 
				from student_fees f left join student_master m on f.student_id=m.student_id 
				where (year='".$year
				."' or (year = '".($year-1)."' and month(date_payment)=4)) and date_payment between  '".$from."' and '".$to
					."' ";
				$sqldetail .= " and (month(date_payment) in ('".$newmonth."') ) ";
				$sqldetail .= " and year(date_payment)='".$nextyear 
				."' group by student_class order by student_class+0 asc"; */
					/* for advances paid for 2017 session bf 2017-04-01 */
						$sqldetail="select date_payment as date_paymentm,sum(annual_fees_paid)  as annual_fees_paid,
					sum(IF((payment_mode='Cash' and concession_applied > 0 ),0,annual_fees_paid)) as annual_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0 ),0,tuition_fees_paid)) as tuition_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,funds_fees_paid)) as funds_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,sports_fees_paid)) as sports_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,late_fees_paid)) as late_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,admission_fees_paid)) as admission_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,security_paid)) as security_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,dayboarding_fees_paid)) as dayboarding_fees_paid ,
					sum(IF((payment_mode='Cash' and concession_applied > 0 ),0,activity_fees)) as activity_fees ,
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,bus_fees_paid)) as busfees ,
					sum(concession_applied) as concession_applied,  
					sum(IF((payment_mode='Cash' and concession_applied > 0),0,amount_paid)) as amount_paid,
					sum(IF((payment_mode='Cash'),(IF((payment_mode='Cash' and concession_applied > 0 ),0,amount_paid)),0)) as cash ,
					sum(if(payment_mode='Cheque',if(cheque_status!='realized',0,amount_paid),0) ) as cheque ,
					sum(if(payment_mode='Online',amount_paid,0) ) as online 
						from student_fees f left join student_master m on f.student_id=m.student_id left join busfees_master b on b.bus_id=m.bus_id 
						where year='2018' and date_payment   < '2018-04-01' and month(date_payment) in ('".$newmonth."')  
						group by date_payment order by date_payment asc"; 
//						print_r($sqldetail);
					$qdetail=Yii::app()->db->createCommand($sqldetail)->queryAll();
					
					
					$objWorkSheet = $objPHPExcel->createSheet(); 
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('A1', 'Date');
					//		 $objPHPExcel->setActiveSheetIndex($j)->setCellValue('B1', 'No. of student');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('C1', 'Annual fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('D1', 'Tution fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('E1', 'Funds students');	
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('F1', 'Sports fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('G1', 'Admission fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('H1', 'Security fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('I1', 'Late fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('J1', 'Bus fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('K1', 'DB');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('L1', 'Activity');
					//		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('K1', 'Concession fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('N1', 'Total fees');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('O1', 'Amount paid Cash');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('P1', 'Amount paid Cheque');
					$objPHPExcel->setActiveSheetIndex($j)->setCellValue('Q1', 'Amount paid Online');
					
					
					
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
					
					$totanualsum1=0;$tottutsum1=0; $totfundsum1=0;$totsportssum1=0;$totactsum1=0;$totadmsum1=0;$totsecsum1=0;$totlatesum1=0;$totbussum1=0;$totconcessionsum1=0;$amountsum1=0;$totalstu1=0;
					$totdbsum1=$totactsum1=0;
					$amountpaid1cash=0;
					$amountpaid1chq=0;
					$amountpaid1online=0;
					$totamountsum1=0;	
					
					
					foreach($qdetail as $detdata){
						
						$pdate =$detdata['date_paymentm'];
						$totanualsum1 +=$detdata['annual_fees_paid'];
						$tottutsum1 +=$detdata['tuition_fees_paid'];
						$totfundsum1 +=$detdata['funds_fees_paid'];
						$totsportssum1 +=$detdata['sports_fees_paid'];
						$totadmsum1 +=$detdata['admission_fees_paid'];
						$totsecsum1 +=$detdata['security_paid'];
						$totlatesum1 +=$detdata['late_fees_paid'];
						$totbussum1 +=$detdata['busfees'];
						$totdbsum1 +=$detdata['dayboarding_fees_paid'];
						$totactsum1 +=$detdata['activity_fees'];
						$temptotal=$detdata['annual_fees_paid']+$detdata['tuition_fees_paid']+$detdata['funds_fees_paid']+$detdata['sports_fees_paid']
						+$detdata['admission_fees_paid']+$detdata['security_paid']+$detdata['late_fees_paid']+$detdata['busfees']
						+$detdata['dayboarding_fees_paid']+$detdata['activity_fees'];
 //180220						$amountsum1 +=$detdata['amount_paid'];
//180220 						$totamountsum1 +=$detdata['amount_paid'];
 						$totamountsum1 +=$temptotal;
						$amountsum1 +=$temptotal;
//180220						$amountpaid1cash +=$detdata['cash'];
						$amountpaid1cash +=($temptotal-$detdata['cheque']-$detdata['online']);
						$amountpaid1chq +=$detdata['cheque'];
						$amountpaid1online +=$detdata['online'];
						
						$concession1= $detdata['concession_applied'];
						$totconcessionsum1 +=$concession1;
						
					//assume cash = total - cheque - online
						
						$objPHPExcel->setActiveSheetIndex($j)
						->setCellValue('A'.$i, $pdate)
						->setCellValue('C'.$i, $detdata['annual_fees_paid'])
						->setCellValue('D'.$i, $detdata['tuition_fees_paid'])
						->setCellValue('E'.$i, $detdata['funds_fees_paid'])
						->setCellValue('F'.$i, $detdata['sports_fees_paid'])
						->setCellValue('G'.$i, $detdata['admission_fees_paid'])
						->setCellValue('H'.$i, $detdata['security_paid'])
						->setCellValue('I'.$i, $detdata['late_fees_paid'])
						->setCellValue('J'.$i, $detdata['busfees'])
						->setCellValue('K'.$i, $detdata['dayboarding_fees_paid'])
						->setCellValue('L'.$i, $detdata['activity_fees'])
//						->setCellValue('M'.$i, $detdata['concession_applied'])
//180220						->setCellValue('N'.$i, $detdata['amount_paid'])
						->setCellValue('N'.$i, $temptotal)
//180220 ttoal coming wrong						->setCellValue('O'.$i, $detdata['cash'])
						->setCellValue('O'.$i, ($temptotal- $detdata['cheque'] - $detdata['online']))
						->setCellValue('P'.$i, $detdata['cheque'])
						->setCellValue('Q'.$i, $detdata['online']);
						
						
						$i++;
						
						
						
					}
					
					
					$objPHPExcel->setActiveSheetIndex($j)
					->setCellValue('A'.$i, 'Total')
					//				->setCellValue('B'.$i, $totalstu1)
					->setCellValue('C'.$i, $totanualsum1)
					->setCellValue('D'.$i,  $tottutsum1)
					->setCellValue('E'.$i, $totfundsum1)
					->setCellValue('F'.$i, $totsportssum1)
					->setCellValue('G'.$i, $totadmsum1)
					->setCellValue('H'.$i,  $totsecsum1)
					->setCellValue('I'.$i,  $totlatesum1)
					->setCellValue('J'.$i, $totbussum1)
					->setCellValue('K'.$i, $totdbsum1)
					->setCellValue('L'.$i, $totactsum1)
//					->setCellValue('M'.$i, $totconcessionsum1)
					->setCellValue('N'.$i, $totamountsum1)
//180220					->setCellValue('O'.$i, $amountpaid1cash)
					->setCellValue('O'.$i, $totamountsum1 - $amountpaid1chq - $amountpaid1online)
					->setCellValue('P'.$i, $amountpaid1chq)
					->setCellValue('Q'.$i, $amountpaid1online);
					
					
				}
				
				$filename="Actualclasswise_monthlyreport".$year.".xls";
				
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
		
		/* get the activity defaulter data
			lloks at the activityfees
			year is the financial year, and defaulters list ignores students who phave passe dout date < today
			input paramm c = class; activity fees are pre-nursery to class 2
		*/
		public function actionActivityDefaultersData($c=null,$year=null)
		{
		echo "ji";
			$feesrecord="";
			if($year==null or $year==""){
				$year=(date('m')<'04') ? date('Y',strtotime('-1 year')) : date('Y');
			}
//			 echo "selected year=".$year;
			 $currentdate=date('Y-m-d');
			 $montharray = $this->get_months_array($year);
			 $months = implode(",",$montharray);
			 
			$classstring="'nursery,pre-nursery,kg,1,2'";
			//this query returns students who have paid
			$query = "select student_fees.student_id,group_concat(trim(student_fees.fees_period_month) order by student_fees.fees_period_month+0) 
			as months_paid,student_fees.student_class as class_no,student_master.addmission_no,student_master.admission_date,student_master.passedout_date,
			student_master.student_name,student_classes.section from student_fees LEFT JOIN student_master ON student_fees.student_id = student_master.student_id 
			LEFT JOIN student_classes ON student_fees.student_id=student_classes.student_id  and student_classes.class_no=student_class"; // students who have to deposit fees
			$where = " where student_fees.year='".$year."' and(ifnull(student_fees.activity_fees,0) )>0 and find_in_set(class_no,".$classstring.")  ";
			if($c!=""  )
			{
				$where .= " and class_no='".$c."'";
			}
			$where .="	group by student_fees.student_id having months_paid !='".$months."'";
			$orderby = " order by class_no,section,addmission_no";
			
			//if class selected, add class to where clause
			if($c!=""  )
			{
				$where .= " and class_no='".$c."'";
			}
			//add another select for students who have not paid at all
			$queryunion = "select student_master.student_id, '' as months_paid,student_classes.class_no,student_master.addmission_no,student_master.admission_date,student_master.passedout_date,
			student_master.student_name,student_classes.section from student_master 
			INNER JOIN student_classes ON student_master.student_id=student_classes.student_id " ; // students who have to deposit fees
			$whereunion = " where student_master.student_id not in (select student_id from student_fees where year='".$year."') and find_in_set(class_no,".$classstring.")  ";
			 
			if($c!=""  )
			{
				$whereunion .= " and class_no='".$c."'";
			}
			$whereunion .= " group by student_classes.student_id having max(class_no)";
			//build the query
			$query = "select * from (".$query.$where." union ".$queryunion.$whereunion." ) as a ".$orderby;
//			echo $query;
			$query1=Yii::app()->db->createCommand($query)->queryAll();
			$mp='';
			foreach($query1 as $data)
			{
				$feesrecord='';
				$mp  = $data['months_paid'];
				$passedout_date  = $data['passedout_date'];
				//some data in fee_period_months has gone in with spaces like "1, 2, 3", sp spaces need to be removed
				$mp2 =array_map('trim', explode(',', $mp));
				//get the diff of the months not paid for
				$tmp = array_diff($montharray,$mp2);
				$tmpval  = implode(",",$tmp);
				if($tmpval==0 or ($passedout_date != null and $passedout_date!='' and $passedout_date< $currentdate))  //all months paid for student passed out
				{
					//				print_r('no value');
				}
				else
				{
					$feesrecord=$feesrecord.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'*'.$tmpval.'$';
					echo $feesrecord; 
				}
			}
		}
		
		
		
		
		public function actionTransportdefreport(){
			
			$this->render('transportdefaulter');
			
		}
		
		public function actionTransportDefaultersData($c=null,$year=null)
		{
			$feesrecord="";
			if($year==null or $year==""){
				$year=(date('m')<'04') ? date('Y',strtotime('-1 year')) : date('Y');
			}
//			 echo "selected year=".$year;
			 $currentdate=date('Y-m-d');
			 $montharray = $this->get_months_array($year);
			 $months = implode(",",$montharray);
			 
			
			//this query returns students who have paid
			$query = "select student_master.student_id,group_concat(trim(student_fees.fees_period_month) order by student_fees.fees_period_month+0) 
			as months_paid,student_fees.student_class,student_master.addmission_no,student_master.admission_date,student_master.passedout_date,
			student_master.student_name,student_classes.section,
			busfees_master.route, busfees_master.destination  from student_master LEFT JOIN student_fees ON student_fees.student_id = student_master.student_id 
			LEFT JOIN busfees_master ON student_master.bus_id = busfees_master.bus_id 
			LEFT JOIN student_classes ON student_master.student_id=student_classes.student_id  and student_classes.class_no=student_class"; // students who have to deposit fees
			$where = " where student_fees.year='".$year."' and(ifnull(student_fees.bus_fees_paid,0))>0 
			 and student_fees.student_id in (select student_id from student_master where student_master.bus_id > 0 ) ";
			$orderby = " group by student_fees.student_id having months_paid !='".$months."' order by student_fees.student_class,section,route,destination,student_master.addmission_no";
			
			//if class selected, add class to where clause
			if($c!=""  )
			{
				$where .= " and student_class='".$c."'";
			}
			//build the query
			$query .= $where.$orderby;
//			echo $query;
			$query1=Yii::app()->db->createCommand($query)->queryAll();
			$mp='';
			foreach($query1 as $data)
			{
				$feesrecord='';
				$mp  = $data['months_paid'];
				$passedout_date  = $data['passedout_date'];
				//some data in fee_period_months has gone in with spaces like "1, 2, 3", sp spaces need to be removed
				$mp2 =array_map('trim', explode(',', $mp));
				//get the diff of the months not paid for
				$tmp = array_diff($montharray,$mp2);
				$tmpval  = implode(",",$tmp);
				if($tmpval==0 or ($passedout_date != null and $passedout_date!='' and $passedout_date< $currentdate))  //all months paid for student passed out
				{
					//				print_r('no value');
				}
				else
				{
					$feesrecord=$feesrecord.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['student_class'].'*'.$data['section'].'*'
					.$data['route'].'*'.$data['destination'].'*'.$tmpval.'$';
					echo $feesrecord; 
				}
			}
		}
		
		
		public function actionTransportdefdata_160928($datefrom=null,$c=null,$dateto=null,$year=null){
			
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
				
				$details="";	
				$querytrans="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") and (sm.bus_id is not null) group by sm.addmission_no ORDER BY sm.addmission_no ASC";
				
				
				$restrans=Yii::app()->db->createCommand($querytrans)->queryAll();
				
				$details="";
				
				foreach($restrans as $data1){
					
					if($data1['admission_date'] > $datefrom1 && $data1['admission_date'] < $dateto1 ){
						$tmp="";
						$admdate=explode('-',$data1['admission_date']);
						$mon=$admdate[1];
						$mon= ltrim($mon, '0');
						for($adm=$mon; $adm<=$dt1; $adm++){
							
							$tmp.=$adm;
							if($adm!=$dt1)
							$tmp.=",";
							
						}
					}
					
					
					if($data1['class_no']==$c){
						$details=$details.$data1['addmission_no'].'*'.$data1['student_name'].'*'.$data1['class_no'].'*'.$data1['section'].'*'.$tmp.'*'.$data1['route'].'&';
						
					}	
				}
				
				
				$query5="SELECT *,GROUP_CONCAT(distinct sf.fees_period_month) as months FROM (SELECT * FROM `student_fees` as sf1 where student_class='".$c."' AND fees_period_month in (".$tmp.") and year='".$year."' group by sf1.student_id , sf1.fees_period_month having sum(sf1.bus_fees_paid)=0) sf left join student_master sm on (sm.student_id=sf.student_id and (sm.passedout_date is null or sm.passedout_date > ".$dateto1."))  and (sm.bus_id is not null) left join student_classes sc on sc.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where sm.addmission_no!=''   group by sf.student_id order by sm.addmission_no asc";
				
				
				$query1=Yii::app()->db->createCommand($query5)->queryAll();
				
				
				//$details="";
				foreach($query1 as $data){
					
					//$feespaid=explode(",",$data['months']);
					//$feespaid=array_map('trim',$feespaid);
					//$arr = array_intersect($tmparray, $feespaid);
					//$result = array_diff($tmparray, $arr);
					//$feesunpaid=implode(",",$result);
					
					$details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['student_class'].'*'.$data['section'].'*'.$data['months'].'*'.$data['route'].'&';
					
				}
				
			}
			
			else{
				
				
				$details="";	
				//$querytrans1="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") and (sm.bus_id is not null) group by sm.addmission_no ORDER BY cls.class_no+1 ASC";
				
				
				$querytrans1="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where cls.student_id = sm.student_id and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") and (sm.bus_id is not null) group by sm.addmission_no ORDER BY cls.class_no+1 ASC";
				
				
				$resrtrans1=Yii::app()->db->createCommand($querytrans1)->queryAll();
				
				
				foreach($resrtrans1 as $data1){
					
					if($data1['admission_date'] >= $datefrom1 && $data1['admission_date'] <= $dateto1 ){
						$tmp="";
						$admdate=explode('-',$data1['admission_date']);
						$mon=$admdate[1];
						$mon= ltrim($mon, '0');
						for($adm=$mon; $adm<=$dt1; $adm++){
							
							$tmp.=$adm;
							if($adm!=$dt1)
							$tmp.=",";
							
						}
					}
					
					
					$details=$details.$data1['addmission_no'].'*'.$data1['student_name'].'*'.$data1['class_no'].'*'.$data1['section'].'*'.$tmp.'*'.$data1['route'].'&';
					
				}
				
				
				
				$query="SELECT *,GROUP_CONCAT(distinct sf.fees_period_month) as months FROM (SELECT * FROM `student_fees` as sf1 where   fees_period_month in (".$tmp.") and year='".$year."'   group by sf1.student_id , sf1.fees_period_month having sum(sf1.bus_fees_paid)=0 ) sf left join student_master sm on (sm.student_id=sf.student_id and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.")  and (sm.bus_id is not null)) left join student_classes sc on sc.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where sm.addmission_no!='' group by sf.student_id order by sm.addmission_no asc";
				
				$query1=Yii::app()->db->createCommand($query)->queryAll();
				
				//$details="";
				foreach($query1 as $data){
					
					/*$feespaid=explode(",",$data['months']);
						$feespaid=array_map('trim',$feespaid);
						$arr = array_intersect($tmparray, $feespaid);
						$result = array_diff($tmparray, $arr);
					$feesunpaid=implode(",",$result);*/
					
					
					$details=$details.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'*'.$data['months'].'*'.$data['route'].'&';
					
				}
			}
			echo $details; 
		}
		
		public function actionTransportDefaultersExcel($datefrom=null,$c=null,$dateto=null,$year=null){
			
			
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
				
				$querytrans="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") and (sm.bus_id is not null) group by sm.addmission_no ORDER BY sm.addmission_no ASC";
				
				
				$restrans=Yii::app()->db->createCommand($querytrans)->queryAll();
				
				
				$query="SELECT *,GROUP_CONCAT(sf.fees_for_months) as months FROM (SELECT * FROM `student_fees` as sf1 where student_class='".$c."' AND fees_period_month in (".$tmp.")  and year='".$year."'  group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0 ) sf left join student_master sm on (sm.student_id=sf.student_id and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") and (sm.bus_id is not null)) left join student_classes sc on sc.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where sm.addmission_no!=''   group by sf.student_id order by sm.addmission_no asc";
				
				
				$query1=Yii::app()->db->createCommand($query)->queryAll();
				
				
				
				Yii::import('ext.phpexcel.XPHPExcel');    
				
				
				$objPHPExcel= XPHPExcel::createPHPExcel();
				
				$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali Transport Defaulters Document Report")
				->setSubject("SNPS Mohali Transport Defaulters Document Report")
				->setDescription("SNPS Mohali Transport Defaulters Document Report")
				->setKeywords("SNPS Mohali Transport Defaulters result Report")
				->setCategory("SNPS Mohali Transport Defaulters result Report");


				
				
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Admission no')
				->setCellValue('B1', 'Name')
				->setCellValue('C1', 'Class')
				->setCellValue('D1', 'Section')
				->setCellValue('E1', 'Route')
				->setCellValue('F1', 'ActivityFees unpaid for months');
				
				$i=2;
				
				foreach($query1 as $transrep){
					
					/*$feespaid=explode(",",$data['months']);
						$feespaid=array_map('trim',$feespaid);
						$arr = array_intersect($tmparray, $feespaid);
						$result = array_diff($tmparray, $arr);
					$feesunpaid=implode(",",$result);*/
					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $transrep['addmission_no'])
					->setCellValue('B'.$i, $transrep['student_name'])
					->setCellValue('C'.$i, $transrep['student_class'])
					->setCellValue('D'.$i, $transrep['section'])
					->setCellValue('E'.$i,$transrep['route'])
					->setCellValue('F'.$i,$transrep['months']);
					
					$i++;
				}
				
				
				foreach($restrans as $trans){
					
					if($trans['admission_date'] > $datefrom1 && $trans['admission_date'] < $dateto1 ){
						$tmp="";
						$admdate=explode('-',$trans['admission_date']);
						$mon=$admdate[1];
						$mon= ltrim($mon, '0');
						for($adm=$mon; $adm<=$dt1; $adm++){
							
							$tmp.=$adm;
							if($adm!=$dt1)
							$tmp.=",";
							
						}
					}
					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $trans['addmission_no'])
					->setCellValue('B'.$i, $trans['student_name'])
					->setCellValue('C'.$i, $trans['class_no'])
					->setCellValue('D'.$i, $trans['section'])
					->setCellValue('E'.$i,$trans['route'])
					->setCellValue('F'.$i,  $tmp);
					
					$i++;
				}
				
				
			}	
			else{
				
				$querytrans1="SELECT * FROM student_master sm LEFT outer JOIN student_classes as cls ON cls.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where cls.student_class_id = (select max(student_class_id) from student_classes where student_id = sm.student_id) and sm.student_id NOT IN(SELECT student_id FROM student_fees) and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") and (sm.bus_id is not null) group by sm.addmission_no ORDER BY cls.class_no+1 ASC";
				
				
				$restrans1=Yii::app()->db->createCommand($querytrans1)->queryAll();
				
				$query="SELECT *,GROUP_CONCAT(sf.fees_for_months) as months FROM (SELECT * FROM `student_fees` as sf1 where   fees_period_month in (".$tmp.")  and year='".$year."'  group by sf1.student_id , sf1.fees_period_month having sum(sf1.activity_fees)=0 ) sf left join student_master sm on (sm.student_id=sf.student_id and (sm.passedout_date is null or sm.passedout_date > ".$dateto1.") and (sm.bus_id is not null)) left join student_classes sc on sc.student_id=sm.student_id left join busfees_master bf on (bf.bus_id=sm.bus_id) where sm.addmission_no!=''  group by sf.student_id order by sc.class_no+1 asc";
				
				
				$query1=Yii::app()->db->createCommand($query)->queryAll();
				
				
				Yii::import('ext.phpexcel.XPHPExcel');    
				
				
				$objPHPExcel= XPHPExcel::createPHPExcel();
				
				$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
				->setLastModifiedBy("SNPS Mohali")
				->setTitle("SNPS Mohali Transport Defaulters Document Report")
				->setSubject("SNPS Mohali Transport Defaulters Document Report")
				->setDescription("SNPS Mohali Transport Defaulters Document Report")
				->setKeywords("SNPS Mohali Transport Defaulters result Report")
				->setCategory("SNPS Mohali Transport Defaulters result Report");

				
				
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Admission no')
				->setCellValue('B1', 'Name')
				->setCellValue('C1', 'Class')
				->setCellValue('D1', 'Section')
				->setCellValue('E1', 'ActivityFees unpaid for months');
				
				$i=2;
				
				foreach($query1 as $transrep){
					
					/*$feespaid=explode(",",$data['months']);
						$feespaid=array_map('trim',$feespaid);
						$arr = array_intersect($tmparray, $feespaid);
						$result = array_diff($tmparray, $arr);
					$feesunpaid=implode(",",$result);*/
					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $transrep['addmission_no'])
					->setCellValue('B'.$i, $transrep['student_name'])
					->setCellValue('C'.$i, $transrep['class_no'])
					->setCellValue('D'.$i, $transrep['section'])
					->setCellValue('E'.$i, $transrep['route'])
					->setCellValue('F'.$i, $transrep['months']);
					
					$i++;
					
				}
				
				
				foreach($restrans1 as $trans1){
					
					if($trans1['admission_date'] > $datefrom1 && $trans1['admission_date'] < $dateto1 ){
						$tmp="";
						$admdate=explode('-',$trans1['admission_date']);
						$mon=$admdate[1];
						$mon= ltrim($mon, '0');
						for($adm=$mon; $adm<=$dt1; $adm++){
							
							$tmp.=$adm;
							if($adm!=$dt1)
							$tmp.=",";
							
						}
					}
					
					$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $trans1['addmission_no'])
					->setCellValue('B'.$i, $trans1['student_name'])
					->setCellValue('C'.$i, $trans1['class_no'])
					->setCellValue('D'.$i, $trans1['section'])
					->setCellValue('E'.$i,  $trans1['route'])
					->setCellValue('F'.$i,  $tmp);
					
					$i++;
				}
				
			}
			
			
			$objPHPExcel->getActiveSheet()->setTitle('Simple');
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Transportdefaulter.xls"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			
			$objWriter->save('php://output');
			
			Yii::app()->end();
			
			
		}
		
		//return th emonths array which have passed in the passed year
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

public function actionExpectedfeeregister(){
            
			$this->render('expectedfeeregister');
		}

/* Action excelsheet for Expected fee register 
	also prints no of students, new admissions, left etc
	also calculates net tuition fees (deduct concession fee from the total tuition fees)
	does not include dayboarding, busfees 
	*/		
public function actionExpectedfeeexcel($year=null){
	Yii::import('ext.phpexcel.XPHPExcel');    
	$objPHPExcel= XPHPExcel::createPHPExcel();
	$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
	->setLastModifiedBy("SNPS Mohali")
	->setTitle("Expected Fees Register")
	->setSubject("Expected Fees Register")
	->setDescription("Expected Fees Register");

	
	$toyear= $year+1;
	$from=$year."-04-01";
	$to=$toyear."-03-31";
	$sumdetails="";
	
	$sqlsum="select sc.class_no,sc.section,count(distinct sc.student_id) as count_students,sum(fm.annual_fees) ,sum(fm.tuition_fees) ,sum(fm.funds_fees),sum(fm.sports_fees),sum(fm.activity_fees) ,sum(fm.admission_fees) ,sum(fm.security_fees) ,sum(fm.dayboarding_fees),(sum(fm.annual_fees)+sum(fm.tuition_fees)+sum(fm.funds_fees)+sum(fm.sports_fees)+sum(fm.activity_fees)+sum(fm.admission_fees)+sum(fm.security_fees)+sum(fm.dayboarding_fees)) as total from student_classes sc left join fees_master fm on(fm.class_no=sc.class_no) 
	where sc.started_on >= '".$from."' and (sc.ended_on is null or sc.ended_on <= '".$to."') 
	and fm.valid_from >= '".$from."' and (fm.valid_to is null or fm.valid_to <= '".$to."') 
	group by sc.class_no, sc.section order by sc.class_no, sc.section asc";
	$qsum=Yii::app()->db->createCommand($sqlsum)->queryAll();
	
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Class')
	->setCellValue('B1', 'Section')
	->setCellValue('C1', 'Total students')
	->setCellValue('D1', 'Annual')
	->setCellValue('E1', 'Tution')
	->setCellValue('F1', 'Funds')
	->setCellValue('G1', 'Sports')
	->setCellValue('H1', 'Activity')
	->setCellValue('I1', 'Admission')
	->setCellValue('J1', 'Security')
	->setCellValue('K1', 'Dayboarding')
	->setCellValue('L1', 'Total');
	
	
	
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
		$totalstu+=$sumdata['count_students'];
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
		->setCellValue('B'.$k, $sumdata['section'])
		->setCellValue('C'.$k, $sumdata['count_students'])
		->setCellValue('D'.$k, $sumdata['sum(fm.annual_fees)']*12)
		->setCellValue('E'.$k, $sumdata['sum(fm.tuition_fees)']*12)
		->setCellValue('F'.$k, $sumdata['sum(fm.funds_fees)']*12)
		->setCellValue('G'.$k, $sumdata['sum(fm.sports_fees)']*12)
		->setCellValue('H'.$k, $sumdata['sum(fm.activity_fees)']*12)
		->setCellValue('I'.$k, $sumdata['sum(fm.admission_fees)']*12)
		->setCellValue('J'.$k, $sumdata['sum(fm.security_fees)']*12)
		->setCellValue('K'.$k, $sumdata['sum(fm.dayboarding_fees)']*12)
		->setCellValue('L'.$k, $totfeessum);
		
		
		$k++;
	}
	
	
	
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$k, 'Total')
	->setCellValue('C'.$k, $totalstu)
	->setCellValue('D'.$k, $totanualsum)
	->setCellValue('E'.$k, $tottutsum)
	->setCellValue('F'.$k, $totfundsum)
	->setCellValue('G'.$k, $totsportssum)
	->setCellValue('H'.$k, $totactsum)
	->setCellValue('I'.$k, $totadmsum)
	->setCellValue('J'.$k,  $totsecsum)		
	->setCellValue('K'.$k, $totdayboardsum)		
	->setCellValue('L'.$k, $amountsum);
	
	
	
	$sheetname="summary".$year;			
	
	$objPHPExcel->getActiveSheet()->setTitle($sheetname);
	
	$objPHPExcel->setActiveSheetIndex(0);
	
	$array=array("Q1","R1","S1","T1","U1","V1","W1","X1","Y1","Z1");
	$array1=array("Q","R","S","T","U","V","W","X","Y","Z");
	$tmparray = array(); //to store student count for prev month class and section
	
	
	//$date="01-".$month."-".$nextyear;
	$date=$year."-04-01";
	$tdate=($year+1)."-03-31";
	
	$sqlconc="select * from concession_master";
	$qconc=Yii::app()->db->createCommand($sqlconc)->queryAll();
	
	//the main query is common, monthwise calculations are fo rnumber of current students etc
	$sqldetail="select sc.class_no, sc.section, COUNT(distinct sc.student_id) as count_students,fm.annual_fees ,fm.tuition_fees ,fm.funds_fees,fm.sports_fees,fm.activity_fees ,fm.admission_fees ,fm.security_fees ,fm.dayboarding_fees ,COUNT(smc.student_id) as conc_none,";
	
	
	foreach($qconc as $concdata){
		
		$concname=preg_replace("/[^a-zA-Z0-9]/", "", $concdata['concession_type']); 
		
		$sqldetail.=" COUNT(".$concname.".student_id) as ".$concname." ,";
		
	}
	
	$sqldetail= substr($sqldetail, 0, -1);
	
	
	$sqldetail.=" from student_classes sc left join fees_master fm on(fm.class_no=sc.class_no) 
	left join student_master sm on(sm.student_id=sc.student_id) 
	left join student_master smc on(smc.student_id=sc.student_id and smc.concession_id is null) ";
	
	foreach($qconc as $concdata){
		
		$concname=preg_replace("/[^a-zA-Z0-9]/", "", $concdata['concession_type']); 
		$sqldetail.=" left join student_master ".$concname." on(".$concname.".student_id=sc.student_id and ".$concname.".concession_id='".$concdata['concession_id']."')";
		
	}
	//also added check on admission date since for student admitted on 21-05-2017, the sesstion start date in student_classes may be 2016-04-01
	
	$sqldetail.=" where sc.started_on>='".$date."' and sm.admission_date<='".$date."' and (sc.ended_on is null or sc.ended_on<=$tdate)
	and fm.valid_from >= '".$from."' and (fm.valid_to is null or fm.valid_to <= '".$to."') 
	group by sc.class_no,sc.section order by sc.class_no,sc.section asc";
	
//	print_r($sqldetail); exit;
	
	$detail=Yii::app()->db->createCommand($sqldetail)->queryAll();
		
	//monthwise logic begins	
	for($j=1;$j<=12;$j++){
		if($j<10){
			$month=$j+3;
			$nextyear=$year;
		}
		if($j>9){
			$month=$j-9;
			$nextyear=$year+1;
		}
		
		$objWorkSheet = $objPHPExcel->createSheet(); 
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('A1', 'Class');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('B1', 'Section');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('C1', 'No. of student');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('D1', 'Admissions');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('E1', 'Left students');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('F1', 'Total students');	
		
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('G1', 'Annual fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('H1', 'Tution fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('I1', 'Funds fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('K1', 'Sports fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('K1', 'Activity fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('L1', 'Admission fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('M1', 'Security fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('O1', 'Total Expected fees');
		$objPHPExcel->setActiveSheetIndex($j)->setCellValue('P1', 'No concession');
		
		for($col=0; $col<count($qconc); $col++ ){
			
			//$conctype=implode("",$qconc[$col]['concession_type']);
			$conctype=$qconc[$col]['concession_type'];
			$conctype=preg_replace("/[^a-zA-Z0-9]/", "", $conctype);
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
		$section="";
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
		
	
		foreach($detail as $detdata){
			
			//cqlculate admissions in that month in that class and section
			$sqladm="select  count(sm.student_id) as adms  from  student_master sm inner join student_classes sc on sc.student_id=sm.student_id where sc.class_no='".$detdata['class_no']."' and sc.section='".$detdata['section']."'  and  month(sm.admission_date) in ('".$month."') and year(sm.admission_date) in ('".$nextyear."')";
			
			$qadm=Yii::app()->db->createCommand($sqladm)->queryAll();
			
			foreach($qadm as $adm){
				$totadm=$adm['adms'];
			}
			
	//calculate number of students left in that month for that class and section			
			$sqlleft="select  count(sm1.student_id) as leftstu  from  student_master sm1 inner join student_classes sc1 on sc1.student_id=sm1.student_id where sc1.class_no='".$detdata['class_no']."' and sc1.section='".$detdata['section']."' and  month(sm1.passedout_date) in ('".$month."') and year(sm1.passedout_date) in ('".$nextyear."')";
			
			$qleft=Yii::app()->db->createCommand($sqlleft)->queryAll();
			
			
			foreach($qleft as $totleft){
				$left=$totleft['leftstu'];
			}
			
			//calculate new admissions and left students 
			$class=$detdata['class_no'];
			$section=$detdata['section'];
			if($section=='') $section='NA';
			$adms=$totadm;
			$lefts=$left;
			$concnone=$detdata['conc_none'];
			if($j==1){//month of april
				$stu=$detdata['count_students'];
				/*calculate total no. of students after new admissions and left.*/ 
				$tstu= $stu+$adms-$lefts; 
				$tmparray[$class][$section][$j]=$tstu;
			}
			else{
				$stu = 0;
				if(isset($tmparray[$class][$section][$j-1])) $stu=$tmparray[$class][$section][$j-1]; //prev month
				/*calculate total no. of students after new admissions and left.*/
				$tstu=$stu+$adms-$lefts;
				$tmparray[$class][$section][$j]=$tstu;
			}
			
			$totalstudents+=$tstu;
			$noconcession=$concnone+$adms-$lefts;
			$totalconcession+=$noconcession;
			
			
			//calculate concession amount for subtracting from tution fees
			$camt=0;
			$concstu=0;
			for($col=0; $col<count($qconc); $col++ ){
				
				//$conctyp=implode("",$qconc[$col]['concession_type']);
				$conctyp=$qconc[$col]['concession_type'];
				$conctyp1=preg_replace("/[^a-zA-Z0-9]/", "", $conctyp);
				
				$concstu=$detdata[$conctyp1];
				
				$sqlc="select * from concession_master where concession_type='".$conctyp."'";
				
				$qc=Yii::app()->db->createCommand($sqlc)->queryAll();
				
				foreach($qc as $ct){
					
					if($ct['concession_persent']=='amount'){
						$camt+=$ct['concession_amount']*$concstu;
					}
					else {
					//calculate concession amount as percent over tuition amount
						$tutfeesperstudent=$detdata['tuition_fees'];
						$tamt = ($ct['concession_amount'] * $tutfeesperstudent) / 100;
						$camt+=$tamt*$concstu;
					}
				}
			}
			
			
			//calculate fees for earlier students + new admissions
			if($month=='4'){
				$anualfees=$detdata['annual_fees']*($stu+$adms); //if april for all, esle only for new admissions
			}
			else{
				$anualfees=$detdata['annual_fees']*($adms); //if april for all, esle only for new admissions
			}
			$tutfees=$detdata['tuition_fees']*($stu+$adms);
			//subtract concession from tution fees
			$tutfees=$tutfees-$camt;
			if($tutfees<0){
				$tutfees=0;
			}
			$fundfees=$detdata['funds_fees']*($stu+$adms);
			$sportsfees=$detdata['sports_fees']*($stu+$adms);
			//adm fees and security only for new admissions
			$admfees=$detdata['admission_fees']*($adms);
			$secfees=$detdata['security_fees']*($adms);
			//activity fees mandatory for classes <=2
			if($class>=3){
			}
			else{
				$actfees=$detdata['activity_fees']*($stu+$adms);
			}
			$tot=($anualfees+$tutfees+$fundfees+$sportsfees+$actfees+$admfees+$secfees);
			
			//sum of all fees for all classes
			$totanualfees+=$anualfees;
			$tottutfees+=$tutfees;
			$totfundfees+=$fundfees;
			$totsportsfees+=$sportsfees;
			$totactfees+=$actfees;
			$totadmfees+=$admfees;
			$totsecfees+= $secfees;
			$totdayboardfees+=$dayboardfees;
			$totstu+=$detdata['count_students'];
			$admstu+=$totadm;
			$leftstu+=$left;
			$totfees+=$tot;
			
			
			/* $afees=$detdata['total']/$detdata['COUNT(sc.student_class_id)']*$adms;
				
				$fees=$detdata['total']+ $afees;
			$totfees+=$fees;*/
			
			
			
			$objPHPExcel->setActiveSheetIndex($j)
			->setCellValue('A'.$i, $class)
			->setCellValue('B'.$i, $section)
			->setCellValue('C'.$i, $stu)
			->setCellValue('D'.$i, $adms)
			->setCellValue('E'.$i, $lefts)
			->setCellValue('F'.$i, $tstu)
			->setCellValue('G'.$i, $anualfees)
			->setCellValue('H'.$i, $tutfees)
			->setCellValue('I'.$i, $fundfees)
			->setCellValue('J'.$i, $sportsfees)
			->setCellValue('K'.$i, $actfees)
			->setCellValue('L'.$i, $admfees)
			->setCellValue('M'.$i, $secfees)
			->setCellValue('O'.$i, $tot)
			->setCellValue('P'.$i, $noconcession);
			
			for($col=0; $col<count($qconc); $col++ ){
				
				//$conctyp=implode("",$qconc[$col]['concession_type']);
				$conctyp=$qconc[$col]['concession_type'];
				$conctyp=preg_replace("/[^a-zA-Z0-9]/", "", $conctyp);
				
				$objPHPExcel->setActiveSheetIndex($j)->setCellValue($array1[$col].$i, $detdata[$conctyp]);	
				
			}	
			$i++;
			$m++;
		
		}
		$objPHPExcel->setActiveSheetIndex($j)
		->setCellValue('A'.$i, 'Total')
		->setCellValue('C'.$i, $totstu)
		->setCellValue('D'.$i, $admstu)
		->setCellValue('E'.$i,  $leftstu)
		->setCellValue('F'.$i, $totalstudents)
		->setCellValue('G'.$i, $totanualfees)
		->setCellValue('H'.$i, $tottutfees)
		->setCellValue('I'.$i, $totfundfees)
		->setCellValue('j'.$i,  $totsportsfees)
		->setCellValue('K'.$i,  $totactfees)
		->setCellValue('L'.$i, $totadmfees)
		->setCellValue('M'.$i, $totsecfees)
		->setCellValue('O'.$i, $totfees)
		->setCellValue('P'.$i, $totalconcession);
		
		
	}
	
	$filename="Expectedclasswise_monthlyreport".$year.".xls";
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename='.$filename);
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	
	$objWriter->save('php://output');
	
	Yii::app()->end();
}
/* Action excelsheet finalfeereport ends from here is to be printed */					

		public function actionChequedepositreport(){
			
			
			$this->render('chequedepositreport');
			
		}
/* action chequestatus starts here */
public function actionChequedepositview($datefrom=null,$dateto=null){
			
			
			$datefrom1 = date("Y-m-d", strtotime($datefrom));
			$dateto1 = date("Y-m-d", strtotime($dateto));
			$date=date('Y');
			$sessionstarts=$date."-04-01";

			$q="SELECT sf.cheq_no, sf.bank_name,sf.branch_name, sum(sf.amount_paid) as amount_paid, group_concat(distinct sm.student_name) as student_name, sm.mobile_no,
			group_concat(distinct sm.addmission_no) as addmission_no,group_concat(distinct sf.student_class) as student_class,
			group_concat(distinct sf.student_section) as student_section FROM student_fees sf LEFT JOIN student_master sm ON ( sm.student_id = sf.student_id ) WHERE sf.payment_mode='cheque' and sf.cheque_status='open' AND sf.date_payment BETWEEN '".$datefrom1."' AND '".$dateto1
			."' group by sf.bank_name, sf.branch_name, sf.cheq_no"; 
//echo $q; die;
			$qc=Yii::app()->db->createCommand($q)->queryAll();

			$chqdetails="";
			$amount="";
			$amount=0;
			foreach($qc as $chq){
				
				$chqdetails=$chqdetails=$chqdetails.$chq['student_name'].'!'.$chq['addmission_no'].'!'.$chq['student_class'].'!'.$chq['student_section'].'!'.$chq['mobile_no'].'!'.$chq['bank_name'].'!'.$chq['branch_name'].'!'.$chq['cheq_no'].'!'.$chq['amount_paid'].'||';

				$amount+=$chq['amount_paid'];
			
			}
			echo $chqdetails.'$'.$amount;

		}
/* action chequestatus ends here */

/* Excel stylesheet for cheque deposit report begins here for
	This will generate 4 excels: Statebank, Gramin, Cooperative and all other banks
*/
		public function actionChequedepositexcel($datefrom=null,$dateto=null){

			$bankarray=array('SBI','OTHERS','Cash');
			$datefrom1 = date("Y-m-d", strtotime($datefrom));
			$dateto1 = date("Y-m-d", strtotime($dateto));
			$date=date('Y');
			$sessionstarts=$date."-04-01";
			$q="";
			$activesheetindex=0;
			Yii::import('ext.phpexcel.XPHPExcel');    
			$objPHPExcel= XPHPExcel::createPHPExcel();
			$objPHPExcel->getProperties()->setCreator("SNPS Mohali")
			->setLastModifiedBy("SNPS Mohali")
			->setTitle("SNPS Mohali Cheque Deposit Excel Report")
			->setSubject("SNPS Mohali Cheque Deposit Excel Report")
			->setDescription("SNPS Mohali Cheque Deposit Excel Report")
			->setKeywords("SNPS Mohali Cheque Deposit Excel Report")
			->setCategory("SNPS Mohali Cheque Deposit Excel Report");

			foreach($bankarray as $bank){
				$filename="Cheque Deposit Status Report.xls";

				if($bank=='OTHERS'){
					$q="SELECT sf.cheq_no, sf.bank_name, sf.branch_name, sum(sf.amount_paid) as amount_paid, group_concat(distinct sm.student_name) as student_name,CASE WHEN sm.phone_no!=NULL THEN sm.phone_no ELSE sm.mobile_no END AS phone_no,
					group_concat(distinct sm.addmission_no) as addmission_no,group_concat(distinct sf.student_class) as student_class,
					group_concat(distinct sf.student_section) as student_section FROM student_fees sf LEFT JOIN student_master sm ON ( sm.student_id = sf.student_id ) 
					WHERE sf.bank_name!='$bankarray[0]' and sf.bank_name!='$bankarray[1]' and sf.payment_mode='cheque' and sf.cheque_status='open' AND sf.date_payment BETWEEN '".$datefrom1."' AND '".$dateto1
					."' group by sf.bank_name, sf.branch_name, sf.cheq_no"; 
				}
				elseif ($bank=='Cash') {
//echo "Have a Great Wow day!";die; 
$q="SELECT sf.cheq_no, sf.bank_name, sf.branch_name, sm.student_name,sf.amount_paid,CASE WHEN sm.phone_no!=NULL THEN sm.phone_no ELSE sm.mobile_no END AS phone_no, sm.addmission_no, sf.student_class, sf.student_section FROM student_fees sf LEFT JOIN student_master sm ON ( sm.student_id = sf.student_id ) 
					WHERE sf.payment_mode='Cash' AND sf.date_payment BETWEEN '".$datefrom1."' AND '".$dateto1."'" ; 
					//echo $q;die;
}
else{
	$q="SELECT sf.cheq_no, sf.bank_name, sf.branch_name, sum(sf.amount_paid) as amount_paid, group_concat(distinct sm.student_name) as student_name,CASE WHEN sm.phone_no!=NULL THEN sm.phone_no ELSE sm.mobile_no END AS phone_no,
					group_concat(distinct sm.addmission_no) as addmission_no,group_concat(distinct sf.student_class) as student_class,
					group_concat(distinct sf.student_section) as student_section FROM student_fees sf LEFT JOIN student_master sm ON ( sm.student_id = sf.student_id ) 
					WHERE sf.bank_name='$bank' and sf.payment_mode='cheque' and sf.cheque_status='open' AND sf.date_payment BETWEEN '".$datefrom1."' AND '".$dateto1
					."' group by sf.bank_name, sf.branch_name, sf.cheq_no"; 
				}
				$qc=Yii::app()->db->createCommand($q)->queryAll();

				$count = count ($qc);

				
				if(!empty($qc)){
				     // Add new sheet
				      $objWorkSheet = $objPHPExcel->createSheet($activesheetindex); //Setting index when creating

				      $objPHPExcel->setActiveSheetIndex($activesheetindex)				
					->setCellValue('C1', 'Shishu Niketan Public School, Sector 66, Mohali')
					->setCellValue('C2', 'State Bank of Patiala, Phase – 7, Mohali OD Account No. 65274303453')
					->setCellValue('C3', 'Tel: 9815094449')
					->setCellValue('E3', 'Date: '.date("d-m-y"))
					->setCellValue('G3', 'Date of Entry: '.$datefrom1);					
				      $objPHPExcel->setActiveSheetIndex($activesheetindex)				
					->setCellValue('A5', 'SrNo')
					->setCellValue('B5', 'Name')
					->setCellValue('C5', 'Admission Number(s)')				
					->setCellValue('D5', 'Class')
					->setCellValue('E5', 'Section')				 
					->setCellValue('F5', 'Phone Number')
					->setCellValue('G5', 'Bank')
					->setCellValue('H5', 'Branch')				 
					->setCellValue('I5', 'Cheque No')
					->setCellValue('J5', 'Amount');
					
					$i=6;
					$sumamount=0;
					$loop=0;	
					foreach($qc as $collectionrp){
						
						$sumamount+=$collectionrp['amount_paid'];

						$bankname = $collectionrp['bank_name'];
						$branchname = $collectionrp['branch_name'];
						$loop++;
						$objPHPExcel->setActiveSheetIndex($activesheetindex)
						->setCellValue('A'.$i,$loop)
						->setCellValue('B'.$i, $collectionrp['student_name'])
						->setCellValue('C'.$i, $collectionrp['addmission_no'])					
						->setCellValue('D'.$i, $collectionrp['student_class'])
						->setCellValue('E'.$i, $collectionrp['student_section'])
						->setCellValue('F'.$i, $collectionrp['phone_no'])
						->setCellValue('G'.$i, $collectionrp['bank_name'])
						->setCellValue('H'.$i, $collectionrp['branch_name'])
						->setCellValue('I'.$i, $collectionrp['cheq_no'])
						->setCellValue('J'.$i, $collectionrp['amount_paid']);
						$i++;
					}

					$objPHPExcel->setActiveSheetIndex($activesheetindex)
					->setCellValue('A'.$i, 'Total')
					->setCellValue('B'.$i, '')
					->setCellValue('C'.$i,  '')
					->setCellValue('D'.$i, '')
					->setCellValue('E'.$i, '')
					->setCellValue('F'.$i, '')
					->setCellValue('G'.$i, '')				
					->setCellValue('H'.$i, '')
					->setCellValue('I'.$i, '')
					->setCellValue('J'.$i, $sumamount);


					
					
					$objPHPExcel->getActiveSheet()->setTitle($bank);
					
					$objPHPExcel->setActiveSheetIndex($activesheetindex);
					
					$activesheetindex++;
					
				}	
			}
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$filename);
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			Yii::app()->end();				
		}
/* Excel stylesheet for cheque deposit report ends here for*/		
public function actionExport(){
	$activesheetindex=0;
	Yii::import('ext.phpexcel.XPHPExcel');    
			$objPHPExcel= XPHPExcel::createPHPExcel();
			
	$objWorkSheet = $objPHPExcel->createSheet($activesheetindex); //Setting index when creating
					$objPHPExcel->setActiveSheetIndex($activesheetindex)	
					->setCellValue('C1', 'Shishu Niketan Public School, Sector 66, Mohali')
					->setCellValue('E2', 'Student Records')
					->setCellValue('C3', 'Tel: 9815094449')
					->setCellValue('E3', 'Date: '.date("d-m-y"));
					$objPHPExcel->setActiveSheetIndex($activesheetindex)	
			
					->setCellValue('A4', 'Student Name')
					->setCellValue('B4', 'Adress')
					->setCellValue('C4', 'City')				
					->setCellValue('D4', 'Mobile No.');
					$model = StudentMaster::model()->findAll();if ( isset($searchParams) )
                {
                        $model->attributes = $searchParams;
						
                }
	$i=5;				
foreach ($model as $value) {
	$objPHPExcel->setActiveSheetIndex($activesheetindex)				
					->setCellValue('A'.$i, $value['student_name'])
					->setCellValue('B'.$i, $value['address'])
					->setCellValue('C'.$i, $value['city'])				
					->setCellValue('D'.$i, $value['mobile_no']);
$i++;
}
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="export_' . date('d.m.Y') . '.xls"');
//echo iconv('utf-8', 'windows-1251', $data); //If suddenly in Windows will gibberish
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
Yii::app()->end();
}
/* 19-july-2017 search student by class and section*/
public function actionGetbyclass($class=null,$section=null)
	{
		//echo "Search by class"; die;
		$record="";
		if($class!=="" && $section!=="" )
			{
				//echo $class." AND ".$section;
				$query="SELECT student_master.addmission_no, student_master.student_name, student_master.mobile_no, student_classes.class_no, student_classes.section FROM student_master INNER JOIN student_classes ON student_master.student_id = student_classes.student_id";
				$where=" WHERE student_classes.class_no = '".$class."' AND student_classes.section = '".$section."' AND student_master.mobile_no != '' ";
				$query .= $where;
				//echo $query;die;
			}elseif ($class!=="" && $section=="") {
    //echo "Have a good day!"; die;
	$query="SELECT student_master.addmission_no, student_master.student_name, student_master.mobile_no, student_classes.class_no, student_classes.section FROM student_master INNER JOIN student_classes ON student_master.student_id = student_classes.student_id";
				$where=" WHERE student_classes.class_no = '".$class."' AND student_master.mobile_no != ''";
				$query .= $where;
				//echo $query;die;
} 
elseif ($class=="" && $section!=="") {
//echo "Have a Great Wow day!";die; 
$query="SELECT student_master.addmission_no, student_master.student_name, student_master.mobile_no, student_classes.class_no, student_classes.section FROM student_master INNER JOIN student_classes ON student_master.student_id = student_classes.student_id";
				$where=" WHERE student_classes.section = '".$section."' AND  student_master.mobile_no != ''";
				$query .= $where;
				//echo $query;die;
}
		
			else
			{
				$query="SELECT student_master.addmission_no, student_master.student_name, student_master.mobile_no, student_classes.class_no, student_classes.section FROM student_master INNER JOIN student_classes ON student_master.student_id = student_classes.student_id";
				$where=" WHERE student_master.mobile_no != ''";
				$query .= $where;
				//echo $query;die;
			}
			$result=Yii::app()->db->createCommand($query)->queryAll();
			if($result)
			{		 
						foreach($result as $data)
						{
							$feesrecord='';
						$feesrecord=$feesrecord.$data['addmission_no'].'*'.$data['student_name'].'*'.$data['class_no'].'*'.$data['section'].'*'.$data['mobile_no'].'*'.'$';
								echo $feesrecord; 
						}
			}
	}
	
	
}	
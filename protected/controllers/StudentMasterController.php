<?php

class StudentMasterController extends Controller
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
				'actions'=>array('create','update','Busroute','sms'),
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
	    $model=$this->loadModel($id);
		
	    $sql="select sf.*,sm.* from student_fees sf LEFT JOIN student_master sm on (sm.student_id=sf.student_id) where sf.student_id='".$model->student_id."' order by sf.date_payment desc";
        
		$query=Yii::app()->db->createCommand($sql)->queryAll();
		$feedetails="";
		
		foreach($query as $fee) {
		
	    $feedetails=$feedetails.$fee['fees_for_months'].'!'.$fee['fees_period_month'].'!'.$fee['annual_fees_paid'].'!'.$fee['tuition_fees_paid'].'!'.$fee['funds_fees_paid'].'!'.$fee['sports_fees_paid'].'!'.$fee['activity_fees'].'!'.$fee['admission_fees_paid'].'!'.$fee['security_paid'].'!'.$fee['late_fees_paid'].'!'.$fee['dayboarding_fees_paid'].'!'.$fee['bus_fees_paid'].'!'.$fee['amount_paid'].'!'.$fee['date_payment'].'!'.$fee['payment_mode'].'!'.$fee['cheq_no'].'!'.$fee['bank_name'].'!'.$fee['concession_applied'].'!'.$fee['Total_amount'].'!'.$fee['addmission_no'].'!'.$fee['student_name'].'!'.$fee['father_name'].'&';
  
		}
	
		$this->render('view',array(
			'model'=>$this->loadModel($id),'feedetails'=>  $feedetails,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{    
		 $admdate=date("Y-m-d");
         $model=new StudentMaster;
	     $modelclass=new StudentClasses;
		 $modelbus=new BusfeesMaster;
		 
	     //$qry = "Select addmission_no from student_master where student_id = (Select max(student_id) from student_master)";
         $qry = "Select max(addmission_no) as addmission_no from student_master";
	     $com = Yii::app()->db->createCommand($qry)->queryRow();
         $max_id = $com["addmission_no"];
         $model->addmission_no = $max_id + 1;
		 
		 
		if(isset($_POST['StudentMaster']))
		{
			$model->attributes=$_POST['StudentMaster'];
      
				if(isset($_POST['admission'])){
				  $model->addmission_no=$_POST['admission'];
				   }
				   
/*				if(isset($_POST['bus_id'])){
				   $model->bus_id=$_POST['bus_id'];
				} */
//170404 concession id is not getting saved, odd; so specifically set
				 if(isset($_POST['StudentMaster']['concession_id'])){
				 $model->concession_id=$_POST['StudentMaster']['concession_id'];
				}
				//oddly in update if rour, dest exist, then the id is StdentMaster_detination, else the id is bus_id
				if(isset($_POST['StudentMaster']['destination'])){ 
				    if($_POST['StudentMaster']['destination']=="Please select destination"){
						   $model->bus_id=null;
				} 
					 else{
						$model->bus_id=$_POST['StudentMaster']['destination'];
					  }
				}
				else { 
						  $model->bus_id=null;
				} 

				
				if(isset($_POST['gender'])){
				 $model->gender=$_POST['gender'];
				}
				   
				if(isset($_POST['birthdate'])){
				 if($_POST['birthdate']==""){
				$model->birth_date="0000-00-00";
				}
				else{
				 $de = $_POST['birthdate'];
				 $originalDate = $de;
				 $newDate = date("Y-m-d", strtotime($originalDate));  
				 $model->birth_date=$newDate;
				 }
				}
				 
				if(isset($_POST['sessstart'])){
				$sessstart = $_POST['sessstart'];
				$sessfrom = date("Y-m-d", strtotime($sessstart));
				 }
				 
				 
				if(isset($_POST['admdate'])){
				  $admis = $_POST['admdate'];
				  $originalDate = $admis;
				  $newDate = date("Y-m-d", strtotime($originalDate));     
				  $model->admission_date=$newDate;
				}
				  
				if(isset($_POST['passoutdate'])){
				 if($_POST['passoutdate']=="" || $_POST['passoutdate']=="0000-00-00"){
				 $model->passedout_date=NULL;
				}
				
				else{
				  $passoutdate = $_POST['passoutdate'];
				  $passoutform = date("Y-m-d", strtotime($passoutdate));     
				  $model->passedout_date=$passoutform;
				}
				}

				if($model->save())
				{
							
					$model1=new StudentClasses;
					$model1->section=$_POST['section'];
					$model1->student_id = $model->student_id;
					$model1->class_no =$_POST['class'];
					
					$model1->started_on =$sessfrom;
					$model1->ended_on =null;
					$model1->save();
				
					$this->redirect(array('admin','id'=>$model->student_id));
			}	
		}
		
		$this->render('create',array(
			'model'=>$model,'admdate'=>$admdate,'modelclass'=>$modelclass,'route'=>null,'destination'=>null
		));
	}
	
	public function actionBusroute($busid=null){
	
	     $bussql="select bus_id,destination from busfees_master where route='".$busid."' ";
         $querybussql=Yii::app()->db->createCommand($bussql)->queryAll();
		
		 $a="";
		 foreach($querybussql as $row){
		 $a.=$row['bus_id'].",".$row['destination'].'$';
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
          $modelbus=new BusfeesMaster();
		
          $q="select admission_date from student_master where student_id='".$id."'";
		  $s=Yii::app()->db->createCommand($q)->queryRow();
		  $admdate=$s['admission_date'];
		  
		if(isset($_POST['StudentMaster']))
		{        
print_r($_POST); 
				 if(isset($_POST['admission'])){
				 $model->addmission_no=$_POST['admission'];
				}
//170404 concession id is not getting saved, odd; so specifically set
				 if(isset($_POST['StudentMaster']['concession_id'])){
				 $model->concession_id=$_POST['StudentMaster']['concession_id'];
				}
				//oddly in update if rour, dest exist, then the id is StdentMaster_detination, else the id is bus_id
				if(isset($_POST['StudentMaster']['destination'])){ 
				    if($_POST['StudentMaster']['destination']=="Please select destination"){
						   $model->bus_id=null;
   				    }
					 else{
						$model->bus_id=$_POST['StudentMaster']['destination'];
					  }
				}
				else { 
						  $model->bus_id=null;
				} 
				if(isset($_POST['passoutdate'])){
				 if($_POST['passoutdate']=="" || $_POST['passoutdate']=="0000-00-00" ){
				 $model->passedout_date=null;
				}
				else{
				  $passoutdate = $_POST['passoutdate'];
				  $passoutform = date("Y-m-d", strtotime($passoutdate));     
				  $model->passedout_date=$passoutform;
				  
				 $sqlselect="select max(student_class_id) from student_classes where student_id='".$id."'";
				 $qselect=Yii::app()->db->createCommand($sqlselect)->queryAll();
				 
				 foreach($qselect as $maxid){
				 $maxclassid=$maxid['max(student_class_id)'];
				 }
				 
					$modelstuclass = StudentClasses::model()->findByPk($maxclassid);
					$modelstuclass->ended_on=$passoutform;
					$modelstuclass->save();
				 
				 }
				}
				if(isset($_POST['admdate'])){
					$admis = $_POST['admdate'];

					$originalDate = $admis;
					$newDate = date("Y-m-d", strtotime($originalDate));
					$model->admission_date=$newDate;
				}

				 
				if(isset($_POST['birthdate'])){
				if($_POST['birthdate']==""){
				$model->birth_date="0000-00-00";
				}
				else{
				$de = $_POST['birthdate'];
				$originalDate = $de;
				$newDate = date("Y-m-d", strtotime($originalDate));  
				$model->birth_date=$newDate;
				}
				}
				
					$model->attributes=$_POST['StudentMaster'];
					if($model->save()) {
					$this->redirect(array('admin','id'=>$model->student_id)) ;
					}	
        }
		$route=null;
		$destination=null;
		if($model['bus_id']>0){
			$sqlselect="select route,destination from busfees_master where bus_id='".$model['bus_id']."'";
			$qselect=Yii::app()->db->createCommand($sqlselect)->query();
			if($qselect!=null && count($qselect)>0){
				while ($row = $qselect->read()) {
					$route=$row['route'];
					$destination=$row['destination'];
					break;
				}	
			}
		 }
		    $this->render('update',array(
			'model'=>$model,'admdate'=>$admdate, 'destination'=>$destination, 'route'=>$route));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$count=0;
		$model=$this->loadModel($id);
      
		//if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		//if(!isset($_GET['ajax']))
	    $sql="select * from student_fees where student_id='".$model->student_id."'";
		$query=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($query as $rec){
			$count=1;
			break;
		}
		if($count=='0'){
			$this->loadModel($id)->delete();
			if(!isset($_GET['ajax'])){
				Yii::app()->user->setFlash('success','Student deleted Successfully');
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			else{
				echo "<div class='flash-error'>Student Deleted Successfully</div>";
			}
		}
        else {
			if(!isset($_GET['ajax'])){
				Yii::app()->user->setFlash('error','Sorry, fees paid by this student; cannot be deleted');
			}
			else{
				echo "<div class='flash-error'>Sorry, fees paid by this student; cannot be deleted</div>";
			}
	    }
	
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('StudentMaster');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
       $model = new StudentMaster('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StudentMaster']))
        {
                $model->attributes = $_GET['StudentMaster'];
                Yii::app()->user->setState('StudentMasterSearchParams', $_GET['StudentMaster']);
        }
        else
        {
                $searchParams = Yii::app()->user->getState('StudentMasterSearchParams');
                if ( isset($searchParams) )
                {
                        $model->attributes = $searchParams;
                }
        }
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StudentMaster the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StudentMaster::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StudentMaster $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='student-master-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/* 19-july-2017 SMS EXPORT WITH SEARCH */
	public function actionSms()
	{//echo "SMS EXPORT";die;

		$this->render('sms');
	}

}

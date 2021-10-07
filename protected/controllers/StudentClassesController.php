<?php

class StudentClassesController extends Controller
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
				'actions'=>array('create','update','Search','Details'),
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
		$model=new StudentClasses;
		$searchbox="a";
		if(isset($_POST['StudentClasses']))
		{
		if(isset($_POST['stuid'])){
		  $model->student_id=$_POST['stuid'];
		}
	
		if(isset($_POST['startdate'])){
		if($_POST['startdate']==""){
		$model->started_on="0000-00-00";
		}
		else{
		$de = $_POST['startdate'];
		$originalDate = $de;
		$newDate = date("Y-m-d", strtotime($originalDate));
		$model->started_on=$newDate;
		}
		}
			
		if(isset($_POST['enddate'])){
		if($_POST['enddate']==""){
		$model->ended_on="0000-00-00";
		}
		else{
		$endate = $_POST['enddate'];
		$originalDate = $endate;
		$newDate = date("Y-m-d", strtotime($originalDate));
		$model->ended_on=$newDate;
		 }
		}
		
		
		$model->attributes=$_POST['StudentClasses'];
		if($model->save())
		$this->redirect(array('admin','id'=>$model->student_class_id));
		}

		$this->render('create',array(
			'model'=>$model,'searchbox'=>$searchbox,
		));
	}
	
	
	public function actionSearch($name=null,$class1=null,$admission=null,$section=null){
	
	    $query=null;
        $model=new StudentClasses;	
               
//$query="select * from student_master where student_name ='".$name."' OR class='".$class1."' OR addmission_no='".$admission."' OR section='".$section."'";


/*if($name!="" || $admission!=""){
$query="select * from student_master where";
if($name!="")
$query=$query." student_name LIKE '".$name."%'  OR";
$query=$query." addmission_no='".$admission."'";
}
else{
$query="select sc.student_id,sm.student_name from student_classes sc LEFT JOIN(select student_id as student_id , student_name as student_name from student_master)as sm ON(sm.student_id=sc.student_id) where class_no='".$class1."' OR section='".$section."'";
}*/

			$query="select DISTINCT  a.student_id, a.student_name , max(class_no) as class_no from student_master a 
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
			$query=$query." group by sc.student_id"; 

			$query1=Yii::app()->db->createCommand($query)->queryAll();
			$q = "";
			foreach($query1 as $h)
			{
			$q .=$h['student_id']."$".$h['student_name'].":".$h['class_no'].",";
			}
			echo $q;
	}
	
	public function actionDetails($id=null)
	{      
        $query2=null;
        $model=new StudentClasses;	
                
		$query2="SELECT sm.student_id as student_id,sc.class_no, sc.started_on, sc.ended_on,sc.section,
		sm.addmission_no, sm.student_name from student_master sm left join student_classes sc on (sm.student_id=sc.student_id) WHERE sm.student_id ='".$id."'";

		$query3=Yii::app()->db->createCommand($query2)->queryAll();

		foreach($query3 as $d)
		{
		$details= $d['student_id'].",".$d['class_no'].",".$d['started_on'].",".$d['ended_on'].",".$d['section'].",".$d['student_name'].",".$d['addmission_no'];
		}
		echo $details;
	}
	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $searchbox="b";
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
       
		if(isset($_POST['StudentClasses']))
		{
				$model->attributes=$_POST['StudentClasses'];
				
				if(isset($_POST['startdate'])){
				if($_POST['startdate']==""){
				$model->started_on="0000-00-00";
				}
				else{
				$de = $_POST['startdate'];
				$originalDate = $de;
				$newDate = date("Y-m-d", strtotime($originalDate));
				$model->started_on=$newDate;
				}
				}
				
				if(isset($_POST['enddate'])){
				if($_POST['enddate']==""){
				$model->ended_on="0000-00-00";
				}
				else{
				$endate = $_POST['enddate'];
				$originalDate = $endate;
				$newDate = date("Y-m-d", strtotime($originalDate));
				$model->ended_on=$newDate;
				 }
				}
				
				if($model->save())
				$this->redirect(array('admin','id'=>$model->student_class_id));
		}

		$this->render('update',array(
			'model'=>$model,'searchbox'=>$searchbox,
		));
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
		$dataProvider=new CActiveDataProvider('StudentClasses');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StudentClasses('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StudentClasses']))
			$model->attributes=$_GET['StudentClasses'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StudentClasses the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StudentClasses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StudentClasses $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='student-classes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

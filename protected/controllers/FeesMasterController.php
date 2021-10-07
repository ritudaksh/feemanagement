<?php

class FeesMasterController extends Controller
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
				'actions'=>array('create','update'),
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
		$model=new FeesMaster;
      $count=0;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FeesMaster']))
		{	
			$model->attributes=$_POST['FeesMaster'];

 if(isset($_POST['validfrom']))                          
$vaildfrom = $_POST['validfrom'];
$originalDate = $vaildfrom;
$newDate = date("Y-m-d", strtotime($originalDate));     
$model->valid_from=$newDate;
{
  
     }
 if(isset($_POST['validto']))
$vaildto = $_POST['validto'];
$originalDate = $vaildto;
$newDate = date("Y-m-d", strtotime($originalDate));     
$model->valid_to=$newDate;


	 

$sql="select * from fees_master where class_no='".$model->class_no."' and valid_from='".$model->valid_from."' and valid_to='".$model->valid_to."'";
			$query=Yii::app()->db->createCommand($sql)->queryAll();	
			
            foreach($query as $row){
             $count=1;
			}
			if($count=='0'){
			if($model->save())
				$this->redirect(array('admin','id'=>$model->fees_id));
		}
		else{?>
		
		<script>
		alert("Fees already exists for this class and session");
	   </script>
		
		<?php }
		
		
		
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FeesMaster']))
		{
			$model->attributes=$_POST['FeesMaster'];


if(isset($_POST['validfrom']))                          
$vaildfrom = $_POST['validfrom'];
$originalDate = $vaildfrom;
$newDate = date("Y-m-d", strtotime($originalDate));     
$model->valid_from=$newDate;
{
  
     }
 if(isset($_POST['validto']))
$vaildto = $_POST['validto'];
$originalDate = $vaildto;
$newDate = date("Y-m-d", strtotime($originalDate));     
$model->valid_to=$newDate;
{
 
  
        }
			if($model->save())
				$this->redirect(array('admin','id'=>$model->fees_id));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('FeesMaster');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FeesMaster('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FeesMaster']))
			$model->attributes=$_GET['FeesMaster'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FeesMaster the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FeesMaster::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FeesMaster $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fees-master-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

<?php

class LatefeeMasterController extends Controller
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
		$model=new LatefeeMaster;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LatefeeMaster']))
		{
			
			if(isset($_POST['daysfrom'])){
				
                     $model->days_from =$_POST['daysfrom'];
                     
				 }
				 if(isset($_POST['daysto'])){
                   $model->days_to =$_POST['daysto'];
                    }
                  
			
			
			
			$model->attributes=$_POST['LatefeeMaster'];
			if($model->save())
			//if(isset($_POST['LatefeeMaster'])){
				//$sql12="select dr1.* from latefee_master dr1 inner join latefee_master dr2
//on dr2.days_from > dr1.days_from   and dr2.days_from < dr1.days_to";
  //$command=Yii::app()->db->createCommand($sql12);
//$command->execute();
	//$daysfrom=null;
			//$daysto=null;
			//$current_ranges=null;

			//$new_range = range($daysfrom, $daysto);
							
//$current_ranges = db_query('select dr1.* from latefee_master dr1
//inner join latefee_master dr2
//on dr2.days_from > dr1.days_from 
 // and dr2.days_from < dr1.days_to');
			// $latefee=Yii::app()->db->createCommand($current_ranges)->queryAll();
			//foreach ($current_ranges as $range) {
  //if (count(array_intersect($new_range, range($range["days_from"], $range["days_to"])))) {
  //throw new RangeException();
  //}
//}



	
				$this->redirect(array('admin','id'=>$model->latefee_id));
		//}
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

		if(isset($_POST['LatefeeMaster']))
		{


			
			if(isset($_POST['daysfrom'])){
				
                     $model->days_from =$_POST['daysfrom'];
                     
				 }
				 if(isset($_POST['daysto'])){
                   $model->days_to =$_POST['daysto'];
                    }
                  
			
			
			$model->attributes=$_POST['LatefeeMaster'];
			if($model->save())
				$this->redirect(array('admin','id'=>$model->latefee_id));
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
		$dataProvider=new CActiveDataProvider('LatefeeMaster');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LatefeeMaster('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LatefeeMaster']))
			$model->attributes=$_GET['LatefeeMaster'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LatefeeMaster the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LatefeeMaster::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LatefeeMaster $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='latefee-master-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

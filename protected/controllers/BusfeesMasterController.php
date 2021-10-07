<?php
	
	class BusfeesMasterController extends Controller
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
			'actions'=>array('create','update','busdetails','busfeesmasterexcel'),
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
			$model=new BusfeesMaster;
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
			$busroute="";
			if(isset($_POST['BusfeesMaster']))
			{
				
				
				if(isset($_POST['busno'])){
					$model->route=$_POST['busno'];
				}
				if(isset($_POST['destination'])){
					$model->destination=$_POST['destination'];
				}
				
				$model->attributes=$_POST['BusfeesMaster'];
				
				if($model->save()){
					$this->redirect(array('admin','id'=>$model->bus_id));
				}	
			}
			
			$this->render('create',array(
			'model'=>$model,'busroute'=>$busroute,
			));
		}
/* Excel sheet to get the detail of bus fees of every route starts here 23rd may 2017*/		

	public function actionBusfeesmasterexcel()
	{
		$model=BusfeesMaster::model()->findAll(array('order'=>'route'));

         Yii::import('ext.phpexcel.XPHPExcel');    
			  $objPHPExcel= XPHPExcel::createPHPExcel();
			  $objPHPExcel->getProperties()->setCreator("SNPS Mohali")
									->setLastModifiedBy("SNPS Mohali")
									 ->setTitle("SNPS Mohali Bus Fees Master Excel sheet")
									 ->setSubject("SNPS Mohali Bus Fees Master Excel sheet")
									 ->setDescription("SNPS Mohali Bus Fees Master Excel sheet")
									 ->setKeywords("SNPS Mohali Bus Fees Master Excel sheet")
									 ->setCategory("SNPS Mohali Bus Fees Master Excel sheet");


		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Bus route')
					->setCellValue('B1', 'Destination')
					->setCellValue('C1', 'Bus Fees')
					->setCellValue('D1', 'Bus Driver')
					->setCellValue('E1', 'Bus Attendant');


       	$i=2;
				 
					foreach($model as $busdata){
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$i, $busdata['route'])
						->setCellValue('B'.$i, $busdata['destination'])
						->setCellValue('C'.$i, $busdata['bus_fees'])
						->setCellValue('D'.$i, $busdata->route0['bus_driver'])
						->setCellValue('E'.$i, $busdata->route0['bus_attendant']);

						$i++;
					}
					
				  
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				

		$objPHPExcel->setActiveSheetIndex(0);


	    $filename="Busfeesreport".".xls";

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='.$filename);
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');

		Yii::app()->end();

	}
/* Excel sheet to get the detail of bus fees of every route ends here 23rd may 2017*/		
		
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
			
			$busquery="select * from busfees_master where bus_id='".$id."'";
			$sqlbus=Yii::app()->db->createCommand($busquery)->queryRow();
			$busroute=$sqlbus['route'];
			
			if(isset($_POST['BusfeesMaster']))
			{  
				if(isset($_POST['busno'])){
					$model->route=$_POST['busno'];
				}
				if(isset($_POST['destination'])){
					$model->destination=$_POST['destination'];
				}
				
				
				$model->attributes=$_POST['BusfeesMaster'];
				if($model->save())
				$this->redirect(array('admin','id'=>$model->bus_id));
			}
			
			
			
			
			
			$this->render('update',array(
			'model'=>$model,'busroute'=>$busroute
			));
		}
		
		public function actionBusdetails($route=null){
			
			$busdetails="select * from bus_master where bus_route='".$route."'";
			$resbus=Yii::app()->db->createCommand($busdetails)->queryRow();
			$driver=$resbus['bus_driver'];
			$conductor=$resbus['bus_conductor'];
			$attendant=$resbus['bus_attendant'];
			echo $driver."&".$conductor."&".$attendant;
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
			$dataProvider=new CActiveDataProvider('BusfeesMaster');
			$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		}
		
		/**
		* Manages all models.
		*/
		public function actionAdmin()
		{
		$model=new BusfeesMaster('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BusfeesMaster']))
		$model->attributes=$_GET['BusfeesMaster'];
		
		$this->render('admin',array(
		'model'=>$model,
		));
		}
		
		/**
		* Returns the data model based on the primary key given in the GET variable.
		* If the data model is not found, an HTTP exception will be raised.
		* @param integer $id the ID of the model to be loaded
		* @return BusfeesMaster the loaded model
		* @throws CHttpException
		*/
		public function loadModel($id)
		{
		$model=BusfeesMaster::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
		}
		
		/**
		* Performs the AJAX validation.
		* @param BusfeesMaster $model the model to be validated
		*/
		protected function performAjaxValidation($model)
		{
		if(isset($_POST['ajax']) && $_POST['ajax']==='busfees-master-form')
		{
		echo CActiveForm::validate($model);
		Yii::app()->end();
		}
		}
		}
				
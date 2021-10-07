<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Student Fees'=>array('admin'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Student Fees', 'url'=>array('admin')),
);
?>

<h1>Create Student Fees</h1>
<?php 

$this->renderPartial('_form', array('model'=>$model,'fees'=>$fees,'m'=>$m,'contyp'=>$contyp));

//$this->renderPartial('_form', array('model'=>$model));

 ?>

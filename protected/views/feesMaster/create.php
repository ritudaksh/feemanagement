<?php
/* @var $this FeesMasterController */
/* @var $model FeesMaster */

$this->breadcrumbs=array(
	'Fees'=>array('admin'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Fees', 'url'=>array('admin')),
);
?>

<h1>Create Fees</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

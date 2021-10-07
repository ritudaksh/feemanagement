<?php
/* @var $this FeesMasterController */
/* @var $model FeesMaster */

$this->breadcrumbs=array(
	'Fees'=>array('admin'),
	$model->fees_id=>array('view','id'=>$model->fees_id),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Fees', 'url'=>array('create')),
	//array('label'=>'View FeesMaster', 'url'=>array('view', 'id'=>$model->fees_id)),
	array('label'=>'Manage Fees', 'url'=>array('admin')),
);
?>

<h1>Update Fees <?php echo $model->fees_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

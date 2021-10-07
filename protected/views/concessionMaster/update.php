<?php
/* @var $this ConcessionMasterController */
/* @var $model ConcessionMaster */

$this->breadcrumbs=array(
	'Concession'=>array('admin'),
	$model->concession_id=>array('view','id'=>$model->concession_id),
	'Update',
);

$this->menu=array(
	
	array('label'=>'Create Concession', 'url'=>array('create')),
	//array('label'=>'View ConcessionMaster', 'url'=>array('view', 'id'=>$model->concession_id)),
	array('label'=>'Manage Concession', 'url'=>array('admin')),
);
?>

<h1>Update Concession <?php echo $model->concession_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

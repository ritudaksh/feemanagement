<?php
/* @var $this ConcessionMasterController */
/* @var $model ConcessionMaster */

$this->breadcrumbs=array(
	'Concession Masters'=>array('index'),
	$model->concession_id,
);

$this->menu=array(
	
	array('label'=>'Create ConcessionMaster', 'url'=>array('create')),
//array('label'=>'Update ConcessionMaster', 'url'=>array('update', 'id'=>$model->concession_id)),
//array('label'=>'Delete ConcessionMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->concession_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConcessionMaster', 'url'=>array('admin')),
);
?>

<h1>View Concession Master #<?php echo $model->concession_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'concession_id',
		'concession_type',
		'concession_persent',
		'concession_amount',
	),
)); ?>

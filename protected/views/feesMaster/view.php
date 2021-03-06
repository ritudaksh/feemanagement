<?php
/* @var $this FeesMasterController */
/* @var $model FeesMaster */

$this->breadcrumbs=array(
	'Fees Masters'=>array('index'),
	$model->fees_id,
);

$this->menu=array(
	
	array('label'=>'Create FeesMaster', 'url'=>array('create')),
//array('label'=>'Update FeesMaster', 'url'=>array('update', 'id'=>$model->fees_id)),
	//array('label'=>'Delete FeesMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->fees_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FeesMaster', 'url'=>array('admin')),
);
?>

<h1>View FeesMaster #<?php echo $model->fees_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'fees_id',
		'class_no',
		'annual_fees',
		'tuition_fees',
		'funds_fees',
		'sports_fees',
		'activity_fees',
		'admission_fees',
		'security_fees',
		'dayboarding_fees',
		'valid_from',
		'valid_to',
	),
)); ?>

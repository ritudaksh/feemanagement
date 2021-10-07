<?php
/* @var $this LatefeeMasterController */
/* @var $model LatefeeMaster */

$this->breadcrumbs=array(
	'Latefee Masters'=>array('index'),
	$model->latefee_id,
);

$this->menu=array(
	
	array('label'=>'Create LatefeeMaster', 'url'=>array('create')),
	//array('label'=>'Update LatefeeMaster', 'url'=>array('update', 'id'=>$model->latefee_id)),
	//array('label'=>'Delete LatefeeMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->latefee_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LatefeeMaster', 'url'=>array('admin')),
);
?>

<h1>View LatefeeMaster #<?php echo $model->latefee_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'latefee_id',
		'days_from',
		'days_to',
		'latefee',
	),
)); ?>

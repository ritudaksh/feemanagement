<?php
/* @var $this PaymentScheduleMasterController */
/* @var $model PaymentScheduleMaster */

$this->breadcrumbs=array(
	'Payment Schedule Masters'=>array('index'),
	$model->schedule_id,
);

$this->menu=array(
	
	array('label'=>'Create PaymentScheduleMaster', 'url'=>array('create')),
	//array('label'=>'Update PaymentScheduleMaster', 'url'=>array('update', 'id'=>$model->schedule_id)),
	//array('label'=>'Delete PaymentScheduleMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->schedule_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaymentScheduleMaster', 'url'=>array('admin')),
);
?>

<h1>View PaymentScheduleMaster #<?php echo $model->schedule_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'schedule_id',
		'fees_for_months',
		'pay_in_month',
		'payment_date',
	),
)); ?>

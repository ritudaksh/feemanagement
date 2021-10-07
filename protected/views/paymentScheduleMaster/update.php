<?php
/* @var $this PaymentScheduleMasterController */
/* @var $model PaymentScheduleMaster */

$this->breadcrumbs=array(
	'Payment Schedule'=>array('index'),
	$model->schedule_id=>array('view','id'=>$model->schedule_id),
	'Update',
);

$this->menu=array(

	array('label'=>'Create Payment Schedule', 'url'=>array('create')),
	//array('label'=>'View PaymentScheduleMaster', 'url'=>array('view', 'id'=>$model->schedule_id)),
	array('label'=>'Manage Payment Schedule', 'url'=>array('admin')),
);
?>

<h1>Update Payment Schedule <?php echo $model->schedule_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

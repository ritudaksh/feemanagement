<?php
/* @var $this PaymentScheduleMasterController */
/* @var $model PaymentScheduleMaster */

$this->breadcrumbs=array(
	'Payment Schedule'=>array('admin'),
	'Create',
);

$this->menu=array(
	
	array('label'=>'Manage Payment Schedule', 'url'=>array('admin')),
);
?>

<h1>Create Payment Schedule</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

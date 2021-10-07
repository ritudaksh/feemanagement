<?php
/* @var $this BusfeesMasterController */
/* @var $data BusfeesMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bus_id), array('view', 'id'=>$data->bus_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('route')); ?>:</b>
	<?php echo CHtml::encode($data->route); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination')); ?>:</b>
	<?php echo CHtml::encode($data->destination); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_fees')); ?>:</b>
	<?php echo CHtml::encode($data->bus_fees); ?>
	<br />


</div>
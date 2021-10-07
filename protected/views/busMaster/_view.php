<?php
/* @var $this BusMasterController */
/* @var $data BusMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('busdetail_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->busdetail_id), array('view', 'id'=>$data->busdetail_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_route')); ?>:</b>
	<?php echo CHtml::encode($data->bus_route); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_driver')); ?>:</b>
	<?php echo CHtml::encode($data->bus_driver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_conductor')); ?>:</b>
	<?php echo CHtml::encode($data->bus_conductor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_attendant')); ?>:</b>
	<?php echo CHtml::encode($data->bus_attendant); ?>
	<br />


</div>
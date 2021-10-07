<?php
/* @var $this LatefeeMasterController */
/* @var $data LatefeeMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('latefee_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->latefee_id), array('view', 'id'=>$data->latefee_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('days_from')); ?>:</b>
	<?php echo CHtml::encode($data->days_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('days_to')); ?>:</b>
	<?php echo CHtml::encode($data->days_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('latefee')); ?>:</b>
	<?php echo CHtml::encode($data->latefee); ?>
	<br />


</div>
<?php
/* @var $this PaymentScheduleMasterController */
/* @var $data PaymentScheduleMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('schedule_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->schedule_id), array('view', 'id'=>$data->schedule_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fees_for_months')); ?>:</b>
	<?php echo CHtml::encode($data->fees_for_months); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pay_in_month')); ?>:</b>
	<?php echo CHtml::encode($data->pay_in_month); ?>
	<br />


</div>
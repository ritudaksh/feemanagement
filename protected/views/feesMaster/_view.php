<?php
/* @var $this FeesMasterController */
/* @var $data FeesMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('fees_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fees_id), array('view', 'id'=>$data->fees_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class_no')); ?>:</b>
	<?php echo CHtml::encode($data->class_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('annual_fees')); ?>:</b>
	<?php echo CHtml::encode($data->annual_fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tuition_fees')); ?>:</b>
	<?php echo CHtml::encode($data->tuition_fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('funds_fees')); ?>:</b>
	<?php echo CHtml::encode($data->funds_fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sports_fees')); ?>:</b>
	<?php echo CHtml::encode($data->sports_fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admission_fees')); ?>:</b>
	<?php echo CHtml::encode($data->admission_fees); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('security_fees')); ?>:</b>
	<?php echo CHtml::encode($data->security_fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dayboarding_fees')); ?>:</b>
	<?php echo CHtml::encode($data->dayboarding_fees); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dueby_date')); ?>:</b>
	<?php echo CHtml::encode($data->dueby_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valid_form')); ?>:</b>
	<?php echo CHtml::encode($data->valid_form); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('valide_to')); ?>:</b>
	<?php echo CHtml::encode($data->valide_to); ?>
	<br />

	*/ ?>

</div>
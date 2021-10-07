<?php
/* @var $this StudentFeesController */
/* @var $data StudentFees */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_fee_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->student_fee_id), array('view', 'id'=>$data->student_fee_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_class_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_class_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fees_for_months')); ?>:</b>
	<?php echo CHtml::encode($data->fees_for_months); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('annual_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->annual_fees_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tuition_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->tuition_fees_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('funds_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->funds_fees_paid); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sports_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->sports_fees_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admission_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->admission_fees_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('security_paid')); ?>:</b>
	<?php echo CHtml::encode($data->security_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('late_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->late_fees_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dayboarding_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->dayboarding_fees_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_fees_paid')); ?>:</b>
	<?php echo CHtml::encode($data->bus_fees_paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_payment')); ?>:</b>
	<?php echo CHtml::encode($data->date_payment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_mode')); ?>:</b>
	<?php echo CHtml::encode($data->payment_mode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cheq_no')); ?>:</b>
	<?php echo CHtml::encode($data->cheq_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_name')); ?>:</b>
	<?php echo CHtml::encode($data->bank_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('concession_applied')); ?>:</b>
	<?php echo CHtml::encode($data->concession_applied); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('concession_type')); ?>:</b>
	<?php echo CHtml::encode($data->concession_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Total_amount')); ?>:</b>
	<?php echo CHtml::encode($data->Total_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_paid')); ?>:</b>
	<?php echo CHtml::encode($data->amount_paid); ?>
	<br />

	*/ ?>

</div>
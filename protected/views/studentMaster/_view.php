<?php
/* @var $this StudentMasterController */
/* @var $data StudentMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->student_id), array('view', 'id'=>$data->student_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addmission_no')); ?>:</b>
	<?php echo CHtml::encode($data->addmission_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_name')); ?>:</b>
	<?php echo CHtml::encode($data->student_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('father_name')); ?>:</b>
	<?php echo CHtml::encode($data->father_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mother_name')); ?>:</b>
	<?php echo CHtml::encode($data->mother_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birth_date')); ?>:</b>
	<?php echo CHtml::encode($data->birth_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone_no')); ?>:</b>
	<?php echo CHtml::encode($data->phone_no); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile_no')); ?>:</b>
	<?php echo CHtml::encode($data->mobile_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_no')); ?>:</b>
	<?php echo CHtml::encode($data->bus_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bus_destination')); ?>:</b>
	<?php echo CHtml::encode($data->bus_destination); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admission_date')); ?>:</b>
	<?php echo CHtml::encode($data->admission_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_concessiontype')); ?>:</b>
	<?php echo CHtml::encode($data->student_concessiontype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passedout_date')); ?>:</b>
	<?php echo CHtml::encode($data->passedout_date); ?>
	<br />

	*/ ?>

</div>
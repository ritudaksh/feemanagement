<?php
/* @var $this StudentClassesController */
/* @var $data StudentClasses */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_class_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->student_class_id), array('view', 'id'=>$data->student_class_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('class_no')); ?>:</b>
	<?php echo CHtml::encode($data->class_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('started_on')); ?>:</b>
	<?php echo CHtml::encode($data->started_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ended_on')); ?>:</b>
	<?php echo CHtml::encode($data->ended_on); ?>
	<br />


</div>
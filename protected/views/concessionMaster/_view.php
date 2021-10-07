<?php
/* @var $this ConcessionMasterController */
/* @var $data ConcessionMaster */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('concession_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->concession_id), array('view', 'id'=>$data->concession_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('concession_type')); ?>:</b>
	<?php echo CHtml::encode($data->concession_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('concession_persent')); ?>:</b>
	<?php echo CHtml::encode($data->concession_persent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('concession_amount')); ?>:</b>
	<?php echo CHtml::encode($data->concession_amount); ?>
	<br />


</div>
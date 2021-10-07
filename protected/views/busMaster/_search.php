<?php
/* @var $this BusMasterController */
/* @var $model BusMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'busdetail_id'); ?>
		<?php echo $form->textField($model,'busdetail_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bus_route'); ?>
		<?php echo $form->textField($model,'bus_route'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bus_driver'); ?>
		<?php echo $form->textField($model,'bus_driver',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bus_conductor'); ?>
		<?php echo $form->textField($model,'bus_conductor',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bus_attendant'); ?>
		<?php echo $form->textField($model,'bus_attendant',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
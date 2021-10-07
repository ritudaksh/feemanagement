<?php
/* @var $this BusfeesMasterController */
/* @var $model BusfeesMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'bus_id'); ?>
		<?php echo $form->textField($model,'bus_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'route'); ?>
		<?php echo $form->textField($model,'route',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destination'); ?>
		<?php echo $form->textField($model,'destination',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bus_fees'); ?>
		<?php echo $form->textField($model,'bus_fees'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
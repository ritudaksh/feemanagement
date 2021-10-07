<?php
/* @var $this PaymentScheduleMasterController */
/* @var $model PaymentScheduleMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'schedule_id'); ?>
		<?php echo $form->textField($model,'schedule_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fees_for_months'); ?>
		<?php echo $form->textField($model,'fees_for_months',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pay_in_month'); ?>
		<?php echo $form->textField($model,'pay_in_month'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
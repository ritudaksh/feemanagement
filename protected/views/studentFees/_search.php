<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'student_fee_id'); ?>
		<?php echo $form->textField($model,'student_fee_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id'); ?>
	</div>

	<!--<div class="row">
		<?php //echo $form->label($model,'student_class_id'); ?>
		<?php //echo $form->textField($model,'student_class_id'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'fees_for_months'); ?>
		<?php echo $form->textField($model,'fees_for_months',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'annual_fees_paid'); ?>
		<?php echo $form->textField($model,'annual_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tuition_fees_paid'); ?>
		<?php echo $form->textField($model,'tuition_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'funds_fees_paid'); ?>
		<?php echo $form->textField($model,'funds_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sports_fees_paid'); ?>
		<?php echo $form->textField($model,'sports_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admission_fees_paid'); ?>
		<?php echo $form->textField($model,'admission_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'security_paid'); ?>
		<?php echo $form->textField($model,'security_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'late_fees_paid'); ?>
		<?php echo $form->textField($model,'late_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dayboarding_fees_paid'); ?>
		<?php echo $form->textField($model,'dayboarding_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bus_fees_paid'); ?>
		<?php echo $form->textField($model,'bus_fees_paid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_payment'); ?>
		<?php echo $form->textField($model,'date_payment'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_mode'); ?>
		<?php echo $form->textField($model,'payment_mode',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cheq_no'); ?>
		<?php echo $form->textField($model,'cheq_no',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bank_name'); ?>
		<?php echo $form->textField($model,'bank_name',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'concession_applied'); ?>
		<?php echo $form->textField($model,'concession_applied'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'concession_type_id'); ?>
		<?php echo $form->textField($model,'concession_type_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Total_amount'); ?>
		<?php echo $form->textField($model,'Total_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount_paid'); ?>
		<?php echo $form->textField($model,'amount_paid'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<?php
/* @var $this MemberEmailsController */
/* @var $model MemberEmails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'member-emails-index-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'member_emailid'); ?>
		<?php echo $form->textField($model,'member_emailid'); ?>
		<?php echo $form->error($model,'member_emailid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'added_on'); ?>
		<?php echo $form->textField($model,'added_on'); ?>
		<?php echo $form->error($model,'added_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'member_guid'); ?>
		<?php echo $form->textField($model,'member_guid'); ?>
		<?php echo $form->error($model,'member_guid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'provider_guid'); ?>
		<?php echo $form->textField($model,'provider_guid'); ?>
		<?php echo $form->error($model,'provider_guid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'provider_name'); ?>
		<?php echo $form->textField($model,'provider_name'); ?>
		<?php echo $form->error($model,'provider_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'called_you'); ?>
		<?php echo $form->textField($model,'called_you'); ?>
		<?php echo $form->error($model,'called_you'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_hired'); ?>
		<?php echo $form->textField($model,'date_hired'); ?>
		<?php echo $form->error($model,'date_hired'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hired_rate'); ?>
		<?php echo $form->textField($model,'hired_rate'); ?>
		<?php echo $form->error($model,'hired_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'called_them'); ?>
		<?php echo $form->textField($model,'called_them'); ?>
		<?php echo $form->error($model,'called_them'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'toured'); ?>
		<?php echo $form->textField($model,'toured'); ?>
		<?php echo $form->error($model,'toured'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hired_contracted'); ?>
		<?php echo $form->textField($model,'hired_contracted'); ?>
		<?php echo $form->error($model,'hired_contracted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'satisfaction'); ?>
		<?php echo $form->textField($model,'satisfaction'); ?>
		<?php echo $form->error($model,'satisfaction'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
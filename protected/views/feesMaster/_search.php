<?php
/* @var $this FeesMasterController */
/* @var $model FeesMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'fees_id'); ?>
		<?php echo $form->textField($model,'fees_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'class_no'); ?>
		<?php echo $form->textField($model,'class_no',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'annual_fees'); ?>
		<?php echo $form->textField($model,'annual_fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tuition_fees'); ?>
		<?php echo $form->textField($model,'tuition_fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'funds_fees'); ?>
		<?php echo $form->textField($model,'funds_fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sports_fees'); ?>
		<?php echo $form->textField($model,'sports_fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activity_fees'); ?>
		<?php echo $form->textField($model,'activity_fees'); ?>
	</div>
	
	
	
	<div class="row">
		<?php echo $form->label($model,'admission_fees'); ?>
		<?php echo $form->textField($model,'admission_fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'security_fees'); ?>
		<?php echo $form->textField($model,'security_fees'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dayboarding_fees'); ?>
		<?php echo $form->textField($model,'dayboarding_fees'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->label($model,'valid_from'); ?>
		<?php echo $form->textField($model,'valid_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'valid_to'); ?>
		<?php echo $form->textField($model,'valid_to'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
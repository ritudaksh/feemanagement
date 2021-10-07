<?php
/* @var $this StudentMasterController */
/* @var $model StudentMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'student_id'); ?>
		<?php echo $form->textField($model,'student_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'addmission_no'); ?>
		<?php echo $form->textField($model,'addmission_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'student_name'); ?>
		<?php echo $form->textField($model,'student_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'father_name'); ?>
		<?php echo $form->textField($model,'father_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mother_name'); ?>
		<?php echo $form->textField($model,'mother_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'birth_date'); ?>
		<?php echo $form->textField($model,'birth_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'phone_no'); ?>
		<?php echo $form->textField($model,'phone_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mobile_no'); ?>
		<?php echo $form->textField($model,'mobile_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bus_id'); ?>
		<?php echo $form->textField($model,'bus_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($model,'bus_destination'); ?>
		<?php //echo $form->textField($model,'bus_destination',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gender'); ?>
		<?php echo $form->textField($model,'gender',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admission_date'); ?>
		<?php echo $form->textField($model,'admission_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'concession_id'); ?>
		<?php echo $form->textField($model,'concession_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'passedout_date'); ?>
		<?php echo $form->textField($model,'passedout_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
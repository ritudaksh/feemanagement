<?php
/* @var $this ConcessionMasterController */
/* @var $model ConcessionMaster */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'concession_id'); ?>
		<?php echo $form->textField($model,'concession_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'concession_type'); ?>
		<?php echo $form->textField($model,'concession_type',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'concession_persent'); ?>
		<?php echo $form->textField($model,'concession_persent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'concession_amount'); ?>
		<?php echo $form->textField($model,'concession_amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
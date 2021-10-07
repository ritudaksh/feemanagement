<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="form" style="margin-left:200px; width:60%;border:3px solid black;background:#CEE1EB;">
<h1 style="margin-left:250px;margin-top:10px;">Login</h1>

<p style="margin-left:130px;">Please fill out the following form with your login credentials:</p>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	

	<div class="row" style="margin-left:210px;margin-top:-10px;">
		
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row" style="margin-left:210px;">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: You may login with <kbd>admin</kbd>/<kbd>admin</kbd>.
		</p>
	</div>

	<div class="row rememberMe" style="margin-left:210px;">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons" style="margin-left:250px;">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

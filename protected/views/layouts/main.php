<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
</head>
<body>
<div id="wrapper">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'update-profile-form',
	
	'enableAjaxValidation'=>true,
)); ?>
<?php $this->endWidget(); ?>
<div id="header">
<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
<div class="container" id="page">

</div><!-- header -->
<?php
if(Yii::app()->user->name !="Guest"){?>
	<div class="main_menu">
<?php


$this->widget('zii.widgets.CMenu',array(
  'activeCssClass'=>'active',
  'activateParents'=>true,
  'items'=>array(
      
    array(
      'label'=>'Admin Section',
      'url'=>array('studentMaster/admin'),
      'items'=>array(
        array('label'=>'Student Master', 'url'=>array('studentMaster/admin')),
        array('label'=>'Generate Mobile Numbers List', 'url'=>array('studentMaster/sms')),
		
        array('label'=>'Payment Schedule Master', 'url'=>array('/paymentScheduleMaster/admin','view'=>'about')),
        array('label'=>'Latefees Master', 'url'=>array('/latefeeMaster/admin', 'view'=>'about')),
        array('label'=>'Busfees/Route Master', 'url'=>array('/busfeesMaster/admin', 'view'=>'about')),
        array('label'=>'Concession Master', 'url'=>array('/concessionMaster/admin','view'=>'about')),
        array('label'=>'Student Class Master', 'url'=>array('/studentClasses/admin', 'view'=>'about')),
        array('label'=>'Fee Master ', 'url'=>array('/feesMaster/admin', 'view'=>'about')),
		array('label'=>'Bus Master ', 'url'=>array('/busMaster/admin', 'view'=>'about')),
      ),
    ),
 array(
      'label'=>'Fees Section',
      'url'=>array('/studentFees/admin'),
     'items'=>array(
	 
     array('label'=>'Student Fees','url'=>array('/studentFees/admin','view'=>'about')),
	
	  array('label'=>'Account heads', 'url'=>array('site/accountheads')),
	  array('label'=>'Expenses', 'url'=>array('site/expenses')),
	   array('label'=>'Cheque Status', 'url'=>array('/studentFees/chequestatus')),
       
        ),
    ),

       array(
      'label'=>'Reports',
      'url'=>array('site/report'),
      'items'=>array(
        array('label'=>'Tution fees Defaulter', 'url'=>array('site/report')),
		array('label'=>'Collection', 'url'=>array('site/collection')),
		array('label'=>'Transport', 'url'=>array('site/transport')),
		array('label'=>'Admission report', 'url'=>array('site/admission')),
	    array('label'=>'Expense report', 'url'=>array('site/expensereport')),
		array('label'=>'Final fees report', 'url'=>array('site/finalfeesreport')),
		array('label'=>'Activity fees defaulter', 'url'=>array('site/activityfeesreport')),
		array('label'=>'Transport fees defaulter', 'url'=>array('site/transportdefreport')),	
		array('label'=>'Expected Fee Register', 'url'=>array('site/expectedfeeregister')),	
		array('label'=>'Cheque Deposit Report', 'url'=>array('site/chequedepositreport')),	
      ),
    ),
/*  array('label'=>'Login', 'url'=>array('/studentFees/admin'), 
  'visible'=>Yii::app()->user->isGuest),*/
				array('label'=>'Logout ('.Yii::app()->user->name.')', 
			    'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			
			),
));

 ?>
</div>
<?php }?>

	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; to Shishu Niketan Public School, Mohali.
		All Rights Reserved.<br/>
		
	</div><!-- footer -->

</div><!-- page -->
</body>
</html>

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
<style>
.main_menu {
    color: #FFFFFF;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px;
    height: 30px;
    line-height: 30px;
    position: relative;
 background: none repeat scroll 0 0 #0066A4;;;
}
.main_menu ul {
    list-style: none outside none;
    margin: 0;
    padding: 0;
}
.main_menu ul li {
    background: no-repeat scroll 0 0 #0066A4;;;
    border-right: 1px solid #000000;
    float: left;
    margin: 0;
    padding: 0;
}
.main_menu ul li a {
    color: #FFFFFF;
    display: block;
    padding: 0 29px;
    text-decoration: none;
}
.main_menu ul li a:hover {
    background: none repeat scroll 0 0 #3EA5EA;
    color: #000000;
}
.main_menu ul li ul {
    display: none;
    margin: 0;
    padding: 0;
    position: absolute;
    top: 30px;
    width: auto;
}
.main_menu ul li:hover ul {
    display: block;
    margin: 0;
    padding: 0;
    position: absolute;
}
.main_menu ul li:hover li {
    float: none;
    list-style: none outside none;
    margin: 0;
}
.main_menu ul li:hover li {
    background: none repeat scroll 0 0 #333333;
    border-top: 1px solid #000000;
}
.main_menu ul li:hover li a {
    color: #FFFFFF;
    display: block;
    padding: 0 20px;
    width: 170px;
}
.main_menu ul li li a:hover {
    color: #000000;
}

</style>

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
		
        array('label'=>'Payment Schedule Master', 'url'=>array('/paymentScheduleMaster/admin','view'=>'about')),
        array('label'=>'Latefees Master', 'url'=>array('/latefeeMaster/admin', 'view'=>'about')),
        array('label'=>'Busfees Master', 'url'=>array('/busfeesMaster/admin', 'view'=>'about')),
        array('label'=>'Concession Master', 'url'=>array('/concessionMaster/admin','view'=>'about')),
        array('label'=>'Student Class Master', 'url'=>array('/studentClasses/admin', 'view'=>'about')),
        array('label'=>'Fee Master ', 'url'=>array('/feesMaster/admin', 'view'=>'about')),
      ),
    ),
 array(
      'label'=>'Fees Section',
      'url'=>array('/studentFees/admin'),
     'items'=>array(
	 
     array('label'=>'Student Fees','url'=>array('/studentFees/admin','view'=>'about')),
	
        ),
    ),

       array(
      'label'=>'Reports',
      'url'=>array('site/report'),
      'items'=>array(
        array('label'=>'Defaulter', 'url'=>array('site/report')),
		array('label'=>'Collection', 'url'=>array('site/collection')),
		array('label'=>'Transport', 'url'=>array('site/transport')),
		array('label'=>'Admission report', 'url'=>array('site/admission')),
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
</div>
</body>
</html>

</script>

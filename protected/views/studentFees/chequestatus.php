<script type="text/javascript" src="./js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./css/jquery-ui.css">
<style>
#loader_img
{
	display:none;
	    margin-left: 50%;
    margin-bottom: 10px;
}

</style>
<?php
/* @var $this StudentFeesController */
/* @var $model StudentFees */

$this->breadcrumbs=array(
	'Student Fees'=>array('admin'),
	'Manage',
);

$this->menu=array(
	
	array('label'=>'Create ss Fees', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#student-fees-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Cheque Status</h1>


<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chequestatusform',

	'enableAjaxValidation'=>false,
)); ?>
      
	  <div class="form-group" style="float:right;">
	      <input type="submit" class="btn btn-primary btn-lg status" name="realized" id="realized" value="Mark as Realized">
		  
		   <input type="submit" class="btn btn-primary btn-lg status" name="rejected" id="rejected" value="Mark as Rejected">
		   
	  </div>
	  
	  	 <?php $today=date("d-m-y"); ?>
		<div class="form-group">  
		   Realized Date: <input class="btn btn-primary btn-lg" type="text" id="datepicker" value= <?php echo $today ?>>
		</div>
	 <img src="images/ajax-loader.gif" id="loader_img">
        	
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'student-fees-grid',
	'htmlOptions' => array('style'=>'width:100%'),
	'dataProvider'=>$model->searchOpenCheques(),
	'filter'=>$model,
	'columns'=>array(
		
              /*  array(
            'name'=>'studentFee.addmission_no',
            'filter'=>CHtml::activeTextField($model,'admno'),
        ),*/
		
                //'student_name',
				//'fathers_name',
				//'student_class_id',
		     
            array(
               'id'=>'student_fee_id',
               'class'=>'CCheckBoxColumn',
               'selectableRows' => '50', 
               'selectableRows'=>2,
               'value'=>$model->student_fee_id,
               'htmlOptions'=>array('style'=>'width: 20px'),
               
                  

         	  ),
             	
  		 
		array(
            'name'=>'student.addmission_no',
	    'header'=>'Admission No',
            'filter'=>CHtml::activeTextField($model,'admno'),
        ),
		
		'student_class',
		'student_section',
			array(
            'name'=>'student.student_name',
            'filter'=>CHtml::activeTextField($model,'name'),
        ),
       

		//'fees_for_months',
		'fees_period_month',
		'year',
		array(
    'name'=>'date_payment',
    'header'=>'Date Payment',
   
    'value'=>'Yii::app()->dateFormatter->format("yyyy-MM-dd",strtotime($data->date_payment))'
),
             
                 
		/*'annual_fees_paid',
		'tuition_fees_paid',
		'funds_fees_paid',
		'sports_fees_paid',*/
		'cheque_status',
		'cheq_no',
		'bank_name',
		'branch_name',
/*		'annual_fees_paid',
		'tuition_fees_paid',
		'concession_applied',
		'funds_fees_paid',
		'admission_fees_paid',
		'security_paid',
		'dayboarding_fees_paid',
		'bus_fees_paid',
		'activity_fees', */
		'date_payment',
/*		'late_fees_paid',
		'concession_applied',
		'concession_type',
		*/
		'Total_amount',
		'amount_paid',
		array(
    'name'=>'entry_date',
    'header'=>'Date of entry',
   
   'value'=>'$data->entry_date==NULL?"":date("d-m-Y",strtotime($data->entry_date))',
    'filter'=>CHtml::activeTextField($model, 'entry_date', 
                 array('placeholder'=>'yyyy-mm-dd'))
),
		array(
			'class'=>'CButtonColumn',
'template'=>'{update}{delete}',
'deleteConfirmation'=>"Are You Sure you want to delete this fees?",
  'buttons' =>array('update'=>array(

             'label'=>'Edit',
    
               array(
                            'visible'=>'true',
    ),

		),
 'delete'=>array(
                            'visible'=>'true',
    ),
	),


		),
	),
));


 ?>

<div class="row buttons" style="margin-left:250px">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>		


 <?php $this->endWidget(); ?>



<script>
$(document).ready(function() {
				  
					  
		 $(function() {
			$( "#datepicker" ).datepicker({
				dateFormat: 'dd-mm-yy'
				});
			   });
	
	
       
 		$("input:checkbox").change(function() {
 			
		    var someObj = {};
		    someObj.selectvalue = [];
		    someObj.deselectvalue = [];

		    $("input:checkbox").each(function() {
		        if ($(this).is(":checked")) {

		           someObj.selectvalue.push($(this).attr("value"));
		        } else {
		            someObj.deselectvalue.push($(this).attr("value"));
		        }
		    });
		//alert(someObj.selectvalue);

            $getval  =  someObj.selectvalue;
             //alert($getval);	
            var str1 = $getval .toString(); 
            //alert(str1);
           // console.log(str1);

     
		$("#realized").click(function(e){

		
		 var date = $("#datepicker").datepicker("getDate");
         var date1 = $.datepicker.formatDate("yy-mm-dd", date);
             e.preventDefault();
		  /// alert($(this).val());
		   // alert('checkrec');
		   
		   	var buttonid=$(this).attr("id");
			var b1   = buttonid.toString();

		   	var feesid=someObj.selectvalue;

		   	var f1   = feesid.toString();
             //console.log(b1);
             console.log(f1);
				$.ajax({
				type: "GET",
				url:    "<?php echo Yii::app()->createUrl('studentFees/Chequestatus'); ?>",
				data: {'feesids':f1, 'entdate':date1,'chngst':'Realized' },
				success: function(xhr){
					location.reload();
				//console.log("sucess"+xhr.readyState+this.url);
				},
				error: function(xhr){
				//console.log("failure"+xhr.readyState+this.url);
				}
			});

			});
    
       $("#rejected").click(function(e){
              var date = $("#datepicker").datepicker("getDate");
              var date1 = $.datepicker.formatDate("yy-mm-dd", date);
              //alert(date1);
             e.preventDefault();
		   	var buttonid=$(this).attr("id");
              var b1   = buttonid.toString();
             
		   	var feesid=someObj.selectvalue;

		   	var f1   = feesid.toString();
            	$.ajax({
				type: "GET",
				url:    "<?php echo Yii::app()->createUrl('studentFees/Chequestatus'); ?>",
				data: {'feesids':f1, 'entdate':date1,'chngst':'Rejected' },
				success: function(xhr){
					$('#loader_img').css("display","none");
					location.reload();
				console.log("sucess"+xhr.readyState+this.url);
				},
				error: function(xhr){
				console.log("failure"+xhr.readyState+this.url);
				}

		  });
      });
   });
   
			
   
   

});

</script>


<script>
$(".status").click(function(){
	$('#loader_img').css("display","block");
      });

  </script>





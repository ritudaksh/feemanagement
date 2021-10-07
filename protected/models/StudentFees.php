<?php

/**
 * This is the model class for table "student_fees".
 *
 * The followings are the available columns in table 'student_fees':
 * @property string $student_fee_id
 * @property integer $student_id
 * @property string $student_class
 * @property string $student_section
 * @property string $fees_for_months
 * @property string $fees_period_month
 * @property string $year
 * @property integer $bus_id
 * @property integer $annual_fees_paid
 * @property integer $tuition_fees_paid
 * @property integer $funds_fees_paid
 * @property integer $sports_fees_paid
 * @property integer $activity_fees
 * @property integer $admission_fees_paid
 * @property integer $security_paid
 * @property integer $late_fees_paid
 * @property integer $dayboarding_fees_paid
 * @property integer $bus_fees_paid
 * @property string $date_payment
 * @property string $payment_mode
 * @property string $cheq_no
 * @property string $bank_name
 * @property double $concession_applied
 * @property integer $concession_type_id
 * @property double $Total_amount
 * @property double $amount_paid
 * @property string $isdefault
 * @property string $entry_date
 *
 * The followings are the available model relations:
 * @property BusfeesMaster $bus
 * @property StudentMaster $student
 * @property ConcessionMaster $concessionType
 */
class StudentFees extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $admno;//manuualy added
	public $name;//manuualy added
	public $chequestatus;
	public $selectall;

	public function tableName()
	{
		return 'student_fees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, student_class, student_section, fees_for_months, fees_period_month', 'required'),
			array('student_id, bus_id, annual_fees_paid, tuition_fees_paid, funds_fees_paid, sports_fees_paid, activity_fees, admission_fees_paid, security_paid, late_fees_paid, dayboarding_fees_paid, bus_fees_paid ', 'numerical', 'integerOnly'=>true),
			array('concession_applied, Total_amount, amount_paid', 'numerical'),
			array('student_class, fees_for_months, cheq_no', 'length', 'max'=>20),
			array('student_section', 'length', 'max'=>1),
			array('fees_period_month', 'length', 'max'=>50),
			array('year', 'length', 'max'=>4),
			array('payment_mode, isdefault', 'length', 'max'=>10),
			array('bank_name', 'length', 'max'=>30),
			array('branch_name', 'length', 'max'=>50),
			array('date_payment, entry_date', 'safe'),
			array('realized_date, realized_date', 'safe'),
			array('cheque_status, cheque_status', 'safe'),
			array('cheque_status', 'length', 'max'=>10),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('student_fee_id, student_id, student_class,student_section, fees_for_months, fees_period_month, year, bus_id, annual_fees_paid, tuition_fees_paid, funds_fees_paid, sports_fees_paid, activity_fees, admission_fees_paid, security_paid, late_fees_paid, dayboarding_fees_paid, bus_fees_paid, date_payment,payment_mode, cheq_no, bank_name,
			    branch_name, concession_applied, concession_type_id, Total_amount, amount_paid, 
			    isdefault, entry_date,cheque_status,realized_date', 'safe', 'on'=>'search'),
			//manually add relation attribute to  model, where search string will be stored. 
			array( 'name,admno', 'safe', 'on'=>'search' ),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'bus' => array(self::BELONGS_TO, 'BusfeesMaster', 'bus_id'),
			'student' => array(self::BELONGS_TO, 'StudentMaster', 'student_id'),
			'concessionType' => array(self::BELONGS_TO, 'ConcessionMaster', 'concession_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'student_fee_id' => 'Student Fee',
			'student_id' => 'Student',
			'student_class' => 'Student Class',
			'student_section' => 'Student Section',
			'fees_for_months' => 'Fees For Months',
			'fees_period_month' => 'Fees Period Month',
			'year' => 'Year',
			'bus_id' => 'Bus',
			'annual_fees_paid' => 'Annual Fees Paid',
			'tuition_fees_paid' => 'Tuition Fees Paid',
			'funds_fees_paid' => 'Funds Fees Paid',
			'sports_fees_paid' => 'Sports Fees Paid',
			'activity_fees' => 'Activity Fees',
			'admission_fees_paid' => 'Admission Fees Paid',
			'security_paid' => 'Security Paid',
			'late_fees_paid' => 'Late Fees Paid',
			'dayboarding_fees_paid' => 'Dayboarding Fees Paid',
			'bus_fees_paid' => 'Bus Fees Paid',
			'date_payment' => 'Date Payment',
			'payment_mode' => 'Payment Mode',
			'cheq_no' => 'Cheq No',
			'bank_name' => 'Bank Name',
			'concession_applied' => 'Concession Applied',
			'concession_type_id' => 'Concession Type',
			'Total_amount' => 'Total Amount',
			'amount_paid' => 'Amount Paid',
			'isdefault' => 'Isdefault',
			'entry_date' => 'Entry Date',
			'cheque_status'=>'Cheque Status',			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with=array('student');

		$criteria->compare('student_fee_id',$this->student_fee_id,true);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('student_class',$this->student_class,true);
		$criteria->compare('student_section',$this->student_section,true);
		$criteria->compare('fees_for_months',$this->fees_for_months,true);
		$criteria->compare('fees_period_month',$this->fees_period_month,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('bus_id',$this->bus_id);
		$criteria->compare('annual_fees_paid',$this->annual_fees_paid);
		$criteria->compare('tuition_fees_paid',$this->tuition_fees_paid);
		$criteria->compare('funds_fees_paid',$this->funds_fees_paid);
		$criteria->compare('sports_fees_paid',$this->sports_fees_paid);
		$criteria->compare('activity_fees',$this->activity_fees);
		$criteria->compare('admission_fees_paid',$this->admission_fees_paid);
		$criteria->compare('security_paid',$this->security_paid);
		$criteria->compare('late_fees_paid',$this->late_fees_paid);
		$criteria->compare('dayboarding_fees_paid',$this->dayboarding_fees_paid);
		$criteria->compare('bus_fees_paid',$this->bus_fees_paid);
		$criteria->compare('date_payment',$this->date_payment,true);
		$criteria->compare('payment_mode',$this->payment_mode,true);
		$criteria->compare('cheq_no',$this->cheq_no,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('concession_applied',$this->concession_applied);
		$criteria->compare('concession_type_id',$this->concession_type_id,true);
		$criteria->compare('Total_amount',$this->Total_amount);
		$criteria->compare('amount_paid',$this->amount_paid);
		$criteria->compare('isdefault',$this->isdefault,true);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('cheque_status',$this->cheque_status,true);
		$criteria->compare('student.addmission_no', $this->admno,true);
		$criteria->compare('student.student_name', $this->name,true);
		
		

		return new CActiveDataProvider($this, array(
		
		 'pagination'=>array(
                       'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                ),
				'sort'=>array(
				
				       'attributes'=>array(
					    'student.addmission_no'=>array(
						'asc'=>'student.addmission_no',
						'desc'=>'student.addmission_no DESC',
					),
					
						  'student.student_name'=>array(
						'asc'=>'student.student_name',
						'desc'=>'student.student_name DESC',
					),
					
					'*',
				),
                      'defaultOrder'=>'entry_date DESC',
                              ),
				
				
			'criteria'=>$criteria,
		));
	}
	public function searchOpenCheques()
	{

		$criteria=new CDbCriteria;
		$criteria->with=array('student');
		$criteria->compare('student_class',$this->student_class,true);
		$criteria->compare('student_section',$this->student_section,true);
		$criteria->compare('year',$this->year,true);
		$criteria->compare('date_payment',$this->date_payment,true);
		$criteria->compare('payment_mode',$this->payment_mode,true);
		$criteria->compare('cheq_no',$this->cheq_no,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('Total_amount',$this->Total_amount);
		$criteria->compare('amount_paid',$this->amount_paid);
		$criteria->compare('entry_date',$this->entry_date,true);
		$criteria->compare('cheque_status','Open',true);
		$criteria->compare('student.addmission_no', $this->admno,true);
		$criteria->compare('student.student_name', $this->name,true);
		return new CActiveDataProvider($this, array(
		
		 'pagination'=>array(
                       'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                ),
				'sort'=>array(
				
				       'attributes'=>array(
					    'student.addmission_no'=>array(
						'asc'=>'student.addmission_no',
						'desc'=>'student.addmission_no DESC',
					),
					
						  'student.student_name'=>array(
						'asc'=>'student.student_name',
						'desc'=>'student.student_name DESC',
					),
					
					'*',
				),
                      'defaultOrder'=>'entry_date DESC',
                              ),
				
				
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StudentFees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

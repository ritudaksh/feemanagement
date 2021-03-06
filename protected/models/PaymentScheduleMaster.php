<?php

/**
 * This is the model class for table "payment_schedule_master".
 *
 * The followings are the available columns in table 'payment_schedule_master':
 * @property integer $schedule_id
 * @property string $fees_for_months
 * @property string $pay_in_month
 * @property string $payment_date
 */
class PaymentScheduleMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment_schedule_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fees_for_months, pay_in_month, payment_date', 'required'),
			array('fees_for_months', 'length', 'max'=>100),
			array('pay_in_month, payment_date', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('schedule_id, fees_for_months, pay_in_month, payment_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'schedule_id' => 'Schedule',
			'fees_for_months' => 'Fees For Months',
			'pay_in_month' => 'Pay In Month',
			'payment_date' => 'Payment Date',
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

		$criteria->compare('schedule_id',$this->schedule_id);
		$criteria->compare('fees_for_months',$this->fees_for_months,true);
		$criteria->compare('pay_in_month',$this->pay_in_month,true);
		$criteria->compare('payment_date',$this->payment_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentScheduleMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "fees_master".
 *
 * The followings are the available columns in table 'fees_master':
 * @property integer $fees_id
 * @property string $class_no
 * @property integer $annual_fees
 * @property integer $tuition_fees
 * @property integer $funds_fees
 * @property integer $sports_fees
 * @property integer $activity_fees
 * @property integer $admission_fees
 * @property integer $security_fees
 * @property integer $dayboarding_fees
 * @property string $valid_from
 * @property string $valid_to
 */
class FeesMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fees_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('class_no, annual_fees, tuition_fees, funds_fees, sports_fees, admission_fees, security_fees, dayboarding_fees', 'required'),
			array('annual_fees, tuition_fees, funds_fees, sports_fees, activity_fees, admission_fees, security_fees, dayboarding_fees', 'numerical', 'integerOnly'=>true),
			array('class_no', 'length', 'max'=>11),
			array('valid_from, valid_to', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fees_id, class_no, annual_fees, tuition_fees, funds_fees, sports_fees, activity_fees, admission_fees, security_fees, dayboarding_fees, valid_from, valid_to', 'safe', 'on'=>'search'),
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
			'fees_id' => 'Fees',
			'class_no' => 'Class No',
			'annual_fees' => 'Annual Fees',
			'tuition_fees' => 'Tuition Fees',
			'funds_fees' => 'Funds Fees',
			'sports_fees' => 'Sports Fees',
			'activity_fees' => 'Activity Fees',
			'admission_fees' => 'Admission Fees',
			'security_fees' => 'Security Fees',
			'dayboarding_fees' => 'Dayboarding Fees',
			'valid_from' => 'Valid From',
			'valid_to' => 'Valid To',
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

		$criteria->compare('fees_id',$this->fees_id);
		$criteria->compare('class_no',$this->class_no,true);
		$criteria->compare('annual_fees',$this->annual_fees);
		$criteria->compare('tuition_fees',$this->tuition_fees);
		$criteria->compare('funds_fees',$this->funds_fees);
		$criteria->compare('sports_fees',$this->sports_fees);
		$criteria->compare('activity_fees',$this->activity_fees);
		$criteria->compare('admission_fees',$this->admission_fees);
		$criteria->compare('security_fees',$this->security_fees);
		$criteria->compare('dayboarding_fees',$this->dayboarding_fees);
		$criteria->compare('valid_from',$this->valid_from,true);
		$criteria->compare('valid_to',$this->valid_to,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FeesMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

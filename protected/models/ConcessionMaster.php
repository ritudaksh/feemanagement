<?php

/**
 * This is the model class for table "concession_master".
 *
 * The followings are the available columns in table 'concession_master':
 * @property integer $concession_id
 * @property string $concession_type
 * @property string $concession_persent
 * @property integer $concession_amount
 *
 * The followings are the available model relations:
 * @property StudentFees[] $studentFees
 * @property StudentMaster[] $studentMasters
 */
class ConcessionMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'concession_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('concession_type, concession_persent', 'required'),
			array('concession_amount', 'numerical', 'integerOnly'=>true),
			array('concession_type, concession_persent', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('concession_id, concession_type, concession_persent, concession_amount', 'safe', 'on'=>'search'),
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
			'studentFees' => array(self::HAS_MANY, 'StudentFees', 'concession_type_id'),
			'studentMasters' => array(self::HAS_MANY, 'StudentMaster', 'concession_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'concession_id' => 'Concession',
			'concession_type' => 'Concession Type',
			'concession_persent' => 'Concession Persent',
			'concession_amount' => 'Concession Amount',
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

		$criteria->compare('concession_id',$this->concession_id);
		$criteria->compare('concession_type',$this->concession_type,true);
		$criteria->compare('concession_persent',$this->concession_persent,true);
		$criteria->compare('concession_amount',$this->concession_amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConcessionMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "busfees_master".
 *
 * The followings are the available columns in table 'busfees_master':
 * @property integer $bus_id
 * @property integer $route
 * @property string $destination
 * @property integer $bus_fees
 *
 * The followings are the available model relations:
 * @property BusMaster $route0
 * @property StudentFees[] $studentFees
 * @property StudentMaster[] $studentMasters
 */
class BusfeesMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'busfees_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('route, bus_fees', 'numerical', 'integerOnly'=>true),
			array('destination', 'length', 'max'=>50),
			array('destination,route,bus_fees', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bus_id, route, destination, bus_fees', 'safe', 'on'=>'search'),
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
			'route0' => array(self::BELONGS_TO, 'BusMaster', 'route'),
			'studentFees' => array(self::HAS_MANY, 'StudentFees', 'bus_id'),
			'studentMasters' => array(self::HAS_MANY, 'StudentMaster', 'bus_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bus_id' => 'Bus',
			'route' => 'Route',
			'destination' => 'Destination',
			'bus_fees' => 'Bus Fees',
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

		$criteria->compare('bus_id',$this->bus_id);
		$criteria->compare('route',$this->route);
		$criteria->compare('destination',$this->destination,true);
		$criteria->compare('bus_fees',$this->bus_fees);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BusfeesMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

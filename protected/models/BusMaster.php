<?php

/**
 * This is the model class for table "bus_master".
 *
 * The followings are the available columns in table 'bus_master':
 * @property integer $busdetail_id
 * @property integer $bus_route
 * @property string $bus_driver
 * @property string $bus_conductor
 * @property string $bus_attendant
 * @property string $internal
 *
 * The followings are the available model relations:
 * @property BusfeesMaster[] $busfeesMasters
 */
class BusMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bus_master';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bus_route', 'numerical', 'integerOnly'=>true),
			array('bus_driver, bus_conductor, bus_attendant', 'length', 'max'=>50),
			array('internal', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('busdetail_id, bus_route, bus_driver, bus_conductor, bus_attendant, internal', 'safe', 'on'=>'search'),
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
			'busfeesMasters' => array(self::HAS_MANY, 'BusfeesMaster', 'route'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'busdetail_id' => 'Busdetail',
			'bus_route' => 'Bus Route',
			'bus_driver' => 'Bus Driver',
			'bus_conductor' => 'Bus Conductor',
			'bus_attendant' => 'Bus Attendant',
			'internal' => 'Internal',
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

		$criteria->compare('busdetail_id',$this->busdetail_id);
		$criteria->compare('bus_route',$this->bus_route);
		$criteria->compare('bus_driver',$this->bus_driver,true);
		$criteria->compare('bus_conductor',$this->bus_conductor,true);
		$criteria->compare('bus_attendant',$this->bus_attendant,true);
		$criteria->compare('internal',$this->internal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BusMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

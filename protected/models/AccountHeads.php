<?php

/**
 * This is the model class for table "account_heads".
 *
 * The followings are the available columns in table 'account_heads':
 * @property integer $account_id
 * @property integer $account_code
 * @property integer $parentaccount_id
 * @property string $account_name
 * @property string $account_desc
 */
class AccountHeads extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account_heads';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_code, parentaccount_id', 'numerical', 'integerOnly'=>true),
			array('account_name', 'length', 'max'=>100),
			array('account_desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('account_id, account_code, parentaccount_id, account_name, account_desc', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'account_code' => 'Account Code',
			'parentaccount_id' => 'Parentaccount',
			'account_name' => 'Account Name',
			'account_desc' => 'Account Desc',
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

		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account_code',$this->account_code);
		$criteria->compare('parentaccount_id',$this->parentaccount_id);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('account_desc',$this->account_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccountHeads the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

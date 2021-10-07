<?php

/**
 * This is the model class for table "expenses".
 *
 * The followings are the available columns in table 'expenses':
 * @property integer $expense_id
 * @property integer $account_id
 * @property string $expense_desc
 * @property string $expense_date
 * @property integer $amount
 * @property string $paid_to
 */
class Expenses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'expenses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, amount', 'numerical', 'integerOnly'=>true),
			array('paid_to', 'length', 'max'=>100),
			array('expense_desc, expense_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('expense_id, account_id, expense_desc, expense_date, amount, paid_to', 'safe', 'on'=>'search'),
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
			'expense_id' => 'Expense',
			'account_id' => 'Account',
			'expense_desc' => 'Expense Desc',
			'expense_date' => 'Expense Date',
			'amount' => 'Amount',
			'paid_to' => 'Paid To',
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

		$criteria->compare('expense_id',$this->expense_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('expense_desc',$this->expense_desc,true);
		$criteria->compare('expense_date',$this->expense_date,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('paid_to',$this->paid_to,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Expenses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

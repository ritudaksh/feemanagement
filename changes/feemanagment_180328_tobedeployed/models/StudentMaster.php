<?php

/**
 * This is the model class for table "student_master".
 *
 * The followings are the available columns in table 'student_master':
 * @property integer $student_id
 * @property integer $addmission_no
 * @property string $student_name
 * @property string $father_name
 * @property string $mother_name
 * @property string $birth_date
 * @property string $phone_no
 * @property string $mobile_no
 * @property string $email
 * @property string $address
 * @property string $city
 * @property integer $bus_id
 * @property string $gender
 * @property string $admission_date
 * @property integer $concession_id
 * @property string $status
 * @property string $passedout_date
 *
 * The followings are the available model relations:
 * @property StudentClasses[] $studentClasses
 * @property StudentFees[] $studentFees
 * @property ConcessionMaster $concession
 * @property BusfeesMaster $bus
 */
class StudentMaster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'student_master';
	}
//manually added for filter in grids
     public $class ;
	 public $section;
	 public $concessiontype;
     public $route;
	 public $destination;
	 public $category; //category added

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addmission_no, student_name,admission_date', 'required'),
			array('addmission_no', 'numerical', 'integerOnly'=>true),
			array('student_name, father_name, mother_name, phone_no, mobile_no, email, address, city, status', 'length', 'max'=>50),
			array('gender', 'length', 'max'=>10),
			array('category', 'length', 'max'=>7),
			array('birth_date, passedout_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('student_id, addmission_no, student_name, father_name, mother_name, birth_date, phone_no, mobile_no, email, address, city, bus_id, gender, admission_date, concession_id, status, passedout_date', 'safe', 'on'=>'search'),
			//manually add relation attribute to  model, where search string will be stored. 
			array( 'class,section,concessiontype', 'safe', 'on'=>'search' ),
			array( 'route,destination', 'safe', 'on'=>'search' ),
			array( 'category', 'safe', 'on'=>'search' ),
			/* category has been added */
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
/*			'studentClasses' => array(self::HAS_ONE, 'StudentClasses', 'student_id', 
								'having'=>'max(studentClasses.student_class_id)',
								'group' =>'studentClasses.student_id',
								), //this one originally had HAS_MANY but with the max check, only 1 record
*/
			'studentClasses' => array(self::HAS_ONE, 'StudentClasses','student_id', 
			                    
								//'having'=>'max(student_class_id)',
								'having'=>'MAX(CONVERT(class_no, SIGNED))',
								'order'=>'studentClasses.student_class_id DESC', 
								'group' =>'studentClasses.student_class_id',
	                            //'condition'=>'studentClasses.ended_on IS NULL or studentClasses.ended_on="0000-00-00"'
								),

			'studentFees' => array(self::HAS_MANY, 'StudentFees', 'student_id'),
			'concession' => array(self::BELONGS_TO, 'ConcessionMaster', 'concession_id'),
			'bus' => array(self::BELONGS_TO, 'BusfeesMaster', 'bus_id'),
 		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'student_id' => 'Student',
			'addmission_no' => 'Addmission No',
			'student_name' => 'Student Name',
			'father_name' => 'Father Name',
			'mother_name' => 'Mother Name',
			'birth_date' => 'Birth Date',
			'phone_no' => 'Phone No',
			'mobile_no' => 'Mobile No',
			'email' => 'Email',
			'address' => 'Address',
			'city' => 'City',
			'bus_id' => 'Bus',
			'gender' => 'Gender',
			'admission_date' => 'Admission Date',
//			'concession_id' => 'Concession',
			'status' => 'Status',
			'passedout_date' => 'Passedout Date',
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
		//add the related attributes
		$criteria->with = array( 'studentClasses','concession','bus');

		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('addmission_no',$this->addmission_no);
		$criteria->compare('student_name',$this->student_name,true);
		$criteria->compare('father_name',$this->father_name,true);
		$criteria->compare('mother_name',$this->mother_name,true);
		$criteria->compare('birth_date',$this->birth_date,true);
		$criteria->compare('phone_no',$this->phone_no,true);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('bus_id',$this->bus_id);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('admission_date',$this->admission_date,true);
		$criteria->compare('category',$this->category,true);
//		$criteria->compare('concession_id',$this->concession_id);
//		above commented and below 3 manully added
        $criteria->compare('concession.concession_type', $this->concessiontype, true); //for relational field
        $criteria->compare('studentClasses.class_no', $this->class,true);
        $criteria->compare('studentClasses.section', $this->section,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('passedout_date',$this->passedout_date,true);
		$criteria->compare('bus.route', $this->route, true); //for relational field
		$criteria->compare('bus.destination', $this->destination, true); //for relational field

		return new CActiveDataProvider($this, array(
	      'pagination'=>array(
                       'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
                ),
			'sort'=>array(
				'attributes'=>array(
					'concession.concession_type'=>array(
						'asc'=>'concession.concession_type',
						'desc'=>'concession.concession_type DESC',
					),
					
					'bus.route'=>array(
						'asc'=>'bus.route',
						'desc'=>'bus.route DESC',
					),
					'bus.destination'=>array(
						'asc'=>'bus.destination',
						'desc'=>'bus.destination DESC',
					),
					
					'studentClasses.class_no'=>array(
						'asc'=>'studentClasses.class_no',
						'desc'=>'studentClasses.class_no DESC',
					),
					'studentClasses.section'=>array(
						'asc'=>'studentClasses.section',
						'desc'=>'studentClasses.section DESC',
					),
					'*',
				),
				'defaultOrder'=>'addmission_no ASC',
            ),
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StudentMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

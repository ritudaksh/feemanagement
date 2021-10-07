<?php

/**
 * This is the model class for table "student_master".
 *
 * The followings are the available columns in table 'student_master':
 * @property integer $student_id
 * @property integer $addmission_no
 * @property integer $class
 * @property string $student_name
 * @property string $father_name
 * @property string $mother_name
 * @property string $birth_date
 * @property integer $phone_no
 * @property integer $mobile_no
 * @property string $address
 * @property string $city
 * @property string $bus_destination
 * @property string $gender
 * @property string $admission_date
 * @property string $student_concessiontype
 *
 * The followings are the available model relations:
 * @property StudentClasses $studentClasses
 * @property StudentFees $studentFees
 * @property StudentFees[] $studentFees1
 */
class StudentMaster extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StudentMaster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'student_master';
	}
     public $class ;
	 public $section;
	
	 
	 
	 
	 
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('addmission_no,student_name,father_name, gender, admission_date,status', 'required'),
			array('student_name,father_name, mother_name', 'match' ,'pattern'=>'/^[A-Za-z_]/u', 'message'=>'Field can contain only alphanumeric characters.'),
		array('student_name,father_name, mother_name', 'length', 'max'=>20, 'min' => 3,'message' => 'Incorrect username length between 3 and 20 characters.'),
			array('addmission_no,phone_no mobile_no',  'numerical', 'integerOnly'=>true),
array('addmission_no','unique'),
			//array('phone_no, mobile_no', 'length', 'max'=>10, 'min' => 6),
			
			
			
			
			array('student_name, father_name, mother_name, address, city,bus_no, bus_destination,email, student_concessiontype', 'length', 'max'=>25),
			array('gender', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('student_id, route,addmission_no, class,section,student_name, father_name, mother_name, birth_date, phone_no, mobile_no,email, address, city, bus_destination, gender, admission_date, student_concessiontype,status,passedout_date', 'safe', 'on'=>'search'),
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
			'studentClasses' => array(self::HAS_ONE, 'StudentClasses', 'student_class_id'),
                        
			'studentFees' => array(self::HAS_ONE, 'StudentFees', 'student_fee_id'),
			'studentFees1' => array(self::HAS_MANY, 'StudentFees', 'student_id'),
            
 
			'studentMaster' => array(self::HAS_ONE, 'StudentClasses', 'student_id'),
		    

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'student_id' => 'Student',
			'addmission_no' => 'Admission No',
			//'class' => 'Class',
            //'section'=>'Section',
			'student_name' => 'Student Name',
			'father_name' => 'Father Name',
			'mother_name' => 'Mother Name',
			'birth_date' => 'Birth Date',
			'phone_no' => 'Phone No',
			'mobile_no' => 'Mobile No',
			'email'=>'Email Id',
			'address' => 'Address',
			'city' => 'City',
			'route'=>'Route',
			'bus_no'=>'Bus No',
			'bus_destination' => 'Bus Destination',
			'gender' => 'Gender',
			'admission_date' => 'Admission Date',
			'student_concessiontype' => 'Student ConcessionType',
			'status'=>'Status',
			'passedout_date'=>'Passed out date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('studentMaster');
		
		$criteria->compare('studentMaster.student_id',$this->student_id);
		$criteria->compare('addmission_no',$this->addmission_no);
		$criteria->compare('student_name',$this->student_name,true);
		$criteria->compare('father_name',$this->father_name,true);
		$criteria->compare('mother_name',$this->mother_name,true);
		$criteria->compare('birth_date',$this->birth_date,true);
		$criteria->compare('phone_no',$this->phone_no);
		$criteria->compare('mobile_no',$this->mobile_no);
		$criteria->compare('email',$this->email);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('route',$this->route,true);
		$criteria->compare('bus_no',$this->bus_no,true);
		$criteria->compare('bus_destination',$this->bus_destination,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('admission_date',$this->admission_date,true);
		$criteria->compare('student_concessiontype',$this->student_concessiontype,true);
        $criteria->compare('studentMaster.class_no', $this->class,true);
        $criteria->compare('studentMaster.section', $this->section,true);
		$criteria->compare('status',$this->status,true);
	
		
		

		
		
		
		return new CActiveDataProvider($this, array(
		      'pagination'=>array(
                        'pageSize'=>20,
                ),
		'sort'=>array(
                      'defaultOrder'=>'addmission_no ASC',
                              ),
		
			'criteria'=>$criteria,
		));
	}
}

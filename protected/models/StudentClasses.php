<?php

/**
 * This is the model class for table "student_classes".
 *
 * The followings are the available columns in table 'student_classes':
 * @property integer $student_class_id
 * @property integer $student_id
 * @property string $class_no
 * @property string $section
 * @property string $started_on
 * @property string $ended_on
 *
 * The followings are the available model relations:
 * @property StudentMaster $student
 */
class StudentClasses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	 public $name;
	 public $admno;
	
	public function tableName()
	{
		return 'student_classes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, section', 'required'),
			array('student_id', 'numerical', 'integerOnly'=>true),
			array('class_no, section', 'length', 'max'=>50),
			array('started_on, ended_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('student_class_id, student_id,name,admno,class_no, section, started_on, ended_on', 'safe', 'on'=>'search'),
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
			'student' => array(self::BELONGS_TO, 'StudentMaster', 'student_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'student_class_id' => 'Student Class',
			'student_id' => 'Student',
			'class_no' => 'Class No',
			'section' => 'Section',
			'started_on' => 'Started On',
			'ended_on' => 'Ended On',
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
		$criteria->compare('student_class_id',$this->student_class_id);
		$criteria->compare('student.student_id',$this->student_id);
		$criteria->compare('class_no',$this->class_no,true);
		$criteria->compare('section',$this->section,true);
		$criteria->compare('started_on',$this->started_on,true);
		$criteria->compare('ended_on',$this->ended_on,true);
		$criteria->compare('student.student_name', $this->name,true);
		$criteria->compare('student.addmission_no', $this->admno,true);
		
		return new CActiveDataProvider($this, array(
		
		
		      'pagination'=>array(
                        
						'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),

                ),
				'sort'=>array(
                      
					  'attributes'=>array('class_no','started_on','ended_on','section',
					 'student.student_name'=>array(
						'asc'=>'student.student_name',
						'desc'=>'student.student_name DESC',
					),
					
						 'student.addmission_no'=>array(
						'asc'=>'student.addmission_no',
						'desc'=>'student.addmission_no DESC',
					),
					
					),  
					  'defaultOrder'=>'student.addmission_no ASC',
					  
					  
					  
                              ),
				
				
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StudentClasses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

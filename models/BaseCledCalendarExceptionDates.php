<?php

/**
 * This is the model base class for the table "cled_calendar_exception_dates".
 *
 * Columns in table "cled_calendar_exception_dates" available as properties of the model:
 * @property integer $cled_id
 * @property string $cled_date
 * @property string $cled_type
 * @property string $cled_notes
 *
 * There are no model relations.
 */
abstract class BaseCledCalendarExceptionDates extends CActiveRecord
{
    /**
    * ENUM field values
    */
    const CLED_TYPE_WORKING_DAY = 'Working Day';
    const CLED_TYPE_HOLLIDAY = 'Holliday';
    const CLED_TYPE_PUBLIC_HOLLIDAY = 'Public Holliday';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'cled_calendar_exception_dates';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), array(
                array('cled_date, cled_type', 'required'),
                array('cled_notes', 'default', 'setOnEmpty' => true, 'value' => null),
                array('cled_type', 'length', 'max' => 15),
                array('cled_notes', 'safe'),
                array('cled_id, cled_date, cled_type, cled_notes', 'safe', 'on' => 'search'),
            )
        );
    }

    public function getItemLabel()
    {
        return (string) $this->cled_date;
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(), array(
                'savedRelated' => array(
                    'class' => '\GtcSaveRelationsBehavior'
                )
            )
        );
    }

    public function relations()
    {
        return array_merge(
            parent::relations(), array(
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'cled_id' => Yii::t('D2calendarModule.model', 'Cled'),
            'cled_date' => Yii::t('D2calendarModule.model', 'Cled Date'),
            'cled_type' => Yii::t('D2calendarModule.model', 'Cled Type'),
            'cled_notes' => Yii::t('D2calendarModule.model', 'Cled Notes'),
        );
    }

    public function enumLabels()
    {
        return array(
           'cled_type' => array(
               self::CLED_TYPE_WORKING_DAY => Yii::t('D2calendarModule.model', 'CLED_TYPE_WORKING_DAY'),
               self::CLED_TYPE_HOLLIDAY => Yii::t('D2calendarModule.model', 'CLED_TYPE_HOLLIDAY'),
               self::CLED_TYPE_PUBLIC_HOLLIDAY => Yii::t('D2calendarModule.model', 'CLED_TYPE_PUBLIC_HOLLIDAY'),
           ),
            );
    }

    public function getEnumFieldLabels($column){

        $aLabels = $this->enumLabels();
        return $aLabels[$column];
    }

    public function getEnumLabel($column,$value){

        $aLabels = $this->enumLabels();

        if(!isset($aLabels[$column])){
            return $value;
        }

        if(!isset($aLabels[$column][$value])){
            return $value;
        }

        return $aLabels[$column][$value];
    }


    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }

        $criteria->compare('t.cled_id', $this->cled_id);
        $criteria->compare('t.cled_date', $this->cled_date, true);
        $criteria->compare('t.cled_type', $this->cled_type, true);
        $criteria->compare('t.cled_notes', $this->cled_notes, true);


        return $criteria;

    }

}

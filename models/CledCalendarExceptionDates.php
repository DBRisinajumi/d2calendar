<?php

// auto-loading
Yii::setPathOfAlias('CledCalendarExceptionDates', dirname(__FILE__));
Yii::import('CledCalendarExceptionDates.*');

class CledCalendarExceptionDates extends BaseCledCalendarExceptionDates
{

    /**
     * for date range filter
     * @var type 
     */
    var $cled_date_range;
    
    // Add your model-specific methods here. This file will not be overriden by gtc except you force it.
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        return parent::init();
    }

    public function getItemLabel()
    {
        return parent::getItemLabel();
    }

    public function behaviors() {
        return array_merge(
                parent::behaviors(), array(
             //auditrail       
            'LoggableBehavior' => array(
                'class' => 'LoggableBehavior'
            ),
        ));
    }

    public function rules()
    {
        return array_merge(
                parent::rules()
                , array(
            array('cled_id, cled_date, cled_type, cled_notes, cled_date_range', 'safe', 'on' => 'search'),
                )
        );
    }
    
    public function searchCriteria($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;            
        }
        
        /**
         * filter date to from
         */
        if(!empty($this->cled_date_range)){
            
            $date_time = DateTime::createFromFormat('d.m.Y', substr($this->cled_date_range,0,10));
            $date_from = $date_time->format('Y-m-d');

            $date_time = DateTime::createFromFormat('d.m.Y',substr($this->cled_date_range,-10));
            $date_to = $date_time->format('Y-m-d');
            
            $criteria->AddCondition("cled_date >= '".$date_from."'");
            $criteria->AddCondition("cled_date <= '".$date_to."'");
        }
                     
        return  parent::searchCriteria($criteria);
    }       

    public function search($criteria = null)
    {
        if (is_null($criteria)) {
            $criteria = new CDbCriteria;
        }
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $this->searchCriteria($criteria),
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort'=>array(
              'defaultOrder'=>'cled_date',
            )
            
        ));
    }

    /**
     * izskaitļo nākamo neģenerēto gadu
     * @return type
     */
    public static function getNextYear(){
        $sql = "
            SELECT 
              CASE
                WHEN MAX(YEAR(cled_date)) IS NULL 
                THEN YEAR(NOW()) 
                ELSE MAX(YEAR(cled_date)) + 1 
              END 
            FROM
              cled_calendar_exception_dates 
        ";
        return Yii::app()->db->createCommand($sql)->queryScalar();
    }
    
    /**
     * aizpilda kalendāru ar brīvdienām un darbadienām
     * @param year $year 
     * @return boolean
     */
    public function fillYear($year){

        $sql = "set @year = :year";
        $rawData = Yii::app()->db->createCommand($sql);
        $rawData->bindParam(":year", $year, PDO::PARAM_INT);                
        $rawData->query();        
        
        //validate, if year filled
        $sql = "select count(0) from cled_calendar_exception_dates where year(cled_date) = @year";
        $rawData = Yii::app()->db->createCommand($sql);
        $count = $rawData->queryScalar();
        if ($count > 0) {
            return TRUE;
        }
        
        //fill year
        $sql = "set @date := concat(@year,'-01-01')";
        while (true) {
            Yii::app()->db->createCommand($sql)->query();
            $sql = "INSERT INTO cled_calendar_exception_dates "
                    . "(cled_date,cled_type) "
                    . "select "
                    . "@date,"
                    . "case DAYOFWEEK(@date)
                        when 7 then '" . CledCalendarExceptionDates::CLED_TYPE_HOLLIDAY . "'  
                        when 1 then '" . CledCalendarExceptionDates::CLED_TYPE_HOLLIDAY . "'  
                    else '" . CledCalendarExceptionDates::CLED_TYPE_WORKING_DAY . "'
                  end";
            Yii::app()->db->createCommand($sql)->query();
            $sql = "set @date :=  DATE_ADD(@date, INTERVAL 1 DAY)";
            Yii::app()->db->createCommand($sql)->query();
            $sql = "select year(@date)";
            $y = Yii::app()->db->createCommand($sql)->queryScalar();
            if ($y != $year) {
                return TRUE;
            }
        }
    }

    /**
     * @param string $month format YYYY-MM
     * @return array|mixed|null|static[]
     */
    public function findhMonth($month)
    {
        
        $sql = "set @month = :month";
        $rawData = Yii::app()->db->createCommand($sql);
        $rawData->bindParam(":month", $month, PDO::PARAM_STR);                
        $rawData->query();  
        
        $criteria = new CDbCriteria;
        
        //filtrēšana pēc mēneša
        $criteria->AddCondition("cled_date >= ADDDATE(concat(@month,'-01'),-1) 
                AND cled_date <= ADDDATE(concat(@month,'-01'), INTERVAL  1 MONTH )");
        $criteria->order = 'cled_date';
        
        return self::model()->findAll($criteria);
        
    }       
    
}

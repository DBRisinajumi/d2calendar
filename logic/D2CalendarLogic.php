<?php

class D2CalendarLogic
{

    /**
     * @var string format YYYY-MM
     */
    private $month;

    /** @var  CledCalendarExceptionDates[] */
    private $days;

    /**
     * @var string|bool format YYYY-MM
     */
    private $actualDay;

    /**
     * D2CalendarLogic constructor.
     * @param string $month format YYYY-MM
     */
    public function __construct($month)
    {
        $this->month = $month;
        $calendar = new CledCalendarExceptionDates();
        /** @var CledCalendarExceptionDates $calendarDay */
        foreach($calendar->findhMonth($month) as $calendarDay){
            if(!$this->actualDay){
                $this->actualDay = $calendarDay->cled_date;
            }
            $this->days[$calendarDay->cled_date] = $calendarDay;
        }

    }

    /**
     * @return string|bool
     */
    public function getActualDay()
    {
        return $this->actualDay;
    }

    /**
     * @return string|bool
     */
    public function getNextDay()
    {
        $isActualDay = false;
        foreach($this->days as $day => $dayModel){

            if($isActualDay){
                return $this->actualDay = $day;
            }
            $isActualDay = $day === $this->actualDay;
        }

        return $this->actualDay = false;
    }


    /**
     * @param string $date yyyy-mm-dd
     * @return bool
     */
    public function isWorkingDay($date = false)
    {
        if(!$date){
            $date = $this->actualDay;
        }
        return CledCalendarExceptionDates::CLED_TYPE_WORKING_DAY === $this->days[$date]->cled_type;
    }

    /**
     * @param string $date format yyyy-mm-dd
     * @return bool
     */
    public function isHoliday($date = false)
    {
        if(!$date){
            $date = $this->actualDay;
        }
        return CledCalendarExceptionDates::CLED_TYPE_HOLLIDAY === $this->days[$date]->cled_type;
    }

    /**
     * @param string $date format yyyy-mm-dd
     * @return bool
     */
    public function isPublicHolliday($date = false)
    {
        if(!$date){
            $date = $this->actualDay;
        }
        return CledCalendarExceptionDates::CLED_TYPE_PUBLIC_HOLLIDAY === $this->days[$date]->cled_type;
    }


}
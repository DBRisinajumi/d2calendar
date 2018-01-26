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
     * @var DateTime|bool
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
            $dayDate = DateTime::createFromFormat('Y-m-d H:i:s', $calendarDay->cled_date .  ' 00:00:00');
            if(!$this->actualDay){
                $this->actualDay = $dayDate;
            }
            $this->days[$calendarDay->cled_date] = $calendarDay;
        }

    }

    /**
     * @return DateTime|bool
     */
    public function getActualDay()
    {
        return $this->actualDay;
    }

    /**
     * @return DateTime|bool
     */
    public function getNextDay()
    {
        if(!$this->actualDay){
            return false;
        }
        $isActualDay = false;
        foreach($this->days as $dayYMD => $dayModel){
            $day = DateTime::createFromFormat('Y-m-d H:i:s', $dayYMD .  ' 00:00:00');
            if($isActualDay){
                return $this->actualDay = $day;
            }
            $isActualDay = $day->format('Ymd') === $this->actualDay->format('Ymd');
        }

        return $this->actualDay = false;
    }


    /**
     * @param DateTime|false $date
     * @return bool
     */
    public function isWorkingDay($date = false)
    {
        return CledCalendarExceptionDates::CLED_TYPE_WORKING_DAY === $this->getType($date);
    }

    /**
     * @param DateTime|false $date
     * @return bool
     */
    public function isHoliday($date = false)
    {
        return CledCalendarExceptionDates::CLED_TYPE_HOLLIDAY === $this->getType($date);
    }

    /**
     * @param DateTime|false $date
     * @return bool
     */
    public function isPublicHoliday($date = false)
    {
        return CledCalendarExceptionDates::CLED_TYPE_PUBLIC_HOLLIDAY === $this->getType($date);
    }

    /**
     * @param bool|DateTime $date
     * @return string
     *
     */
    public function getType($date = false)
    {
        if(!$date){
            $date = $this->getActualDay();
        }
        $dateYmd = $date->format('Y-m-d');
        return $this->days[$dateYmd]->cled_type;
    }


}
<?php

/**
 * Description of dispatcher
 *
 * @author Naveed
 */
class Dispatch extends Eloquent {

    protected $guarded = array();
    private static $_limit = 5;
    private $_dispatchesTableName = 'dispatches';
    private $_eventsTableName = 'events';
    private $_dispatchId = 0;

    /*
     * @params $dpInfo
     * return dispatch ID
     * 
     * Function accepts an array and returns dispatcher id.
     * 
     */

    public function insertDispatchInfo($dpInfo) {
        $_dispatchId = DB::table($this->_dispatchesTableName)->insertGetId($dpInfo);
        return $_dispatchId;
    }

    /*
     * @params $eventData
     * return query status
     * 
     * Functions accepts an array with all event related information.
     * 
     */

    public function insertEvents($eventData = array()) {
        return DB::table($this->_eventsTableName)->insert($eventData);
    }

    /*
     * 
     * @param $date
     * @param $day
     * @param $month
     * return requested data with pagination
     * 
     * Function accepts date, day and month info
     * checks if these variables are empty or not and set the condition appropriately
     * In where clause I used WHERERAW function of query builder API. Reason to
     * choose this was, first check the status of DATE, DAY or MONTH and then
     * apply the WHERE condition appropriately. Applying such filters was not
     * possible QUERY BUILDER WHERE function. In that case was I needed to write
     * same query multiple times for different conditions.
     * 
     * Now we can add more conditons (after filtering them out) with WHERERAW
     * function without need to write same query again and again for each condition.
     * 
     */

    public function getDispatches($date, $day, $month) {
         $condition = '';
        
        if (!empty($day)) $condition .= "{$this->_eventsTableName}.day = '{$day}' AND ";

        if (!empty($date)) $condition .= "{$this->_eventsTableName}.date = {$date} AND ";

        if (!empty($month)) $condition .= "{$this->_eventsTableName}.month = '{$month}' AND ";

        $condition = trim ($condition, " AND");

        $output = DB::table($this->_eventsTableName)
            ->select("{$this->_eventsTableName}.*", "{$this->_dispatchesTableName}.time", "{$this->_dispatchesTableName}.repeat")
            ->join($this->_dispatchesTableName, "{$this->_eventsTableName}.dispatch_id", '=', "{$this->_dispatchesTableName}.id")
            ->whereRaw($condition)
            ->paginate(self::$_limit);
            
        return $output;
    }

}

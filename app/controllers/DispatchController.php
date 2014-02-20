<?php

class DispatchController extends BaseController {

    public $layout = "layouts.index";
    private $dpi = NULL;

    public function __construct() {
        $this->dpi = new Dispatch;
    }

    public function index() {
        $this->layout->content = View::make('dispatcher.setevent')
            ->with('title', 'Set Events');
    }
    
    /*
     * This function fetch the result based on requested info
     * It pass the info to model function and gets the requested data back
     * And pass that data to view for display
     */

    public function fetchResult() {
        $date = Input::get('date');
        $day = Input::get('weekday');
        $month = Input::get('month');

        if (empty($date) && empty($day) && empty($month))
            return Redirect::to('/findDispatchers')
                            ->withErrors('Please select some value');

        if (!empty($date) && !empty($day)) {
            return Redirect::to('/findDispatchers')
                            ->withErrors('Please select weekday or date');
        } else {
            $dispatchers = $this->dpi->getDispatches($date, $day, $month);

            $this->layout->content = View::make(
                'dispatcher.result', array(
                    'dispatchers' => $dispatchers,
                    'date' => $date,
                    'day' => $day,
                    'month' => $month
                )
            )
            ->with('title', 'Fetch Dispatchers');
        }
    }

    /*
     * This function generates the view for finding Dispatchers
     */

    public function findDispatchers() {
        $dayDateTime = $this->calculateDayDateTime();
        $this->layout->content =
                View::make('dispatcher.find', array(
                    'weekdays' => $dayDateTime['weekdays'],
                    'currentMonthDates' => $dayDateTime['dates'],
                    'months' => $dayDateTime['month'],
                        )
                )->with('title', 'Find Dispatchers');
    }
    
    /*
     * This function insert only single event info
     * It separates the date and time and than pass this info to model function
     */
    
    public function storeSingleDispatcher() {
        $rules = array('date' => 'required');
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
            return Redirect::to('/')->withErrors($validator);
        else {
            $dateTime = explode(' ', Input::get('date'));
            $date = $dateTime[0];

            $eventDate = explode('-', $date);

            $dpLastId = $this->dpi
                    ->insertDispatchInfo(array('time' => $dateTime[1]));
            $eventData = array(
                'dispatch_id' => $dpLastId,
                'date' => $eventDate[2],
                'month' => $eventDate[1],
                'year' => $eventDate[0],
            );

            $response = $this->dpi->insertEvents($eventData);
            if (!$response)
                return Redirect::to('/')->withErrors("Unable to set dispatcher information!");
            else {
                Session::flash('message', 'Successfully created a dispatch!');
                return Redirect::to('/');
            }
        }
    }
    
    /*
     * This function generates the view for Recurring Dispatchers
     */
    
    public function recurringDispatcher() {
        $dayDateTime = $this->calculateDayDateTime();
        $this->layout->content = 
                View::make('dispatcher.recurring',
                    array(
                        'weekdays' => $dayDateTime['weekdays'],
                        'currentMonthDates' => $dayDateTime['dates'],
                        'time' => $dayDateTime['time']
                    )
                )->with('title', 'Set Recurring Event');
    }
    
    
    /*
     * 
     * This function store the recurring dispatchers infomartion
     * It first check which information user wants to store
     * e.g. Date, week day or month
     * Once it determins that, it take outs the key and size of each date, day or month array.
     * Then it loop through each array and store the information into table.
     * 
     */
    
    public function storeRecurringDispatcher() {
        if (Input::server("REQUEST_METHOD") == "POST") {
            $rules = array(
                'weekdays' => 'required_without:dates',
                'dates' => 'required_without:weekdays',
                'months' => 'required',
                'time' => 'required',
                'repeat' => 'required',
            );
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails())
                return Redirect::to('/recurringDispatcher')->withErrors($validator);
            
            $dates = Input::get('dates');
            $days = Input::get('weekdays');
            $months = Input::get('months');

            if (!empty($dates) && !empty($days))
                return Redirect::to('/recurringDispatcher')
                    ->withErrors('You can not select date(s) and day(s) togather!');

            $combineArray = array('date' => $dates,'day' => $days,'month' => $months);

            $getArraySize = array(
                'date' => count($dates),
                'day' => count($days),
                'month' => count($months)
            );
            asort($getArraySize);
            
            $delZeroValue = min($getArraySize);
            $key = array_search($delZeroValue, $getArraySize);
            unset($getArraySize[$key]);
            
            $getMaxValue = max($getArraySize);
            $getMinValue = min($getArraySize);
            
            if($getMaxValue == $getMinValue) {
                $getKeys = array_keys($getArraySize);
                $getMinValueKey = $getKeys[0];
                $getMaxValueKey = $getKeys[1];
            } else {
                $getMaxValueKey = array_search($getMaxValue, $getArraySize);
                $getMinValueKey = array_search($getMinValue, $getArraySize);
            }

            $dpLastId = $this->dpi->insertDispatchInfo(
                array('time' => Input::get('time'), 'repeat' => Input::get('repeat'))
            );

            $rows = array();
            for ($i = 0; $i < $getMaxValue; $i++) {
                for ($a = 0; $a < $getMinValue; $a++) {
                    $row['dispatch_id'] = $dpLastId;
                    $row[$getMaxValueKey] = $combineArray[$getMaxValueKey][$i];
                    $row[$getMinValueKey] = $combineArray[$getMinValueKey][$a];
                    $row['year'] = date("Y");
                    array_push($rows, $row);
                }
            }

            $response = $this->dpi->insertEvents($rows);
            unset($rows, $dates, $days, $months);

            if (!$response)
                return Redirect::to('/recurringDispatcher')->withErrors("Unable to set dispatch information!");
            else {
                Session::flash('message', 'Successfully created a dispatch!');
                return Redirect::to('/recurringDispatcher');
            }
        }
    }

    /*
     * returns @array
     *
     * Code inside this function can be place directly in any function 
     * but for maintainability I placed it in a separate function.
     * 
     */
    private function calculateDayDateTime() {
        $dayDateTime = array();

        /* Get current month dates */
        for ($i = 1; $i <= date('t'); $i++)
            $currentMonthDates[$i] = $i;
        

        /* Set weekday */
        $weekDays = array(
            'Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday'
        );
        

        /* calculate Time */
        for ($t = 15; $t <= 1440; $t += 15) {
            $tmp = sprintf("%02d:%02d", $t / 60 % 24, $t % 60);
            $time[$tmp] = $tmp;
            asort($time);
        }
        
        /* 
         * Get number of months.
         * Although laravel provide its own function of Month as a dropdown list
         * But it is not possible to have default value in the drop down  
         */
        
        for ($m = 1; $m <= 12; $m++) {
            $month[$m] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        }
        
        $dayDateTime = array(
            'dates' => $currentMonthDates,
            'weekdays' => $weekDays,
            'time' => $time,
            'month' => $month
        );

        return $dayDateTime;
    }

}
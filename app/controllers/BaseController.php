<?php

class BaseController extends Controller {

    protected $layout = 'layouts/master';

    /**
    * set grille id, which has been bound from the routes
    */
    public $grille_id;
    public function __construct () {
        $this->grille_id = App::make('grille_id');
    }

    /**
     * GET /
     */
    public function getIndex()
    {
        $errors = Session::get('message');

        //get hours
        //for now just hardcode that Eliot grille
        $grille_id = 1;
        $hours = Hour::where('grille_id', $grille_id)->get();

        //find days that close the following day
        $hours2 = clone $hours;

        foreach ($hours as $hour)
        {
            if ($hour->close_time == "23:59:59")
            {
                foreach($hours2 as $hour2)
                {
                    //if day is saturday, check sunday
                    if ($hour->day_of_week==6)
                    {
                        if ($hour2->day_of_week==0 && $hour2->open_time == "00:00:00")
                        {
                            $hour->close_time = $hour2->close_time;
                        }
                    }
                    else
                    {
                        if ($hour2->day_of_week==$hour->day_of_week + 1 &&
                                    $hour2->open_time == "00:00:00")
                        {
                            $hour->close_time = $hour2->close_time;
                        }
                    }

                }
            }

        }

        //remove the duplicate day objects, and reformat values
        foreach ($hours as $key => $hour)
        {
            if ($hour->open_time == "00:00:00")
            {
                unset($hours[$key]);
            }
            else
            {
                $hour->open_time = date('h:i a', strtotime($hour->open_time));
                $hour->close_time = date('h:i a', strtotime($hour->close_time));

                //map day names to numbers
                switch ($hour->day_of_week)
                {
                    case 0:
                        $hour->day_of_week = "Sunday";
                        break;
                    case 1:
                        $hour->day_of_week = "Monday";
                        break;
                    case 2:
                        $hour->day_of_week = "Tuesday";
                        break;
                    case 3:
                        $hour->day_of_week = "Wednesday";
                        break;
                    case 4:
                        $hour->day_of_week = "Thursday";
                        break;
                    case 5:
                        $hour->day_of_week = "Friday";
                        break;
                    case 6:
                        $hour->day_of_week = "Saturday";
                        break;
                    default:
                         $hour->day_of_week = $hour->day_of_week;
                }
            }
        }

        //check to see if open now
        date_default_timezone_set('America/New_York');
        $current_time = date('H:i:s', time());
        $weekday = date('w', time());

        //attempt to pull from database

        $open_now = Grille::find($grille_id)->open_now;


        $this->layout->content = View::make('index',
            ['hours' => $hours, 'open' => $open_now, 'err_messages' => $errors]);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

}

?>

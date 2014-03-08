<?php

class BaseController extends Controller {

    protected $layout = 'layouts/master';

    /**
     * GET /
     */
    public function getIndex()
    {
        $errors = Session::get('message');

        $this->layout->content = View::make('index',
            ['err_messages' => $errors]);
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

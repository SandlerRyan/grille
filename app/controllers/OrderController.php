<?php

class OrderController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $courses = Order::get();
        $this->layout->content = View::make('orders.index', ['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // TODO: Create a structured JSON of all menue items
        // Example: 
        {"name": "burger1",
        "description"
        "price"
        "category": "drinks"

            {"burger1": 50, "burger2": 5}, "drinks": [{JSON ITEMS1, JSON ITEMS2}]

        }
        [{BURGERS}, {CHEESE}, {DRINKS}, {FRIES}]


        $this->layout->content = View::make('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        
        return Redirect::to('courses/' . $course->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        $faculty = Faculty::find($course->faculty);
        $field = Field::find($course->field);
        $this->layout->content = View::make('courses.show', 
            ['course' => $course, 
            'faculty' => $faculty,
            'field' => $field]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->layout->content = View::make('courses/edit', ["course" => $course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        return Redirect::to('courses/' . $course->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return Redirect::to('courses/');
    }

}
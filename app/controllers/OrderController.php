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
        //fetch all available menu items
        $grilled_cheese = Item::select('id','name','price','description','available')->where('category_id','1')->get();
        $burgers = Item::select('id','name','price','description','available')->where('category_id','2')->get();
        $fries = Item::select('id','name','price','description','available')->where('category_id','4')->get();
        $drinks = Item::select('id','name','price','description','available')->where('category_id','5')->get();
        
        //store as a dictionary
        $menu = ['Grilled Cheese'=> $grilled_cheese, 'Burgers'=> $burgers, 'Fries and Friends'=>$fries, 'Drinks and Desserts'=> $drinks];
        $this->layout->content = View::make('orders.create', ['menu' => $menu]);

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

    //Check Request form from the order page. 
    public function checkout()
    {   

        // TODO: Check if user exists. If not, redirect to Checkout Page. 
        //If it exists, redirect to HUID, and then to Checkout Page

        //Form Data
        $form = Input::all();
        



        $this->layout->content = View::make('checkout.index', ['form' => $form]);

    }

       
}

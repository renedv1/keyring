<?php

class HomeController extends BaseController {
    
    protected $layout = 'layout.master';

   /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function showIndex() {
        $this->layout->content = View::make('home.index');
    }

}

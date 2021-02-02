<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcessorController extends Controller
{
    //
    public function store(Request $request) {

        $this->validate($request, [
            'email' => 'required|email'
        ]);
        
        return redirect()->back()->withInput($request->only('_name'))->with('success', 'You submitted a valid email. Good job!');
    }
}

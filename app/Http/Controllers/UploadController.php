<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(){

        return view('index');
    }

    public function store(Request $request){
        $file_name = $request->file('file')->getClientOriginalName();
        dd($request->file('file'));
        $request->file('file')->storeAs('','upload_file.pdf');

    }
}

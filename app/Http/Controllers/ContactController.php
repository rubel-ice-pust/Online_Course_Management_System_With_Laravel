<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactModel;


class ContactController extends Controller
{
      function ContactIndex(){


    	return view('Contact');
    }


     function getContactData(){

    $result=json_encode(ContactModel::orderBy('id','desc')->get());

    return $result;

    }

     function getContactDetails(Request $req){
     $id= $req->input('id');
     $result= json_encode(ContactModel::where('id','=',$id)->get()) ;

     return $result;
}



 function ContactDelete(Request $req){
     $id= $req->input('id');
     $result= ContactModel::where('id','=',$id)->delete();

     if($result==true){      
       return 1;
     }
     else{
     	return 0;
     }
}
}

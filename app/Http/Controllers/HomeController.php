<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactModel;
use App\Models\CourseModel;
use App\Models\ProjectsModel;
use App\Models\ReviewModel;
use App\Models\ServicesModel;
use App\Models\VisitorModel;

class HomeController extends Controller
{
    function HomeIndex()
     {
        
        $TotalContact =  ContactModel::count();
        $TotalCourse  =  CourseModel::count();
        $TotalProjects=  ProjectsModel::count();
        $TotalReview  =  ReviewModel::count();
        $TotalServices=  ServicesModel::count();
        $TotalVisitor =  VisitorModel::count();




        
        return view('Home',[

         'TotalContact'=>$TotalContact,
         'TotalCourse'=>$TotalCourse, 
         'TotalProjects'=>$TotalProjects, 
         'TotalReview'=> $TotalReview,
         'TotalServices'=>$TotalServices,
         'TotalVisitor'=>$TotalVisitor 

        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectsModel;

class ProjectController extends Controller
{
      
      function ProjectIndex(){





    	return view('Project');
    }



     function getProjectData(){

    $result=json_encode(ProjectsModel::orderBy('id','desc')->get());

    return $result;
    }



     function getProjectDetails(Request $req){
     $id= $req->input('id');
     $result= json_encode(ProjectsModel::where('id','=',$id)->get()) ;

     return $result;
}


    function ProjectDelete(Request $req){
     $id= $req->input('id');
     $result= ProjectsModel::where('id','=',$id)->delete();

     if($result==true){      
       return 1;
     }
     else{
     	return 0;
     }
}



 function ProjectUpdate(Request $req){
     $id= $req->input('id');
     $name = $req->input('name');
     $desc = $req->input('desc');


     $result= ProjectsModel::where('id','=',$id)->update(['project_name'=>$name,'project_desc'=>$desc]);

     if($result==true){      
       return 1;
     }
     else{
     	return 0;
     }
}

function ProjectAdd(Request $req){
     $name = $req->input('name');
     $desc = $req->input('desc');

     $result= ProjectsModel::insert(['project_name'=>$name,'project_desc'=>$desc]);

     if($result==true){      
       return 1;
     }
     else{
     	return 0;
     }
}




}

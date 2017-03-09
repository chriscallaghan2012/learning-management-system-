<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 3/5/17
 * Time: 4:53 PM
 */

namespace App\Controllers;


use App\Core\Controller;
use App\Core\Request;
use App\Core\ResourceInterface;
use App\Core\Session;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;

class CoursesController extends Controller implements ResourceInterface
{
    public function index()
    {
        $courses = Course::all();
        return view('admin/courses/index',['courses'=>$courses]);
    }

    public function create()
    {
        dispalyForDebug($mail = new \PHPMailer());die();
        $courses = Course::all();
        $cats = Category::all();
        return view('admin/courses/create',['courses'=>$courses, 'cats'=>$cats]);
    }

    public function store(Request $request)
    {
        $errors = $this->validator->validate($request, [
            'title' => 'required',
            'desc' => 'required',
            'start' => 'required',
            'end' => 'required',
            'cat' => 'required',
            'rank' => 'required',
        ]);

        if ($errors) {
            $request->saveToSession($errors);
            redirect('courses/create', ['errors'=>$request->getLastFromSession()]);
        }else {
            $course = new Course();
            $course->title = $request->get('title');
            $course->description = $request->get('desc');
            $course->start = $request->get('start');
            $course->end = $request->get('end');
            $course->cid = $request->get('cat');
            $course->rate = $request->get('rank');
            $course->tid =1; // dummy

            try {
                $image = uploadFile("image",$_SERVER["DOCUMENT_ROOT"]."/uploads/","",time(),getImageTypes());
                $course->image = $image['name'];
            } catch (\Exception $e) {
                $e->getMessage();
            }
            $course->save();
            Session::set('message',"User Added Successfully");
            redirect('courses/create');
        }


    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function edit($id)
    {
        $course=Course::retrieveByPK($id);
        $cats = Category::all();
        return view('admin/courses/edit',['course'=>$course,'cats'=>$cats]);
    }

    public function update(Request $request, $id)
    {
        $course=Course::retrieveByPK($id);
        if(verifyCSRF($request)){
            $errors = $this->validator->validate($request, [
                'title' => 'required',
                'desc' => 'required',
                'start' => 'required',
                'end' => 'required',
                'cat' => 'required',
                'rank' => 'required',
            ]);
        }
        if ($errors)
        {
            $request->saveToSession($errors);
            redirect("/courses/".$course->id.'/edit', $request->getLastFromSession());
        }else{
            $course->title = $request->get('title');
            $course->description = $request->get('desc');
            $course->start = $request->get('start');
            $course->end = $request->get('end');
            $course->cid = $request->get('cat');
            $course->rate = $request->get('rank');
            $course->tid =2; // dummy
            if ($_FILES['image']['name'])
            {
                try {
                    $image = uploadFile("image",$_SERVER["DOCUMENT_ROOT"]."/uploads/","",time(),getImageTypes());
                    $course->image = $image['name'];
                } catch (\Exception $e) {
                    $e->getMessage();
                }
            }
            $course->update();
            Session::set('message',"Course Updated Successfully");
            redirect('/courses/create');
        }

    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
        $course=Course::retrieveByPK($id);
        $course->delete();
        Session::set('message',"Course Deleted Successfully");
    }


}
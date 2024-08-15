<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Career;
use Image;
use Session;

class CareerController extends Controller
{
    public function index()
    {
        $career = Career::latest()->get();
        return view('backend.career.index',compact('career'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name_bangla' => 'required|string|max:255',
            'name_english' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'national_id' => 'required|string|max:20',
            'religious' => 'required|string|max:50',
            'blood_g' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'ocupation' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'professional_add' => 'required|string|max:500',
            'present_add' => 'required|string|max:500',
            'permanent_add' => 'required|string|max:500',
            'image' => 'required|image|max:2048',
        ]);


        if($request->hasfile('image')){
            $img = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(300,300)->save('upload/career/'.$name_gen);
            $save_url = 'upload/career/'.$name_gen;
        }else{
            $save_url = '';
        }

        $career = new Career();
        $career->name_bangla = $request->name_bangla;
        $career->name_english = $request->name_english;
        $career->father_name = $request->father_name;
        $career->mother_name = $request->mother_name;
        $career->education = $request->education;
        $career->dob = $request->dob;
        $career->phone = $request->phone;
        $career->email = $request->email;
        $career->national_id = $request->national_id;
        $career->religious = $request->religious;
        $career->blood_g = $request->blood_g;
        $career->ocupation = $request->ocupation;
        $career->designation = $request->designation;
        $career->professional_add = $request->professional_add;
        $career->present_add = $request->present_add;
        $career->permanent_add = $request->permanent_add;
        $career->status = 0;
        $career->image = $save_url;
        $career->created_at = Carbon::now();
        $career->save();

        Session::flash('success','Application Submitted Successfully');
        return redirect()->route('career-executive-apply-from');
    }

    public function view($id)
    {
        $career = Career::findOrFail($id);
    	return view('backend.career.view',compact('career'));
    }

    public function edit($id)
    {
        $career = Career::findOrFail($id);
    	return view('backend.career.edit',compact('career'));
    }

    public function update(Request $request, $id)
    {
        //dd($request);
        $this->validate($request, [
            'name_bangla' => 'required|string|max:255',
            'name_english' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'national_id' => 'required|string|max:20',
            'religious' => 'required|string|max:50',
            'blood_g' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'ocupation' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'professional_add' => 'required|string|max:500',
            'present_add' => 'required|string|max:500',
            'permanent_add' => 'required|string|max:500',
        ]);

        $career = Career::find($id);
        // //career Photo Update
        if($request->hasfile('image')){
            try {
                if(file_exists($career->image)){
                    unlink($career->image);
                }
            } catch (Exception $e) {

            }
            $image = $request->image;
            $image_save = time().$image->getClientOriginalName();
            Image::make($image)->resize(640,360)->save('upload/career/'.$image_save);
            $career->image = 'upload/career/'.$image_save;
        }else{
           $image_save = '';
        }

        $career->name_bangla = $request->name_bangla;
        $career->name_english = $request->name_english;
        $career->father_name = $request->father_name;
        $career->mother_name = $request->mother_name;
        $career->education = $request->education;
        $career->dob = $request->dob;
        $career->phone = $request->phone;
        $career->email = $request->email;
        $career->national_id = $request->national_id;
        $career->religious = $request->religious;
        $career->blood_g = $request->blood_g;
        $career->ocupation = $request->ocupation;
        $career->designation = $request->designation;
        $career->professional_add = $request->professional_add;
        $career->present_add = $request->present_add;
        $career->permanent_add = $request->permanent_add;
        $career->update();

        $notification = array(
            'message' => 'Career Updated Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('career.index')->with($notification);
    }

    public function destroy($id)
    {
        $career = Career::findOrFail($id);
        try {
            if(file_exists($career->image)){
                unlink($career->image);
            }
        } catch (Exception $e) {

        }

    	$career->delete();

        $notification = array(
            'message' => 'Career Deleted Successfully.',
            'alert-type' => 'error'
        );
		return redirect()->back()->with($notification);
    }

    /*=================== Start Active/Inactive Methoed ===================*/
    public function active($id){
        $career = Career::find($id);
        $career->status = 1;
        $career->save();

        Session::flash('success','Career Active Successfully.');
        return redirect()->back();
    }

    public function inactive($id){
        $career = Career::find($id);
        $career->status = 0;
        $career->save();

        Session::flash('warning','Career Inactive Successfully.');
        return redirect()->back();
    }
}

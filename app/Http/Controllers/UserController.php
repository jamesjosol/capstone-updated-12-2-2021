<?php

namespace App\Http\Controllers;

use App\Models\Enroll;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index() {
        return view('pages.users.index');
    }

    public function personalInfoForm() {
        return view('pages.users.users-personal-info');
    }

    public function personalInfoStore(Request $request) {
    
        $request->validate([
            'profile_pic'                 => 'required|mimes:jpeg,png,jpg',
            'firstName'             => 'required|string',
            'lastName'              => 'required|string',
            'middleName'            => 'required|string',
            'gender'                 => 'required|string',
            'birthDate'              => 'required|date',
            'birthPlace'             => 'required|string',
            'nationality'             => 'required|string',
            'religion'             => 'required|string',
            'civilStatus'           => 'required|string',
            'fatherName'             => 'required|string',
            'fatherOccup'             => 'required|string',
            'fatherContact'             => 'numeric',
            'motherName'             => 'required|string',
            'motherOccup'             => 'required|string',
            'motherContact'             => 'numeric',
            'guardianName'          => 'string',
            'guardianContact'       => 'numeric',
            'barangay'             => 'required|string',
            'town'             => 'required|string',
            'province'             => 'required|string',
            'grade_LVL'          => 'required|string',
            'elemSchool'             => 'required|string',
            'elemSchlAddr'             => 'required|string',
            'elemYrAttnd'             => 'required|string',
            'secondarySchool'             => 'string',
            'secondarySchlAddr'             => 'string',
            'secondaryYrAttnd'             => 'string',
        ]);

        $user = User::find(auth()->user()->id);
        $imageName = time() . $request->lastName.'.'.$request->profile_pic->extension(); 

        $user->profile_pic = $imageName;
        $user->save();

        $request->profile_pic->move(public_path('images'), $imageName);

        
        $student = Student::create([
            'user_id'           => auth()->user()->id,
            'firstName'         => $request->firstName,
            'lastName'          => $request->lastName,
            'middleName'        => $request->middleName,
            'gender'        => $request->gender,
            'birthDate'        => $request->birthDate,
            'birthPlace'        => $request->birthPlace,
            'nationality'        => $request->nationality,
            'religion'        => $request->religion,
            'civilStatus'        => $request->civilStatus, 
            'fatherName'        => $request->fatherName,
            'fatherOccup'        => $request->fatherOccup,
            'fatherContact'        => $request->fatherContact,
            'motherName'        => $request->motherName,
            'motherOccup'        => $request->motherOccup,
            'motherContact'        => $request->motherContact,
            'guardianName'        => $request->guardianName,
            'guardianContact'        => $request->guardianContact,
            'barangay'        => $request->barangay,
            'town'        => $request->town,
            'province'        => $request->province,
            'grade_LVL'        => $request->grade_LVL,
            'elemSchool'        => $request->elemSchool,
            'elemSchlAddr'        => $request->elemSchlAddr,
            'elemYrAttnd'        => $request->elemYrAttnd,
            'secondarySchool'        => $request->secondarySchool,
            'secondarySchlAddr'        => $request->secondarySchlAddr,
            'secondaryYrAttnd'        => $request->secondaryYrAttnd,
        ]);

        return redirect()->route('user.dashboard');
    }

    public function stepOneEnrollment(Request $request) {
        
        $enrollment = $request->session()->get('enrollment');

        return view('pages.users.enrollment',compact('enrollment'));
    }

    public function stepOneEnrollmentStore(Request $request) {
       
        $request->validate([
            'level'                 => 'required|numeric',
            'student_type'          => 'required|string',
            'track'                 => 'string|nullable',
            'strand'                => 'string|nullable',
            'title'                 => 'required|string',
            'remarks'               => 'required|string',
        ]);

        $enrollment = $request->session()->get('enrollment');
       
        if(isset($request->requiredFile)) {
            $request->validate([
                'requiredFile.*'        => 'image|mimes:jpeg,png,jpg,svg|max:4096',
                'requiredFile'          => 'max:3',
            ], [
                'requiredFile.*.max' => 'Image should be less than 4mb.',
                'requiredFile.*.mimes' => 'Only jpeg, png, svg files are allowed.',
                'requiredFile.max' => 'A maximum of 3 images are allowed.',
                'requiredFile.image' => 'Only jpeg, png, svg files are allowed.',
            ]);
        }
        if($request->student_type == 'New Student' || $request->student_type == 'Transferee'){
            $request->validate([
                'requiredFile'          => 'required',
            ], [
                'requiredFile.required' => 'You must submit required documents.',
            ]);
        }

        if(!isset($enrollment->requirement_images)) {
            if(isset($request->requiredFile)) {
                foreach($request->file('requiredFile') as $image){
                    $rand = Str::random(10);
                    $fileName = "requiredFile-$rand-" . time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('requiredFileImgs'), $fileName);
                    // $image->storeAs('requiredFileImgs', $fileName);
                    $data[] = $fileName;
                }
            }
        }
    
        if(empty($enrollment)){
            $enrollment = new Enroll();
            $enrollment->fill($request->except('requiredFile'));
            if(!isset($enrollment->requirement_images) && isset($enrollment->requiredFile)) $enrollment->requirement_images = json_encode($data);
            $request->session()->put('enrollment', $enrollment);
        }else{
            $enrollment = $request->session()->get('enrollment');
            $enrollment->fill($request->except('requiredFile'));
            if(!isset($enrollment->requirement_images) && isset($request->requiredFile)) $enrollment->requirement_images = json_encode($data);
            $request->session()->put('enrollment', $enrollment);
        }
        // dd($enrollment->requiredFile);
        return redirect()->route('user.payment');
    }

    public function removeRequirementImage(Request $request) {
        $enrollment = $request->session()->get('enrollment');
        if(isset($enrollment->requirement_images)) {
            foreach(json_decode($enrollment->requirement_images) as $file) {           
                $file_path = public_path("requiredFileImgs/$file");
                File::delete($file_path);
            }
            $enrollment->requirement_images = null;
        }
        return view('pages.users.enrollment',compact('enrollment'));
    }

    public function stepTwoEnrollment(Request $request) {
        $enrollment = $request->session()->get('enrollment');

        // dd($enrollment);
        return view('pages.users.payments',compact('enrollment'));
    }


}

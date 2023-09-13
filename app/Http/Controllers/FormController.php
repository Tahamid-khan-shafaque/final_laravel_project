<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Form;


class FormController extends Controller
{
    public function submit(Request $request)
    {

         // Validate the form data
         $request->validate([
            'photo' => 'image|max:2048', // Maximum file size of 2MB (2048 kilobytes)
        ]);
        // Retrieve form data
        $name = $request->input('name');
        $email = $request->input('email');
        $number = $request->input('number');
        $department = $request->input('department');
        $bloodgroup = $request->input('bloodgroup');
        $gender = $request->input('gender');
        $skillset = $request->input('skillset');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public_subdirectory');
        } else {
            $photoPath = null;
        }

        // Save the form data to the database
        DB::table('form_data')->insert([
            'name' => $name,
            'email' => $email,
            'number' => $number,
            'department' => $department,
            'bloodgroup' => $bloodgroup,
            'gender' => $gender,
            'skillset' => $skillset,
            'photo' => $photoPath, 
        ]);

        // Redirect the user to a success page or display a success message
        return redirect()->route('success');
    }

    public function displayData($id = null)
    {
        if ($id) {
            // Fetch the specific form data from the database
            $formData = Form::find($id);
        } else {
            // Fetch all form data from the database
            $formData = DB::table('form_data')->get();
        }

        // Pass the data to the view for display
        return view('data-display', compact('formData'));
    }
    public function viewForm($id)
    {
        // Retrieve the form data based on the provided ID
        $formData = DB::table('form_data')->where('id', $id)->first();
    
        // Pass the data to the view for display
        return view('view', compact('formData'));
    }

    
}
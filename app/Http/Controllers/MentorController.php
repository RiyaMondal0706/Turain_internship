<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\InternshipCredentialsMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\File;

class MentorController extends Controller
{
    public function mentor_internList_show()
    {
        $mentorId = session()->get('user_id');
        $mentor_id = DB::table('users')
            ->where('id', $mentorId)
            ->first();
        $mentor = DB::table('mentor_data')
            ->where('id', $mentor_id->mentor_data_id)
            ->first();
        $assign = DB::table('assign')
            ->where('mentor_id', $mentor->id)
            ->get();
        return view('mentor.intern_list', compact('assign'));
    }
    public function assignCreate()
    {
        $mentorId = session()->get('user_id');
        $mentor_id = DB::table('users')
            ->where('id', $mentorId)
            ->first();
        $mentor = DB::table('mentor_data')
            ->where('id', $mentor_id->mentor_data_id)
            ->first();
        $assign = DB::table('assign')
            ->where('mentor_id', $mentor->id)
            ->get();

        return view('mentor.assignment_create', compact('assign'));
    }

    public function assign_store(Request $request)
    {
        // dd($request->id);
        $filePath = null;
        if ($request->hasFile('documentation')) {
            $file = $request->file('documentation');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/documentation'), $fileName);

            $filePath = 'assets/documentation/' . $fileName;
        }
        DB::table('assignment')->insert([
            'assign_id' => $request->intern_id,
            'project' => $request->project_name,
            'project_description' => $request->documentation_note,
            'documentation' =>  $fileName,
            'start_date' => Carbon::now('Asia/Kolkata'),
            'end_date' => $request->submit_date,
        ]);
        return redirect()
            ->route('mentor.intern.list');
    }

    public function assign_view($id)
    {
        $project =  DB::table('assignment')
            ->where('assign_id', $id)
            ->get();
        // dd($project);
        return view('mentor.assignment_project', compact('project'));
    }
    public function assignment_edit_show($id)
    {
        $project =  DB::table('assignment')
            ->where('id', $id)
            ->first();
        return view('mentor.assignment_edit', compact('project'));
    }
    public function assign_update(Request $request, $id)
    {
        $assignment = DB::table('assignment')->where('id', $id)->first();

        if (!$assignment) {
            abort(404);
        }

        // Base data
        $updateData = [
            'project' => $request->project_name,
            'project_description' => $request->documentation_note,
            'end_date' => $request->submit_date,
        ];
        // dd($request->documentation);

        if ($request->has('documentation')) {

            if (!empty($assignment->documentation)) {
                $oldFilePath = public_path('assets/documentation/' . $assignment->documentation);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            $file = $request->file('documentation');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/documentation'), $fileName);


            $updateData['documentation'] = $fileName;
        }

        // dd($updateData);
        DB::table('assignment')->where('id', $id)->update($updateData);

        return redirect()->route('assignment.view', $id)
            ->with('success', 'Assignment updated successfully!');
    }
    public function intern_profile($id)
    {
        $result = DB::select('CALL get_intern_profile(?)', [$id]);

        if (empty($result)) {
            abort(404, 'Intern not found');
        }
        $intern = $result[0];
        return view('mentor.intern_profile', compact('intern'));
    }

    public function getNotes($assignId)
{
    $notes = DB::table('assignment_notes')
        ->where('assign_id', $assignId)
        ->orderBy('created_at', 'desc')
        ->get([
            'id',
            'note',
            DB::raw("DATE_FORMAT(created_at, '%d %b %Y') as created_at")
        ]);

    return response()->json($notes);
}
public function submission_assigment_show($id)
{
$assignment = DB::table('assignment')
        ->where('id', $id)
        ->first();

    if (!$assignment) {
        abort(404, 'Assignment not found');
    }

    // Optional: fetch related notes for this assignment
    $notes = DB::table('assignment_notes')
        ->where('assign_id', $assignment->assign_id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Optional: fetch GitHub submission link
    $github = DB::table('assignment_github')
        ->where('assign_id', $assignment->id)
        ->first();


        $final = DB::table('assignment_submissions')
        ->where('assign_id', $assignment->id)
        ->first();
        
    return view('mentor.submission_assignment_show', compact('assignment', 'notes', 'github', 'final'));
}

 public function store(Request $request)
    {

        $request->validate([
            'project_id' => 'required|integer',
            'review' => 'required|string',
        ]);

       DB::table('assignment_submissions')
    ->where('assign_id', $request->project_id)
    ->update([
        'submitted_by_mentor'       => $request->review,
    ]);

        
    }

    public function index_show(){

    $mentorId = session()->get('user_id');
    // dd($mentorId);
    $id = DB::table('users')->where('id', $mentorId)->first();
     $internCount = DB::table('assign')
     ->where('mentor_id',$id->mentor_data_id)
    ->count();
     $activeIntern = DB::table('assign')
      ->where('mentor_id',$id->mentor_data_id)
     ->where('status', 1)
    ->count();

    $assign = DB::table('assign')->where('mentor_id', $id->mentor_data_id)->get();
$projectCount = DB::table('assign')
    ->join('assignment', 'assignment.assign_id', '=', 'assign.id')
    ->where('assign.mentor_id', $id->mentor_data_id)
    ->count();

    $submitedCount = DB::table('assign')
    ->join('assignment', 'assignment.assign_id', '=', 'assign.id')
     ->where('assignment.status', 1)
    ->where('assign.mentor_id', $id->mentor_data_id)
    ->count();

    
          return view('mentor.index' , compact('internCount', 'projectCount' ,'activeIntern', 'submitedCount'));
    }

public function mentor_profile_show(){
      $mentorId = session()->get('user_id');
        $mentor_id = DB::table('users')
            ->where('id', $mentorId)
            ->first();
        $mentor = DB::table('mentor_data')
            ->where('id', $mentor_id->mentor_data_id)
            ->first();

            return view('mentor.mentor_profile', compact('mentor'));
    }


}
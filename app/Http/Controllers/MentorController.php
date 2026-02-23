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

class MentorController extends Controller
{
    public function internList_show()
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
            ->where('assign_id', $id)
            ->first();
        return view('mentor.assignment_edit', compact('project'));
    }
    public function assign_update(Request $request, $id)
    { {
            $assignment = DB::table('assignment')->where('id', $id)->first();

            $updateData = [

                'project' => $request->project_name,
                'start_date' => Carbon::now('Asia/Kolkata'),
                'end_date' => $request->submit_date,
            ];
            if ($request->hasFile('documentation')) {
                $file = $request->file('documentation');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/documentation'), $fileName);
                $updateData['documentation'] = 'assets/documentation/' . $fileName;
            } else {
                $updateData['documentation'] = $assignment->documentation;
            }
            DB::table('assignment')->where('id', $id)->update($updateData);

            return redirect()->route('assignment.view', $id)
                ->with('success', 'Assignment updated successfully!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\InternshipCredentialsMail;
use App\Mail\mentorCredentialsMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;

class HrController extends Controller
{
    public function internCreate_show()
    {
        $state = DB::table('states')
            ->get();
        $departments = DB::table('departments')
            ->get();
        return view('hr.intern_create', compact('state', 'departments'));
    }

    public function internList_show()
    {

        $intern = DB::table('intern_data')
            ->get();

        return view('hr.intern_list', compact('intern'));
    }
    public function internship_store(Request $request)
    {
        $plainPassword = random_int(10000000, 99999999);
        // dd($request->hasFile('avatar'));
        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('assets/images/intern'), $avatarName);
        }
        $startDate = Carbon::createFromFormat('Y-m-d', $request->intern_start);

        $internshipDataId = DB::table('intern_data')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department_id,
            'designation' =>  $request->designation_id,
            'dob' => Carbon::parse($request->dob)->format('Y-m-d'),
            'github_link' => $request->gitbub,
            'mp_boad' => $request->mp_boad,
            'mp_marks' => $request->mp_marks,
            'hs_boad' => $request->hs_boad,
            'hs_marks' => $request->hs_marks,
            'graduation' => $request->gratuadion,
            'graduation_cgpa' => $request->graduation_marks,
            'post_graduation' => $request->postgraduation,
            'post_graduation_cgpa' => $request->postgraduation_marks,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'district' => $request->district,
            'state' => $request->state,
            'city' => $request->city,
            'image' => $avatarName,
            'entry_date' => $startDate->format('Y-m-d'),
            'end_date' => $startDate->copy()->addMonths(3)->format('Y-m-d'),
            'create_at' => now(),
        ]);

        $generate = 'turain' . random_int(1000, 9999);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role' => 'candidate',
            'turain_id' => $generate,
            'internship_data_id' => $internshipDataId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($request->email)->send(
            new InternshipCredentialsMail(
                $request->name,
                $request->email,
                $plainPassword,
                $generate
            )
        );

        return back()->with('success', 'Internship registered & user created successfully!');
    }




    public function getDistricts(Request $request)
    {
        return DB::table('districts')
            ->where('state_id', $request->state_id)
            ->select('id', 'name')
            ->get();
    }
    public function getCities(Request $request)
    {
        return DB::table('cities')
            ->where('district_id', $request->district_id)
            ->select('id', 'name')
            ->get();
    }
    public function updateStatus(Request $request)
    {
        // dd("ok");
        DB::table('intern_data')
            ->where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);
        DB::table('users')
            ->where('internship_data_id', $request->id)
            ->update([
                'status' => $request->status
            ]);

        return response()->json([
            'success' => true,
            'message' => $request->status == 1
                ? 'Intern activated successfully'
                : 'Intern deactivated successfully'
        ]);
    }
    public function inter_view($id)
    {
        $result = DB::select('CALL get_intern_profile(?)', [$id]);

        if (empty($result)) {
            abort(404, 'Intern not found');
        }
        $intern = $result[0];

        return view('hr.intern_view', compact('intern'));
    }

    public function intern_edit_show($id)
    {
        $state = DB::table('states')
            ->get();

        $intern = DB::table('intern_data')
            ->where('id', $id)
            ->first();
        $departments = DB::table('departments')
            ->get();
        return view('hr.intern_edit', compact('state', 'intern', 'departments'));
    }

    public function intern_update(Request $request, $id)
    {
        // dd($request);
        // $request->validate([
        //     'name'        => 'required|string',
        //     'email'       => 'required|email',
        //     'phone'       => 'required|digits:10',
        //     'designation' => 'required',
        //     'dob'         => 'required|date',
        //     'intern_start' => 'required|date',
        // ]);

        DB::beginTransaction();

        try {
            $oldAvatar = DB::table('intern_data')
                ->where('id', $id)
                ->value('image');

            $avatarName = $oldAvatar;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('assets/images/intern'), $avatarName);
            }

            $startDate = Carbon::createFromFormat('Y-m-d', $request->intern_start);


            DB::table('intern_data')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'department' => $request->department_id,
                    'designation' => $request->designation_id,
                    'dob' => $request->dob,
                    'github_link' => $request->gitbub,
                    'mp_boad' => $request->mp_boad,
                    'mp_marks' => $request->mp_marks,
                    'hs_boad' => $request->hs_boad,
                    'hs_marks' => $request->hs_marks,
                    'graduation' => $request->gratuadion,
                    'graduation_cgpa' => $request->graduation_marks,
                    'post_graduation' => $request->postgraduation,
                    'post_graduation_cgpa' => $request->postgraduation_marks,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                    'district' => $request->district,
                    'state' => $request->state,
                    'city' => $request->city,
                    'image' => $avatarName,
                    'entry_date' => $startDate->format('Y-m-d'),
                    'end_date' => $startDate->copy()->addMonths(3)->format('Y-m-d'),

                ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Internship updated successfully!');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Intern update failed', [
                'intern_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Something went wrong. Changes were not saved.');
        }
    }
    public function mentorCreate_show()
    {
        $departments = DB::table('departments')
            ->get();
        return view('hr.mentor_create', compact('departments'));
    }
    public function mentor_store(Request $request)
    {
        $avatarName = null;
        $plainPassword = random_int(10000000, 99999999);
        if ($request->hasFile('avatar')) {
            $avatar      = $request->file('avatar');
            $avatarName  = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('assets/images/mentor'), $avatarName);
        }

        $internshipDataId = DB::table('mentor_data')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation_id,
            'department' => $request->department_id,
            'address' => $request->address,
            'image' => $avatarName,
            'created_at' => now(),
        ]);

        $generate = 'turain' . random_int(1000, 9999);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role' => 'mentor',
            'turain_id' => $generate,
            'mentor_data_id' => $internshipDataId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($request->email)->send(
            new mentorCredentialsMail(
                $request->name,
                $request->email,
                $plainPassword,
                $generate
            )
        );
        return redirect()
            ->route('hr.mentor.list')
            ->with('success', 'Mentor created successfully!');
    }

    public function mentorList_show()
    {

        $mentor = DB::table('mentor_data')
            ->get();
        return view('hr.mentor_list', compact('mentor'));
    }
    public function updateStatus_mentor(Request $request)
    {
        // dd("ok");
        DB::table('mentor_data')
            ->where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);
        DB::table('users')
            ->where('mentor_data_id', $request->id)
            ->update([
                'status' => $request->status
            ]);

        return response()->json([
            'success' => true,
            'message' => $request->status == 1
                ? 'Intern activated successfully'
                : 'Intern deactivated successfully'
        ]);
    }

    public function mentor_view($id)
    {
        $mentor = DB::table('mentor_data')
            ->where('id', $id)
            ->first();
        return view('hr.mentor_view', compact('mentor'));
    }

    public function mentor_edit_show($id)
    {
        $mentor = DB::table('mentor_data')
            ->where('id', $id)
            ->first();
        $departments = DB::table('departments')
            ->get();
        return view('hr.mentor_edit', compact('mentor', 'departments'));
    }
    public function mentor_update(Request $request, $id)
    {
        $oldAvatar = DB::table('mentor_data')
            ->where('id', $id)
            ->value('image');

        $avatarName = $oldAvatar;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('assets/images/intern'), $avatarName);
        }
        DB::table('mentor_data')
            ->where('id', $id)
            ->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'designation' => $request->designation_id,
                    'department' => $request->department_id,
                    'image' => $avatarName,
                    'address' => $request->address,
                ]
            );
        return redirect()
            ->route('hr.mentor.list');
    }

    public function assignCreate_show(Request $request)
    {
        $interns =  DB::table('intern_data')
            ->get();
        $mentors =  DB::table('mentor_data')
            ->get();

        return view('hr.assign', compact('interns', 'mentors'));
    }

    public function assignCreate(Request $request)
    {
        DB::table('assign')->insert(
            [
                'mentor_id' => $request->mentor_id,
                'candidate_id' => $request->intern_id
            ]
        );
        return redirect()
            ->route('hr.assign.list');
    }

    public function assignList_show()
    {
        $assignments = DB::table('assign')
            ->join('mentor_data', 'assign.mentor_id', '=', 'mentor_data.id')
            ->join('intern_data', 'assign.candidate_id', '=', 'intern_data.id')
            ->select(
                'assign.*',
                'mentor_data.name as mentor_name',
                'intern_data.name as intern_name'
            )
            ->get()
            ->groupBy('mentor_id');

        return view('hr.assign_list', compact('assignments'));
    }

    public function updateStatus_assign(Request $request)
    {
        // dd($request->status);
        DB::table('assign')
            ->where('id', $request->id)
            ->update([
                'status' => $request->status,
            ]);
    }

    public function getDesignations(Request $request)
    {
        $designations = DB::table('designations')
            ->where('department_id', $request->department_id)
            ->where('status', 1)
            ->select('id', 'designation_name')
            ->get();

        return response()->json($designations);
    }
    public function department_show()
    {
        $departments = DB::table('departments')
            ->get();
        return view('hr.department_list', compact('departments'));
    }
    public function department_create()
    {
        return view('hr.department_create');
    }
    public function department_store(Request $request)
    {
        $departmentName = $request->department_name;

        $departmentCode = strtoupper(substr($departmentName, 0, 3));

        DB::table('departments')->insert([
            'department_name' => $request->department_name,
            'department_code' => $departmentCode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('hr.department.list');
    }
    public function designation_create()

    {
        $departments = DB::table('departments')
            ->get();
        return view('hr/designation_create', compact('departments'));
    }

    public function designation_store(Request $request)
    {
        $request->validate([
            'level' => 'required|in:junior,mid,senior,lead',
        ]);

        DB::table('designations')->insert([
            'department_id' => $request->department_id,
            'designation_name' => $request->designation_name,
            'level' => $request->level,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()
            ->route('hr.department.list');
    }

    public function department_edit($id)
    {
        $department = DB::table('departments')
            ->where('id', $id)
            ->first();

        $departments = DB::table('departments')
            ->get();
        $designations = DB::table('designations')
            ->where('department_id', $id)
            ->get();
        return view('hr.department_edit', compact('department', 'departments', 'designations'));
    }

    public function updateDesignations(Request $request, $id)
    {

        DB::table('designations')
            ->where('department_id', $request->department_id)
            ->update([
                'status' => 0,
                'updated_at' => now(),
            ]);


        if ($request->has('selected_designations')) {
            foreach ($request->selected_designations as $id) {
                DB::table('designations')
                    ->where('id', $id)
                    ->update([
                        'department_id' => $request->department_id,
                        'status' => 1,
                        'updated_at' => now(),
                    ]);
            }
        }

        return redirect()->back()->with('success', 'Designations updated successfully');
        return back()->with('success', 'Updated successfully');
    }


public function completed_project_show(){
   return view("hr.complete_project");
}

public function index_show(){
    $internCount = DB::table('intern_data')
    ->count();
    $activeInterns = DB::table('intern_data')->where('status', 1)->count();

       $mentorCount = DB::table('mentor_data')
    ->count();
  $activementors = DB::table('mentor_data')->where('status', 1)->count();
   $projectCount = DB::table('assignment')
    ->count();
   $completedCount = DB::table('assignment_submissions')
    ->count();

     return view('index' , compact('internCount', 'activeInterns', 'mentorCount', 'activementors', 'projectCount', 'completedCount'));
}

public function generate_cirtificate($id){
    
DB::table('assignment_submissions')
    ->where('id', $id)
    ->update([
        'submitted_by_hr'       => 'Approved',
    ]);
       return redirect()
            ->route('hr.completed_project.list')
            ->with('success', 'Cirtificate generate successfully!');
}


public function upcomming_birthday_show(){
$data = DB::select('CALL get_all_birthdays_desc_all()');
  return view("hr.birthday_list" , compact('data'));
}

public function upcomming_work_anniversery_show(){
    dd("work");
}


}
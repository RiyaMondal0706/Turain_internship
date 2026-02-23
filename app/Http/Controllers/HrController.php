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

class HrController extends Controller
{
    public function internCreate_show()
    {
        $state = DB::table('states')

            ->get();
        return view('hr.intern_create', compact('state'));
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
            'designation' => $request->designation,
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
        $intern = DB::table('intern_data')
            ->where('id', $id)
            ->first();
        $state = DB::table('states')
            ->where('id', $intern->state)
            ->first();
        $districts = DB::table('districts')
            ->where('id', $intern->district)
            ->first();
        $cities = DB::table('cities')
            ->where('id', $intern->city)
            ->first();


        // dd($id);
        return view('hr.intern_view', compact('intern', 'state', 'districts', 'cities'));
    }

    public function intern_edit_show($id)
    {
        $state = DB::table('states')
            ->get();

        $intern = DB::table('intern_data')
            ->where('id', $id)
            ->first();
        return view('hr.intern_edit', compact('state', 'intern'));
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
                    'designation' => $request->designation,
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
        return view('hr.mentor_create');
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
            'designation' => $request->designation,
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
            new InternshipCredentialsMail(
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
        return view('hr.mentor_edit', compact('mentor'));
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
                    'designation' => $request->designation,
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
    }

    public function assignList_show()
    {
        $assign = DB::table('assign')
            ->get();

        return view('hr.assign_list', compact('assign'));
    }

    public function updateStatus_assign(Request $request)
    {
        DB::table('assign')
            ->where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);


        return response()->json([
            'success' => true,
            'message' => $request->status == 1
                ? 'assign activated successfully'
                : 'assign deactivated successfully'
        ]);
    }

    public function assign_view($id)
    {
        dd($id);
    }
}

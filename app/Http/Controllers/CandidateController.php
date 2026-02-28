<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Mail\InternshipCredentialsMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Str;
class CandidateController extends Controller
{
    public function projectList_show()
    {
        $candidateId = session()->get('user_id');
        $candidate_id = DB::table('users')
            ->where('id', $candidateId)
            ->first();

        $assign = DB::table('assign')
            ->where('candidate_id', $candidate_id->internship_data_id)
            ->first();

        $can = $assign->id;
        $project = DB::table('assignment')
            ->where('assign_id', $can)
            ->where('status', 1)
            ->get();
        // dd($project);
        return view('candidate.project_list', compact('project'));
    }

    public function today_work_store(Request $request)
    {

        $request->validate([
            'assign_id' => 'required',
            'note'      => 'required',
            'date'      => 'required'
        ]);

        $assignId = $request->assign_id;
        $note     = $request->note;

        $noteDate = Carbon::createFromFormat('d M Y', $request->date)->toDateString();
        $existing = DB::table('assignment_notes')
            ->where('assign_id', $assignId)
            ->whereDate('created_at', $noteDate)
            ->first();

        if ($existing) {
            DB::table('assignment_notes')
                ->where('id', $existing->id)
                ->update([
                    'note'       => $note,
                    'updated_at' => now(),
                ]);

            return response()->json([
                'status'  => true,
                'message' => 'Note updated successfully'
            ]);
        }

        DB::table('assignment_notes')->insert([
            'assign_id' => $assignId,
            'note'      => $note,
            'created_at' => $noteDate . ' ' . now()->format('H:i:s'),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Note saved successfully'
        ]);
    }

    public function github_store(Request $request)
    {

        DB::table('assignment_github')->insert([
            'assign_id' => $request->assign_id,
            'github_link' => $request->note,
            'created_at' => now(),

        ]);
        return response()->json([
            'status' => true,
            'message' => 'GitHub link saved successfully'
        ]);
    }


    public function submitAssignmentPost(Request $request, $id)
    {


        DB::table('assignment_submissions')->insert([
            'assign_id' => $id,
            'project_link' =>  $request->project_link,
            'notes' =>   $request->note,
            'created_at' => now(),

        ]);

        DB::table('assignment')
            ->where('id', $id)
            ->update([
                'status' => 0
            ]);

        return redirect()
            ->route('candidate.project.list');
    }


    public function submitedprojectList_show()
    {
        $candidateId = session()->get('user_id');
        $data = DB::select('CALL get_submitted_projects_by_user(?)', [$candidateId]);
        return view('candidate.submitted_project_list', compact('data'));
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
    public function index_show()
    {

        $intern = session()->get('user_id');
        // dd($mentorId);
        $id = DB::table('users')->where('id', $intern)->first();
        $internCount = DB::table('assign')
            ->where('candidate_id', $id->internship_data_id)
            ->count();
        $activeIntern = DB::table('assign')
            ->where('candidate_id', $id->internship_data_id)
            ->where('status', 1)
            ->count();

        $assign = DB::table('assign')->where('candidate_id', $id->internship_data_id)->get();
        $projectCount = DB::table('assign')
            ->join('assignment', 'assignment.assign_id', '=', 'assign.id')
            ->where('assign.candidate_id', $id->internship_data_id)
            ->count();

        $submitedCount = DB::table('assign')
            ->join('assignment', 'assignment.assign_id', '=', 'assign.id')
            ->where('assignment.status', 1)
            ->where('assign.mentor_id', $id->internship_data_id)
            ->count();

        return view('candidate.index',  compact('internCount', 'projectCount', 'activeIntern', 'submitedCount'));
    }
    public function showIdCard()
    {
        $internId = session()->get('user_id');

        $id = DB::table('users')->where('id', $internId)->first();

        $intern = DB::table('intern_data')->where('id', $id->internship_data_id)->first();

        return view('candidate.icard_show', compact('intern', 'id'));
    }

    public function candidate_profile_show()
    {
        $internId = session()->get('user_id');
        $intern_id = DB::table('users')
            ->where('id', $internId)
            ->first();
        $intern = DB::table('intern_data')
            ->where('id', $intern_id->internship_data_id)
            ->first();

        return view('candidate.intern_profile', compact('intern'));
    }
    public function candidate_chatbox_show()
    {
        $user = session()->get('user_id');
        $users = DB::table('users')
            ->where('status', 1)
            ->where('id', '<>', $user)
            ->get();

        return view("candidate.chabox", compact('users'));
    }

        public function candidate_messages(User $user)
    {
        $fromId = session()->get('user_id');
        $toId   = $user->id;

        $messages = DB::table('ch_messages')
            ->where(function ($q) use ($fromId, $toId) {
                $q->where('from_id', $fromId)
                    ->where('to_id', $toId);
            })
            ->orWhere(function ($q) use ($fromId, $toId) {
                $q->where('from_id', $toId)
                    ->where('to_id', $fromId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('candidate.partials.messages', compact('messages', 'fromId', 'toId'));
    }

    public function candidate_send(Request $request)
    {
        // dd($request);
        DB::table('ch_messages')->insert([
            'id'         => (string) Str::uuid(),
            'from_id'    => session()->get('user_id'),
            'to_id'      => $request->to_id,
            'body'    => $request->message,
            'created_at' => now(),
        ]);

        return response()->json(['status' => 'sent']);
    }
public function candidate_chatUsers()
{
    $currentUserId = session()->get('user_id');

    if (!$currentUserId) {
        return response()->json([]);
    }

    // Get last message per chat user
    $chats = DB::table('ch_messages as m')
        ->select(
            DB::raw('
                IF(m.from_id = ' . $currentUserId . ',
                   m.to_id,
                   m.from_id
                ) as user_id
            '),
            'm.body',
            'm.created_at'
        )
        ->where(function ($q) use ($currentUserId) {
            $q->where('m.from_id', $currentUserId)
              ->orWhere('m.to_id', $currentUserId);
        })
        ->orderBy('m.created_at', 'desc')
        ->get()
        ->unique('user_id'); // one per user (latest message)

    if ($chats->isEmpty()) {
        return response()->json([]);
    }

    // Get user details
    $users = DB::table('users')
        ->whereIn('id', $chats->pluck('user_id'))
        ->get()
        ->keyBy('id');

    $data = [];

    foreach ($chats as $chat) {
        $user = $users[$chat->user_id] ?? null;
        if (!$user) continue;

        $data[] = [
            'id' => $user->id,
            'name' => $user->name,
            'last_message' => $chat->body,
            'time' => Carbon::parse($chat->created_at)->format('h:i A'),
        ];
    }

    return response()->json($data);
}
}
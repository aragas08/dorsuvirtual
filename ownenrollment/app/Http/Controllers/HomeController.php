<?php

namespace App\Http\Controllers;

use App\Models\IncomingStudent;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $auth = '';
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(){
        $enrollees = Student::all();
        $semesters = Semester::all();
        $current_semester = Semester::where('created_at', $semesters->count())->get();
        $countEnrollees = $enrollees->count();
        $countIncoming = $enrollees->where('student_status', 'incoming')->count();
        $countTransferees = $enrollees->where('student_status', 'transferee')->count();
        $countReturning = $enrollees->where('student_status', 'returnee')->count();
        $countOld = $enrollees->where('student_status', 'old')->count();
        $countAdvised = $enrollees->where('application_status', 'advised')->count();
        $countAccepted = $enrollees->where('application_status', 'accepted')->count();
        $transferredTo = $enrollees->where('application_status', 'transferred_to')->count();
        $hasSchoolID = $enrollees->where('school_id', '!=', NULL)->count();

        $sample = DB::table('authorization_app')->selectRaw('app_id')->groupBy("app_id")->get();

        return view('dashboard' , [
            'counted' => $countEnrollees,
            'incoming' => $countIncoming,
            'transferees' => $countTransferees,
            'returning' => $countReturning,
            'old' => $countOld,
            'countAdvised' => $countAdvised,
            'countAccepted' => $countAccepted,
            'transferredTo' => $transferredTo,
            'hasSchoolID' => $hasSchoolID,
            'semesters' => $current_semester,
            'sample' => $sample
        ]);
    }

    public function sidebarAjax(Request $request){
        $user = Auth::user()->id;

        

        return $user;
    }

}

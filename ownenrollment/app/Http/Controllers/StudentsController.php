<?php
namespace App\Http\Controllers;
use App\Models\IncomingStudent;
use App\Models\Student;
use App\Models\User;
use App\Models\Campus;
use App\Models\Employee;
use App\Models\Studentgrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function grade()
    {
        $sid = Auth::user()->username;
        $programs = DB::table('program')->join('department','program.department_id','=','department.id')->
        where('department.id', '!=', 5)->select('*','program.id as pid')->get();
        $grades = DB::select("SELECT * FROM `studentgrade` where username='$sid' and sy = (select sy from studentgrade where username='$sid' order by sy desc limit 1) and 
        semester = (select semester from studentgrade where username='$sid' and sy=(select sy from studentgrade where username='$sid' order by sy desc limit 1) order by semester desc limit 1)");
        $sem = collect(\DB::select("SELECT semester FROM studentgrade where username='$sid' and sy=(SELECT sy FROM studentgrade where username='$sid' order by sy desc limit 1) order by semester desc limit 1"))->first();
        $sy = DB::table('studentgrade')->select('sy')->where('username','=',Auth::user()->username)->groupBy('sy')->get();
        if($sem === null){
            $sem = collect(\DB::SELECT("SELECT semester FROM studentgrade limit 1"))->first();
        }
        return view('students.portal.grade',['grade'=>$grades, 'sy'=>$sy, 'sem'=>$sem, 'program'=>$programs]);
    }

    public function getGrade(Request $request)
    {
        $sid = Auth::user()->username;
        $grades = DB::select("SELECT * FROM `studentgrade` where username='$sid' and semester = $request->sem and sy = '$request->sy'");
        $returnGrade = "";
        foreach($grades as $grade){
            $returnGrade .= "<tr><td>".$grade->subject."</td>
            <td>".$grade->description."</td>
            <td>".$grade->grade."</td>
            <td>".$grade->completion."</td></tr>";
        }
        return response()->json(['grade'=>$returnGrade]);
    }

    public function uploadStudent(Request $request)
    {
        $file= $request->uploadedfile;
        $filename = $request->uploadedfile->getClientOriginalName();
        $file->move('upload',$filename);
        $filepath = public_path("upload/".$filename);
        $file = fopen($filepath,"r");
        $importData_arr = array();
        set_time_limit(0);
        $i = 0;
        while (($filedata = fgetcsv($file, 100000, ",")) !== FALSE) {
            $num = count($filedata);
            $user = new User();
            $user->username = $filedata[0];
            $user->password = Hash::make($filedata[1]);
            $user->name = $filedata[2];
            $user->email = $filedata[0]."_".$i."@gmail.com";
            $user->type = 'student';
            $user->save();
            $i++;
            // if($i == 0){
            //     $i++;
            //     continue;
            // }
            // for ($c = 0; $c < $num; $c++) {
            //     $importData_arr[$i][] = $filedata[$c];
            // }
            // $i++;
            // $j = 0;
            // foreach($importData_arr as $importData){
            //     $j++;
            //     $user = new User();
            //     $user->username = $importData[0];
            //     $user->password = Hash::make($importData[1]);
            //     $user->name = $importData[2];
            //     $user->email = $i."-".$j."@gmail.com";
            //     $user->save();
            // }
        }
        return view('auth.register');
    }

    public function index()
    { 
        $user = Auth::id();

        $employee = DB::table('employees')
            ->where('users_id', '=', $user)
            ->select('id')
            ->get();

        $employeeData = json_decode( json_encode($employee), true);
   
        $designation = DB::table('designation_employees')
                        ->where('designation_employees.employees_id', '=', $employeeData[0]['id'])
                        ->select('designation_employees.designation_role', 'designation_employees.program_id')
                        ->get();

        $designationData = json_decode( json_encode($designation), true);
        
        if($designationData[0]['designation_role'] == "adviser"){
            return view('students.adviser');
        } elseif($designationData[0]['designation_role'] == "admission_staff"){
            return view('students.admission');
        } else {
            return view('students.adviser');
        }
    }

    public function ajaxIndex(){
        // $user = Auth::id();
        // $employee = DB::table('employees')
        //     ->where('users_id', '=', $user)
        //     ->select('id')
        //     ->get();

        // $employeeData = json_decode( json_encode($employee), true);
        
        // $designation = DB::table('designation_employees')
        //                 ->where('designation_employees.employees_id', '=', $employeeData[0]['id'])
        //                 ->select('designation_role as dr', 'program_id as dpi')
        //                 ->get();  

        //$designationData = json_decode( json_encode($designation), true);

        // if($designation[0]->dr == 'adviser' || $designation[0]->dr == 'program_head'){

        //     $orderByClause  = "CASE WHEN program.id = '" . $designation[0]->dpi . "' THEN 0 ELSE 1 END";

            $students = DB::table('incoming_students')
            ->join('program', 'incoming_students.course_prio', '=', 'program.id')
            ->select('incoming_students.*', 'program.short_name');
            
            //return response()->json($students);
            //->orderByRaw($orderByClause);
            //->orderBy('school_id', 'asc');

            if(request()->ajax()) {
                return DataTables::of($students)
                ->addColumn('fullname', function($row){
                        return $row->first_name.' '.$row->middle_name.' '.$row->last_name;
                    })
                ->filterColumn('fullname', function($students, $keyword){
                    $keywords = trim($keyword);
                    $students->whereRaw("CONCAT(first_name, middle_name, last_name) like ?", ["%{$keywords}%"]);
                })
                ->addColumn('action', function($row){
                    return
                '<a class="btn btn-primary btn-sm mx-1" 
                    id="viewStudent"
                    href="javascript:void(0)" 
                    role="button"
                    data-url="' . route('viewStudent', $row->id) . '">View</a> 
                <a  class="btn btn-primary btn-sm mx-1" 
                    id="viewAdvisee" 
                    href="javascript:void(0)" 
                    role="button" 
                    data-url="' . route('checkRequirements', $row->id) . '">Advise</a>
                <a  class="btn btn-primary btn-sm mx-1" 
                    id="viewEndorse" 
                    href="javascript:void(0)" 
                    role="button" 
                    data-url="' . route('checkRequirements', $row->id) . '">Endorse</a>';
                })
                ->rawColumns(['fullname', 'action'])
                ->addIndexColumn()
                ->make(true);
            }
        // } elseif ($designation[0]->dr == 'admission_staff' || $designation[0]->dr == 'admission_head') {

        //     $students = DB::table('incoming_students')
        //         ->join('program', 'incoming_students.course_prio', '=', 'program.id')
        //         ->select('incoming_students.*', 'program.description')
        //         ->orderBy('school_id', 'asc');

        //     if(request()->ajax()) {
        //         return DataTables::of($students)
        //         ->addColumn('fullname', function($row){
        //             return $row->first_name.' '.$row->middle_name.' '.$row->last_name;
        //         })
        //         ->filterColumn('fullname', function($students, $keyword){
        //             $keywords = trim($keyword);
        //             $students->whereRaw("CONCAT(first_name, middle_name, last_name) like ?", ["%{$keywords}%"]);
        //         })
        //         ->addColumn('action', function($row){
        //             return
        //                 '<a class="btn btn-primary btn-sm mx-1" 
        //                     id="viewStudent"
        //                     href="javascript:void(0)" 
        //                     role="button"
        //                     data-url="' . route('viewStudent', $row->id) . '">View</a> 
        //                 <a  class="btn btn-primary btn-sm mx-1" 
        //                     id="checkRequirements" 
        //                     href="javascript:void(0)" 
        //                     role="button" 
        //                     data-url="' . route('checkRequirements', $row->id) . '">Accept</a>';
        //         })
        //         ->rawColumns(['action'])
        //         ->addIndexColumn()
        //         ->make(true);
        //     }
        // }
        //return view('students.adviser');
    }

    public function requirements($id)
    {
        $student = IncomingStudent::find($id);
        
        //dd($student);

        return view('students.requirements')->with('student', $student);
    }
    
    public function checkRequirements($id)
    {
        $student = DB::table('incoming_students')
            ->select('*')
            ->where('id', $id)
            ->get();

        return response()->json($student);
    }

    

    public function forAdvising($id)
    {
        $student = DB::table('incoming_students')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'transfer_creds', 'clearance', 'remarks', 'is_accepted', 'is_advised')
            ->where('id', $id)
            ->get();

        return response()->json($student);
    }

    public function checkFiles(Request $request)
    {
        IncomingStudent::where('id', $request->input('reqIdHidden'))
            ->update([
                'student_profile' => $request->input('student_profile'),
                'suast_result' => $request->input('suast_result'),
                'form_138' => $request->input('form_138'),
                'als_pept' => $request->input('als_pept'),
                'good_moral' => $request->input('good_moral'),
                'nso_auth' => $request->input('nso_auth'),
                'marriage_contract' => $request->input('marriage_contract'),
                'id_picture' => $request->input('id_picture'),
                'long_b_env' => $request->input('long_b_env'),
                'win_env_stamp' => $request->input('win_env_stamp'),
                'remarks' => $request->input('remarks'),
            ]);
        return redirect('students');
    }

    public function info()
    {
        $programs = DB::table('program')->join('department','program.department_id','=','department.id')->
        where('department.id', '!=', 5)->select('*','program.id as pid')->get();
        $info = Student::where('users_id',Auth::user()->id)->first();
        $campus = Campus::all();
        if($info == null){
            $info = [
                'first_name' => '', 
                'middle_name' => '',
                'last_name' => '',
                'suffix' => '',
                'birthdate' => '',
                'birthplace' => '',
                'age' => '',
                'sex' => '',
                'civil_status' => '',
                'spouse_name' => '',
                'citizenship' => '',
                'height' => '',
                'weight' => '',
                'spouse_occupation' => '',
                'child_number' => '',
                'r_address' => '',
                'c_address' => '',
                'email' => '',
                'fb_account' => '',
                'contact_number' => '',
                'ethnic_group' => '',
                'religion' => '',
                'languages' => '',
                'is_working' => '',
                'working_for' => '',
                'fathers_name' => '| | | | ',
                'fathers_contact_number' => '',
                'fathers_address' => '',
                'fathers_employment' => '',
                'mothers_name' => '| | | | ',
                'mothers_contact_number' => '',
                'mothers_address' => '',
                'mothers_employment' => '',
                'parents_are' => '',
                'family_monthly_income' => '',
                'siblings' => '',
                'working_siblings' => '',
                'college_siblings' => '',
                'hs_siblings' => '',
                'guardian' => '',
                'guardians_number' => '',
                'guardian_address' => '',
                'gen_ability' => '',
                'spatial_apt' => '',
                'verbal_apt' => '',
                'perceptual_apt' => '',
                'numerical_apt' => '',
                'manual_dex' => '',
                'guardian_not_living_parents' => '',
                'elem_school' => '',
                'elem_year' => '',
                'high_school' => '',
                'strand' => '',
                'hs_year' => '',
                'vocational_school' => '',
                'vocational_year' => '',
                'vocational_course' => '',
                'honors' => '',
                'scholar' => '',
                'gctc_course' => '',
                'gctc_year' => '',
                'campus' => '',
                'course_prio' => '',
                'why_this_course' => '',
                'decide' => '',
                'why_dorsu' => '',
                'is_new' => '',
                'is_transferee' => '',
                'ambition_in_life' => '',
                'school_expectation' => '',
                'instructor_expectation' => '',
                'subject_like' => '',
                'course_expectation' => '',
                'student_expectation' => '',
                'subject_most_like' => '',
                'hobbies' => '',
                'motto' => '',
                'talent' => '',
                'interest' => '',
                'would_you_like_to_talk' => '',
                'lrn' => '',
                'selfassesment' => '',
                'bothers' => '',
                'profile' => '',
                'pwd' => '',
                'single_parent' => '',
                'working_student' => '',
                'embarrassing' => '',
                'friends' => '',
                'parents' => '',
                'teachers' => '',
                'counselors' => '',
            ];
        }
        return view('students.portal.admissionform',[
        'program'=>$programs,
        'info'=>$info, 
        'campus'=>$campus, 
        'firstname'=>openssl_decrypt($info->first_name,"AES-128-ECB",'itsuitsu'),
        'lastname'=>openssl_decrypt($info->last_name,"AES-128-ECB",'itsuitsu')]);
    }

    public function assign()
    {
        $assign_students = DB::table('incoming_students')
        ->join('program', 'incoming_students.course_prio', '=', 'program.id')
        ->select('incoming_students.*', 'program.major as course_1')        
        ->where('incoming_students.is_accepted', '=', 1)
        ->where('incoming_students.school_id', '=', NULL)
        ->orderBy('incoming_students.date_accepted', 'DESC')
        
        ->paginate(10);

        //dd($assign_students);
        return view('students.assign', [
            'assign_students' => $assign_students,
        ]);
    }

    public function assigned(){

        $students = DB::table('incoming_students')
            ->join('program', 'incoming_students.course_prio', '=', 'program.id')
            ->select('incoming_students.*', 'program.description')
            ->where('school_id', '!=',  'NULL');

        if(request()->ajax()) {
            return DataTables::of($students)
            ->addColumn('fullname', function($row){
                return $row->first_name.' '.$row->middle_name.' '.$row->last_name;
            })
            ->filterColumn('fullname', function($students, $keyword){
                $keywords = trim($keyword);
                $students->whereRaw("CONCAT(first_name, middle_name, last_name) like ?", ["%{$keywords}%"]);
            })
        
            ->rawColumns([])
            ->addIndexColumn()
            ->make(true);
        }
        return view('students.assigned');
    }

    public function ajaxAssigned(){
        $students = DB::table('incoming_students')
            ->join('program', 'incoming_students.course_prio', '=', 'program.id')
            ->select('incoming_students.*', 'program.short_name')
            ->where('school_id', '!=',  'NULL');

        if(request()->ajax()) {
            return DataTables::of($students)
            ->addColumn('fullname', function($row){
                return $row->first_name.' '.$row->middle_name.' '.$row->last_name;
            })
            ->filterColumn('fullname', function($students, $keyword){
                $keywords = trim($keyword);
                $students->whereRaw("CONCAT(first_name, middle_name, last_name) like ?", ["%{$keywords}%"]);
            })
        
            ->rawColumns([])
            ->addIndexColumn()
            ->make(true);
        }
    }

    public function accept(Request $request)
    {
        $accepted = 1;
        $currentDate = Carbon::now();

        IncomingStudent::where('id', $request->id)
            ->update([
                'is_accepted' => $accepted,
                'date_accepted' => $currentDate,
            ]);
        return redirect('students');
    }

    public function advise(Request $request)
    {
        $advised = 1;
        $currentDate = Carbon::now();


        IncomingStudent::where('id', $request->id)
            ->update([
                'is_advised' => $advised,
                'date_advised' => $currentDate,
            ]);
        return redirect('students');
    }

    public function endorse(Request $request)
    {

        IncomingStudent::where('id', $request->id)
            ->update([
                'course_prio' => $request->courseSelect,
                'course_second_prio' => $request->courseSelect2,
                'course_third_prio' => $request->courseSelect3,
            ]);

        return redirect('students');
    }

    public function updateSchoolID(Request $request)
    {
        $now = Carbon::now();
        $campus = IncomingStudent::select('campus')
            ->where('id', '=', $request->id)
            ->get();

        $prefix_for_id = '';

        if($campus[0]->campus == 'Main Campus(Mati)'){
            $prefix_for_id = $now->year;
        } elseif ($campus[0]->campus == 'Banaybanay Extension Campus') {
            $prefix_for_id = 'BE22';
        } elseif ($campus[0]->campus == 'Cateel Extension Campus') {
            $prefix_for_id = 'CE22';
        } elseif ($campus[0]->campus == 'San-Isidro Extension Campus') {
            $prefix_for_id = 'SE22';
        } elseif ($campus[0]->campus == 'Baganga Classes Campus') {
            $prefix_for_id = 'BC22';
        }

        
        $last_sid = DB::select('
            SELECT MAX(RIGHT(school_id, POSITION("-" IN school_id)-1)) 
            AS last_count FROM incoming_students 
            WHERE school_id like "' . $prefix_for_id . '-%"
        ');

        if($last_sid[0]->last_count == NULL){
            $counter = 1;
        } else {
            $counter = (int)$last_sid[0]->last_count + 1;
        }

        //$num = (int)$last_sid[0]->last_count + 1;
        //dd($last_sid);
        $school_id = $prefix_for_id . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

        IncomingStudent::where('id', $request->id)
            ->update([
                'school_id' => $school_id,
                'school_id_at' => $now->toDateString(),
            ]);

        return redirect('students/assign');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        
        return view('students.show')->with('student', $student);
    }

    public function viewStudent($id)
    {
        $student = IncomingStudent::find($id);

        return response()->json($student);
    }

    public function programList(){
        $programs = DB::table('program')
            ->select('*')
            ->get();

        return response()->json($programs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        IncomingStudent::where('id', $id)
            ->update(['school_id'=>$request->input('school_id')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function gctc()
    {
        return view('gctc.gctc');
    }
}

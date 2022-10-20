<?php

namespace App\Http\Controllers;

use App\Models\IncomingStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\App;
use App\Models\Program;
use App\Models\User;
use App\Models\Student;
use Validator;

class IncomingStudentsController extends Controller{
    public function index(){
        $programs = DB::table('program')->join('department','program.department_id','=','department.id')->
        where('department.id', '!=', 5)->select('*','program.id as pid')->get();
        return view('incomingstudents.stepbystep')->with('program',$programs);
    }

    public function StopNum(Request $req){
    session(['key'=>$req->key,'studenttype'=>$req->type]);
        return response()->json(['number'=>session('key'), 'type'=>session('studenttype')]);
    }

    public function GetNum(){
        return response()->json(['number'=>session('key'), 'type'=>session('studenttype'), 'transaction' => session('tracking')]);
    }
    
    public function create()
    {
        return view('incomingstudents.create');
    }
    
    public function studentform($id){
        return view('studentform')->with(['type'=>$id]);
    }
    
    public function accept(){
        session(['loged'=>true]);
        return response(true);
    }

    public function storeStudent(Request $request){
        $exist = collect(\DB::select("SELECT * FROM students WHERE users_id = ".Auth::user()->id))->first();
        $fathersname = $request['fafname'].'| '.$request['famname'].'| '.$request['falname'].'| ';
        if($request['fasuffix'] !== null){
            $fathersname .= $request['fasuffix'].'.';
        }
        $mothersname = $request['mofname'].'| '.$request['momname'].'| '.$request['molname'].'| ';
        if($request['mosuffix'] !== null){
            $mothersname .= $request['mosuffix'].'.';
        }
        $isnew = 0;
        $istransferee = 0;
        if($request['studtype'] === 'new'){
            $isnew = 1;
        }else if($request['studtype'] === 'transferee'){
            $istransferee = 1;
        }
        $msg = 'Sorry! we have some problem from database';
        $bool = false;
        $who = 'Friends: '.$request['friends'].', Parents: '.$request['parents'].', Teacher: '.$request['teachers'].', Councilors: '.$request['counselors'];
        $base64 = "";
        if($request->image !== null){
            $path = $request->image->getRealPath();
            $logo = file_get_contents($path);
            $base64 = base64_encode($logo);
        }else{
            $base64 = $request['hdn_image'];
        }
        if($exist == null){
            $newStud = new Student();
            $newStud->users_id = Auth::user()->id;
            $newStud->id = $request['studentId'];
            $newStud->first_name = $request['fname']; 
            $newStud->middle_name = $request['mname'];
            $newStud->last_name = $request['lname'];
            $newStud->suffix = $request['suffix'];
            $newStud->birthdate = $request['birthdate'];
            $newStud->birthplace = $request['birthplace'];
            $newStud->age = $request['age'];
            $newStud->sex = $request['gender'];
            $newStud->civil_status = $request['status'];
            $newStud->spouse_name = $request['spousename'];
            $newStud->citizenship = $request['citizenship'];
            $newStud->height = $request['height'];
            $newStud->weight = $request['weight'];
            $newStud->spouse_occupation = $request['spouseoccupation'];
            $newStud->child_number = $request['marriedchildren'];
            $newStud->r_address = $request['res-add'].'| '.$request['res-city'].'| '.$request['res-state'].'| '.$request['res-zip'];
            $newStud->c_address = $request['cur-add'].'| '.$request['cur-city'].'| '.$request['cur-state'].'| '.$request['cur-zip'];
            $newStud->email = $request['email'];
            $newStud->fb_account = $request['fbacc'];
            $newStud->contact_number = $request['contact'];
            $newStud->ethnic_group = $request['ethnic'];
            $newStud->religion = $request['religion'];
            $newStud->languages = $request['language'];
            $newStud->is_working = $request['wstudent'];
            $newStud->working_for = $request['detailemp'];
            $newStud->fathers_name = $fathersname;
            $newStud->fathers_contact_number = $request['facontact'];
            $newStud->fathers_address = $request['faaddress'];
            $newStud->fathers_employment = $request['fa-work'];
            $newStud->mothers_name = $mothersname;
            $newStud->mothers_contact_number = $request['mocontact'];
            $newStud->mothers_address = $request['moaddress'];
            $newStud->mothers_employment = $request['mo-work'];
            $newStud->parents_are = $request['optradio2'];
            $newStud->family_monthly_income = $request['famincome'];
            $newStud->siblings = $request['siblings'];
            $newStud->working_siblings = $request['wsiblings'];
            $newStud->college_siblings = $request['csiblings'];
            $newStud->hs_siblings = $request['hsiblings'];
            $newStud->guardian = $request['guardian'];
            $newStud->guardians_number = $request['gcontact'];
            $newStud->guardian_address = $request['gaddress'];
            $newStud->gen_ability = $request['genability'];
            $newStud->spatial_apt = $request['spatial'];
            $newStud->verbal_apt = $request['verbal'];
            $newStud->perceptual_apt = $request['perceptual'];
            $newStud->numerical_apt = $request['numerical'];
            $newStud->manual_dex = $request['manual'];
            $newStud->guardian_not_living_parents = $request['guardianliving'];
            $newStud->elem_school = $request['elemschool'];
            $newStud->elem_year = $request['elemyear'];
            $newStud->high_school = $request['secschool'];
            $newStud->strand = $request['strand'];
            $newStud->hs_year = $request['secyear'];
            $newStud->vocational_school = $request['vocschool'];
            $newStud->vocational_year = $request['vocyear'];
            $newStud->vocational_course = $request['voccourse'];
            $newStud->honors = $request['honors'];
            $newStud->scholar = $request['scholar'];
            $newStud->gctc_course = $request['gctccourse'];
            $newStud->gctc_year = $request['gctcyear'];
            $newStud->campus = $request['campus'];
            $newStud->course_prio = $request['firstcourse'];
            $newStud->why_this_course = $request['qcourse'];
            $newStud->decide = $request['decide'];
            $newStud->why_dorsu = $request['qenroll'];
            $newStud->is_new = $isnew;
            $newStud->is_transferee = $istransferee;
            $newStud->ambition_in_life = $request['qambition'];
            $newStud->school_expectation = $request['expectschool'];
            $newStud->instructor_expectation = $request['expectinstructor'];
            $newStud->subject_like = $request['expectsubjectleast'];
            $newStud->course_expectation = $request['expectcourse'];
            $newStud->student_expectation = $request['expectstudent'];
            $newStud->subject_most_like = $request['expectsubjectmost'];
            $newStud->hobbies = $request['hobbies'];
            $newStud->motto = $request['motto'];
            $newStud->talent = $request['talent'];
            $newStud->interest = $request['interest'];
            $newStud->lrn = $request['lrn'];
            $newStud->would_you_like_to_talk = $who;
            $newStud->selfassesment = json_encode($request['selfassesment']);
            $newStud->bothers = json_encode($request['bothers']);
            $newStud->profile = $base64;
            $newStud->pwd = $request['pwd'];
            $newStud->single_parent = $request['sparent'];
            $newStud->working_student = $request['wstudent'];
            $newStud->embarrassing = $request['embarrassing'];
            $newStud->friends = $request['friends'];
            $newStud->parents = $request['parents'];
            $newStud->teachers = $request['teachers'];
            $newStud->counselors = $request['counselors'];
            $newStud->save();
            $bool = true;
            $msg = "The information has been updated.";
            
        }else{ 
            Student::where('users_id',Auth::user()->id)->update([
                'first_name' => $request['fname'], 
                'middle_name' => $request['mname'],
                'last_name' => $request['lname'],
                'suffix' => $request['suffix'],
                'birthdate' => $request['birthdate'],
                'birthplace' => $request['birthplace'],
                'age' => $request['age'],
                'sex' => $request['gender'],
                'civil_status' => $request['status'],
                'spouse_name' => $request['spousename'],
                'citizenship' => $request['citizenship'],
                'height' => $request['height'],
                'weight' => $request['weight'],
                'spouse_occupation' => $request['spouseoccupation'],
                'child_number' => $request['marriedchildren'],
                'r_address' => $request['res-add'].'| '.$request['res-city'].'| '.$request['res-state'].'| '.$request['res-zip'],
                'c_address' => $request['cur-add'].'| '.$request['cur-city'].'| '.$request['cur-state'].'| '.$request['cur-zip'],
                'email' => $request['email'],
                'fb_account' => $request['fbacc'],
                'contact_number' => $request['contact'],
                'ethnic_group' => $request['ethnic'],
                'religion' => $request['religion'],
                'languages' => $request['language'],
                'is_working' => $request['wstudent'],
                'working_for' => $request['detailemp'],
                'fathers_name' => $fathersname,
                'fathers_contact_number' => $request['facontact'],
                'fathers_address' => $request['faaddress'],
                'fathers_employment' => $request['fa-work'],
                'mothers_name' => $mothersname,
                'mothers_contact_number' => $request['mocontact'],
                'mothers_address' => $request['moaddress'],
                'mothers_employment' => $request['mo-work'],
                'parents_are' => $request['optradio2'],
                'family_monthly_income' => $request['famincome'],
                'siblings' => $request['siblings'],
                'working_siblings' => $request['wsiblings'],
                'college_siblings' => $request['csiblings'],
                'hs_siblings' => $request['hsiblings'],
                'guardian' => $request['guardian'],
                'guardians_number' => $request['gcontact'],
                'guardian_address' => $request['gaddress'],
                'gen_ability' => $request['genability'],
                'spatial_apt' => $request['spatial'],
                'verbal_apt' => $request['verbal'],
                'perceptual_apt' => $request['perceptual'],
                'numerical_apt' => $request['numerical'],
                'manual_dex' => $request['manual'],
                'guardian_not_living_parents' => $request['guardianliving'],
                'elem_school' => $request['elemschool'],
                'elem_year' => $request['elemyear'],
                'high_school' => $request['secschool'],
                'strand' => $request['strand'],
                'hs_year' => $request['secyear'],
                'vocational_school' => $request['vocschool'],
                'vocational_year' => $request['vocyear'],
                'vocational_course' => $request['voccourse'],
                'honors' => $request['honors'],
                'scholar' => $request['scholar'],
                'gctc_course' => $request['gctccourse'],
                'gctc_year' => $request['gctcyear'],
                'campus' => $request['campus'],
                'course_prio' => $request['firstcourse'],
                'why_this_course' => $request['qcourse'],
                'decide' => $request['decide'],
                'why_dorsu' => $request['qenroll'],
                'is_new' => $isnew,
                'is_transferee' => $istransferee,
                'ambition_in_life' => $request['qambition'],
                'school_expectation' => $request['expectschool'],
                'instructor_expectation' => $request['expectinstructor'],
                'subject_like' => $request['expectsubjectleast'],
                'course_expectation' => $request['expectcourse'],
                'student_expectation' => $request['expectstudent'],
                'subject_most_like' => $request['expectsubjectmost'],
                'hobbies' => $request['hobbies'],
                'motto' => $request['motto'],
                'talent' => $request['talent'],
                'interest' => $request['interest'],
                'would_you_like_to_talk' => $who,
                'lrn' => $request['lrn'],
                'selfassesment' => $request['selfassesment'],
                'bothers' => $request['bothers'],
                'profile' => $base64,
                'pwd' => $request['pwd'],
                'single_parent' => $request['sparent'],
                'working_student' => $request['wstudent'],
                'embarrassing' => $request['embarrassing'],
                'friends' => $request['friends'],
                'parents' => $request['parents'],
                'teachers' => $request['teachers'],
                'counselors' => $request['counselors'],
            ]);
            $msg = "The information has been updated.";
            $bool = true;
        }
        return response()->json(['success'=>$bool,'msg'=>$msg]);
    }
    
    public function store(Request $request)
    {
        $newStud = new IncomingStudent();
        $newStud->first_name = $request['fname']; 
        $newStud->middle_name = $request['mname'];
        $newStud->last_name = $request['lname'];
        $newStud->suffix = $request['suffix'];
        $newStud->birthdate = $request['birthdate'];
        $newStud->age = $request['age'];
        $newStud->sex = $request['gender'];
        $newStud->civil_status = $request['status'];
        $newStud->spouse_name = $request['spousename'];
        $newStud->citizenship = $request['citizenship'];
        $newStud->height = $request['height'];
        $newStud->weight = $request['weight'];
        $newStud->spouse_occupation = $request['spouseoccupation'];
        $newStud->child_number = $request['marriedchildren'];
        $newStud->r_address = $request['res-add'].'| '.$request['res-city'].'| '.$request['res-state'].'| '.$request['res-zip'];
        $newStud->c_address = $request['cur-add'].'| '.$request['cur-city'].'| '.$request['cur-state'].'| '.$request['cur-zip'];
        $newStud->email = $request['email'];
        $newStud->fb_account = $request['fbacc'];
        $newStud->contact_number = $request['contact'];
        $newStud->ethnic_group = $request['ethnic'];
        $newStud->religion = $request['religion'];
        $newStud->languages = $request['language'];
        $newStud->is_working = $request['wstudent'];
        $newStud->working_for = $request['detailemp'];
        $fathersname = $request['fafname'].'| '.$request['famname'].'| '.$request['falname'].'| ';
        if($request['fasuffix'] !== null){
            $fathersname .= $request['fasuffix'].'.';
        }
        $mothersname = $request['mofname'].'| '.$request['momname'].'| '.$request['molname'].'| ';
        if($request['mosuffix'] !== null){
            $mothersname .= $request['mosuffix'].'.';
        }
        if($request['studtype'] === 'new'){
            $newStud->is_new = 1;
        }else if($request['studtype'] === 'transferee'){
            $newStud->is_transferee = 1;
        }
        $newStud->fathers_name = $fathersname;
        $newStud->fathers_contact_number = $request['facontact'];
        $newStud->fathers_address = $request['faaddress'];
        $newStud->fathers_employment = $request['fa-work'];
        $newStud->mothers_name = $mothersname;
        $newStud->mothers_contact_number = $request['mocontact'];
        $newStud->mothers_address = $request['moaddress'];
        $newStud->mothers_employment = $request['mo-work'];
        $newStud->parents_are = $request['optradio2'];
        $newStud->family_monthly_income = $request['famincome'];
        $newStud->siblings = $request['siblings'];
        $newStud->working_siblings = $request['wsiblings'];
        $newStud->college_siblings = $request['csiblings'];
        $newStud->hs_siblings = $request['hsiblings'];
        $newStud->guardian = $request['guardian'];
        $newStud->guardians_number = $request['gcontact'];
        $newStud->guardian_address = $request['gaddress'];
        $newStud->gen_ability = $request['genability'];
        $newStud->spatial_apt = $request['spatial'];
        $newStud->verbal_apt = $request['verbal'];
        $newStud->perceptual_apt = $request['perceptual'];
        $newStud->numerical_apt = $request['numerical'];
        $newStud->manual_dex = $request['manual'];
        $newStud->guardian_not_living_parents = $request['guardianliving'];
        $newStud->elem_school = $request['elemschool'];
        $newStud->elem_year = $request['elemyear'];
        $newStud->high_school = $request['secschool'];
        $newStud->strand = $request['strand'];
        $newStud->hs_year = $request['secyear'];
        $newStud->vocational_school = $request['vocschool'];
        $newStud->vocational_year = $request['vocyear'];
        $newStud->vocational_course = $request['voccourse'];
        $newStud->honors = $request['honors'];
        $newStud->scholar = $request['scholar'];
        $newStud->gctc_course = $request['gctccourse'];
        $newStud->gctc_year = $request['gctcyear'];
        $newStud->campus = $request['campus'];
        $newStud->course_prio = $request['firstcourse'];
        $newStud->course_second_prio = $request['secondcourse'];
        $newStud->course_third_prio = $request['thirdcourse'];
        $newStud->why_this_course = $request['qcourse'];
        $newStud->decide = $request['decide'];
        $newStud->why_dorsu = $request['qenroll'];
        $newStud->ambition_in_life = $request['qambition'];
        $newStud->school_expectation = $request['expectschool'];
        $newStud->instructor_expectation = $request['expectinstructor'];
        $newStud->subject_like = $request['expectsubjectleast'];
        $newStud->course_expectation = $request['expectcourse'];
        $newStud->student_expectation = $request['expectstudent'];
        $newStud->subject_most_like = $request['expectsubjectmost'];
        $newStud->hobbies = $request['hobbies'];
        $newStud->motto = $request['motto'];
        $newStud->talent = $request['talent'];
        $newStud->interest = $request['interest'];
        $newStud->pwd = $request['pwd'];
        $newStud->single_parent = $request['sparent'];
        $newStud->working_student = $request['wstudent'];
        $base64 = '';
        if($request->image !== null){
            $path = $request->image->getRealPath();
            $logo = file_get_contents($path);
            $base64 = base64_encode($logo);
            $newStud->profile = $base64;
        }
        $newStud->selfassesment = $request->selfassesment;
        $newStud->bothers = $request->bothers;
        $who = 'Friends: '.$request['friends'].', Parents: '.$request['parents'].', Teacher: '.$request['teacher'].', Councilors: '.$request['counselors'];
        $newStud->would_you_like_to_talk = $who;
        $tracking = time().''.rand(0,99);
        $newStud->transaction_number = $tracking;
        $newStud->embarrassing = $request['embarrassing'];
        $newStud->friends = $request['friends'];
        $newStud->parents = $request['parents'];
        $newStud->teachers = $request['teachers'];
        $newStud->counselors = $request['counselors'];
        $newStud->save();
        session(['path' => $path, 'tracking' => $tracking]);
        return response()->json(['transaction'=>$tracking,'success'=>true]);
    }

    public function uploadreq(Request $request){
        $adProfile = ''; $formOne = ''; $goodMoral = ''; $psa = ''; $marriage = ''; $husband = ''; $rog =''; $tor =''; $honorable = '';
        if($request->admissionProfile != ""){ 
            $adProfile = $request->admissionProfile->getClientOriginalName();
            $request->admissionProfile->move(session("path"),$adProfile);
        }
        if($request->formOne != ""){ 
            $formOne = $request->formOne->getClientOriginalName();
            $request->formOne->move(session("path"),$formOne);
        }
        if($request->goodMoral != ""){ 
            $goodMoral = $request->goodMoral->getClientOriginalName();
            $request->goodMoral->move(session("path"),$goodMoral);
        }
        if($request->psa != ""){ 
            $psa = $request->psa->getClientOriginalName();
            $request->psa->move(session("path"),$psa);
        }
        if($request->marriage != ""){ 
            $marriage = $request->marriage->getClientOriginalName();
            $request->marriage->move(session("path"),$marriage);
        }
        if($request->husband != ""){ 
            $husband = $request->husband->getClientOriginalName();
            $request->husband->move(session("path"),$husband);
        }
        if($request->rog != ""){ 
            $rog = $request->rog->getClientOriginalName();
            $request->rog->move(session("path"),$rog);
        }
        if($request->tor != ""){ 
            $tor = $request->tor->getClientOriginalName();
            $request->tor->move(session("path"),$tor);
        }
        if($request->honorable != ""){ 
            $honorable = $request->honorable->getClientOriginalName();
            $request->honorable->move(session("path"),$honorable);
        }
        DB::update('UPDATE incoming_students SET admission=?,psa_husband=?,form_138=?,good_moral=?,nso_auth=?,marriage_contact=?,transcript_records=?,transfer_creds=?,last_sem_grades=? where transaction_number = ?',
        [$adProfile,$husband,$formOne,$goodMoral,$psa,$marriage,$tor,$honorable,$rog,session('tracking')]);
        //$request->file->move(session('path'),$filename);
        return response()->json(['success'=>"The file has been uploaded",'file'=>"EHOSER","path"=>session("path")]);
    }


    public function showView(){
        $photo = Student::All();
        // return response()->json($photo);
        return view('students.portal.sample',['photo'=>$photo]);
    }

    public function searchticket(Request $req){
        $student = DB::table('incoming_students')->where('transaction_number',$req->search)->first();
        return response()->json($student);
    }

    public function show($id)
    {
        $incoming_student = IncomingStudent::find($id);
        return view('incomingstudents.show')->with('incoming_student', $incoming_student);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lessons;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Validator;
use Hash;
use DB;
class UserController extends Controller
	{
	public function index(){	
		return view('auth.login');
	}
	public function register(){		
		if(session()->has('loggedInUser')){
			return redirect('/layouts.dashboard');
		}else{
			return view('auth.register');
		}
	}

	public function dashboard(){
		return view('layouts.dashboard');
	}
	public function home(){	
		return view('layouts.home');
	}

	public function saveUser(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email'=> 'required',
			'password'=> 'required|min:5|max:50',
			'cpassword'=> 'required|min:5|same:password',

		],[
			'cpassword.same' => 'Password did not match',
			'cpassword.required' => 'Confirm password is required',

		]);
		if($validator->fails()){
			return response()->json(['status'=>400,'message'=> $validator->getMessageBag()]);
		}else{
			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->password = Hash::make($request->password);
			$user->save();

			return response()->json(['status'=>200,'message'=> 'Registered Successfully']);
		}
	}
	public function loginUser(Request $request){
		$validator = Validator::make($request->all(), [
			'email'=> 'required|email',
			'password'=> 'required|min:5|max:50',
		]);
		if($validator->fails()){
			return 	response()->json([
				'status'=>400,
				'message'=> $validator->getMessageBag(),
			]);
		}else{
			$user = User::where('email', $request->email)->first();
			if($user){
				if(Hash::check($request->password, $user->password)){
					$request->session()->put('loggedInUser', ['userid'=>$user->id,'name'=>$user->name]);
					return response()->json(['status'=>200, 'message'=>'success']);
				}
				else{
					return response()->json(['status'=>401, 'message'=>'E-mail or password is incorrect!']);
				}
			}
			else{
				return response()->json(['status'=>401, 'message'=>'User not found!']);
			}
		}
	}
	public function lessonRecords(){
        $lessons = Lessons::where('deleted_at', '0')->get();
        return view('layouts.lessons', compact('lessons'));
    }
	public function addLesson(Request $request){
		$validator = Validator::make($request->all(), [
			'course_name' => 'required',
			'from'=> 'required',
			'to'=> 'required',
			'instructor'=> 'required',

		]);
		if($validator->fails()){
			return response()->json(['status'=>400,'message'=> $validator->getMessageBag()]);
		}else{
			$lessons = new Lessons();
			$lessons->course_name = $request->course_name;
			$lessons->from = $request->from;
			$lessons->to = $request->to;
			$lessons->instructor = $request->instructor;
			$lessons->save();

			return response()->json(['status'=>200,'message'=> 'Add Successfully']);
		}
	}
	public function editDeleteLesson(Request $request){
		if($request->type == 'edit'){
			$validator = Validator::make($request->all(), [
				'course_name' => 'required',
				'from'=> 'required',
				'to'=> 'required',
				'instructor'=> 'required',
	
			]);
			if($validator->fails()){
				return response()->json(['status'=>400,'message'=> $validator->getMessageBag()]);
			}else{
				Lessons::where('id', $request->id)->update([
					'course_name'=>$request->course_name,
					'from'=>$request->from,
					'to'=>$request->to,
					'instructor'=>$request->instructor,
				]);
				return response()->json(['status'=>200,'message'=> 'Save Successfully']);
			}	
		}elseif($request->type == 'gen_cert'){
			$cert = new Certificate();
			$cert->user_id = $request->user_id;
			$cert->lesson_id = $request->lesson_id;
			$cert->date_completed = $request->date_completed;
			$cert->save();

			return response()->json(['status'=>200,'message'=> 'Registered Successfully']);
		}
		else{
			Lessons::where('id', $request->id)->update([
				'deleted_at'=> time()
			]);
			return response()->json(['status'=>200,'message'=> 'Save Successfully']);
		}
	
	}
	public function viewLesson($id){
		$lessonDetails = Lessons::where('id', $id)->get()->toArray();
		$arr = [];
		foreach ($lessonDetails as $key => $value) {
			$arr = [
				'id'=>$value['id'],
				'course_name' =>$value['course_name'],
				'from'=>$value['from'],
				'to'=>$value['to'],
				'instructor'=>$value['instructor'],
			];
		}
		return view('layouts.viewlesson', compact('arr'));

	}
	public function certificates(){	
		$id = request()->session()->get('loggedInUser')['userid'];
		$certificat =DB::table('certificates')
		->select('users.name','lessons.course_name', 'certificates.*')
		->leftJoin('users', 'certificates.user_id', '=', 'users.id')
		->leftJoin('lessons', 'certificates.lesson_id', '=', 'lessons.id')
		->where('certificates.user_id', $id)
		->where('lessons.deleted_at', 0)
		->get();
		// $arr = [];
		// foreach ($certificat as $key => $value) {
		// 	$arr[] = [
		// 		'id'=>$value['id'],
		// 		'user_id'=>$value['user_id'],
		// 		'lesson_id'=>$value['lesson_id'],
		// 		'date_completed'=>$value['date_completed'],
		// 		'deleted_at'=>$value['deleted_at'],
		// 	];
		// }
        return view('layouts.certificates', compact('certificat'));
	}
	public function viewCert($id){
		$certDetails = DB::table('certificates')
		->select('users.name','lessons.course_name', 'lessons.from','lessons.deleted_at as les_del','certificates.*')
		->leftJoin('users', 'certificates.user_id', '=', 'users.id')
		->leftJoin('lessons', 'certificates.lesson_id', '=', 'lessons.id')
		->where('certificates.id', $id)
		->get();
		$arr = [];
		foreach ($certDetails as $value) {
			$arr =[
				'name'=> $value->name,
				'course_name'=>$value->course_name,
				'from'=>$value->from,
				'date_completed'=>$value->date_completed,
			];
		}

		return view('layouts.viewcert', compact('arr'));

	}
	public function logout(){
		if(session()->has('loggedInUser')){
			session()->pull('loggedInUser');
			return redirect('/');
		}

	}
}

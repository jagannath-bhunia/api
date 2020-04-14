<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Employee;
use Illuminate\Support\Facades\Auth; 
use Validator;
use DB;
class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
           
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'mobile' => ['required','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required', 
            'password_confirmation' => 'required|same:password', 
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 


    public function logout() 
    { 
        if (Auth::check()) {
           // $user->tokens()->where('id', Auth::user()->id)->delete();
            //Auth::user()->AauthAcessToken()->delete();
            DB::table('oauth_access_tokens')->where('user_id', '=', Auth::user()->id)->delete();
            $status[0]='logout sucessfully';
            $status[1]="1";
         }else{
            $status[0]='Alredy logout';
            $status[1]="0";
         }
        
      
     
    return response()->json(['status' => $status], $this-> successStatus);
    }

/** 
     * showbyid api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function showbyid($id){
        $user = Employee::find($id);
        return response()->json($user);
    }


/** 
     * insert api 
     * 
     * @return \Illuminate\Http\Response 
     */
    
    public function insert(Request $request){
        $request->validate([
            'name'=>'required',
            'details'=>'required',
            'salary'=>'required',
        ]);
        $users = new Employee();
        $users->name = $request->input('name');
        $users->details = $request->input('details');
        $users->salary = $request->input('salary');
        $users->save();
        return response()->json($users);

    }
/** 
     * update api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function update(Request $request){
        $id= $request->id;
        
        $name = $request->input('name');
        $details = $request->input('details');
        $salary = $request->input('salary');
        $user=DB::table('employees')->where('id',$id)->update(['name' =>$name,'details' =>$details,'salary'=>$salary]);

        return response()->json($user);
    }
/** 
     * delete api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function delete(Request $request){
       $id=$request->id;

        $user=DB::table('employees')->where('id',$id)->delete();
        
        return response()->json($user);

    }
}
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderBy('id','ASC')->paginate(100);
        return view('backend.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'string|required|max:30',
            'email'=>'string|required|unique:users',
            'password'=>'string|required',
            'role'=>'required|in:admin,user,envoy',
            'status'=>'required|in:active,inactive',
            'region'=>'required|in:store1,store2',
        ]);
        // dd($request->all());
        $data=$request->all();
        $data['password']=Hash::make($request->password);
        // dd($data);
        $status=User::create($data);
        // dd($status);
       
        if($status){
            request()->session()->flash('success','تم اضافة مستخدم بنجاح ');
        }
        else{
            request()->session()->flash('error','حدث خطا اثنا الاضافة ');
        }
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        return view('backend.users.edit')->with('user',$user);
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
        $user=User::findOrFail($id);
        $request->validate([
            'name'=>'string|required|max:30',
            'email'=>'string|required',
            'role'=>'required|in:admin,user,envoy',
            'status'=>'required|in:active,inactive',
            'region'=>'required|in:store1,store2',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        $data['password']=Hash::make($request->password);
        
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','تم التعديل بنجاح');
        }
        else{
            request()->session()->flash('error','حدث خطا اثناء التعديل ');
        }
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $delete=User::findorFail($id);
    //     $status=$delete->delete();
    //     if($status){
    //         request()->session()->flash('success','User Successfully deleted');
    //     }
    //     else{
    //         request()->session()->flash('error','There is an error while deleting users');
    //     }
    //     return redirect()->route('users.index');
    // }



    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}

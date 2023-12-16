<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class AdminAdminController extends Controller
{
    public function index()
    {
        $currentUserId = Auth::id();
        $positionObject = DB::table('admins')->select('position')->where('user_id', $currentUserId)->first();
        $position = $positionObject->position;
        $admins = DB::table('admins')
            ->join('users', 'admins.user_id', '=', 'users.id')
            ->select('admins.*', 'users.name', 'users.email')
            ->where('admins.position', '>', $position)
            ->orderBy('admins.id', 'ASC')
            ->get();

        $data = ['admins' => $admins];
        return view('admins.admins.index', $data);
    }

    public function create()
    {
        $admins = Admin::pluck('user_id')->toArray();
        $users = User::whereNotIn('id',$admins)->orderBy('id','ASC')->get();
        $data = ['users' => $users];
        return view('admins.admins.create',$data);
    }

    public function create_selcted($user)
    {
        $admins = Admin::pluck('user_id')->toArray();
        $users = User::whereNotIn('id',$admins)->orderBy('id','ASC')->get();
        $user_selected = User::where('id',$user)->first();
        $data = [
            'users' => $users,
            'user_selected' => $user_selected,
        ];
        return view('admins.admins.create_selected',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'position' => 'required',
        ]);

        Admin::create($request->all());
        return redirect()->route('admins.admins.index');
    }

    public function store_level(Request $request)
    {
        $user_id = $request->input('user_id');
        $position = $request->input('position');


        Admin::create([
            'user_id' => $user_id,
            'position' => $position,
        ]);
        return redirect()->route('admins.admins.index');
    }


    public function edit(Admin $admin)
    {
        $data = [
            'admin'=> $admin,
        ];
        return view('admins.admins.edit',$data);
    }

    public function update(Request $request, Admin $admin)
    {
        $this->validate($request,[
            'position' => 'required',
        ]);

        $admin->update($request->all());
        return redirect()->route('admins.admins.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.admins.index');
    }
}

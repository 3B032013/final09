<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $users = User::orderby('id','ASC')->paginate($perPage);
        $data = ['users' => $users];
        return view('admins.users.index',$data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);
        // 搜尋會員資料
        $users = User::where('email', 'like', "%$query%")
            ->orWhere('name', 'like', '%' . $query . '%')
            ->orWhere('sex', 'like', '%' . $query . '%')
            ->orWhere('phone', 'like', '%' . $query . '%')
            ->paginate($perPage);

        // 返回結果
        return view('admins.users.index', [
            'users' => $users,
            'query' => $query,
        ]);
    }

    public function create()
    {
        return view('admins.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:20',
            'sex' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        User::create($request->all());
        return redirect()->route('admins.users.index');
    }

    public function edit(User $user)
    {
        $data = [
            'user'=> $user,
        ];
        return view('admins.users.edit',$data);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => 'required|max:20',
            'sex' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $user->update($request->all());
        return redirect()->route('admins.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admins.users.index');
    }
}

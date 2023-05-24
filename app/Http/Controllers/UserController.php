<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereNotIn('name', ['administrator'])->get();
        if (request()->ajax()) {
            return datatables($users)
            ->editColumn('option', 'users.partials.action')
            ->rawColumns(['option'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('users.index', ['users'=>$users]);
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
        $data = request()->validate([
            'email'=>['string', 'required', 'unique:users'],
            'name' => ['string', 'required'],
        ]);
        $data['password'] = Hash::make('sdfasdqweqwfsafasfas');
        User::create($data);

        return redirect()->back()->with('success', 'User created! Email sent for creating password');
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

    public function changePassword()
    {
        return view('users.change-password');
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

    public function update(User $user)
    {
        $data = request()->validate([
            'email'=>['string', 'required', Rule::unique('users')->ignore($user->id)],
            'name' => ['string', 'required'],
        ]);

        $user->update($data);

        return redirect()->back()->with('success', 'User updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(User $user)
    {
        $data = request()->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);
        if (! Hash::check($data['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password incorrect');
        }
        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->back()->with('success', 'Password changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User deleted');
    }
}

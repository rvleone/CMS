<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loggedId =Auth::id();
        $users = User::paginate(10);
        return view('admin.users.index', [
            'users' => $users,
            'loggedId'=> intval($loggedId)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'email', 'password', 'password_confirmation');
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], $messages = [
                'name.required' => 'O Nome é obrigatório',
                'email.required' => 'O E-mail é obrigatório',
                'email.email' => 'O E-mail é inválido',
                'email.unique' => 'O E-mail já existe',
                'password.required' => 'A Senha é obrigatório',
                'password.confirmed' => 'A Senha está diferente do Confirmar Senha',
            ]);
        if ($validator->fails()) {
            return redirect()->route('users.create')->withErrors($validator)->withInput();
        }
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return redirect()->route('users.index')->with('success', '');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('admin.users.edit', ['user' => $user]);
        }
        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $data = $request->only(['name', 'email', 'password', 'password_confirmation']);
            $validator = Validator::make([
                'name' => $data['name'],
                'email' => $data['email'],
            ], [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'string', 'max:255']
            ]);
            if ($validator->fails()) {
                return redirect()->route('users.edit', ['user' => $id])->withErrors($validator)->withInput();
            }
            $user->name = $data['name'];
            if ($user->email != $data['email']) {
                $hasEmail = User::where('email', $data['email'])->get();
                if (count($hasEmail) === 0) {
                    $user->email = $data['email'];
                } else {
                    $validator->errors()->add('email', __('validation.unique', [
                        'attribute' => 'email'
                    ]));
                }
            }
            if (!empty($data['password'])) {
                if (strlen($data['password']) >= 6) {
                    if ($data['password'] === $data['password_confirmation']) {
                        $user->password = Hash::make($data['password']);
                    } else {
                        $validator->errors()->add('password', __('validation.confirmed', [
                            'attribute' => 'password',
                        ]));
                    }
                } else {
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 6
                    ]));
                }
            }
            if (count($validator->errors()) > 0) {
                return redirect()->route('users.edit', ['user' => $id])
                    ->withErrors($validator)->withInput();
            }
        }
        $user->save();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $loggedId = intval(Auth::id());
        if ($loggedId !== intval($id)) {
            $user = User::find($id);
            $user->delete();
        }
        return redirect()->route('users.index');
    }
}

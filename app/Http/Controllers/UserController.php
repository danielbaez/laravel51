<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Company;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::all();
    	$users = User::orderBy('id')->paginate(8);
    	//dd(User::find(1)->company->name);
    	return View('panel.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::orderBy('CO_COMPANY_ID', 'desc')->lists('CO_NAME', 'CO_COMPANY_ID');
        return view('panel.users.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'name'      => 'required|max:100',
            'email'     => 'required|email',
            'password'  => 'required|confirmed',
            'type'      => 'required|in:1,2,3',
            'country'      => 'required|in:pe,mx',
            'company_id'  => ($request->get('type') == 3) ? 'required' : "",
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => \Hash::make($request->get('password')),
            'type' => $request->get('type'),
            'country' => $request->get('country'),
            'company_id' => ($request->get('type') == 3) ? $request->get('company_id') : 0,
            'active' => $request->has('active') ? 1 : 0,
            'method_call' => ($request->get('type') != 3) ? $request->get('method_call') : '',
            'phone_pe' => ($request->get('type') != 3) ? $request->get('phone_pe') : '',
            'phone_mx' => ($request->get('type') != 3) ? $request->get('phone_mx') : '',
        ]);
        
        $message = $user ? 'Usuario agregado correctamente!' : 'El usuario NO pudo agregarse!';
        
        return redirect()->route('user.index')->with('message', $message);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

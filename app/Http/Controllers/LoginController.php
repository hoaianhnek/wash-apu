<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends StatusController
{   

    #region [index]
    /**
     * Display the index page of the application.
     *
     * This function checks if an admin user is authenticated. If not, it redirects to the login page; otherwise, it redirects to the order management page.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse The view for the login page or a redirect response to the order management page.
    */
    public function index()
    {   
        // if (!Auth::guard('admin')->check()) {
        //     return view("login.index");
        // }
        return redirect('/kd0100l');
    }
    #endregion

    #region [login]
    /**
     * Process the user login request.
     *
     * This function validates the user's input for email and password. If the validation fails, it returns errors with the input data. If the validation succeeds, it attempts to log in the user based on the provided credentials, checking the 'flg_del' field for user status. If login is successful, it returns a success response; otherwise, it returns an error response.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing user input.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response A redirect response to the login page with errors or a success response based on the login result.
    */
    public function login(Request $request)
    {   
        $rules = [
            'login_id' => 'required',
            'password' => 'required',
        ];
    
        $messages = [
            'login_id.required' => $this->messageService->get('E0000'),
            'password.required' => $this->messageService->get('E0000'),
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('login_id', 'password');
        if(Auth::attempt(
                [
                    'login_id' => $credentials['login_id'], 
                    'password' =>  $credentials['password'],
                    'flg_del' => function ($query) {
                        $query->Where(function ($query2) {
                            $query2->where('flg_del','<>',1)->orwhere('flg_del','=',null);
                        });
                    }
                ])
        ){
            return $this->successResponse($this->messageService->get('S0000')); 
        }
        else {
            return $this->errorResponse($this->messageService->get('E0000'));
        }
    }
    #endregion

    #region [logout]
    /**
     * Log the user out and redirect to the homepage.
     *
     * This function logs the authenticated user out, effectively ending their session, and then redirects them to the homepage or the default landing page.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect response to the homepage or the default landing page.
    */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
    #endregion
}
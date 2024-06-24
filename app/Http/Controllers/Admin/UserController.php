<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Customer::orderBy('id','desc');
        if(isset($_GET['user_name']) && !empty($_GET['user_name'])){
            $users = $users->where('name', 'like', '%'.$_GET['user_name'].'%');
        }
        if(isset($_GET['email']) && !empty($_GET['email'])){
            $users = $users->where('email', 'like', '%'.$_GET['email'].'%');
        }
        if(isset($_GET['phone']) && !empty($_GET['phone'])){
            $users = $users->where('phone', 'like', '%'.$_GET['phone'].'%');
        }
        if(isset($_GET['aadhaar']) && !empty($_GET['aadhaar'])){
            $users = $users->where('aadhaar', 'like', '%'.$_GET['aadhaar'].'%');
        }
        $data['users'] = $users->paginate(10);
        return view('admin.user.index', $data);
    }


}

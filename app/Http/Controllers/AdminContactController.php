<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class AdminContactController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $contacts = Contact::orderby('id','ASC')->paginate($perPage);
        $data = ['contacts' => $contacts];
        return view('admins.contacts.index',$data);
    }

    public function show(Contact $contact)
    {
        $data = [
            'contact'=> $contact,
        ];
        return view('admins.contacts.show',$data);
    }
}

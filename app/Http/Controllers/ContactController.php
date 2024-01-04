<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
//        $validatedData = $request->validate([
//            'title' => 'required|string|max:255',
//            'name' => 'required|string|max:255',
//            'email' => 'required|email|max:255',
//            'phone-number' => 'required|string|max:255',
//            'message' => 'required|string',
//        ]);

        $contact = new Contact();
        $contact->title = $request['title'];
        $contact->name = $request['name'];
        $contact->email = $request['email'];
        $contact->phone = $request['phone-number'];
        $contact->content = $request['message'];

        $contact->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}

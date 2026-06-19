<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $contact = Contact::create([
        'name' => $request->name,
        'name_company' => $request->name_company,
        'email' => $request->email,
        'phone' => $request->phone,
        'project_type' => $request->project_type,
        'message' => $request->message,
    ]);

    Mail::to('youssefghazzar15@gmail.com')
        ->send(new ContactMail($contact));

    return response()->json([
        'success' => true,
        'message' => 'Message envoyé avec succès'
    ], 201);
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
    public function update(Request $request, Contact $contact)
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

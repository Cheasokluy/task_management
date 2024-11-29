<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Return the user dashboard or a list of user-specific resources
        return view('user.dashboard');
    }

    public function create()
    {
        // Return a form for creating new user-specific resources
        return view('user.create');
    }

    public function store(Request $request)
    {
        // Logic to store user-specific resources
        // Example:
        // Resource::create($request->all());
        return redirect()->route('user.index')->with('success', 'Resource created successfully.');
    }

    public function show($id)
    {
        // Display a specific resource associated with the user
        return view('user.show', compact('id'));
    }

    public function edit($id)
    {
        // Return a form to edit a specific user resource
        return view('user.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update a specific resource
        // Example:
        // $resource = Resource::find($id);
        // $resource->update($request->all());
        return redirect()->route('user.index')->with('success', 'Resource updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete a specific resource
        // Example:
        // Resource::destroy($id);
        return redirect()->route('user.index')->with('success', 'Resource deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService)
    {
    }

    public function index(Request $request): View
    {
        $search   = $request->input('search');
        $contacts = $this->contactService->getAllContacts($search);
        return view('contacts.index', compact('contacts', 'search'));
    }

    public function create(): View
    {
        return view('contacts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:contacts,email',
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'company' => 'nullable|string|max:255',
        ]);

        $this->contactService->createContact($data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact): View
    {
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact): View
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:contacts,email,' . $contact->id,
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'company' => 'nullable|string|max:255',
        ]);

        $this->contactService->updateContact($contact, $data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $this->contactService->deleteContact($contact);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}

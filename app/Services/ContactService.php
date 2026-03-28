<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactService
{
    public function getAllContacts(?string $search = null): LengthAwarePaginator
    {
        $query = Contact::orderBy('name');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->paginate(10)->withQueryString();
    }

    public function createContact(array $data): Contact
    {
        return Contact::create($data);
    }

    public function updateContact(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    public function deleteContact(Contact $contact): void
    {
        $contact->delete();
    }
}

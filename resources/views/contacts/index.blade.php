@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Contacts</h1>
        <p class="page-subtitle">Click on a row to view details</p>
    </div>
    <span class="badge">{{ $contacts->total() }} total</span>
</div>

{{-- Search bar --}}
<form method="GET" action="{{ route('contacts.index') }}" class="search-form" role="search">
    <div class="search-input-wrap">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input
            type="search"
            name="search"
            class="search-input"
            placeholder="Search by name, email, company, phone…"
            value="{{ $search ?? '' }}"
            autocomplete="off"
        >
        @if($search)
            <a href="{{ route('contacts.index') }}" class="search-clear" title="Clear search">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </a>
        @endif
    </div>
    <button type="submit" class="btn btn-secondary">Search</button>
</form>

@if($search)
    <p class="search-results-info">
        @if($contacts->total() > 0)
            <strong>{{ $contacts->total() }}</strong> result{{ $contacts->total() > 1 ? 's' : '' }} for "<em>{{ $search }}</em>"
        @else
            No results for "<em>{{ $search }}</em>"
        @endif
    </p>
@endif

@if($contacts->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        @if($search)
            <p>No contacts match your search.</p>
            <a href="{{ route('contacts.index') }}" class="btn btn-ghost">Clear search</a>
        @else
            <p>No contacts yet.</p>
            <a href="{{ route('contacts.create') }}" class="btn btn-primary">Add your first contact</a>
        @endif
    </div>
@else
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr class="row-clickable" data-href="{{ route('contacts.show', $contact) }}">
                    <td data-label="Name">
                        <div class="contact-name">
                            <span class="avatar">{{ mb_strtoupper(mb_substr($contact->name, 0, 1)) }}</span>
                            <strong>{{ $contact->name }}</strong>
                        </div>
                    </td>
                    <td data-label="Email">{{ $contact->email }}</td>
                    <td data-label="Phone">{{ $contact->phone ?? '—' }}</td>
                    <td data-label="Company">{{ $contact->company ?? '—' }}</td>
                    <td data-label="Actions" class="col-actions" onclick="event.stopPropagation()">
                        <div class="action-group">
                            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                onclick="openDeleteModal('{{ addslashes($contact->name) }}', '{{ route('contacts.destroy', $contact) }}')"
                            >Delete</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $contacts->links() }}
    </div>
@endif

{{-- Delete confirmation modal --}}
<div class="modal-overlay" id="deleteModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal">
        <div class="modal-icon modal-icon-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h2 class="modal-title" id="modalTitle">Delete contact</h2>
        <p class="modal-body">Are you sure you want to delete <strong id="modalContactName"></strong>? This action cannot be undone.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn-ghost" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Yes, delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.row-clickable').forEach(function(row) {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href;
        });
    });

    function openDeleteModal(name, action) {
        document.getElementById('modalContactName').textContent = name;
        document.getElementById('deleteForm').action = action;
        document.getElementById('deleteModal').classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('is-open');
        document.body.style.overflow = '';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endsection

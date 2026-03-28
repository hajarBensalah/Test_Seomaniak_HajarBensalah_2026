@extends('layouts.app')

@section('title', $contact->name)

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <a href="{{ route('contacts.index') }}" class="back-link">← Back to contacts</a>
        <h1 class="page-title">{{ $contact->name }}</h1>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-secondary">Edit</a>
        <button
            type="button"
            class="btn btn-danger"
            onclick="openDeleteModal('{{ addslashes($contact->name) }}', '{{ route('contacts.destroy', $contact) }}')"
        >Delete</button>
    </div>
</div>

<div class="card">
    <div class="detail-grid">
        <div class="detail-item">
            <span class="detail-label">Full Name</span>
            <span class="detail-value">{{ $contact->name }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Email Address</span>
            <span class="detail-value">
                <a href="mailto:{{ $contact->email }}" class="link">{{ $contact->email }}</a>
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Phone</span>
            <span class="detail-value">{{ $contact->phone ?? '—' }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Company</span>
            <span class="detail-value">{{ $contact->company ?? '—' }}</span>
        </div>

        <div class="detail-item detail-item-full">
            <span class="detail-label">Address</span>
            <span class="detail-value">{{ $contact->address ?? '—' }}</span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Created</span>
            <span class="detail-value">
                {{ $contact->created_at->format('M d, Y') }}
                <span class="detail-time">at {{ $contact->created_at->format('H:i') }}</span>
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Last Updated</span>
            <span class="detail-value">
                {{ $contact->updated_at->format('M d, Y') }}
                <span class="detail-time">at {{ $contact->updated_at->format('H:i') }}</span>
            </span>
        </div>
    </div>
</div>

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

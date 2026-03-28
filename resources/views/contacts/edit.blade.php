@extends('layouts.app')

@section('title', 'Edit — ' . $contact->name)

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <a href="{{ route('contacts.index') }}" class="back-link">← Back to contacts</a>
        <h1 class="page-title">Edit Contact</h1>
    </div>
</div>

<div class="card">
    <form action="{{ route('contacts.update', $contact) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name', $contact->name) }}"
                    required
                    autofocus
                >
                @error('name')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address <span class="required">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input @error('email') is-invalid @enderror"
                    value="{{ old('email', $contact->email) }}"
                    required
                >
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone" class="form-label">Phone</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-input @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $contact->phone) }}"
                >
                @error('phone')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="company" class="form-label">Company</label>
                <input
                    type="text"
                    id="company"
                    name="company"
                    class="form-input @error('company') is-invalid @enderror"
                    value="{{ old('company', $contact->company) }}"
                >
                @error('company')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="form-label">Address</label>
            <textarea
                id="address"
                name="address"
                class="form-input form-textarea @error('address') is-invalid @enderror"
                rows="3"
            >{{ old('address', $contact->address) }}</textarea>
            @error('address')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('contacts.show', $contact) }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
@endsection

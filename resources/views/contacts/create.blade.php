@extends('layouts.app')

@section('title', 'New Contact')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <a href="{{ route('contacts.index') }}" class="back-link">← Back to contacts</a>
        <h1 class="page-title">New Contact</h1>
    </div>
</div>

<div class="card">
    <form action="{{ route('contacts.store') }}" method="POST" class="form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="John Doe"
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
                    value="{{ old('email') }}"
                    placeholder="john@example.com"
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
                    value="{{ old('phone') }}"
                    placeholder="+1 (555) 000-0000"
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
                    value="{{ old('company') }}"
                    placeholder="Acme Inc."
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
                placeholder="123 Main St, City, Country"
                rows="3"
            >{{ old('address') }}</textarea>
            @error('address')
                <span class="error-msg">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('contacts.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Contact</button>
        </div>
    </form>
</div>
@endsection

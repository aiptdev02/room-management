@csrf

<div class="row">
    <div class="col-md-4 mb-3">
        <label>Name <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $guest->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Phone <span class="text-danger">*</span></label>
        <input type="text" name="phone" value="{{ old('phone', $guest->phone ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $guest->email ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Aadhar Number <span class="text-danger">*</span></label>
        <input type="text" name="aadhar_number" value="{{ old('aadhar_number', $guest->aadhar_number ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $guest->date_of_birth ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Father's Name</label>
        <input type="text" name="father_name" value="{{ old('father_name', $guest->father_name ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Father's Phone</label>
        <input type="text" name="father_phone" value="{{ old('father_phone', $guest->father_phone ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Mother's Name</label>
        <input type="text" name="mother_name" value="{{ old('mother_name', $guest->mother_name ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Mother's Phone</label>
        <input type="text" name="mother_phone" value="{{ old('mother_phone', $guest->mother_phone ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Emergency Contact Number</label>
        <input type="text" name="emergency_number" value="{{ old('emergency_number', $guest->emergency_number ?? '') }}" class="form-control">
    </div>

    <div class="col-md-12 mb-3">
        <label>Permanent Address</label>
        <textarea name="permanent_address" class="form-control">{{ old('permanent_address', $guest->permanent_address ?? '') }}</textarea>
    </div>

    <div class="col-md-4 mb-3">
        <label>Occupation</label>
        <input type="text" name="occupation" value="{{ old('occupation', $guest->occupation ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Joining Date</label>
        <input type="date" name="joining_date" value="{{ old('joining_date', $guest->joining_date ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Expected Stay Duration (Months)</label>
        <input type="number" name="expected_stay_duration" value="{{ old('expected_stay_duration', $guest->expected_stay_duration ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>Monthly Rent Amount</label>
        <input type="number" step="0.01" name="rent_amount" value="{{ old('rent_amount', $guest->rent_amount ?? '') }}" class="form-control">
    </div>

    <div class="col-md-12 mb-3">
        <label>Notes</label>
        <textarea name="notes" class="form-control">{{ old('notes', $guest->notes ?? '') }}</textarea>
    </div>

    <div class="col-md-4 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" {{ old('status', $guest->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="left" {{ old('status', $guest->status ?? '') == 'left' ? 'selected' : '' }}>Left</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>Profile Photo</label>
        <input type="file" name="photo" class="form-control">
        @if(!empty($guest->photo))
            <img src="{{ asset('storage/' . $guest->photo) }}" width="100" class="mt-2">
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label>Aadhar Front Photo</label>
        <input type="file" name="aadhar_front_photo" class="form-control">
        @if(!empty($guest->aadhar_front_photo))
            <img src="{{ asset('storage/' . $guest->aadhar_front_photo) }}" width="100" class="mt-2">
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label>Aadhar Back Photo</label>
        <input type="file" name="aadhar_back_photo" class="form-control">
        @if(!empty($guest->aadhar_back_photo))
            <img src="{{ asset('storage/' . $guest->aadhar_back_photo) }}" width="100" class="mt-2">
        @endif
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('paying-guests.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

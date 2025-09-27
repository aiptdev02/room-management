@extends('masteradmin.layout')

@section('title', 'Room Details')

@section('content')
    <div class="py-4">
        <!-- Breadcrumb and Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Rooms List</h2>
            <a href="{{ route('tenents.index') }}" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left"></i>
                Back</a>
        </div>

        <table class="table table-bordered" id="rooms-table">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Rent</th>
                    <th>Floor</th>
                    <th>Occupied</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $properties->total_rooms; $i++)
                    @php
                        $room = $rooms[$i] ?? null;
                    @endphp
                    <tr data-room-id="{{ $room->id ?? '' }}">
                        <td>
                            <input name="room_number" data-field="room_number" type="text"
                                class="form-control input-room_number"
                                value="{{ old('room_number', $room->room_number ?? 101 + $i) }}">
                            <div class="field-error text-danger small mt-1" data-field="room_number" style="display:none;">
                            </div>
                        </td>

                        <td>
                            <input name="room_type" data-field="room_type" type="text"
                                class="form-control input-room_type" value="{{ old('room_type', $room->room_type ?? '') }}">
                            <div class="field-error text-danger small mt-1" data-field="room_type" style="display:none;">
                            </div>
                        </td>

                        <td>
                            <input name="rent" data-field="rent" type="number" step="0.01"
                                class="form-control input-rent" value="{{ old('rent', $room->rent ?? '') }}">
                            <div class="field-error text-danger small mt-1" data-field="rent" style="display:none;"></div>
                        </td>

                        <td>
                            <input name="floor" data-field="floor" type="text" class="form-control input-floor"
                                value="{{ old('floor', $room->floor ?? '') }}">
                            <div class="field-error text-danger small mt-1" data-field="floor" style="display:none;"></div>
                        </td>

                        <td class="text-center">
                            <input name="is_occupied" data-field="is_occupied" class="form-check-input input-is_occupied"
                                type="checkbox" {{ old('is_occupied', $room->is_occupied ?? false) ? 'checked' : '' }}>
                            <div class="field-error text-danger small mt-1" data-field="is_occupied" style="display:none;">
                            </div>
                        </td>

                        <td>
                            <input type="hidden" class="input-property_id" value="{{ $properties->id }}">

                            <button class="btn btn-sm btn-success save-room" data-store-url="{{ route('tenents.store') }}"
                                data-update-url="{{ $room ? route('tenents.update', $room->id) : '' }}"
                                data-method="{{ $room ? 'PUT' : 'POST' }}">
                                {!! $room ? '<i class="fa-solid fa-pen-to-square"></i>' : 'Save' !!}
                            </button>

                            {{-- fallback row-level feedback (used if server error isn't field specific) --}}
                            <div class="row-feedback mt-1 small text-danger" style="display:none;"></div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div id="rooms-global-alert" style="position: fixed; top: 10px; right: 10px; z-index: 9999;"></div>

    </div>
@endsection

@section('page_script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function showGlobalAlert(message, type = 'success', timeout = 4000) {
                const wrapper = document.getElementById('rooms-global-alert');
                const el = document.createElement('div');
                el.className = `alert alert-${type} alert-dismissible fade show`;
                el.style.minWidth = '220px';
                el.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
                wrapper.appendChild(el);
                setTimeout(() => el.remove(), timeout);
            }

            function clearRowErrors(tr) {
                tr.querySelectorAll('.field-error').forEach(e => {
                    e.style.display = 'none';
                    e.innerText = '';
                });
                tr.querySelectorAll('.is-invalid').forEach(inp => inp.classList.remove('is-invalid'));
                const rowFeedback = tr.querySelector('.row-feedback');
                if (rowFeedback) {
                    rowFeedback.style.display = 'none';
                    rowFeedback.innerText = '';
                }
            }

            function showFieldErrors(tr, errors) {
                // errors is an object: { fieldName: [msg1, msg2], ... }
                let shownAny = false;
                for (const [field, messages] of Object.entries(errors)) {
                    // try to find input by data-field
                    const input = tr.querySelector(`[data-field="${field}"]`);
                    const errEl = tr.querySelector(`.field-error[data-field="${field}"]`);
                    const msg = Array.isArray(messages) ? messages[0] : messages;

                    if (input) {
                        input.classList.add('is-invalid');
                        if (errEl) {
                            errEl.style.display = 'block';
                            errEl.innerText = msg;
                        }
                        shownAny = true;
                    } else {
                        // fallback: show in row-feedback area
                        const rowFeedback = tr.querySelector('.row-feedback');
                        if (rowFeedback) {
                            rowFeedback.style.display = 'block';
                            rowFeedback.innerText = msg;
                            shownAny = true;
                        }
                    }
                }
                return shownAny;
            }

            document.querySelectorAll('.save-room').forEach(btn => {
                btn.addEventListener('click', async function(e) {
                    e.preventDefault();
                    const button = e.currentTarget;
                    const tr = button.closest('tr');

                    clearRowErrors(tr);

                    // collect values from the row
                    const property_id = tr.querySelector('.input-property_id').value;
                    const room_number = tr.querySelector('[data-field="room_number"]').value
                        .trim();
                    const room_type = tr.querySelector('[data-field="room_type"]').value.trim();
                    const rent = tr.querySelector('[data-field="rent"]').value;
                    const floor = tr.querySelector('[data-field="floor"]').value.trim();
                    const is_occupied = tr.querySelector('[data-field="is_occupied"]').checked ?
                        1 : 0;

                    // basic client validation
                    if (!property_id || !room_number || !room_type || !capacity) {
                        // set small messages under fields that are empty
                        if (!room_number) {
                            const el = tr.querySelector(
                                `.field-error[data-field="room_number"]`);
                            el.style.display = 'block';
                            el.innerText = 'Room number is required.';
                            tr.querySelector('[data-field="room_number"]').classList.add(
                                'is-invalid');
                        }
                        if (!room_type) {
                            const el = tr.querySelector(`.field-error[data-field="room_type"]`);
                            el.style.display = 'block';
                            el.innerText = 'Room type is required.';
                            tr.querySelector('[data-field="room_type"]').classList.add(
                                'is-invalid');
                        }
                        if (!capacity) {
                            const el = tr.querySelector(`.field-error[data-field="capacity"]`);
                            el.style.display = 'block';
                            el.innerText = 'Capacity is required.';
                            tr.querySelector('[data-field="capacity"]').classList.add(
                                'is-invalid');
                        }
                        return;
                    }

                    const method = button.dataset.method || 'POST';
                    let url = (method.toUpperCase() === 'PUT' && button.dataset.updateUrl) ?
                        button.dataset.updateUrl : button.dataset.storeUrl;

                    const payload = {
                        property_id,
                        room_number,
                        room_type,
                        rent: rent || null,
                        floor: floor || null,
                        is_occupied,
                    };

                    const originalText = button.innerHTML;
                    button.disabled = true;
                    button.innerText = (method === 'PUT') ? 'Updating...' : 'Saving...';

                    try {
                        const res = await fetch(url, {
                            method: method.toUpperCase(),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        if (res.status === 422) {
                            const json = await res.json();
                            const errors = json.errors || {};
                            // show per-field errors under inputs
                            showFieldErrors(tr, errors);
                            button.disabled = false;
                            button.innerHTML = originalText;
                            return;
                        }

                        if (!res.ok) {
                            const txt = await res.text();
                            showGlobalAlert('Server error: ' + (txt || res.statusText),
                                'danger', 5000);
                            button.disabled = false;
                            button.innerHTML = originalText;
                            return;
                        }

                        const data = await res.json();
                        showGlobalAlert(data.message || 'Saved', 'success');

                        // If new room created, update row attributes & button for future updates
                        if (data.room && data.room.id) {
                            tr.setAttribute('data-room-id', data.room.id);

                            if (data.update_url) {
                                button.dataset.updateUrl = data.update_url;
                                button.dataset.method = 'PUT';
                                button.innerText = 'Update';
                            } else {
                                button.dataset.method = 'PUT';
                                button.innerText = 'Update';
                            }
                        }

                        // update fields with returned normalized data if available
                        if (data.room) {
                            tr.querySelector('[data-field="room_number"]').value = data.room
                                .room_number ?? tr.querySelector('[data-field="room_number"]')
                                .value;
                            tr.querySelector('[data-field="room_type"]').value = data.room
                                .room_type ?? tr.querySelector('[data-field="room_type"]')
                                .value;
                            tr.querySelector('[data-field="rent"]').value = data.room.rent ?? tr
                                .querySelector('[data-field="rent"]').value;
                            tr.querySelector('[data-field="floor"]').value = data.room.floor ??
                                tr.querySelector('[data-field="floor"]').value;
                            tr.querySelector('[data-field="is_occupied"]').checked = (data.room
                                .is_occupied ?? is_occupied) ? true : false;
                        }

                    } catch (err) {
                        console.error(err);
                        showGlobalAlert('Network error. Check console for details', 'danger',
                            5000);
                    } finally {
                        button.disabled = false;
                        if (!button.innerText || button.innerText === 'Saving...' || button
                            .innerText === 'Updating...') {
                            button.innerText = (button.dataset.method === 'PUT') ? 'Update' :
                                'Save';
                        }
                    }
                });
            });
        });
    </script>
@endsection

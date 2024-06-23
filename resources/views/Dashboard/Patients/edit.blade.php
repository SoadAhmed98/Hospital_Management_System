<!-- Modal -->
<div class="modal fade" id="edit{{ $patient->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Patients.update', $patient->id) }}" method="post">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <label for="exampleInputPassword1">Patient Name</label>
                    <input type="hidden" name="id" value="{{ $patient->id }}">
                    <input type="text" name="name" value="{{ $patient->name }}" class="form-control">
                    <br>
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" name="email" value="{{ $patient->email }}" class="form-control">
                    <br>
                    <label for="exampleInputPassword1">Phone</label>
                    <input type="text" name="phone" value="{{ $patient->phone }}" class="form-control">
                    <br>
                    <label for="exampleInputPassword1">Birth Date</label>
                    <input type="date" name="birth_date" value="{{ $patient->birth_date }}" class="form-control">
                    <br>
                    <label for="exampleInputPassword1">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="mail" {{ $patient->gender === 'mail' ? 'selected' : '' }}>Male</option>
                        <option value="femail" {{ $patient->gender === 'femail' ? 'selected' : '' }}>Female</option>
                    </select>
                    <br>
                    <label for="exampleInputPassword1">Blood Group</label>
                    <select name="blood_group" class="form-control">
                        <option value="A+" {{ $patient->blood_group === 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ $patient->blood_group === 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ $patient->blood_group === 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ $patient->blood_group === 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ $patient->blood_group === 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ $patient->blood_group === 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ $patient->blood_group === 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ $patient->blood_group === 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

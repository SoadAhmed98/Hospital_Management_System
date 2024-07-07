<!-- Edit Department Modal -->
<div class="modal fade" id="edit{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDepartmentForm{{ $department->id }}" autocomplete="off">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <!-- Department Name -->
                    <label for="name">Department Name</label>
                    <input type="hidden" name="id" value="{{ $department->id }}">
                    <input type="text" name="name" value="{{ $department->name }}" id="name{{ $department->id }}" class="form-control">
                    <div class="invalid-feedback" id="nameError{{ $department->id }}"></div>
                    <br>

                    <!-- Department Description -->
                    <label for="description">Department Description</label>
                    <input type="text" name="description" value="{{ $department->description }}" id="description{{ $department->id }}" class="form-control">
                    <div class="invalid-feedback" id="descriptionError{{ $department->id }}"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitEditBtn{{ $department->id }}" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitEditBtn{{ $department->id }}').addEventListener('click', function() {
        let form = document.getElementById('editDepartmentForm{{ $department->id }}');
        let formData = new FormData(form);
        
        fetch('{{ route('Departments.update', $department->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                if (data.errors.name) {
                    document.getElementById('name{{ $department->id }}').classList.add('is-invalid');
                    document.getElementById('nameError{{ $department->id }}').innerText = data.errors.name[0];
                } else {
                    document.getElementById('name{{ $department->id }}').classList.remove('is-invalid');
                    document.getElementById('nameError{{ $department->id }}').innerText = '';
                }
                
                if (data.errors.description) {
                    document.getElementById('description{{ $department->id }}').classList.add('is-invalid');
                    document.getElementById('descriptionError{{ $department->id }}').innerText = data.errors.description[0];
                } else {
                    document.getElementById('description{{ $department->id }}').classList.remove('is-invalid');
                    document.getElementById('descriptionError{{ $department->id }}').innerText = '';
                }
            } else {
                location.reload(); // Reload the page to reflect changes
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

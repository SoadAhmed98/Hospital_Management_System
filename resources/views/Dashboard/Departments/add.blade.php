<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addDepartmentForm" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <!-- Department Name -->
                    <label for="name">Department Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="invalid-feedback" id="nameError"></div>
                    <br>

                    <!-- Department Description -->
                    <label for="description">Department Description</label>
                    <input type="text" name="description" id="description" class="form-control">
                    <div class="invalid-feedback" id="descriptionError"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitBtn').addEventListener('click', function() {
        let form = document.getElementById('addDepartmentForm');
        let formData = new FormData(form);
        
        fetch('{{ route('Departments.store') }}', {
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
                    document.getElementById('name').classList.add('is-invalid');
                    document.getElementById('nameError').innerText = data.errors.name[0];
                } else {
                    document.getElementById('name').classList.remove('is-invalid');
                    document.getElementById('nameError').innerText = '';
                }
                
                if (data.errors.description) {
                    document.getElementById('description').classList.add('is-invalid');
                    document.getElementById('descriptionError').innerText = data.errors.description[0];
                } else {
                    document.getElementById('description').classList.remove('is-invalid');
                    document.getElementById('descriptionError').innerText = '';
                }
            } else {
                location.reload(); // Reload the page to reflect changes
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

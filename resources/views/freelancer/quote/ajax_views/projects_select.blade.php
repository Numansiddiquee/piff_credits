<label class="fs-6 fw-semibold mb-2">Select Project</label>
<select class="form-select form-select-sm" name="project" id="project" data-control="select2">
    @if(count($projects) > 0)
        <option value="" selected disabled>Select or Create a Project</option>
        @foreach($projects as $project)
            <option value="{{ $project->id }}">{{ $project->project_name}}</option>
        @endforeach
    @else
        <option value="" selected disabled>No Projects Found</option>
        <option value="create_project" > + Create a Project</option>
    @endif
</select>
<script>
    $('#project').select2();
    function AddProject(){

    }

    $('#project').on('change', function () {
        if ($(this).val() === "create_project") {
            $(this).val(null).trigger('change'); // Reset the select
            window.location.href = "{{ route('admin.project.create')}}";
        }
    });
</script>

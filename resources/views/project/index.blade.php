@extends('master')
@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-10">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Projects</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Projects</a></li>
                            </ul>
                        </div>
                        <div class="col-md-2 text-md-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="ti ti-plus me-2"></i>
                            </button>
                            {{-- <a href="#" class="btn btn-primary">
                                <i class="ti ti-plus me-2"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <h5 class="mb-3">Projects List</h5>
                    <div class="card tbl-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-border mb-0">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>NAME</th>
                                        <th>URL</th>
                                        <th>Webhook Token</th>
                                        <th>Package</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($projects as $project)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$project->name}}</td>
                                                <td><a href="{{$project->project_url}}" target="_blank">{{$project->project_url}}</a></td>
                                                <td class="px-4 py-3.5">
                                                    <div class="flex items-center gap-2">
                                                        <code class="copy-token cursor-pointer bg-light border px-2 py-1 rounded text-primary" 
                                                            data-token="{{$project->webhook_token}}"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="Click to copy">
                                                            {{$project->webhook_token}}
                                                        </code>
                                                        
                                                        <i class="bi bi-clipboard text-muted"></i>
                                                    </div>
                                                </td>
                                                <td>{{$project->package->name}}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="edit-project-btn" 
                                                        data-id="{{ $project->id }}"
                                                        data-name="{{ $project->name }}"
                                                        data-url="{{ $project->project_url }}"
                                                        data-token="{{ $project->webhook_token }}"
                                                        data-package="{{ $project->package_id }}">
                                                            <span class="align-items-center gap-2">
                                                                <i class="ti ti-pencil text-warning f-5 m-r-5"></i>
                                                            </span>
                                                    </a>
                                                    <a href="{{route('project.delete',$project->id)}}" onclick="return confirm('Are you sure you want to delete this project?')">
                                                        <span class="align-items-center gap-2"><i
                                                        class="ti ti-trash text-danger f-5 m-r-5"></i>
                                                        </span>
                                                    </a>

                                                    <a href="{{route('project.sync.config',$project->id)}}">
                                                        <span class=" align-items-center gap-2"><i
                                                        class="ti ti-brand-telegram text-primary f-5 m-r-5"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>  
                                        @empty
                                            <tr>
                                                <td colspan="5"> NO DATA FOUND </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('project.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="projectName" class="form-label">Project Name</label>
                            <input type="text" class="form-control" name="projectName">
                        </div>
                        <div class="mb-3">
                            <label for="ProjectUrl" class="form-label">Project URL</label>
                            <input type="url" class="form-control" name="projectUrl">
                        </div>
                        <div class="mb-3">
                            <label for="webhookToken" class="form-label">Webhook Token</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="webhookToken" id="webhookToken" readonly>
                                <button class="btn btn-outline-secondary" type="button" id="generateTokenBtn">
                                    <i class="bi bi-arrow-clockwise"></i> Generate
                                </button>
                            </div>
                            <small class="text-muted">Click generate to create a secure 64-character token.</small>
                        </div>
                        <div class="mb-3">
                            <label for="PackageId" class="form-label">Package</label>
                            <select name="package_id" id="package_id" class="form-control">
                                <option value="">Select Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- edit modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProjectForm" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" name="projectName" id="edit_projectName">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project URL</label>
                            <input type="url" class="form-control" name="projectUrl" id="edit_projectUrl">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Webhook Token</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="webhookToken" id="edit_webhookToken" readonly>
                                <button class="btn btn-outline-secondary generateTokenBtn" type="button">
                                    <i class="bi bi-arrow-clockwise"></i> Generate
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Package</label>
                            <select name="package_id" id="edit_package_id" class="form-control">
                                <option value="">Select Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
        <script>
            document.querySelectorAll('.copy-token').forEach(element => {
                element.addEventListener('click', function() {
                    const token = this.getAttribute('data-token');
                    
                    // 1. Try modern Clipboard API
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(token)
                            .then(() => showSuccess(this))
                            .catch(err => console.error('Modern copy failed', err));
                    } else {
                        // 2. Fallback for HTTP / Older Browsers
                        const textArea = document.createElement("textarea");
                        textArea.value = token;
                        
                        // Ensure the textarea is not visible or disruptive
                        textArea.style.position = "fixed";
                        textArea.style.left = "-9999px";
                        textArea.style.top = "0";
                        document.body.appendChild(textArea);
                        
                        textArea.focus();
                        textArea.select();
                        
                        try {
                            const successful = document.execCommand('copy');
                            if (successful) showSuccess(this);
                        } catch (err) {
                            console.error('Fallback copy failed', err);
                        }
                        
                        document.body.removeChild(textArea);
                    }
                });
            });

            // Helper function for visual feedback
            function showSuccess(element) {
                const tooltip = bootstrap.Tooltip.getInstance(element);
                if (tooltip) {
                    tooltip.setContent({ '.tooltip-inner': 'Copied!' });
                    setTimeout(() => {
                        tooltip.setContent({ '.tooltip-inner': 'Click to copy' });
                    }, 2000);
                }
            }
        </script>

        <script>
            document.getElementById('generateTokenBtn').addEventListener('click', function() {
                const btn = this;
                const input = document.getElementById('webhookToken');

                // Disable button and show loading state
                btn.disabled = true;
                btn.innerHTML = 'Generating...';

                fetch("{{ route('project.generateToken') }}")
                    .then(response => response.json())
                    .then(data => {
                        // Assuming your controller returns { "token": "random_string" }
                        input.value = data.token;
                        
                        // Re-enable button
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Generate';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                        btn.disabled = false;
                        btn.innerHTML = 'Generate';
                    });
            });
        </script>
        <script>
    document.querySelectorAll('.edit-project-btn').forEach(button => {
        button.addEventListener('click', function() {
            // 1. Get data from button attributes
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const url = this.getAttribute('data-url');
            const token = this.getAttribute('data-token');
            const packageId = this.getAttribute('data-package');

            // 2. Set the Form Action dynamically
            // Replace '0' with the actual ID in the route string
            let urlAction = "{{ route('project.update', ':id') }}";
            urlAction = urlAction.replace(':id', id);
            document.getElementById('editProjectForm').setAttribute('action', urlAction);

            // 3. Fill the input fields
            document.getElementById('edit_projectName').value = name;
            document.getElementById('edit_projectUrl').value = url;
            document.getElementById('edit_webhookToken').value = token;
            document.getElementById('edit_package_id').value = packageId;

            // 4. Show the modal
            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    });

    // Share the Token Generation logic for both modals
    document.querySelectorAll('.generateTokenBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const currentBtn = this;
            // Find the input field relative to the button clicked
            const input = currentBtn.closest('.input-group').querySelector('input');

            currentBtn.disabled = true;
            fetch("{{ route('project.generateToken') }}")
                .then(response => response.json())
                .then(data => {
                    input.value = data.token;
                    currentBtn.disabled = false;
                });
        });
    });
</script>
    @endpush

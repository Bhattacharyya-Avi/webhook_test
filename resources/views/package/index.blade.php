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
                                <h5 class="m-b-10">Packages</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Packages</a></li>
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
                    <h5 class="mb-3">Package List</h5>
                    <div class="card tbl-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-border mb-0">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>NAME</th>
                                        <th>CONFIGS</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($packages as $package)
                                        
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$package->name}}</td>
                                                <td>
                                                    @foreach($package->config as $keyName=>$config)
                                                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis px-3 py-2">
                                                            {{$keyName}}={{$config}}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="edit-package-btn" 
                                                        data-id="{{ $package->id }}"
                                                        data-name="{{ $package->name }}"
                                                        data-config='@json($package->config)'>
                                                            <span class="align-items-center gap-2">
                                                                <i class="ti ti-pencil text-warning f-5 m-r-5"></i>
                                                            </span>
                                                    </a>
                                                    <a href="{{route('package.delete',$package->id)}}">
                                                        <span class="align-items-center gap-2"><i
                                                        class="ti ti-trash text-danger f-5 m-r-5"></i>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Packages</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('package.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="packageName" class="form-label">Package Name</label>
                            <input type="text" class="form-control" name="packageName">
                        </div>
                        <h5 class="title" >Configs</h5>
                        <hr>
                        @foreach ($packageKey as $key)
                            <div class="mb-3">
                                <label for="ProjectUrl" class="form-label">{{$key['level']}}</label>
                                <input type="hidden" class="form-control" value="{{$key['key']}}" name="keyName[]">
                                <input type="number" class="form-control" name="keyValue[]">
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit modal  --}}

    <div class="modal fade" id="editPackageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Package</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPackageForm" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Package Name</label>
                            <input type="text" class="form-control" name="packageName" id="edit_packageName">
                        </div>

                        <h5 class="title">Configs</h5>
                        <hr>

                        @foreach ($packageKey as $key)
                            <div class="mb-3">
                                <label class="form-label">{{ $key['level'] }}</label>
                                <input type="hidden" name="keyName[]" value="{{ $key['key'] }}">
                                <input type="number" 
                                    class="form-control config-input" 
                                    name="keyValue[]" 
                                    data-key="{{ $key['key'] }}">
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Update Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.edit-package-btn').forEach(button => {
            button.addEventListener('click', function() {
                // 1. Extract data
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const config = JSON.parse(this.getAttribute('data-config')); // Parse the JSON string

                // 2. Update Form Action
                let urlAction = "{{ route('package.update', ':id') }}";
                urlAction = urlAction.replace(':id', id);
                document.getElementById('editPackageForm').setAttribute('action', urlAction);

                // 3. Fill Name
                document.getElementById('edit_packageName').value = name;

                // 4. Fill Config Inputs
                // We loop through all inputs with the class 'config-input'
                document.querySelectorAll('.config-input').forEach(input => {
                    const key = input.getAttribute('data-key');
                    // If the key exists in our config object, set the value
                    input.value = config[key] ? config[key] : '';
                });

                // 5. Show Modal
                new bootstrap.Modal(document.getElementById('editPackageModal')).show();
            });
        });
    </script>
@endpush

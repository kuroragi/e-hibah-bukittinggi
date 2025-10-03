<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Permission</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Permission</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleLargeModal"><i class="bi bi-plus-lg"></i> Tambah</button>
                <!-- Modal -->
                <div wire:ignore.self class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light">Tambah permission</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="permissionName" class="form-label">Nama Permission</label>
                                            <input wire:model='name' type="text" class="form-control"
                                                id="permissionName" placeholder="Masukkan nama permission">
                                        </div>
                                        <div class="mb-3">
                                            <label for="guard_name" class="form-label">Guard Name</label>
                                            <select wire:model='guard_name' class="form-control" id="guard_name">
                                                <option value="web">Pilih Guard Name</option>
                                                <option selected value="web">Web</option>
                                                <option value="api">API</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button wire:click.prevent='saveAndMore' type="button" class="btn btn-primary">Simpan
                                    dan
                                    Tambah</button>
                                <button wire:click.prevent='save' type="button" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    @include('components.partials._page_notification')

    <div class="card">
        <div class="card-body">
            <div wire:ignore class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Guard Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $item)
                            <tr wire:key="{{ $item->id }}">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->guard_name }}</td>
                                <td><button wire:click='edit({{ $item->id }})' class="btn btn-sm btn-warning"><i
                                            class="bi bi-pencil-square"></i>
                                        Edit</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Guard Name</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="editModalPermission" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-light">Ubah permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="permissionName" class="form-label">Nama Permission</label>
                                <input wire:model='name' type="text" class="form-control" id="permissionName"
                                    placeholder="Masukkan nama permission">
                                @error('name')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="guard_name" class="form-label">Guard Name</label>
                                <select wire:model='guard_name' class="form-control" id="guard_name">
                                    <option value="web">Pilih Guard Name</option>
                                    <option selected value="web">Web</option>
                                    <option value="api">API</option>
                                    <option value="admin">Admin</option>
                                </select>
                                @error('guard_name')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click.prevent='save' type="button" class="btn btn-primary">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('editPermission', function() {
                $('#editModalPermission').modal('show');
            });

            Livewire.on('closeModal', function() {
                $("#exampleLargeModal").modal('hide');
                $('#editModalPermission').modal('hide');
            });
        })
    </script>
@endpush

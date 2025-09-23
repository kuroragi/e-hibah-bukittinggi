<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Role</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Role</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRole"><i
                        class="bi bi-plus-lg"></i> Tambah</button>
                <!-- Modal -->
                <div wire:ignore.self class="modal fade" id="createRole" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light">Tambah Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="roleName" class="form-label">Nama Role</label>
                                            <input wire:model='name' type="text" class="form-control"
                                                id="permissionName" placeholder="Masukkan nama permission">
                                        </div>
                                        <div wire:ignore class="mb-3">
                                            <label for="selectedPermissions" class="form-label">Permission</label>
                                            <select class="multiple-select" id="selectedPermissions"
                                                data-placeholder="Choose anything" multiple="multiple">
                                                @foreach ($permissions as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
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
                                <button wire:click.prevent='save' type="button" class="btn btn-primary">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div wire:ignore class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Guard Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $item)
                            <tr wire:key="{{ $item->id }}">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->guard_name }}</td>
                                <td>
                                    <button wire:click='edit({{ $item->id }})' class="btn btn-sm btn-warning"><i
                                            class="bi bi-pencil-square"></i> Edit</button>
                                    <button wire:click='delete_warning({{ $item->id }})'
                                        class="btn btn-sm btn-danger ms-2
                                "><i
                                            class="bi bi-trash"></i> Hapus</button>
                                </td>
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

    <div wire:ignore.self class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Ubah Data Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Nama Role</label>
                                <input wire:model='name' type="text" class="form-control" id="permissionName"
                                    placeholder="Masukkan nama permission">
                            </div>
                            <div wire:ignore class="mb-3">
                                <label for="selectedPermissions" class="form-label">Permission</label>
                                <select class="multiple-select" id="editSelectedPermissions"
                                    data-placeholder="Choose anything" multiple="multiple">
                                    @foreach ($permissions as $item)
                                        <option value="{{ $item->name }}"
                                            @if (in_array($item->name, $selectedPermissions)) selected @endif>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                    <button wire:click.prevent='updateRole' type="button" class="btn btn-warning">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="delete_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title">Hapus Data Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <tr>
                                    <td>Nama Role</td>
                                    <td>{{ $name }}</td>
                                </tr>
                                <tr>
                                    <td>Guard Name</td>
                                    <td>{{ $guard_name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click.prevent='delete({{ $roleId }})' type="button"
                        class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>


</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bisa langsung inisialisasi Select2 juga di sini
            $('#createRole').on('shown.bs.modal', function() {
                $('#selectedPermissions').select2({
                    dropdownParent: $('#createRole'),
                    placeholder: 'Choose anything',
                    allowClear: true,
                    width: '100%'
                }).on('change', function() {
                    const selected = $(this).val();

                    Livewire.dispatch('select2-updated', {
                        data: $(this).val()
                    });

                    // Ketika modal ditutup, reset select2 jika perlu
                    $('#createRole').on('hidden.bs.modal', function() {
                        selectEl.val(null).trigger('change');
                    });
                });
            });

            Livewire.on('editRole', function() {
                $('#editRoleModal').modal('show');

                $('#editRoleModal').on('shown.bs.modal', function() {
                    $('#editSelectedPermissions').select2({
                        dropdownParent: $('#editRoleModal'),
                        placeholder: 'Choose anything',
                        allowClear: true,
                        width: '100%'
                    }).on('change', function() {
                        const selected = $(this).val();

                        Livewire.dispatch('select2-updated', {
                            data: $(this).val()
                        });
                    }).val(@this.get('selectedPermissions')).trigger('change');
                });

            });

            Livewire.on("deleteModal", function() {
                $("#delete_modal").modal("show");
            })

            Livewire.on('closeModal', function() {
                $('#createRole').modal('hide');
                $('#editRoleModal').modal('hide');
                $('#delete_modal').modal('hide');
            });

        });
    </script>
@endpush

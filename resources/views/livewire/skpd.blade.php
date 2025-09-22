<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">SKPD</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data SKPD</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" wire:click='create' class="btn btn-primary"><i
                        class="bi bi-plus-lg"></i>Tambah</button>

                <div wire:ignore.self class="modal fade" id="create-modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light"> Tambah SKPD</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="skpd-name" class="form-label">Nama SKPD</label>
                                            <input wire:model='name' type="text" class="form-control" id="skpd-name"
                                                placeholder="Masukkan nama pengguna">
                                        </div>
                                        <div class="mb-3">
                                            <label for="skpd-urusan" class="form-label">Urusan SKPD</label>
                                            @foreach ($urusan_skpd as $key => $urusan)
                                                <div class="input-group mb-3">
                                                    <input wire:model='urusan_skpd.{{ $key }}.nama_urusan'
                                                        type="text" class="form-control"
                                                        placeholder="Masukkan nama urusan">
                                                    <button wire:click.prevent='removeUrusan({{ $key }})'
                                                        class="btn btn-danger" type="button"><i
                                                            class="bi bi-trash"></i></button>
                                                </div>
                                            @endforeach
                                            <button type="button" wire:click='addUrusan'
                                                class="btn btn-outline-primary btn-sm"><i class="bi bi-plus-lg"></i>
                                                Tambah Urusan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button wire:click.prevent='store' type="button" class="btn btn-primary">Save
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
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($skpds as $key => $skpd)
                            <tr>
                                <td>{{ $skpd->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $skpd->id }}" aria-expanded="false"
                                        aria-controls="collapse{{ $skpd->id }}"><i class="bi bi-eye"></i>
                                        Urusan</button>
                                    {{-- <button class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Tambah
                                    Urusan</button> --}}
                                    <button wire:click='edit({{ $skpd->id }})' class="btn btn-sm btn-warning"><i
                                            class="bi bi-pencil-square"></i>
                                        Edit</button>
                                    <button wire:click='verifyDelete({{ $skpd->id }})'
                                        class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="hiddenRow">
                                    <div class="collapse" id="collapse{{ $skpd->id }}">
                                        <div class="card card-body">
                                            <h5>Urusan SKPD</h5>
                                            <table class="table">
                                                @if ($skpd->has_urusan->count() > 0)
                                                    @foreach ($skpd->has_urusan as $urusan)
                                                        <tr>
                                                            <td>{{ $urusan->nama_urusan }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <p>Tidak ada urusan yang ditambahkan.</p>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="edit-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Ubah Data SKPD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="user-name" class="form-label">Nama SKPD</label>
                                <input wire:model='name' type="text" class="form-control" id="user-name"
                                    placeholder="Masukkan nama SKPD">
                            </div>
                            <div class="mb-3">
                                <label for="skpd-urusan" class="form-label">Urusan SKPD</label>
                                @foreach ($urusan_skpd as $key => $urusan)
                                    <div class="input-group mb-3">
                                        <input wire:model='urusan_skpd.{{ $key }}.nama_urusan' type="text"
                                            class="form-control" placeholder="Masukkan nama urusan">
                                        <button wire:click.prevent='removeUrusan({{ $key }})'
                                            class="btn btn-danger" type="button"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                @endforeach
                                <button type="button" wire:click='addUrusan'
                                    class="btn btn-outline-primary btn-sm"><i class="bi bi-plus-lg"></i>
                                    Tambah Urusan</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click.prevent='update' type="button" class="btn btn-warning">Simpan
                        Perubahan</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="delete-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title">Hapus Data SKPD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table w-100">
                                <tr>
                                    <td>Nama Pengguna</td>
                                    <td>:</td>
                                    <td>{{ $skpd->name }}</td>
                                </tr>
                                <tr>
                                    <td>Urusan</td>
                                    <td>:</td>
                                    <td>
                                        @foreach ($skpd->has_urusan as $item)
                                            {{ $loop->iteration }}. {{ $item->nama_urusan }} <br>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click.prevent='delete' type="button" class="btn btn-danger">Hapus
                        Role</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('createModal', () => {
                $('#create-modal').modal('show');
            });

            Livewire.on('editModal', () => {
                $('#edit-modal').modal('show');
            });

            Livewire.on('deleteModal', () => {
                $('#delete-modal').modal('show');
            });

            Livewire.on('closeModal', () => {
                $('#create-modal').modal('hide');
                $('#edit-modal').modal('hide');
            });

            Livewire.on('verifyingDelete', (id) => {
                if (confirm("Apakah Anda yakin ingin menghapus SKPD ini?")) {
                    Livewire.emit('delete', id);
                }
            });
        });
    </script>
@endpush

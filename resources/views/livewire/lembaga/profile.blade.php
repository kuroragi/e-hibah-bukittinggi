<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">
            <h4>Form Data Lembaga</h4>
        </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('lembaga.admin', ['id_lembaga' => $id_lembaga]) }}">Lembaga</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Lembaga</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit='update'>
        <div class="row">
            <div class="col col-md-9 p-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col col-12">
                            <div class="mb-3">
                                <label for="search" class="form-label">Nama Lembaga</label>
                                <input wire:model='name' type="text" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="search" class="form-label">SKPD</label>
                                        <select wire:model='id_skpd' class="form-control">
                                            <option value="">--- Pilih SKPD ---</option>
                                            @foreach ($skpd as $key => $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="search" class="form-label">Urusan</label>
                                        <select wire:model='id_urusan' class="form-control">
                                            <option value="">--- Pilih Urusan ---</option>
                                            @foreach ($urusan as $key => $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_urusan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-6">
                                    <div class="mb-3">
                                        <label for="filter" class="form-label">Email</label>
                                        <input wire:model='email' type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col col-6">
                                    <div class="mb-3">
                                        <label for="filter" class="form-label">No. Telp</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text">+62</span>
                                            <input wire:model='phone' type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="propinsi" class="form-label">Propinsi <span
                                        class="text-danger">*</span></label>
                                <select wire:model='propinsi' class="form-select" id="propinsi">
                                    <option selected>Pilih Propinsi</option>
                                    @foreach ($propinsis as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('propinsi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kota" class="form-label">Kota/Kabupaten <span
                                        class="text-danger">*</span></label>
                                <select wire:model='kabkota' class="form-select" id="kabkota">
                                    <option selected>Pilih Kota/Kabupaten</option>
                                    @foreach ($kabkotas as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('kabkota')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select wire:model='kecamatan' class="form-select" id="kecamatan">
                                        <option selected>Pilih Kecamatan</option>
                                        @foreach ($kecamatans as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('kecamatan')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kelurahan" class="form-label">Kelurahan <span
                                            class="text-danger">*</span></label>
                                    <select wire:model='kelurahan' class="form-select" id="kelurahan">
                                        <option selected>Pilih Kelurahan</option>
                                        @foreach ($kelurahans as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelurahan')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea wire:model='alamat' class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <button wire:model='update' type="submit" class="btn btn-primary w-100">Ubah
                                    Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#propinsi").on('change', function() {
                Livewire.dispatch('updatedPropinsi');
            });

            $("#kabkota").on('change', function() {
                Livewire.dispatch('updatedKabkota');
            });

            $("#kecamatan").on('change', function() {
                Livewire.dispatch('updatedKecamatan');
            });
        });
    </script>
@endpush

<?php

namespace App\Livewire\Permohonan;

use App\Models\PendukungPermohonan;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\RincianRab;
use App\Models\Satuan;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPermohonan extends Component
{
    use WithFileUploads;
    
    public $permohonan;
    public $kegiatans;
    public $skpds;
    public $urusans = [];
    public $satuans;
    public $pendukung;

    public $edit_state;

    public $usulan_apbd;

    // Surat Permohonan
    public $no_mohon;
    public $tanggal_mohon;
    public $perihal_mohon;
    public $file_mohon;

    // Proposal
    public $no_proposal;
    public $tanggal_proposal;
    public $title;
    public $id_skpd;
    public $urusan;
    public $awal_laksana;
    public $akhir_laksana;
    public $file_proposal;

    // Isi Proposal
    public $latar_belakang;
    public $maksud_tujuan;
    public $keterangan;

    // Isi RAB
    public $nominal_rab = 0;
    public $id_status = 1;
    public $nominal_rekomendasi = 0;
    public $tanggal_rekomendasi;
    public $catatan_rekomendasi;
    public $file_pemberitahuan;
    public $nama_kegiatan;
    public $total_kegiatan;
    public $kegiatan_rab = [];
    public $rincian = [];

    // Isi Pendukung
    public $file_pernyataan_tanggung_jawab;
    public $struktur_pengurus;
    public $file_rab;
    public $saldo_akhir_rek;
    public $no_tidak_tumpang_tindih;
    public $tanggal_tidak_tumpang_tindih;
    public $file_tidak_tumpang_tindih;

    protected $listeners = ['updated_id_skpd'];

    public function mount($id_permohonan = null){
        $this->permohonan = Permohonan::with(['lembaga', 'skpd', 'status', 'pendukung'])->where('id', $id_permohonan)->first();
        
        if($this->permohonan){
                $this->usulan_apbd = $this->permohonan->tahun_apbd;
                $this->no_mohon = $this->permohonan->no_mohon;
                $this->tanggal_mohon = $this->permohonan->tanggal_mohon;
                $this->perihal_mohon = $this->permohonan->perihal_mohon;
                $this->file_mohon = $this->permohonan->file_mohon;
                $this->no_proposal = $this->permohonan->no_proposal;
                $this->tanggal_proposal = $this->permohonan->tanggal_proposal;
                $this->title = $this->permohonan->title;
                $this->urusan = $this->permohonan->urusan;
                $this->id_skpd = $this->permohonan->id_skpd;
                $this->urusans = UrusanSkpd::where('id_skpd', $this->id_skpd)->get();
                $this->awal_laksana = $this->permohonan->awal_laksana;
                $this->akhir_laksana = $this->permohonan->akhir_laksana;
                $this->file_proposal = $this->permohonan->file_proposal;
                $this->latar_belakang = $this->permohonan->latar_belakang;
                $this->maksud_tujuan = $this->permohonan->maksud_tujuan;
                $this->keterangan = $this->permohonan->keterangan;
                $this->nominal_rab = $this->permohonan->nominal_rab;
                $this->id_status = $this->permohonan->id_status;
                $this->nominal_rekomendasi = $this->permohonan->nominal_rekomendasi;
                $this->tanggal_rekomendasi = $this->permohonan->tanggal_rekomendasi;
                $this->catatan_rekomendasi = $this->permohonan->catatan_rekomendasi;
                $this->file_pemberitahuan = $this->permohonan->file_pemberitahuan;
        }

        
        $this->kegiatans = RabPermohonan::with(['rincian.satuan'])->where('id_permohonan', $this->permohonan->id)->get();
        if($this->kegiatans){
            $grand = 0;
            foreach ($this->kegiatans as $k1 => $item) {
                foreach ($item->rincian as $k2 => $child) {
                    $grand += $child->subtotal;
                }
            }
            $this->total_kegiatan = $grand;
        }
        foreach ($this->kegiatans as $k1 => $item) {
            $this->kegiatan_rab[$k1] = [
                'id_kegiatan' => $item->id,
                'nama_kegiatan' => $item->nama_kegiatan,
                'total_kegiatan' => 0
            ];
            foreach($item->rincian as $k2 => $child){
                $this->kegiatan_rab[$k1]['rincian'][$k2] = [
                    'id_rincian' => $child->id,
                    'kegiatan' => $child->keterangan,
                    'volume' => $child->volume,
                    'satuan' => $child->id_satuan,
                    'harga_satuan' => $child->harga,
                    'subtotal' => $child->subtotal,
                ];
            }
        }

        $this->skpds = Skpd::all();
        $this->satuans = Satuan::orderBy('name')->get();
        
        $this->edit_state = session('edit_state', 'lembaga');

        $this->pendukung = PendukungPermohonan::findOrFail($this->permohonan->id);
        if($this->pendukung){
            $this->file_pernyataan_tanggung_jawab = $this->pendukung->file_pernyataan_tanggung_jawab;
            $this->struktur_pengurus = $this->pendukung->struktur_pengurus;
            $this->file_rab = $this->pendukung->file_rab;
            $this->saldo_akhir_rek = $this->pendukung->saldo_akhir_rek;
            $this->no_tidak_tumpang_tindih = $this->pendukung->no_tidak_tumpang_tindih;
            $this->tanggal_tidak_tumpang_tindih = $this->pendukung->tanggal_tidak_tumpang_tindih;
            $this->file_tidak_tumpang_tindih = $this->pendukung->file_tidak_tumpang_tindih;
        }


    }

    public function render()
    {
        return view('livewire.permohonan.edit-permohonan');
    }

    #[On('updated_id_skpd')]
    public function updatedIdSkpd($data)
    {
        // Setiap kali id_skpd berubah, ambil urusan terkait dari DB
        $this->urusans = UrusanSkpd::where('id_skpd', $data)
            ->select('id', 'nama_urusan')
            ->orderBy('nama_urusan')
            ->get();
    }

    public function updateEditState($state)
    {
        $this->edit_state = $state;
        session(['edit_state' => $state]);
    }

    public function update_proposal(){
        DB::beginTransaction();

        try {

            $mohon_path = $this->permohonan->file_mohon;
            $proposal_path = $this->permohonan->file_proposal;

            if($this->permohonan->file_mohon != $this->file_mohon){
                if($this->permohonan->file_mohon && Storage::disk('public')->exists($this->permohonan->file_mohon)){
                    Storage::disk('public')->delete($this->permohonan->file_mohon);
                }

                $ext_mohon = $this->file_mohon->getclientOriginalExtension();
                $mohon_path = $this->file_mohon->storeAs('permohonan', 'surat_permohonan_'.Auth::user()->id.$this->permohonan->id_lembaga.date('now').'.'.$ext_mohon, 'public');
            }

            if($this->permohonan->file_proposal != $this->file_proposal){
                if($this->permohonan->file_proposal && Storage::disk('public')->exists($this->permohonan->file_proposal)){
                    Storage::disk('public')->delete($this->permohonan->file_proposal);
                }

                $ext_proposal = $this->file_proposal->getclientOriginalExtension();
                $proposal_path = $this->file_mohon->storeAs('permohonan', 'proposal_permohonan_'.Auth::user()->id.$this->permohonan->id_lembaga.date('now').'.'.$ext_proposal, 'public');
            }

            $this->permohonan->update([
                'tahun_apbd' => $this->usulan_apbd,
                'no_mohon' => $this->no_mohon,
                'tanggal_mohon' => date('Y-m-d', strtotime($this->tanggal_mohon)),
                'perihal_mohon' => $this->perihal_mohon,
                'file_mohon' => $mohon_path,
                'no_proposal' => $this->no_proposal,
                'tanggal_proposal' => date('Y-m-d', strtotime($this->tanggal_proposal)),
                'title' => $this->title,
                'urusan' => $this->urusan,
                'id_skpd' => $this->id_skpd,
                'awal_laksana' => $this->awal_laksana,
                'akhir_laksana' => $this->akhir_laksana,
                'file_proposal' => $proposal_path,
                'latar_belakang' => $this->latar_belakang,
                'maksud_tujuan' => $this->maksud_tujuan,
                'keterangan' => $this->keterangan,
                'nominal_rab' => $this->nominal_rab,
                'id_status' => $this->id_status,
                'nominal_rekomendasi' => $this->nominal_rekomendasi,
                'tanggal_rekomendasi' => $this->tanggal_rekomendasi,
                'catatan_rekomendasi' => $this->catatan_rekomendasi,
                'file_pemberitahuan' => $this->file_pemberitahuan,
            ]);

            ActivityLogService::log('permohonan.update', 'warning', 'pembaruan data permohonan');

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            session()->flash('proposal_error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }

    public function getSubtotal($k1, $k2)
    {
        $child = $this->kegiatan_rab[$k1]['rincian'][$k2];
        $subtotal = (float) ($child['volume'] ?? 0) * (float) ($child['harga_satuan'] ?? 0);
        $this->kegiatan_rab[$k1]['rincian'][$k2]['subtotal'] = $subtotal;
        $this->kegiatan_rab[$k1]['total_kegiatan'] = $this->getTotalKegiatan($k1);
        return $subtotal;
    }

    // Hitung total kegiatan
    public function getTotalKegiatan($k1)
    {
        $total = 0;
        foreach ($this->kegiatan_rab[$k1]['rincian'] as $k2 => $child) {

            $total += $child['subtotal'];
        }
        return $total;
    }

    public function getGrandTotal()
    {
        $grand = 0;
        foreach ($this->kegiatan_rab as $k1 => $item) {
            $grand += $this->getTotalKegiatan($k1);
        }
        $this->total_kegiatan = $grand;
    }

    public function tambahRincian($k1)
    {
        $countChild = count($this->kegiatan_rab[$k1]['rincian']);
        $this->kegiatan_rab[$k1]['rincian'][$countChild + 1] = [
            'kegiatan' => '',
            'volume' => '',
            'satuan' => '',
            'harga_satuan' => '',
            'subtotal' => '',
        ];
    }

    public function tambahKegiatan(){
        $countKegiatan = count($this->kegiatan_rab);
        $this->kegiatan_rab[$countKegiatan + 1] = [
            'name_kegiatan' => '',
            'total_kegiatan' => 0,
            'rincian' => [],
        ];
    }

    public function deleteKegiatan($id_kegiatan){
        $kegiatan = RabPermohonan::findOrFail($id_kegiatan);

        DB::beginTransaction();

        try {
            $kegiatan->rincian()->delete();
    
            $kegiatan->delete();

            DB::commit();

            session()->flash('message', 'Kegiatan dan Semua Rincian telah berhasil di hapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Kegiatan dan Rincian gagal dihapus :'.$th);
        }
    }

    public function deleteRincian($id_rincian){
        DB::beginTransaction();

        try {
            RincianRab::findOrFail($id_rincian)->delete();

            DB::commit();
        } catch (\Throwable $th) {
            session()->flash('error', 'Rincian gagal dihapus :'.$th);
        }
    }

    public function update_rab(){

        DB::beginTransaction();
        try {
            foreach($this->kegiatan_rab as $k1 => $item){
                $kegiatan = RabPermohonan::findOrFail($item['id_kegiatan'])->update([
                    'nama_kegiatan' => $this->kegiatan_rab[$k1]['nama_kegiatan'],
                ]);

                foreach($this->kegiatan_rab[$k1]['rincian'] as $k2 => $rincian){
                    RincianRab::findOrFail($rincian['id_rincian'])->update([
                        'keterangan' => $rincian['kegiatan'],
                        'volume' => $rincian['volume'],
                        'id_satuan' => $rincian['satuan'],
                        'harga' => $rincian['harga_satuan'],
                        'subtotal' => $rincian['subtotal'],
                    ]);
                }
            }
            DB::commit();
            $this->dispatch('close-modal');
            $this->getGrandTotal();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            session()->flash('error', 'Kegiatan dan Rincian gagal dihapus :'.$th);
        }

    }

    public function checkRab(){
        if($this->total_kegiatan == $this->nominal_rab){
            return false;
        }else{
            return true;
        }
    }

    public function saveRab(){
        $this->permohonan->update(['nominal_rab' => $this->nominal_rab]);
        session()->flash('warning_rab', 'Berhasil update data RAB');
    }

    public function update_pendukung(){
        $tanggung_jawab_path = $this->file_pernyataan_tanggung_jawab;
        $pengurus_path = $this->struktur_pengurus;
        $rab_path = $this->file_rab;
        $saldo_akhir_rek_path = $this->saldo_akhir_rek;
        $tidak_tumpang_tindih_path = $this->file_tidak_tumpang_tindih;

        DB::beginTransaction();

        try {
            if($this->pendukung->file_pernyataan_tanggung_jawab != $this->file_pernyataan_tanggung_jawab){
                if($this->pendukung->file_pernyataan_tanggung_jawab && Storage::disk('public')->exists($this->pendukung->file_pernyataan_tanggung_jawab)){
                    Storage::disk('public')->delete($this->pendukung->file_mohon);
                }

                $ext_tanggung_jawab = $this->file_pernyataan_tanggung_jawab->getclientOriginalExtension();
                $tanggung_jawab_path = $this->file_pernyataan_tanggung_jawab->storeAs('dukung_permohonan', 'tanggung_jawab_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_tanggung_jawab, 'public');
            }

            if($this->pendukung->file_mohon != $this->file_mohon){
                if($this->pendukung->file_mohon && Storage::disk('public')->exists($this->pendukung->file_mohon)){
                    Storage::disk('public')->delete($this->pendukung->file_mohon);
                }

                $ext_pengurus = $this->struktur_pengurus->getclientOriginalExtension();
                $pengurus_path = $this->struktur_pengurus->storeAs('dukung_permohonan', 'pengurus_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_pengurus, 'public');
            }

            if($this->pendukung->struktur_pengurus != $this->struktur_pengurus){
                if($this->pendukung->struktur_pengurus && Storage::disk('public')->exists($this->pendukung->struktur_pengurus)){
                    Storage::disk('public')->delete($this->pendukung->struktur_pengurus);
                }

                $ext_rab = $this->file_rab->getclientOriginalExtension();
                $rab_path = $this->file_rab->storeAs('dukung_permohonan', 'rab_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_rab, 'public');
            }

            if($this->pendukung->saldo_akhir_rek != $this->saldo_akhir_rek){
                if($this->pendukung->saldo_akhir_rek && Storage::disk('public')->exists($this->pendukung->saldo_akhir_rek)){
                    Storage::disk('public')->delete($this->pendukung->saldo_akhir_rek);
                }

                $ext_saldo_akhir_rek = $this->saldo_akhir_rek->getclientOriginalExtension();
                $saldo_akhir_rek_path = $this->saldo_akhir_rek->storeAs('dukung_permohonan', 'saldo_akhir_rek_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_saldo_akhir_rek, 'public');
            }

            if($this->pendukung->file_tidak_tumpang_tindih != $this->file_tidak_tumpang_tindih){
                if($this->pendukung->file_tidak_tumpang_tindih && Storage::disk('public')->exists($this->pendukung->file_tidak_tumpang_tindih)){
                    Storage::disk('public')->delete($this->pendukung->file_tidak_tumpang_tindih);
                }

                $ext_tidak_tumpang_tindih = $this->file_tidak_tumpang_tindih->getclientOriginalExtension();
                $tidak_tumpang_tindih_path = $this->file_tidak_tumpang_tindih->storeAs('dukung_permohonan', 'tidak_tumpang_tindih_'.Auth::user()->id.$this->permohonan->id.date('now').'.'.$ext_tidak_tumpang_tindih, 'public');
            }

            $update_pendukung_permohonan = $this->pendukung->update([
                'file_pernyataan_tanggung_jawab' => $tanggung_jawab_path,
                'struktur_pengurus' => $pengurus_path,
                'file_rab' => $rab_path,
                'saldo_akhir_rek' => $saldo_akhir_rek_path,
                'no_tidak_tumpang_tindih' => $this->no_tidak_tumpang_tindih,
                'tanggal_tidak_tumpang_tindih' => $this->tanggal_tidak_tumpang_tindih,
                'file_tidak_tumpang_tindih' => $tidak_tumpang_tindih_path,
            ]);
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }
}

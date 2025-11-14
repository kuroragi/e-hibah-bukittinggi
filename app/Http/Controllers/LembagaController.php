<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Lembaga;
use App\Models\Propinsi;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\UserLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LembagaController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display lembaga information
        if(Auth::user()->hasRole("Super Admin")){
            $lembaga = Lembaga::with(['skpd'])->orderBy('created_at')->get();
        }else if(!Auth::user()->hasRole('Admin Lembaga')){
            $lembaga = Lembaga::with(['skpd'])->where('id_skpd', Auth::user()->id_skpd)->orderBy('created_at')->get();
        }
        
        return view('pages.lembaga.index', [
            'lembaga' => $lembaga
        ]);
    }

    public function admin($id_lembaga = ''){
        $lembaga = Lembaga::find($id_lembaga);
        return view('pages.lembaga.admin', [
            'lembaga' => $lembaga
        ]);
    }

    public function create()
    {
        $propinsis = Propinsi::all();
        $all_kabkotas = KabKota::all();
        $all_kecamatans = Kecamatan::all();
        $all_kelurahans = Kelurahan::all();
        // Logic to show the form for creating a new lembaga
        return view('pages.lembaga.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new lembaga
        // Validate and save the lembaga data
        $validatedLembaga = $request->validate([
            'name_lembaga' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'kelurahan' => 'required',
            'alamat' => 'required',
            'npwp' => 'required',
            'no_akta_kumham' => 'required',
            'date_akta_kumham' => 'required',
            'file_akta_kumham' => 'required|mimetypes:application/pdf',
            'no_domisili' => 'required',
            'date_domisili' => 'required',
            'file_domisili' => 'required|mimetypes:application/pdf',
            'no_operasional' => 'required',
            'date_operasional' => 'required',
            'file_operasional' => 'required|mimetypes:application/pdf',
            'no_pernyataan' => 'required',
            'date_pernyataan' => 'required',
            'file_pernyataan' => 'required|mimetypes:application/pdf',
        ]);

        DB::beginTransaction();
        try {
            $validatedLembaga['name'] = $validatedLembaga['name_lembaga'];
            $validatedLembaga['id_skpd'] = 1;
            $validatedLembaga['id_urusan'] = 2;

            $ext_akta_kumham = $request->file('file_akta_kumham')->getclientOriginalExtension();
            $ext_domisili = $request->file('file_domisili')->getclientOriginalExtension();
            $ext_operasional = $request->file('file_operasional')->getclientOriginalExtension();
            $ext_pernyataan = $request->file('file_pernyataan')->getclientOriginalExtension();

            $validatedLembaga['file_akta_kumham'] = $request->file('file_akta_kumham')->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_akta_kumham.' . $ext_akta_kumham, 'public');
            $validatedLembaga['file_domisili'] = $request->file('file_domisili')->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_domisili.' . $ext_domisili, 'public');
            $validatedLembaga['file_operasional'] = $request->file('file_operasional')->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_operasional.' . $ext_operasional, 'public');
            $validatedLembaga['file_pernyataan'] = $request->file('file_pernyataan')->storeAs('data_lembaga', 'lembaga_' . Auth::user()->id . '_pernyataan.' . $ext_pernyataan, 'public');

            $lembaga = Lembaga::create($validatedLembaga);

            $ext_ktp = $request->file('scan_ktp')->getclientOriginalExtension();

            $data_pimpinan = [
                'name' => $request->input('name_pimpinan'),
                'email' => $request->input('email_pimpinan'),
                'nik' => $request->input('nik'),
                'no_hp' => $request->input('no_hp'),
                'alamat' => $request->input('alamat_pimpinan'),
                'scan_ktp' => $request->file('scan_ktp')->storeAs('pengurus', 'pengurus_' . Auth::user()->id . '_ketua.' . $ext_ktp, 'public'),
            ];

            $lembaga->pengurus()->create($data_pimpinan);

            
            User::where('id', Auth::user()->id)->update([
                'id_lembaga' => $lembaga->id,
            ]);

            ActivityLogService::log('lembaga.create', 'success', 'membuat dan menambahkan data lembaga '.$validatedLembaga['name'], json_encode($lembaga->toArray()));

            DB::commit();
            
            return redirect()->route('lembaga.admin', ['id_lembaga' => $lembaga->id])->with('success', 'Lembaga created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }

    public function show($id_lembaga)
    {
        // Logic to retrieve a specific lembaga by ID
        $lembaga = Lembaga::with(['pengurus'])->findOrFail($id_lembaga);
        return view('pages.lembaga.show', [
            'lembaga' => $lembaga
        ]);
    }

    public function editLembaga($id)
    {
        // Logic to retrieve lembaga for editing
        $lembaga = Lembaga::findOrFail($id);
        return view('pages.lembaga.edit', [
            'lembaga' => $lembaga
        ]);
    }

    public function update(Request $request, $id)
    {
        // Logic to update lembaga data
        $lembaga = Lembaga::findOrFail($id);
        // Validate and update the lembaga data
        return redirect()->route('lembaga')->with('success', 'Lembaga updated successfully.');
    }

    function editPendukung($id){
        //
    }

    function updatePendukung(Request $request, $id){
        // Logic to update lembaga pendukung data
        $lembaga = Lembaga::findOrFail($id);
        // Validate and update the lembaga pendukung data
        return redirect()->route('lembaga.index')->with('success', 'Lembaga pendukung updated successfully.');
    }

    function editPengurus($id){
        // Logic to retrieve lembaga pengurus for editing
        $lembaga = Lembaga::findOrFail($id);
        return view('pages.lembaga.edit_pengurus', compact('lembaga'));
    }

    function updatePengurus(Request $request, $id){
        // Logic to update lembaga pengurus data
        $lembaga = Lembaga::findOrFail($id);
        // Validate and update the lembaga pengurus data
        return redirect()->route('lembaga.index')->with('success', 'Lembaga pengurus updated successfully.');
    }
}

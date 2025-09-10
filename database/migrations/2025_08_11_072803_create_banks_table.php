<?php

use App\Models\Bank;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bank');
            $table->string('name');
            $table->string('acronym');
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        });

        $data = [
            [
                'kode_bank' => '118',
                'name' => 'Nagari',
                'acronym' => 'Nagari',
            ],
            [
                'kode_bank' => '002',
                'name' => 'Bang Rakyat Indonesia',
                'acronym' => 'BRI',
            ],
            [
                'kode_bank' => '009',
                'name' => 'Bank Negara Indonesia',
                'acronym' => 'BNI',
            ],
            [
                'kode_bank' => '008',
                'name' => 'Bang Mandiri',
                'acronym' => 'Mandiri',
            ],
            [
                'kode_bank' => '014',
                'name' => 'Bang Central Asia',
                'acronym' => 'BCA',
            ],
        ];

        foreach ($data as $key => $d) {
            Bank::create([
                'kode_bank' => $d['kode_bank'],
                'name' => $d['name'],
                'acronym' => $d['acronym'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};

<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Helpers\General;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

class GeneralTest extends TestCase
{
    #[Test]
    public function it_formats_date_correctly()
    {
        $date = '2023-12-25';
        $result = General::formatDate($date);

        $this->assertEquals('25-12-2023', $result);
    }

    #[Test]
    public function it_generates_slug_from_string()
    {
        $string = 'Hello World Test 123!@#';
        $result = General::generateSlug($string);

        $this->assertEquals('hello-world-test-123', $result);
        $this->assertStringNotContainsString(' ', $result);
        $this->assertStringNotContainsString('!', $result);
        $this->assertStringNotContainsString('@', $result);
        $this->assertStringNotContainsString('#', $result);
    }

    #[Test]
    public function it_generates_password_with_correct_length()
    {
        $password = General::GeneratePassword(12);

        $this->assertEquals(12, strlen($password));
    }

    #[Test]
    public function it_generates_password_with_default_length()
    {
        $password = General::GeneratePassword();

        $this->assertEquals(10, strlen($password));
    }

    #[Test]
    public function it_generates_password_with_required_character_types()
    {
        $password = General::GeneratePassword(20);

        // Should contain at least one uppercase letter
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        
        // Should contain at least one lowercase letter
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
        
        // Should contain at least one number
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
        
        // Should contain at least one symbol
        $this->assertMatchesRegularExpression('/[!@#$%^&*()_=+\[\]{}|;:,.<>?-]/', $password);
    }

    #[Test]
    public function it_converts_numbers_to_indonesian_words()
    {
        $testCases = [
            0 => '',
            1 => 'satu',
            10 => 'sepuluh',
            11 => 'sebelas',
            15 => 'lima belas',
            20 => 'dua puluh',
            25 => 'dua puluh lima',
            100 => 'seratus',
            150 => 'seratus lima puluh',
            1000 => 'seribu',
            1500 => 'seribu lima ratus',
            10000 => 'sepuluh ribu',
            100000 => 'seratus ribu',
            1000000 => 'satu juta',
            1500000 => 'satu juta lima ratus ribu',
        ];

        foreach ($testCases as $number => $expected) {
            $result = trim(General::Terbilang($number));
            $this->assertEquals($expected, $result, "Failed for number: {$number}");
        }
    }

    #[Test]
    public function it_handles_negative_numbers_in_terbilang()
    {
        $result = General::Terbilang(-100);
        $expected = trim(General::Terbilang(100));
        
        $this->assertEquals($expected, $result);
    }

    #[Test]
    public function it_formats_currency_correctly()
    {
        $testCases = [
            1000 => 'Rp 1.000',
            50000 => 'Rp 50.000',
            1000000 => 'Rp 1.000.000',
            1500750 => 'Rp 1.500.750',
        ];

        foreach ($testCases as $amount => $expected) {
            $result = General::rp($amount);
            $this->assertEquals($expected, $result);
        }
    }

    #[Test]
    public function it_converts_date_to_indonesian_format()
    {
        $date = '2023-12-25'; // Christmas Day 2023 (Monday)
        $result = General::convertDateToIndo($date);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('hari', $result);
        $this->assertArrayHasKey('tanggal', $result);
        $this->assertArrayHasKey('bulan', $result);
        $this->assertArrayHasKey('tahun', $result);

        $this->assertEquals('Senin', $result['hari']);
        $this->assertEquals('25', $result['tanggal']);
        $this->assertEquals('Desember', $result['bulan']);
        $this->assertEquals('2023', $result['tahun']);
    }

    #[Test]
    public function it_converts_date_to_short_indonesian_format()
    {
        $date = '2023-12-25';
        $result = General::convertShortDateToIndo($date);

        $this->assertIsArray($result);
        $this->assertEquals('Sen', $result['hari']);
        $this->assertEquals('25', $result['tanggal']);
        $this->assertEquals('Des', $result['bulan']);
        $this->assertEquals('2023', $result['tahun']);
    }

    #[Test]
    public function it_converts_date_to_indonesian_readable_format()
    {
        $date = '2023-12-25';
        $result = General::getIndoDate($date);

        $this->assertEquals('25 Desember 2023', $result);
    }

    #[Test]
    public function it_converts_date_to_indonesian_terbilang_format()
    {
        $date = '2023-01-05';
        $result = General::getIndoTerbilangDate($date);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('hari', $result);
        $this->assertArrayHasKey('tanggal', $result);
        $this->assertArrayHasKey('bulan', $result);
        $this->assertArrayHasKey('tahun', $result);

        $this->assertEquals('Kamis', $result['hari']);
        $this->assertStringContainsString('lima', trim($result['tanggal']));
        $this->assertEquals('Januari', $result['bulan']);
        $this->assertStringContainsString('dua ribu', trim($result['tahun']));
    }

    #[Test]
    public function it_formats_bidang_list_with_array()
    {
        $items = ['Pendidikan', 'Kesehatan', 'Sosial'];
        $result = General::formatBidangList($items);

        $this->assertEquals('Pendidikan, Kesehatan dan Sosial', $result);
    }

    #[Test]
    public function it_formats_bidang_list_with_collection()
    {
        $items = collect(['Pendidikan', 'Kesehatan']);
        $result = General::formatBidangList($items);

        $this->assertEquals('Pendidikan dan Kesehatan', $result);
    }

    #[Test]
    public function it_formats_bidang_list_with_single_item()
    {
        $items = ['Pendidikan'];
        $result = General::formatBidangList($items);

        $this->assertEquals('Pendidikan', $result);
    }

    #[Test]
    public function it_formats_bidang_list_with_empty_array()
    {
        $items = [];
        $result = General::formatBidangList($items);

        $this->assertEquals('-', $result);
    }

    #[Test]
    public function it_formats_bidang_list_with_key()
    {
        $items = [
            ['name' => 'Pendidikan'],
            ['name' => 'Kesehatan'],
            ['name' => 'Sosial']
        ];
        $result = General::formatBidangList($items, 'name');

        $this->assertEquals('Pendidikan, Kesehatan dan Sosial', $result);
    }

    #[Test]
    public function it_formats_bidang_list_with_custom_separators()
    {
        $items = ['A', 'B', 'C'];
        $result = General::formatBidangList($items, null, ' | ', ' serta ');

        $this->assertEquals('A | B serta C', $result);
    }

    #[Test]
    public function it_filters_empty_values_in_bidang_list()
    {
        $items = ['Pendidikan', '', null, 'Kesehatan', 0, false];
        $result = General::formatBidangList($items);

        $this->assertEquals('Pendidikan dan Kesehatan', $result);
    }

    #[Test]
    public function it_handles_different_month_translations()
    {
        $testCases = [
            '2023-01-01' => 'Januari',
            '2023-02-01' => 'Februari', 
            '2023-03-01' => 'Maret',
            '2023-04-01' => 'April',
            '2023-05-01' => 'Mei',
            '2023-06-01' => 'Juni',
            '2023-07-01' => 'Juli',
            '2023-08-01' => 'Agustus',
            '2023-09-01' => 'September',
            '2023-10-01' => 'Oktober',
            '2023-11-01' => 'November',
            '2023-12-01' => 'Desember',
        ];

        foreach ($testCases as $date => $expectedMonth) {
            $result = General::convertDateToIndo($date);
            $this->assertEquals($expectedMonth, $result['bulan']);
        }
    }

    #[Test]
    public function it_handles_different_day_translations()
    {
        $testCases = [
            '2023-01-01' => 'Minggu', // Sunday
            '2023-01-02' => 'Senin',  // Monday
            '2023-01-03' => 'Selasa', // Tuesday
            '2023-01-04' => 'Rabu',   // Wednesday
            '2023-01-05' => 'Kamis',  // Thursday
            '2023-01-06' => 'Jumat',  // Friday
            '2023-01-07' => 'Sabtu',  // Saturday
        ];

        foreach ($testCases as $date => $expectedDay) {
            $result = General::convertDateToIndo($date);
            $this->assertEquals($expectedDay, $result['hari']);
        }
    }
}

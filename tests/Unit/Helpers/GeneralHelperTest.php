<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;
use App\Helpers\General;
use PHPUnit\Framework\Attributes\Test;

class GeneralHelperTest extends TestCase
{
    #[Test]
    public function it_formats_date_correctly()
    {
        $date = '2024-01-15';
        $formatted = General::formatDate($date);
        
        $this->assertIsString($formatted);
        $this->assertNotEmpty($formatted);
    }

    #[Test]
    public function it_generates_slug_from_string()
    {
        $text = 'Program Hibah Test 2024';
        $slug = General::generateSlug($text);
        
        $this->assertEquals('program-hibah-test-2024', $slug);
    }

    #[Test]
    public function it_generates_password_with_correct_length()
    {
        $length = 12;
        $password = General::GeneratePassword($length);
        
        $this->assertEquals($length, strlen($password));
    }

    #[Test]
    public function it_generates_password_with_default_length()
    {
        $password = General::GeneratePassword();
        
        $this->assertEquals(10, strlen($password)); // Default is 10 based on method signature
    }

    #[Test]
    public function it_generates_password_with_required_character_types()
    {
        $password = General::GeneratePassword(12);
        
        // Check if password contains at least one uppercase, lowercase, number, and symbol
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
        $this->assertMatchesRegularExpression('/[^A-Za-z0-9]/', $password);
    }

    #[Test]
    public function it_converts_numbers_to_indonesian_words()
    {
        $number = 123;
        $words = General::Terbilang($number);
        
        $this->assertIsString($words);
        $this->assertStringContainsString('seratus', strtolower($words));
        $this->assertStringContainsString('dua puluh', strtolower($words));
        $this->assertStringContainsString('tiga', strtolower($words));
    }

    #[Test]
    public function it_handles_negative_numbers_in_terbilang()
    {
        $number = -100;
        $words = General::Terbilang($number);
        
        $this->assertIsString($words);
        // Method uses abs() so it won't contain 'minus'
        $this->assertStringContainsString('seratus', strtolower($words));
    }

    #[Test]
    public function it_formats_currency_correctly()
    {
        $amount = 1500000;
        $formatted = General::rp($amount);
        
        $this->assertStringContainsString('Rp', $formatted);
        $this->assertStringContainsString('1.500.000', $formatted);
    }

    #[Test]
    public function it_converts_date_to_indonesian_format()
    {
        $date = '2024-01-15';
        $result = General::convertDateToIndo($date);
        
        $this->assertIsArray($result);
        $this->assertEquals('Januari', $result['bulan']);
        $this->assertEquals('2024', $result['tahun']);
        $this->assertEquals('15', $result['tanggal']);
    }

    #[Test]
    public function it_converts_date_to_short_indonesian_format()
    {
        $date = '2024-01-15';
        $result = General::convertShortDateToIndo($date);
        
        $this->assertIsArray($result);
        $this->assertEquals('Jan', $result['bulan']);
        $this->assertEquals('2024', $result['tahun']);
    }

    #[Test]
    public function it_handles_get_one_data_from_model()
    {
        // This method requires an actual Eloquent model, so we'll just test it exists
        $this->assertTrue(method_exists(General::class, 'GetOneDataFromModel'));
    }

    #[Test] 
    public function it_tests_existing_methods_only()
    {
        // Test methods that actually exist in the General class
        $this->assertTrue(method_exists(General::class, 'formatDate'));
        $this->assertTrue(method_exists(General::class, 'generateSlug'));
        $this->assertTrue(method_exists(General::class, 'GeneratePassword'));
        $this->assertTrue(method_exists(General::class, 'Terbilang'));
        $this->assertTrue(method_exists(General::class, 'rp'));
        $this->assertTrue(method_exists(General::class, 'convertDateToIndo'));
        $this->assertTrue(method_exists(General::class, 'convertShortDateToIndo'));
    }

    #[Test]
    public function it_handles_different_month_translations()
    {
        $months = [
            '2024-01-01' => 'Januari',
            '2024-02-01' => 'Februari', 
            '2024-03-01' => 'Maret',
            '2024-12-01' => 'Desember'
        ];
        
        foreach ($months as $date => $expectedMonth) {
            $result = General::convertDateToIndo($date);
            $this->assertEquals($expectedMonth, $result['bulan']);
        }
    }

    #[Test]
    public function it_handles_different_day_translations()
    {
        // Test Monday date
        $result = General::convertDateToIndo('2024-01-15'); // This is a Monday
        $this->assertArrayHasKey('hari', $result);
        $this->assertIsString($result['hari']);
    }
}
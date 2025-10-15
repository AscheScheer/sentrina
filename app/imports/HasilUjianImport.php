<?php

namespace App\Imports;

use App\Models\HasilUjian;
use App\Models\User;
use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HasilUjianImport implements ToModel, WithHeadingRow, WithValidation
{
    private $currentStaffId;

    public function __construct($staffId = null)
    {
        // Get current staff ID for auto assignment
        if ($staffId) {
            // Admin specified staff ID
            $this->currentStaffId = $staffId;
        } elseif (Auth::guard('staff')->check()) {
            $this->currentStaffId = Auth::guard('staff')->id();
        } elseif (Auth::guard('admin')->check()) {
            // For admin, we'll use the first staff ID as fallback
            $this->currentStaffId = Staff::first()->id ?? null;
        }
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Skip empty rows
        if (empty($row['nama']) || empty($row['tanggal']) || empty($row['juz'])) {
            return null;
        }

        // Find user by name
        $userName = trim($row['nama']);
        $user = User::where('name', 'like', '%' . $userName . '%')->first();

        if (!$user) {
            // Log or handle user not found - for debugging
            Log::warning("HasilUjianImport: User not found for name: " . $userName);
            return null;
        }

        // Parse tanggal
        try {
            if (is_numeric($row['tanggal'])) {
                // Excel date format (serial number)
                $tanggal = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($row['tanggal'] - 2)->format('Y-m-d');
            } else {
                // String date format - try multiple formats
                $dateString = trim($row['tanggal']);

                // Try different date formats
                $formats = ['Y-m-d', 'd-m-Y', 'd/m/Y', 'm/d/Y', 'Y/m/d'];
                $tanggal = null;

                foreach ($formats as $format) {
                    try {
                        $tanggal = Carbon::createFromFormat($format, $dateString)->format('Y-m-d');
                        break;
                    } catch (\Exception $e) {
                        continue;
                    }
                }

                // If all formats fail, try Carbon::parse
                if (!$tanggal) {
                    $tanggal = Carbon::parse($dateString)->format('Y-m-d');
                }
            }
        } catch (\Exception $e) {
            $tanggal = now()->format('Y-m-d');
        }

        // Standardize juz format
        $juz = $this->standardizeJuz($row['juz']);

        // Handle keterangan - convert "-" to null
        $keterangan = isset($row['keterangan']) && !empty(trim($row['keterangan'])) ? trim($row['keterangan']) : null;
        if ($keterangan === '-' || $keterangan === 'null' || $keterangan === 'NULL') {
            $keterangan = null;
        }

        // Create HasilUjian record
        return new HasilUjian([
            'user_id' => $user->id,
            'tanggal' => $tanggal,
            'juz' => $juz,
            'staff_id' => $this->currentStaffId,
            'keterangan' => $keterangan
        ]);
    }

    private function standardizeJuz($juzInput)
    {
        // Handle different input types
        if (is_numeric($juzInput)) {
            // Direct number input (e.g., 8, 10, etc.)
            $number = (int)$juzInput;
            if ($number >= 1 && $number <= 30) {
                return 'Juz ' . $number;
            }
        }

        // Remove extra spaces and standardize format for string input
        $juz = trim(strval($juzInput));

        // Extract number from input
        preg_match('/(\d+)/', $juz, $matches);

        if (isset($matches[1])) {
            $number = (int)$matches[1];
            if ($number >= 1 && $number <= 30) {
                return 'Juz ' . $number;
            }
        }

        // If no valid number found, return as is
        return $juz;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'tanggal' => 'required',
            'juz' => 'required',
            'keterangan' => 'nullable',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Nama santri harus diisi.',
            'tanggal.required' => 'Tanggal ujian harus diisi.',
            'juz.required' => 'Juz harus diisi.',
        ];
    }
}

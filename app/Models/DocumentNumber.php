<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentNumber extends Model
{

    use HasFactory;

    protected $fillable = ['prefix', 'year_month', 'sequence'];

    public static function generateAttendanceDocumentNumber(): string
    {
        $prefix = 'ATT';
        return self::generateDocumentNumber($prefix);
    }

    public static function generateGeneratorDocumentNumber(): string
    {
        $prefix = 'GATT';
        return self::generateDocumentNumber($prefix);
    }

    public static function generateEmployeeDocumentNumber(DateTime $joinDate = null): string
    {
        $prefix = 'EMP';
        return self::generateDocumentNumber($prefix, $joinDate);
    }


    private static function generateDocumentNumber(string $prefix, DateTime $currentDate = null): string
    {
        $currentDate ??= now();
        $yearMonth = $currentDate->format('ym');
        $yearMonthDate = $currentDate->format('ymd');

        $documentNumber = self::where('prefix', $prefix)
            ->where('year_month', $yearMonth)
            ->first();

        if ($documentNumber) {
            $sequence = $documentNumber->sequence + 1;
            $documentNumber->sequence = $sequence;
            $documentNumber->save();
        } else {
            $sequence = 1;
            self::create([
                'prefix' => $prefix,
                'year_month' => $yearMonth,
                'sequence' => $sequence,
            ]);
        }

        return sprintf('%s-%s-%s', $prefix, $yearMonthDate, $sequence);
    }
}

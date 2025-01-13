<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements WithHeadingRow
{
    use Importable;
}

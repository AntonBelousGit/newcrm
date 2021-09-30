<?php

namespace App\Imports;

use App\Models\AddressesList;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AddressesListImport implements ToModel, WithChunkReading
{
    use RemembersRowNumber;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AddressesList([
            'address' => $row[0],
            'user_id' => Auth::id(),
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}

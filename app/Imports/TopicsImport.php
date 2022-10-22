<?php

namespace App\Imports;

use App\Models\Topic;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TopicsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Topic([
            'name'     => $row['name'],
            // 'created_by'=> $row[2],
            // 'updated_by'=> $row[2],

        ]);
    }
}

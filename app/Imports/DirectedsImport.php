<?php

namespace App\Imports;

use App\Models\Directed;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DirectedsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Directed([
            'sentence'  => $row['sentence'],
            // 'topic_id'  => $row['topic_id'],
            'english'   => $row['english']
        ]);
    }
}

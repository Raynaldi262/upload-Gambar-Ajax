<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Image extends Model
{

    protected $table = 'images';
    protected $primaryKey = 'id';

    protected $fillable = ['doc_id', 'img_name', 'img_path', 'created_by'];

    // public function getDocId()
    // {
    //     $doc_id = DB::select('select LPAD(substr(doc_id, 12, 5)+1,5,0) as doc_id from images order by doc_id desc limit 1');
    //     return $doc_id;
    // }

    public static function getGambar($doc_id)
    {
        $gambar = DB::table('images')->where('doc_id', $doc_id)->get();

        return $gambar;
    }
}

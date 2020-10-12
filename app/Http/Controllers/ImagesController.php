<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\DB;
use Exception;
use Intervention\Image\ImageManagerStatic as Images;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gambar = Image::all();

        return view('home', compact('gambar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        try {
            $docId = DB::select('select LPAD(substr(doc_id, 12, 5)+1,5,0) as doc_id from images order by doc_id desc limit 1');

            $docId =  $docId[0]->doc_id; // hasil query dimasukkan ke variable   
            $docId = 'PI-LKRS-20-' . $docId; //doc id di concate dengan hasil query

        } catch (Exception $e) {
            $docId = 'PI-LKRS-20-00001';
        }

        request()->session()->put('key', $docId);

        $value = request()->session()->get('key');

        echo $value;

        return view('upload', [
            'id' => $docId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => $validator->errors()->all(),
                'class_name'  => 'alert-danger'
            ]);
        } else {
            $docId = $request->doc_id; //dpt dokumen id  
            $ext = $request->image->extension();  //dpt file extension 
            try {
                $counter = Image::getCount($docId);
                if ($counter >= 6) {
                    return response()->json([
                        'message'   => 'Melewati batas dan Melampauinya',
                        'class_name'  => 'alert-danger'
                    ]);
                } else {
                    // dapat nomor ke- dari nama gambar yg aktif //1,2,3 dst
                    $name = DB::select("select SUBSTR(img_name,INSTR(img_name,'.')-1,1) as img_name from images where doc_id = ?", [$docId]);
                    $tmp = ''; //tmp penyimpanan untk nama yg blm ada

                    // looping sampai ketemu angka yg blm ada
                    for ($i = 1; $i < 7; $i++) {
                        $c = 0;
                        foreach ($name as $counter) {
                            if ($counter->img_name == $i) {
                                $c++;
                            }
                        }
                        if ($c == 0) {
                            $tmp = $i;
                            break;
                        }
                    }
                }

                $name = $docId . '-' . $tmp . '.' . $ext;
            } catch (Exception $e) {
                $name = $docId . '-1.' . $ext;
            } // end cari nama

            $path = storage_path('app\public\images\\' . $name);
            Images::make($request->image)->resize(300, 200)->save($path);


            if (!$request->session()->exists('data')) {
                $created_by = 'Guest';
            } else {
                $created_by = $request->session()->get('data');
            }

            Image::create([
                'doc_id' => $docId,
                'img_name' => $name,
                'img_path' => $path,
                'created_by' => $created_by
            ]);

            return response()->json([
                'message'   => 'Image Upload Successfully',
                'class_name'  => 'alert-success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            Image::deleted($request->id);
            // try {    //apus data gambar dari file storage
            //     Storage::disk('local')->delete('public/images/' + $request->name);
            // } catch (Exception $e) {
            //     dump('errror');
            // }
            return response()->json([
                'message'   => 'Data Deleted',
                'class_name'  => 'alert-danger',
            ]);
        }
    }


    public function fetch_data(Request $request)
    {
        $value = $request->session()->get('key');

        if ($request->ajax()) {
            $data = Image::getGambar($value);

            echo json_encode($data);
        }
    }
}

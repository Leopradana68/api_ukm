<?php

namespace App\Http\Controllers;


use App\Models\video_item_galleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class videoitemgalleriController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */
    public function list()
    {
        // Jika tabel artikel gak ada isi maka 
        if (video_item_galleri::count() > 0) {
            $data = video_item_galleri::get();

            return response()->json([
                'data' => $data,
                '__message' => 'Daftar Video berhasil diambil',
                '__func' => 'Video List',
            ], 200);
        }

        return response()->json([
            'data' => 'Video tidak ditemukan',
            '__message' => 'Video berhasil diambil',
            '__func' => 'Video List',
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_galleri' => ['required'],
            'video_url' => ['string'],
            'tumbnail_url' => ['string'],
            
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'Video tidak berhasil dibuat, data yang diberikan tidak valid',
                '__func' => 'Video create',
            ], 422);
        }


        // Eksekusi pembuatan data artikel_kategori
        $query = video_item_galleri::create([
            'id_galleri' => $request->id_galleri,
            'video_url' => $request->video_url,
            'tumbnail_url' => $request->tumbnail_url,
        ]);

        // Jika eksekusi query berhasil maka berikan response success
        if ($query) {
            return response()->json([
                'data' => $query,
                '__message' => 'Video berhasil dibuat',
                '__func' => 'Video create',
            ], 200);
        }

        // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
        return response()->json([
            'data' => $query,
            '__message' => 'Video tidak berhasil dibuat, coba kembali beberapa saat',
            '__func' => 'Video create',
        ], 500);
    }
    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id_video)
    {
        // Validiasi data yang diberikan oleh frontend
        $validator = Validator::make($request->all(), [
            'id_galleri' => ['required'],
            'video_url' => ['string'],
            'tumbnail_url' => ['string'],
        ]);

        // Jika data yang di validasi tidak sesuai maka berikan response error 422
        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                '__message' => 'video tidak berhasil diperbarui, data yang diberikan tidak valid',
                '__func' => 'video update',
            ], 422);
        }

        // Cek jika ID Artikel_kategori yang diberikan merupakan Integer
        if (!is_numeric($id_video)){
            return response()->json([
                'data' => 'ID Video: ' . $id_video,
                '__message' => 'video tidak berhasil diperbarui, ID video harus berupa Integer',
                '__func' => 'Video update',
            ], 422);
        }

        // Cek jika ID Artikel_kategori yang diberikan apakah tersedia di tabel
        if (video_item_galleri::where('id', $id_video)->exists()) {

          {

                 // Eksekusi pembaruan data kategori 
                 $query = video_item_galleri::where('id', $id_video)->update([
                    'id_galleri' => $request->id_galleri,
                    'video_url' => $request->video_url,
                     'tumbnail_url' => $request->tumbnail_url,
                  
                ]);
            }
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Video berhasil diperbarui',
                    '__func' => 'Video update',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video tidak berhasil diperbarui, coba kembali beberapa saat',
                '__func' => 'Video update',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video: ' . $id_video,
            '__message' => 'Id Video tidak berhasil diperbarui, ID Video tidak ditemukan',
            '__func' => 'Video update',
        ], 500);
    }
    
    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id_video)
    {
        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_video)){
            return response()->json([
                'data' => 'ID Video: ' . $id_video,
                '__message' => 'Video tidak berhasil diambil, ID Video harus berupa Integer',
                '__func' => 'Video detail',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (video_item_galleri::where('id', $id_video)->exists()) {

            // Eksekusi pembaruan data ukm
            $query =video_item_galleri::where('id', $id_video)->first();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Detail Video berhasil diambil',
                    '__func' => 'Video detail',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video tidak berhasil diambil, coba kembali beberapa saat',
                '__func' => 'Video detail',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video: ' . $id_video,
            '__message' => 'Video tidak berhasil diambil, ID Video tidak ditemukan',
            '__func' => 'Video detail',
        ], 500);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id_video)
    {
        // Cek jika ID Ukm yang diberikan merupakan Integer
        if (!is_numeric($id_video)){
            return response()->json([
                'data' => 'ID Video: ' . $id_video,
                '__message' => 'Video tidak berhasil dihapus, ID Video harus berupa Integer',
                '__func' => 'Video delete',
            ], 422);
        }

        // Cek jika ID Ukm yang diberikan apakah tersedia di tabel
        if (video_item_galleri::where('id', $id_video)->exists()) {

            // Eksekusi penghapusan data ukm
            $query = video_item_galleri::where('id', $id_video)->delete();
    
            // Jika eksekusi query berhasil maka berikan response success
            if ($query) {
                return response()->json([
                    'data' => $query,
                    '__message' => 'Video berhasil dihapus',
                    '__func' => 'Video delete',
                ], 200);
            }
    
            // Jika gagal seperti masalah koneksi atau apapun maka berikan response error
            return response()->json([
                'data' => $query,
                '__message' => 'Video tidak berhasil dihapus, coba kembali beberapa saat',
                '__func' => 'Video delete',
            ], 500);
        }

        // Jika ID tidak tersedia maka tampilkan response error
        return response()->json([
            'data' => 'ID Video: ' . $id_video,
            '__message' => 'Video tidak berhasil dihapus, ID Video tidak ditemukan',
            '__func' => 'Video delete',
        ], 500);
    }
    
}
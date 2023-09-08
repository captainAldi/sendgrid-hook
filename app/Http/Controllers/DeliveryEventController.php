<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DeliveryEvent;
use App\Models\SenderIdentity;

class DeliveryEventController extends Controller
{
    
    public function index(Request $request)
    {
        //Variable Pencarian
        $cari_sender_identity = $request->get('cari_sender_identity');
        $cari_event = $request->get('cari_event');
        $cari_tanggal_awal = $request->get('cari_tanggal_awal');
        $cari_tanggal_akhir = $request->get('cari_tanggal_akhir');
        

        $tipe_sort = 'desc';
        $var_sort = 'timestamp';

        $set_pagination = $request->get('set_pagination');

        // Semua Delivery Event
        $data_semua_de = DeliveryEvent::query();

        // Kondisi
        if ($cari_sender_identity != '') {
            $data_semua_de = $data_semua_de->where('sender_identity', $cari_sender_identity);
        }

        if ($cari_event != '') {
            $data_semua_de = $data_semua_de->where('event', $cari_event);
        }

        if($cari_tanggal_awal != '' || $cari_tanggal_akhir != '') {
            $data_semua_de = $data_semua_de->whereBetween('timestamp', [$cari_tanggal_awal, $cari_tanggal_akhir]);
        }


        if( $request->has('tipe_sort') || $request->has('var_sort') ) {
            $tipe_sort = $request->get('tipe_sort');
            $var_sort = $request->get('var_sort');

            $data_semua_de = $data_semua_de->orderBy($var_sort, $tipe_sort);
        }

        // Paginate
        if ($set_pagination != '') {
            $data_semua_de = $data_semua_de
                        ->orderBy($var_sort, $tipe_sort)
                        ->paginate($set_pagination);
        } else {
            $data_semua_de = $data_semua_de
                        ->orderBy($var_sort, $tipe_sort)
                        ->paginate(10);
        }

        // Append Data to Query String
        $data_semua_de->appends($request->only(
            $cari_sender_identity,
            $cari_tanggal_awal, 
            $cari_tanggal_akhir, 
            $cari_event,

            $tipe_sort,
            $var_sort,
            $set_pagination
        ));

        // Data Tambahan
        $data_sender_identity = SenderIdentity::all();


        // Tampikan
        return view('events.delivery', compact(
            'data_semua_de',

            'cari_sender_identity',
            'cari_tanggal_awal',
            'cari_tanggal_akhir',
            'cari_event',

            'tipe_sort',
            'var_sort',
            'set_pagination',

            'data_sender_identity'
        ));



    }

    public function detail($message_id)
    {
        // Cek Data ada Atau Tidak
        $data_event = DeliveryEvent::where('message_id', $message_id)->orderBy('timestamp', 'asc')->get();

        if ($data_event->isEmpty()) {
            // Kembali dengan Flash Session Data
            return redirect()->route('get.delivery-event')->with('kesalahan', 'Data Tidak Ada !');

        }


        return view('events.delivery-detail', compact('data_event'));

        
    }

}

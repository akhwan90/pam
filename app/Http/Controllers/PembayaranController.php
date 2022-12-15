<?php

namespace App\Http\Controllers;

use App\Models\GolonganTarif;
use App\Models\Pelanggan;
use App\Models\CatatMeter;
use App\Models\Pegawai;
use App\Models\TransaksiBayar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use stdClass;

class PembayaranController extends Controller
{
    //

    public function getPeriode()
    {
        $tglBatasCatat = 15;
        // $getTglSekarang =
        
        $akhirPeriodeLalu = Carbon::now()->subMonthsNoOverflow()->endOfMonth();
        $periodeLaluTahun = $akhirPeriodeLalu->year;
        $periodeLaluBulan = $akhirPeriodeLalu->month;

        $periodeSebelumTahun = $akhirPeriodeLalu->subMonth(1);
        $periodeSebelumBulan = $akhirPeriodeLalu->subMonth(1);


        $tglBatasCatatPeriodeLalu = $akhirPeriodeLalu->addDay($tglBatasCatat);
        $tglSekarang = Carbon::now();
        
        return [
            'periode_tahun'=> $periodeLaluTahun,
            'periode_bulan'=> $periodeLaluBulan,
            'diff'=> ($tglSekarang->diffInHours($tglBatasCatatPeriodeLalu, false) > 0) ? true : false,
            'tglBatasPeriodeLalu'=>$tglBatasCatatPeriodeLalu,
            'periodeLaluTahun'=> $periodeSebelumTahun->year,
            'periodeLaluBulan'=> $periodeSebelumBulan->month,
        ];
    }

    public function index()
    {
        if (!empty(request('periode'))) {
            $pcPeriode = explode("-", request('periode'));
            $periode['tahun'] = $pcPeriode[0];
            $periode['bulan'] = $pcPeriode[1];
        } else {
            $periode['tahun'] = $this->getPeriode()['periode_tahun'];
            $periode['bulan'] = $this->getPeriode()['periode_bulan'];
        }

        $data['menuAktif'] = 'pencatatMeterBayar';
        $data['datas'] = Pelanggan::join('catat_meter', function($q) use ($periode) {
            $q->on('pelanggans.id', '=', 'catat_meter.pelanggan_id')
            ->where('catat_meter.periode_tahun', $periode['tahun'])
            ->where('catat_meter.periode_bulan', $periode['bulan']);
        })
        ->join('golongan_tarifs', 'pelanggans.golongan_tarif_id', '=', 'golongan_tarifs.id')
        ->select(
            'catat_meter.id AS id_catat',
            'catat_meter.posisi_meter', 
            'catat_meter.biaya_beban', 
            'catat_meter.periode_tahun', 
            'catat_meter.periode_bulan',
            'catat_meter.status_bayar', 
            'catat_meter.penggunaan', 
            'pelanggans.id AS pelanggan_id',
            'pelanggans.nama',
            'golongan_tarifs.tarif',
            'golongan_tarifs.nama AS nama_golongan_tarif',
        )
        ->paginate(100);

        $data['periode'] = $periode;

        return view('pencatat_meter.bayar.index', $data);
    }

    public function bayar($idPelanggan)
    {
        $tahun = request('tahun');
        $bulan = request('bulan');

        $data['menuAktif'] = 'catatMeter';
        $data['detilPelanggan'] = Pelanggan::where('pelanggans.id', $idPelanggan)
            ->join('golongan_tarifs', 'pelanggans.golongan_tarif_id', '=', 'golongan_tarifs.id')
            ->select(
                'pelanggans.*',
                'golongan_tarifs.nama AS nama_golongan_tarif',
                'golongan_tarifs.tarif',
                'golongan_tarifs.tarif_beban'
            )
            ->first();


        $getPosisiSekarang = CatatMeter::where('pelanggan_id', $idPelanggan)
            ->where('periode_tahun', $tahun)
            ->where('periode_bulan', $bulan)
            ->select(
                'posisi_meter',
                'penggunaan',
                'penggunaan_tarif',
                'periode_tahun',
                'periode_bulan',
            )
            ->first();

        if (empty($getPosisiSekarang)) {
            return redirect('pencatatMeter/catatMeter')->with('error', '<div class="alert alert-danger">Data transaksi tidak ditemukan</div>');
        }

        $data['posisiMeterPeriodeSekarang'] = $getPosisiSekarang;


        return view('pencatat_meter.bayar.bayar', $data);
    }

    public function bayarSave()
    {
        $credentials = request()->validate([
            'idPelanggan' => ['required'],
            'tahun' => ['required'],
            'bulan' => ['required'],
            'yang_harus_dibayar' => ['required'],
        ]);

        $userId = Auth::user()->id;
        $getPegawaiId = Pegawai::where('user_id', $userId)->first();
        $pegawaiId = $getPegawaiId->id;

        $idPelanggan = intval(request('idPelanggan'));
        $tahun = intval(request('tahun'));
        $bulan = intval(request('bulan'));
        $yangHarusDibayar = intval(request('yang_harus_dibayar'));


        // cek sudah ada
        $cekSudahAda = CatatMeter::where('periode_tahun', $tahun)
            ->where('periode_bulan', $bulan)
            ->where('pelanggan_id', $idPelanggan)
            ->where('status_bayar', 0)
            ->first();


        if (!empty($cekSudahAda)) {
            DB::beginTransaction();
            try {
                
                TransaksiBayar::insert([
                    'catat_meter_id'=>$cekSudahAda->id,
                    'jumlah_bayar'=>$yangHarusDibayar,
                    'admin_id'=>$userId,
                    'pegawai_id'=>$pegawaiId,
                    'created_at' => Carbon::now('utc')->toDateTimeString(),
                ]);
                CatatMeter::where('id', $cekSudahAda->id)->update([
                    'status_bayar' => 1,
                    'tgl_bayar' => Carbon::now('utc')->toDateTimeString(),
                    'metode_bayar' => 1,
                ]);
                //code...
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                // echo $th;
            }
        } 
        return redirect('pencatatMeter/pembayaran');
    }
}

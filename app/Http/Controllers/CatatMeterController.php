<?php

namespace App\Http\Controllers;

use App\Models\GolonganTarif;
use App\Models\Pelanggan;
use App\Models\CatatMeter;
use App\Models\Pegawai;
use App\Models\Setting;
use App\Models\TransaksiBayar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use stdClass;

class CatatMeterController extends Controller
{
    //

    public function getPeriode()
    {

        $tglBatasCatat = Setting::where('name', 'TANGGAL_CATAT_PERIODE')
        ->first()->value;
        
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

        $data['menuAktif'] = 'catatMeter';
        $data['datas'] = Pelanggan::leftJoin('catat_meter', function($q) use ($periode) {
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

        return view('pencatat_meter.catat_meter.index', $data);
    }

    public function edit($idPelanggan)
    {
        $data['menuAktif'] = 'catatMeter';
        $data['detilPelanggan'] = Pelanggan::where('pelanggans.id', $idPelanggan)
        ->join('golongan_tarifs', 'pelanggans.golongan_tarif_id', '=', 'golongan_tarifs.id')
        ->select(
            'pelanggans.*',
            'golongan_tarifs.nama AS nama_golongan_tarif',
            'golongan_tarifs.tarif'
        )
        ->first();


        // get periode sebelum
        $periodeSebelum = $this->getPeriode();

        $getDetilPeriodeSebelumnya = CatatMeter::where('pelanggan_id', $idPelanggan)
        ->where('periode_tahun', $periodeSebelum['periodeLaluTahun'])
        ->where('periode_bulan', $periodeSebelum['periodeLaluBulan'])
        ->select(
            'posisi_meter',
            'periode_tahun',
            'periode_bulan',
            'catat_meter.penggunaan_tarif',
            'catat_meter.status_bayar',
            'catat_meter.biaya_beban'
        )
        ->first();

        $data['detilPeriodeSebelumnya'] = $getDetilPeriodeSebelumnya;
        if (empty($getDetilPeriodeSebelumnya)) {
            $getDetilPeriodeSebelumnya = new stdClass();
            $getDetilPeriodeSebelumnya->posisi_meter = 0;
            $getDetilPeriodeSebelumnya->periode_tahun = $periodeSebelum['periodeLaluTahun'];
            $getDetilPeriodeSebelumnya->periode_bulan = $periodeSebelum['periodeLaluBulan'];
            $getDetilPeriodeSebelumnya->penggunaan_tarif = 0;
            $getDetilPeriodeSebelumnya->status_bayar = 0;
            $getDetilPeriodeSebelumnya->biaya_beban = 0;
            $data['detilPeriodeSebelumnya'] = $getDetilPeriodeSebelumnya;
        }
        
        $data['posisiMeterSebelumnya'] = 0;
        if (!empty($getDetilPeriodeSebelumnya)) {
            $data['posisiMeterSebelumnya'] = $getDetilPeriodeSebelumnya->posisi_meter;
        }


        $getPosisiSekarang = CatatMeter::where('pelanggan_id', $idPelanggan)
        ->where('periode_tahun', $periodeSebelum['periode_tahun'])
        ->where('periode_bulan', $periodeSebelum['periode_bulan'])
        ->select(
            'posisi_meter',
            'penggunaan',
            'penggunaan_tarif'
        )
        ->first();
        
        $data['posisiMeterPeriodeSekarang'] = $getPosisiSekarang;
        if (empty($getPosisiSekarang)) {
            $getPosisiSekarang = new stdClass();
            $getPosisiSekarang->posisi_meter = 0;
            $getPosisiSekarang->penggunaan = 0;
            $getPosisiSekarang->penggunaan_tarif = 0;
            $data['posisiMeterPeriodeSekarang'] = $getPosisiSekarang;
        }


        return view('pencatat_meter.catat_meter.edit', $data);
    }

    public function addSave()
    {
        $credentials = request()->validate([
            'idPelanggan' => ['required'],
            'tarif' => ['required'],
            'posisiPeriodeSebelumnya' => ['required'],
            'posisi_sekarang' => ['required'],
        ]);

        $userId = Auth::user()->id;
        $getPegawaiId = Pegawai::where('user_id', $userId)->first();
        $pegawaiId = $getPegawaiId->id;
        
        $idPelanggan = intval(request('idPelanggan'));

        // get tarif dan biaya beban
        $getDetilPelanggan = Pelanggan::where('pelanggans.id', $idPelanggan)
        ->join('golongan_tarifs', 'pelanggans.golongan_tarif_id', '=', 'golongan_tarifs.id')
        ->select(
            'golongan_tarifs.*'
        )
        ->first();

        $penggunaan = request('posisi_sekarang') - request('posisiPeriodeSebelumnya');
        $biayaPenggunaan = $penggunaan * request('tarif');

        // get periode 
        $periode = $this->getPeriode();
        $periodeTahun = $periode['periode_tahun'];
        $periodeBulan = $periode['periode_bulan'];

        // cek sudah ada
        $cekSudahAda = CatatMeter::where('periode_tahun', $periodeTahun)
        ->where('periode_bulan', $periodeBulan)
        ->where('pelanggan_id', $idPelanggan)
        ->first();


        if (empty($cekSudahAda)) {
            CatatMeter::insert([
                'periode_tahun'=>$periodeTahun,
                'periode_bulan'=>$periodeBulan,
                'pelanggan_id'=>$idPelanggan,
                'posisi_meter'=>request('posisi_sekarang'),
                'penggunaan'=>$penggunaan,
                'penggunaan_tarif'=>$biayaPenggunaan,
                'status_bayar'=>0,
                'metode_bayar'=>1,
                'pegawai_id'=>$pegawaiId,
                'user_id'=>$userId,
                'created_at' => Carbon::now('utc')->toDateTimeString(),
                'biaya_beban'=> $getDetilPelanggan->tarif_beban,
            ]);
        } else {
            CatatMeter::where('id', $cekSudahAda->id)->update([
                'posisi_meter' => request('posisi_sekarang'),
                'penggunaan' => $penggunaan,
                'penggunaan_tarif' => $biayaPenggunaan,
                'pegawai_id' => $pegawaiId,
                'user_id' => $userId,
                'updated_at' => Carbon::now('utc')->toDateTimeString(),
                'biaya_beban' => $getDetilPelanggan->tarif_beban,
            ]);
        }

        return redirect('pencatatMeter/catatMeter');
    }

    public function qr()
    {
        $data['menuAktif'] = 'catatMeter';
        return view('pencatat_meter.catat_meter.catat_via_qr', $data);
    }
}

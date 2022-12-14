<?php

namespace App\Http\Controllers;

use App\Models\GolonganTarif;
use App\Models\Pelanggan;
use App\Models\CatatMeter;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CatatMeterController extends Controller
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
        $periode['tahun'] = $this->getPeriode()['periode_tahun'];
        $periode['bulan'] = $this->getPeriode()['periode_bulan'];

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
            'pelanggans.id AS pelanggan_id',
            'pelanggans.nama',
            'golongan_tarifs.tarif',
            'golongan_tarifs.nama AS nama_golongan_tarif'
        )
        ->paginate(100);

        $data['periode'] = $periode;

        return view('pencatat_meter.catat_meter.index', $data);
    }

    public function add($idPelanggan)
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

        
        $posisiMeterSebelumnya = CatatMeter::where('pelanggan_id', $idPelanggan)
        ->select(
            'posisi_meter',
            'periode_tahun',
            'periode_bulan'
        )
        ->orderBy('id', 'desc')
        ->limit(1)
        ->first();

        $data['posisiMeterSebelumnya'] = 0;
        if (!empty($posisiMeterSebelumnya)) {
            $data['posisiMeterSebelumnya'] = $posisiMeterSebelumnya->posisi_meter;
        }
        $data['posisiMeterEdit'] = 0;

        return view('pencatat_meter.catat_meter.add', $data);
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

        $posisiMeterSebelumnya = CatatMeter::where('pelanggan_id', $idPelanggan)
        ->where('periode_tahun', $periodeSebelum['periodeLaluTahun'])
        ->where('periode_bulan', $periodeSebelum['periodeLaluBulan'])
        ->select(
            'posisi_meter',
            'periode_tahun',
            'periode_bulan'
        )
        ->first();

        $getPosisiSekarang = CatatMeter::where('pelanggan_id', $idPelanggan)
        ->where('periode_tahun', $periodeSebelum['periode_tahun'])
        ->where('periode_bulan', $periodeSebelum['periode_bulan'])
        ->select(
            'posisi_meter',
        )
        ->first();

        $data['posisiMeterSebelumnya'] = 0;
        if (!empty($posisiMeterSebelumnya)) {
            $data['posisiMeterSebelumnya'] = $posisiMeterSebelumnya->posisi_meter;
        }

        $data['posisiMeterEdit'] = $getPosisiSekarang->posisi_meter;

        return view('pencatat_meter.catat_meter.add', $data);
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
        

        $penggunaan = request('posisi_sekarang') - request('posisiPeriodeSebelumnya');
        $biayaPenggunaan = $penggunaan * request('tarif');

        // get periode 
        $periode = $this->getPeriode();
        $periodeTahun = $periode['periode_tahun'];
        $periodeBulan = $periode['periode_bulan'];

        // cek sudah ada
        $cekSudahAda = CatatMeter::where('periode_tahun', $periodeTahun)
        ->where('periode_bulan', $periodeBulan)
        ->where('pelanggan_id', request('idPelanggan'))
        ->first();

        if (empty($cekSudahAda)) {
            CatatMeter::insert([
                'periode_tahun'=>$periodeTahun,
                'periode_bulan'=>$periodeBulan,
                'pelanggan_id'=>request('idPelanggan'),
                'posisi_meter'=>request('posisi_sekarang'),
                'penggunaan'=>$penggunaan,
                'penggunaan_tarif'=>$biayaPenggunaan,
                'status_bayar'=>0,
                'metode_bayar'=>1,
                'pegawai_id'=>$pegawaiId,
                'user_id'=>$userId,
                'created_at' => Carbon::now('utc')->toDateTimeString()
            ]);
        } else {
            CatatMeter::where('id', $cekSudahAda->id)->update([
                'posisi_meter' => request('posisi_sekarang'),
                'penggunaan' => $penggunaan,
                'penggunaan_tarif' => $biayaPenggunaan,
                'pegawai_id' => $pegawaiId,
                'user_id' => $userId,
                'updated_at' => Carbon::now('utc')->toDateTimeString()
            ]);
        }

        return redirect('pencatatMeter/catatMeter');
    }
}

<?php

/*
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

namespace App\Libraries;

use App\Libraries\TinyMCE\FakeDataIsian;
use App\Libraries\TinyMCE\KodeIsianAnggotaKeluarga;
use App\Libraries\TinyMCE\KodeIsianAritmatika;
use App\Libraries\TinyMCE\KodeIsianForm;
use App\Libraries\TinyMCE\KodeIsianIdentitas;
use App\Libraries\TinyMCE\KodeIsianPasangan;
use App\Libraries\TinyMCE\KodeIsianPenandaTangan;
use App\Libraries\TinyMCE\KodeIsianPenduduk;
use App\Libraries\TinyMCE\KodeIsianPeristiwa;
use App\Libraries\TinyMCE\KodeIsianSurat;
use App\Libraries\TinyMCE\KodeIsianWilayah;
use App\Libraries\TinyMCE\ReplaceAlias;
use App\Models\AliasKodeIsian;
use App\Models\FormatSurat;
use App\Models\LogPenduduk;
use App\Models\Pamong;
use CI_Controller;
use Karriere\PdfMerge\PdfMerge;
use Spipu\Html2Pdf\Html2Pdf;

defined('BASEPATH') || exit('No direct script access allowed');

if (! in_array(setting('font_surat'), FONT_SYSTEM_TINYMCE)) {
    define('K_PATH_MAIN', '');
    define('K_PATH_FONTS', LOKASI_FONT_DESA);
}

class TinyMCE
{
    public const HEADER = '
        <table style="border-collapse: collapse; width: 100%;">
        <tbody>
        <tr>
        <td style="width: 10%;">[logo]</td>
        <td style="text-align: center; width: 90%;">
        <p style="margin: 0; text-align: center;"><span style="font-size: 14pt;">PEMERINTAH [SEbutan_kabupaten] [NAma_kabupaten] <br />KECAMATAN [NAma_kecamatan]<strong><br />[SEbutan_desa] [NAma_desa] </strong></span></p>
        <p style="margin: 0; text-align: center;"><em><span style="font-size: 10pt;">[Alamat_desA]</span></em></p>
        </td>
        </tr>
        </tbody>
        </table>
        <hr style="border: 3px solid;" />
    ';
    public const FOOTER = '
        <table style="border-collapse: collapse; width: 100%; height: 10px;" border="0">
        <tbody>
        <tr>
        <td style="width: 11.2886%; height: 10px;">[kode_desa]</td>
        <td style="width: 78.3174%; height: 10px;">
        <p style="text-align: center;">&nbsp;</p>
        </td>
        <td style="width: 10.3939%; height: 10px; text-align: right;">[KOde_surat]</td>
        </tr>
        </tbody>
        </table>
    ';
    public const FOOTER_TTE = '
        <table style="border-collapse: collapse; width: 100%; height: 10px;" border="0">
        <tbody>
        <tr>
        <td style="width: 11.2886%; height: 10px;">[kode_desa]</td>
        <td style="width: 78.3174%; height: 10px;">
        <p style="text-align: center;">&nbsp;</p>
        </td>
        <td style="width: 10.3939%; height: 10px; text-align: right;">[KOde_surat]</td>
        </tr>
        </tbody>
        </table>
        <table style="border-collapse: collapse; width: 100%; height: 10px;" border="0">
        <tbody>
        <tr>
        <td style="width: 15%;"><div style="max-height: 73px;">[logo_bsre]</div></td>
        <td style="width: 60%; text-align: left; vertical-align: top;">
        <ul style="font-size: 6pt;">
        <li style="font-size: 6pt;"><span style="font-size: 6pt;">UU ITE No. 11 Tahun 2008 Pasal 5 ayat 1 "Informasi Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah".</span></li>
        <li style="font-size: 6pt;"><span style="font-size: 6pt;">Dokumen ini tertanda ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan BSrE.</span></li>
        <li style="font-size: 6pt;"><span style="font-size: 6pt;">Surat ini dapat dibuktikan keasliannya dengan menggunakan qr code yang telah tersedia.</span></li>
        </ul>
        </td>
        <td style="width: 25%; text-align: center;">[qr_bsre]</td>
        </tr>
        </tbody>
        </table>
    ';
    public const TOP    = 3.5; // cm
    public const BOTTOM = 2; // cm

    /**
     * @var CI_Controller
     */
    protected $ci;

    /**
     * @var PdfMerge
     */
    public $pdfMerge;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('surat_model');

        $this->pdfMerge = new PdfMerge();
    }

    public function getTemplate()
    {
        $template = [
            [
                'nama'     => 'Header',
                'template' => [
                    'sistem' => static::HEADER,
                    'desa'   => setting('header_surat'),
                ],
            ],

            [
                'nama'     => 'Footer',
                'template' => [
                    'sistem' => static::FOOTER,
                    'desa'   => setting('footer_surat'),
                ],
            ],

            [
                'nama'     => 'Footer TTE',
                'template' => [
                    'sistem' => static::FOOTER_TTE,
                    'desa'   => setting('footer_surat_tte'),
                ],
            ],
        ];

        return collect($template);
    }

    public function getTemplateSurat()
    {
        return collect(FormatSurat::whereNotNull('template')->jenis(FormatSurat::TINYMCE)->get(['nama', 'template', 'template_desa']))
            ->map(static fn ($item, $key) => [
                'nama'     => 'Surat ' . $item->nama,
                'template' => [
                    'sistem' => $item->template,
                    'desa'   => $item->template_desa,
                ],
            ]);
    }

    public function getFormatedKodeIsian($data = [], $withData = false)
    {
        $idPenduduk      = $data['id_pend'];
        $judulPenduduk   = $data['surat']->form_isian->individu->judul ?? 'Penduduk';
        $daftarKodeIsian = grup_kode_isian($data['surat']->kode_isian);
        $daftarKategori  = collect($data['surat']->form_isian)->toArray();

        $alias = AliasKodeIsian::get();

        $daftar_kode_isian = [
            // Kode Isian Alias
            'Alias' => $alias->map(static function ($item) {
                return [
                    'judul' => $item->judul,
                    'isian' => $item->alias,
                    'data'  => $item->content,
                ];
            })->toArray(),

            // Data Surat
            'Surat' => KodeIsianSurat::get($data),

            // Data Form Surat
            'Form Surat' => KodeIsianForm::get($data['input'], null, $data['surat']['masa_berlaku'] > 0),

            // Data Identitas Desa
            'Identitas Desa' => KodeIsianIdentitas::get(),

            // Data Dusun
            'Wilayah' => KodeIsianWilayah::get(),

            // Data Penduduk
            $judulPenduduk => KodeIsianPenduduk::get($idPenduduk),

            // Data Form Penduduk
            "Form {$judulPenduduk}" => KodeIsianForm::get($data['input'], $daftarKodeIsian['individu'] ?? []),

            // Data Anggota keluarga
            'Anggota Keluarga' => KodeIsianAnggotaKeluarga::get($idPenduduk),

            // Data Pasangan
            'Pasangan' => KodeIsianPasangan::get($idPenduduk),

            // Data Aritmatika untuk penambahan, pengurangan, dan operasi lainnya serta terbilang
            'Aritmatika' => KodeIsianAritmatika::get(),
        ];

        if ($alias->count() <= 0) {
            unset($daftar_kode_isian['Alias']);
        }

        $peristiwa = $data['surat']->form_isian->individu->status_dasar;
        if (array_intersect($peristiwa, LogPenduduk::PERISTIWA)) {
            $daftar_kode_isian['Peristiwa'] = KodeIsianPeristiwa::get($idPenduduk, $peristiwa);
        }

        foreach ($daftarKategori as $key => $value) {
            if ($value->sumber != 1) {
                continue;
            }

            if (! $value->sumber) {
                $value->sumber = 1;
            }

            if (! $value->judul || ! $value->label) {
                $judul        = str_replace('_', ' ', ucwords($key));
                $value->judul = $judul;
                $value->label = $judul;
            }

            if ($value->sumber == 1 && $key != 'individu') {
                if (array_intersect($value->data, [1])) {
                    $daftar_kode_isian[$value->judul] = KodeIsianPenduduk::get($data['input']['id_pend_' . $key], $key);
                }
                $daftar_kode_isian["Form {$value->judul}"] = KodeIsianForm::get($data['input'], $daftarKodeIsian[$key] ?? []);
            } elseif ($value->sumber == 1 && $key == 'individu') {
                if (! array_intersect($value->data, [1])) {
                    unset($daftar_kode_isian[$judulPenduduk]);
                }
            }
        }

        // Penandatangan
        $daftar_kode_isian['Penandatangan'] = KodeIsianPenandaTangan::get($data['input']);

        $daftar_kode_isian = collect($daftar_kode_isian)->map(static function ($item) {
            return collect($item)->map(static function ($item) {
                $item['isian'] = getFormatIsian($item['isian'], $item['case_sentence']);

                return $item;
            });
        })->toArray();

        if ($withData) {
            return collect($daftar_kode_isian)
                ->flatten(1)
                ->pluck('data', 'isian.normal')
                ->toArray();
        }

        if (isset($daftar_kode_isian['Alias'])) {
            // Tukar Posisi Alias agar tampil terakhir
            $daftar_kode_isian['Alias'] = array_shift($daftar_kode_isian);
        }

        return $daftar_kode_isian;
    }

    public function formatPdf($header, $footer, $isi)
    {
        // Pisahkan isian surat
        $isi = str_replace('<p><!-- pagebreak --></p>', '', $isi);
        $isi = explode('<!-- pagebreak -->', $isi);

        // Pengaturan Header
        switch ($header) {
            case 0:
                $backtop    = '0mm';
                $isi_header = '<page_header>' . $isi[0] . '</page_header>';
                $isi_surat  = $isi[1];
                break;

            case 1:
                $backtop    = ((float) setting('tinggi_header')) * 10 . 'mm';
                $isi_header = '<page_header>' . $isi[0] . '</page_header>';
                $isi_surat  = $isi[1];
                break;

            default:
                $backtop    = '0mm';
                $isi_header = '';
                $isi_surat  = $isi[0] . $isi[1];
                break;
        }

        // Pengaturan Footer
        switch ($footer) {
            case 0:
                $backbottom = '0mm';
                $isi_footer = '';
                break;

            default:
                $backbottom = (((float) setting('tinggi_footer')) * 10) . 'mm';
                $isi_footer = '<page_footer>' . $isi[2] . '</page_footer>';
                break;
        }

        return '
            <page backtop="' . $backtop . '" backbottom="' . $backbottom . '">
            ' . $isi_header . '
            ' . $isi_footer . '
            ' . $isi_surat . '
            </page>
        ';
    }

    /**
     * Replace kode isian dengan data yang sesuai.
     *
     * @param array $data
     * @param bool  $imageReplace
     *
     * @return string
     */
    public function replceKodeIsian($data = [], $imageReplace = true)
    {
        $result = $data['isi_surat'];

        $gantiDengan  = setting('ganti_data_kosong');
        $newKodeIsian = collect($this->getFormatedKodeIsian($data, true))
            ->flatMap(static function ($value, $key) {
                if (preg_match('/klg/i', $key)) {
                    return collect(range(1, 10))->map(static function ($i) use ($key, $value) {
                        return [
                            'isian' => str_replace('x_', "{$i}_", $key),
                            'data'  => $value[$i - 1] ?? '',
                        ];
                    });
                } else {
                    return [
                        [
                            'isian' => $key,
                            'data'  => $value,
                        ],
                    ];
                }
            })
            ->mapWithKeys(static function ($item) {
                return [$item['isian'] => $item['data']];
            })
            ->map(static function ($item) use ($gantiDengan) {
                if (null === $item || $item == '/') {
                    return $gantiDengan;
                }

                return $item;
            })
            ->toArray();

        if ((int) $data['surat']['masa_berlaku'] == 0) {
            $result = str_ireplace('[mulai_berlaku] s/d [berlaku_sampai]', $gantiDengan, $result);
        }

        // Kode isian yang berupa alias harus didahulukan
        $alias = ReplaceAlias::get($data['surat'], $data['input']);

        if ($alias) {
            $newKodeIsian = array_replace($newKodeIsian, $alias);
        }

        $pisahkanFoto = [];

        foreach ($newKodeIsian as $key => $value) {
            if (in_array(strtolower($key), array_map('strtolower', ['[terbilang]', '[hitung]']))) {
                continue;
            }
            if (preg_match('/(<img src=")(.*?)(">)/', $key)) {
                $pisahkanFoto[$key] = $value;

                continue;
            }
            // TODO:: Cek dari awal pembuatan, kodeisian [format_nomor_surat] tidak mengikuti aturan penulisan, selalu hasilnya huruf besar.
            if (in_array(strtolower($key), array_map('strtolower', ['[format_nomor_surat]']))) {
                $result = str_ireplace($key, strtoupper($value), $result);
            }
            if (preg_match('/pengikut_surat/i', $key)) {
                $result = str_replace($key, $data['pengikut_surat'] ?? '', $result);
            }
            if (preg_match('/pengikut_kartu_kis/i', $key)) {
                $result = str_replace($key, $data['pengikut_kartu_kis'] ?? '', $result);
            }
            if (preg_match('/pengikut_kis/i', $key)) {
                $result = str_replace($key, $data['pengikut_kis'] ?? '', $result);
            }

            if (preg_match('/pengikut_pindah/i', $key)) {
                $result = str_replace($key, $data['pengikut_pindah'] ?? '', $result);
            }

            $result = case_replace($key, $value, $result);
        }

        // Kode isian berupa hitungan perlu didahulukan
        $result = caseHitung($result);

        $result = terjemahkanTerbilang($result);

        if ($imageReplace) {
            foreach ($pisahkanFoto as $key => $value) {
                $result = caseReplaceFoto($result, $key, $value);
            }
        }

        return $result;
    }

    /**
     * Daftar penandatangan dan pamongnya
     *
     * @return array
     */
    public function formPenandatangan()
    {
        $atas_nama     = [];
        $config        = identitas();
        $penandatangan = Pamong::penandaTangan()->get();

        // Kepala Desa
        $kades = Pamong::kepalaDesa()->first();
        if ($kades) {
            $atas_nama[''] = $kades->pamong_jabatan . ' ' . $config->nama_desa;

            // Sekretaris Desa
            $sekdes = Pamong::ttd('a.n')->first();
            if ($sekdes) {
                $atas_nama['a.n'] = 'a.n ' . $kades->pamong_jabatan . ' ' . $config->nama_desa;

                // Pamogn selain Kepala Desa dan Sekretaris Desa
                $pamong = Pamong::ttd('u.b')->exists();
                if ($pamong) {
                    $atas_nama['u.b'] = 'u.b ' . $sekdes->pamong_jabatan . ' ' . $config->nama_desa;
                }
            }

            return [
                'penandatangan' => $penandatangan,
                'atas_nama'     => $atas_nama,
            ];
        }
        session_error(', ' . setting('sebutan_kepala_desa') . ' belum ditentukan.');
        redirect('pengurus');
    }

    /**
     * Daftar penandatangan dan pamongnya
     *
     * @return array
     */
    public function getDaftarLampiran()
    {
        $lampiran               = [];
        $daftar_lampiran_sistem = glob(DEFAULT_LOKASI_LAMPIRAN_SURAT . '*', GLOB_ONLYDIR);
        $daftar_lampiran_desa   = glob(LOKASI_LAMPIRAN_SURAT_DESA . '*', GLOB_ONLYDIR);
        $daftar_lampiran        = array_merge($daftar_lampiran_desa, $daftar_lampiran_sistem);

        foreach ($daftar_lampiran as $value) {
            if (file_exists(FCPATH . $value . '/view.php')) {
                $lampiran[] = kode_format(basename($value));
            }
        }

        return collect($lampiran)->unique()->sort()->values();
    }

    /**
     * Generate surat menggunakan html2pdf, kemudian gabungakan ke pdfMerge.
     *
     * @param string $surat
     * @param array  $margins
     *
     * @return PdfMerge
     */
    public function generateSurat($surat, array $data, $margins)
    {
        $surat = str_replace(base_url(), FCPATH, $surat);

        (new Html2Pdf($data['surat']['orientasi'], $data['surat']['ukuran'], 'en', true, 'UTF-8', $margins))
            ->setTestTdInOnePage(true)
            ->setDefaultFont(underscore(setting('font_surat'), true, true))
            ->writeHTML($surat) // buat surat
            ->output($out = tempnam(sys_get_temp_dir(), '') . '.pdf', 'F');

        return $this->pdfMerge->add($out);
    }

    /**
     * Generate lampiran menggunakan html2pdf, kemudian gabungakan ke pdfMerge.
     *
     * @param int|string|null $id
     *
     * @return PdfMerge|null
     */
    public function generateLampiran($id = null, array $data = [])
    {
        if (empty($data['surat']['lampiran'])) {
            return;
        }

        $surat    = $data['surat'];
        $input    = $data['input'];
        $config   = identitas();
        $individu = $this->surat_model->get_data_surat($id);

        // Data penandatangan terpilih
        $penandatangan = $this->surat_model->atas_nama($data);

        $lampiran     = explode(',', strtolower($surat['lampiran']));
        $format_surat = substitusiNomorSurat($input['nomor'], setting('format_nomor_surat'));
        $format_surat = str_ireplace('[kode_surat]', $surat['kode_surat'], $format_surat);
        $format_surat = str_ireplace('[kode_desa]', $config['kode_desa'], $format_surat);
        $format_surat = str_ireplace('[bulan_romawi]', bulan_romawi((int) (date('m'))), $format_surat);
        $format_surat = str_ireplace('[tahun]', date('Y'), $format_surat);

        if (isset($input['gunakan_format'])) {
            unset($lampiran);

            switch (strtolower($input['gunakan_format'])) {
                case 'f-1.08 (pindah pergi)':
                    $lampiran[] = 'f-1.08';
                    break;

                case 'f-1.23, f-1.25, f-1.29, f-1.34 (sesuai tujuan)':
                    $lampiran[] = 'f-1.25';
                    break;

                case 'f-1.03 (pindah datang)':
                    $lampiran[] = 'f-1.03';
                    break;

                case 'f-1.27, f-1.31, f-1.39 (sesuai tujuan)':
                    $lampiran[] = 'f-1.27';
                    break;

                default:
                    $lampiran[] = null;
                    break;
            }
        }

        // exclude lampiran jika lampiran tidak dikaitkan dengan nilai inputan tertentu
        $lampiran = $this->excludeLampiran($surat, $input, $lampiran);

        for ($i = 0; $i < count($lampiran); $i++) {
            // Cek lampiran desa
            $view_lampiran[$i] = FCPATH . LOKASI_LAMPIRAN_SURAT_DESA . $lampiran[$i] . '/view.php';

            if (! file_exists($view_lampiran[$i])) {
                $view_lampiran[$i] = FCPATH . DEFAULT_LOKASI_LAMPIRAN_SURAT . $lampiran[$i] . '/view.php';
            }

            $data_lampiran[$i] = FCPATH . LOKASI_LAMPIRAN_SURAT_DESA . $lampiran[$i] . '/data.php';
            if (! file_exists($data_lampiran[$i])) {
                $data_lampiran[$i] = FCPATH . DEFAULT_LOKASI_LAMPIRAN_SURAT . $lampiran[$i] . '/data.php';
            }

            // Data lampiran
            include $data_lampiran[$i];
        }

        ob_start();

        for ($j = 0; $j < count($lampiran); $j++) {
            // View Lampiran
            include $view_lampiran[$j];
        }

        $lampiran = ob_get_clean();

        $data['isi_surat'] = $lampiran;

        $lampiran = $this->replceKodeIsian($data, false);

        (new Html2Pdf($data['surat']['orientasi'], $data['surat']['ukuran'], 'en', true, 'UTF-8'))
            ->setTestTdInOnePage(true)
            ->setDefaultFont(underscore(setting('font_surat'), true, true))
            ->writeHTML($lampiran) // buat lampiran
            ->output($out = tempnam(sys_get_temp_dir(), '') . '.pdf', 'F');

        return $this->pdfMerge->add($out);
    }

    public function __get($name)
    {
        return $this->ci->{$name};
    }

    public function __call($method, $arguments)
    {
        return $this->ci->{$method}(...$arguments);
    }

    private function excludeLampiran($surat, $input, $lampiran)
    {
        $kodeIsian       = $surat->kode_isian;
        $includeLampiran = []; // tambahkan lampiran jika memenuhi syarat
        $excludeLampiran = []; // semua lampiran dengan syarat

        foreach ($kodeIsian as $isian) {
            if ($isian->kaitkan_kode) {
                if (! empty($isian->kaitkan_kode)) {
                    foreach ((array) $isian->kaitkan_kode as $kaitkanItem) {
                        $kaitkanArr = json_decode($kaitkanItem, true);

                        foreach ($kaitkanArr as $kaitkan) {
                            $namaElm = substr('[form_status_kawin_pria]', strlen('[form_'), -1);

                            if ($kaitkan['lampiran_terkait']) {
                                foreach ($kaitkan['lampiran_terkait'] as $key => $value) {
                                    $excludeLampiran[] = strtolower($value);
                                }
                            }

                            if (in_array($input[$namaElm], $kaitkan['nilai_isian'])) {
                                if ($kaitkan['lampiran_terkait']) {
                                    foreach ($kaitkan['lampiran_terkait'] as $key => $value) {
                                        $includeLampiran[] = strtolower($value);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $lampiranTanpaSyarat = array_diff($lampiran, $excludeLampiran);

        return array_merge($lampiranTanpaSyarat, $includeLampiran);
    }

    public function getPreview($request)
    {
        return FakeDataIsian::set($request);
    }

    public function generateMultiPage(string $templateString)
    {
        if (empty($templateString)) {
            return [];
        }
        $pattern = '/<div\s+style="page-break-after:\s*always;">.*<!-- pagebreak -->.*<\/div>/im';

        return preg_split($pattern, $templateString);
    }
}

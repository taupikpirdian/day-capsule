<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use App\Repositories\Interfaces\LapduRepositoryInterface;
use App\Repositories\Interfaces\EksekusiRepositoryInterface;
use App\Repositories\Interfaces\PenuntutanRepositoryInterface;
use App\Repositories\Interfaces\PenyidikanRepositoryInterface;
use App\Repositories\Interfaces\SatuanKerjaRepositoryInterface;
use App\Repositories\Interfaces\PenyelidikanRepositoryInterface;

class MonevExport implements FromView
{
    public $title, $user, $lapduRepo, $satuanKerjaRepo, $penyelidikanRepo, $penyidikanRepo, $penuntutanRepo, $eksekusiRepo;
    public $havePermissionView, $havePermissionDelete, $havePermissionEdit;

    public function __construct(
        LapduRepositoryInterface $lapduRepo,
        SatuanKerjaRepositoryInterface $satuanKerjaRepo,
        PenyelidikanRepositoryInterface $penyelidikanRepo,
        PenyidikanRepositoryInterface $penyidikanRepo,
        PenuntutanRepositoryInterface $penuntutanRepo,
        EksekusiRepositoryInterface $eksekusiRepo
    ) {
        $this->title = "Penilaian Kinerja Satuan Kerja Kejaksaan Tinggi Dalam Penanganan Perkara Tindak Pidana Khusus Tahun " . date('Y');
        $this->lapduRepo = $lapduRepo;
        $this->satuanKerjaRepo = $satuanKerjaRepo;
        $this->penyelidikanRepo = $penyelidikanRepo;
        $this->penyidikanRepo = $penyidikanRepo;
        $this->penuntutanRepo = $penuntutanRepo;
        $this->eksekusiRepo = $eksekusiRepo;
    }
    
    public function view(): View
    {
        $rows = [
            [
                'no' => 1,
                'kriteria_penilaian' => 'KUALITAS PENANGANAN PERKARA TINDAK PIDANA KHUSUS',
                'bobot' => 40,
                'count_total_uraian' => 11,
                'tahapan_kegiatan' => [
                    [
                        'title' => 'Penyelidikan (30%)',
                        'count_uraian' => 2,
                        'uraian' => [
                            [
                                'is_first' => true,
                                'title' => 'Penyelidikan terkait 7 perkara direktif (Sprinlid terbit tahun '.date('Y').')',
                                'poin' => 20,
                                'jumlah' => 1,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-2",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyelidikan diluar 7 perkara direktif (Sprinlid terbit tahun '.date('Y').')',
                                'poin' => 10,
                                'jumlah' => 22,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-2",
                            ]
                        ]
                    ],
                    [
                        'title' => 'Penyelidikan (70%)',
                        'count_uraian' => 9,
                        'uraian' => [
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan terkait 7 perkara direktif (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 20,
                                'jumlah' => 3,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan diluar 7 perkara direktif (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 5,
                                'jumlah' => 8,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan terkait Pelaku tindak pidana sebagai penyelenggara negara UU RI 28 tahun 1999 (Sprindik terbit tahun '.date('Y').'): Pejabat Negara Lembaga Tinggi, Menteri, Gubernur, Hakim, Dubes, Wakil Gubernur, Bupati/Walikota, Direksi Komisaris BUMN/BUMD, pimpinan BI, Rektor/ Warek, Pejabat Eselon 1, Pimpinan DPRD, Jaksa, Penyidik, Panitera, Pimpinan dan Bendahara Proyek',
                                'poin' => 9,
                                'jumlah' => 1,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan terkait Pelaku tindak pidana selain penyelenggara negara (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 5,
                                'jumlah' => 5,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan dengan penerapan TPPU (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 9,
                                'jumlah' => 0,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan dengan tersangka Korporasi (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 8,
                                'jumlah' => 0,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan dengan nilai kerugian negara > Rp5 Miliar (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 9,
                                'jumlah' => 4,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Surat dari Auditor",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyidikan dengan pembuktian kerugian perekonomian negara (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 8,
                                'jumlah' => 0,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Surat dari Auditor/Ahli",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Pelelangan benda sitaan (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 7,
                                'jumlah' => 0,
                                'nilai_percent' => 40/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Bukti setor RPL/BA Penitipan/Penilaian sementara",
                            ]
                        ]
                    ]
                ]
            ],
            [
                'no' => 2,
                'kriteria_penilaian' => 'KUANTITAS PENANGANAN PERKARA TINDAK PIDANA KHUSUS',
                'bobot' => 30,
                'count_total_uraian' => 9,
                'tahapan_kegiatan' => [
                    [
                        'title' => 'Penyelidikan (30%)',
                        'count_uraian' => 3,
                        'uraian' => [
                            [
                                'is_first' => true,
                                'title' => 'Jumlah Penyelidikan (Sprinlid terbit tahun '.date('Y').')',
                                'poin' => 10,
                                'jumlah' => 1,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-2",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Penyelesaian Penyelidikan (Sprinlid terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')',
                                'poin' => 20,
                                'jumlah' => 22,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Pidsus-7",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Tunggakan Penyelidikan (Sprinlid sebelum tahun '.date('Y').')',
                                'poin' => -6,
                                'jumlah' => 22,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-2",
                            ]
                        ]
                    ],
                    [
                        'title' => 'Penyidikan (55%)',
                        'count_uraian' => 4,
                        'uraian' => [
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Penyidikan (Sprindik terbit tahun '.date('Y').')',
                                'poin' => 15,
                                'jumlah' => 3,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Penetapan tersangka (Sprindik terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')',
                                'poin' => 15,
                                'jumlah' => 8,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Pidsus-18",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Penyelesaian Penyidikan (Sprindik terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')',
                                'poin' => 25,
                                'jumlah' => 1,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Tunggakan Penyidikan (Sprindik terbit sebelum tahun '.date('Y').' yang belum diselesaikan)',
                                'poin' => -6,
                                'jumlah' => 5,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                        ]
                    ],
                    [
                        'title' => 'Prapenuntutan (15%)',
                        'count_uraian' => 2,
                        'uraian' => [
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Prapenuntutan (Sprin Jaksa Peneliti terbit tahun '.date('Y').')',
                                'poin' => 6,
                                'jumlah' => 3,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Penyelesaian Prapenuntutan TP. Korupsi/TP. Khusus Lainnya (Sprin  Jaksa Peneliti terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')',
                                'poin' => 9,
                                'jumlah' => 8,
                                'nilai_percent' => 30/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Pidsus-18",
                            ],
                        ]
                    ]
                ]
            ],
            [
                'no' => 3,
                'kriteria_penilaian' => 'PENYELAMATAN KEUANGAN NEGARA',
                'bobot' => 15,
                'count_total_uraian' => 6,
                'tahapan_kegiatan' => [
                    [
                        'title' => 'Penyelidikan (45%)',
                        'count_uraian' => 3,
                        'uraian' => [
                            [
                                'is_first' => true,
                                'title' => 'Pengembalian Uang Negara (PNBP Kejaksaan) diatas Rp5 Miliar',
                                'poin' => 45,
                                'jumlah' => 1,
                                'nilai_percent' => 15/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Bukti setor PNBP",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Pengembalian Uang Negara (PNBP Kejaksaan) Rp1 Miliar s/d Rp5 Miliar',
                                'poin' => 25,
                                'jumlah' => 22,
                                'nilai_percent' => 15/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Bukti setor PNBP",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Pengembalian Uang Negara (PNBP Kejaksaan) kurang dari Rp1 Miliar',
                                'poin' => 10,
                                'jumlah' => 22,
                                'nilai_percent' => 15/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Bukti setor PNBP",
                            ]
                        ]
                    ],
                    [
                        'title' => 'Penyidikan (55%)',
                        'count_uraian' => 3,
                        'uraian' => [
                            [
                                'is_first' => false,
                                'title' => 'Penyelamatan Kerugian Negara diatas Rp100 Miliar',
                                'poin' => 55,
                                'jumlah' => 3,
                                'nilai_percent' => 15/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "BA sita /Blokir/ BA titip",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyelamatan Kerugian Negara Rp50 Miliar s/d Rp100 Miliar',
                                'poin' => 25,
                                'jumlah' => 8,
                                'nilai_percent' => 15/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "BA sita /Blokir/ BA titip",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Penyelamatan Kerugian Negara kurang dari Rp50 Miliar',
                                'poin' => 10,
                                'jumlah' => 1,
                                'nilai_percent' => 15/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "BA sita /Blokir/ BA titip",
                            ],
                        ]
                    ]
                ]
            ],
            [
                'no' => 4,
                'kriteria_penilaian' => 'MANAJERIAL',
                'bobot' => 10,
                'count_total_uraian' => 7,
                'tahapan_kegiatan' => [
                    [
                        'title' => 'Penyelidikan (20%)',
                        'count_uraian' => 2,
                        'uraian' => [
                            [
                                'is_first' => true,
                                'title' => 'Jumlah Penyelesaian Penyelidikan sesuai dengan SOP (Maksimal Pulau Jawa 42 hari, Luar Pulau Jawa 60 hari)',
                                'poin' => 5,
                                'jumlah' => 1,
                                'nilai_percent' => 10/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "SprinLid & BA Ekspose",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Kepatuhan pengisian CMS Input Data 100% Dibawah 100% Jumlah = 0, 100% Jumlah = 1',
                                'poin' => 15,
                                'jumlah' => 22,
                                'nilai_percent' => 10/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-2 dan Screenshot CMS",
                            ],
                        ]
                    ],
                    [
                        'title' => 'Penyidikan (20%)',
                        'count_uraian' => 2,
                        'uraian' => [
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Penyelesaian Penyidikan sesuai dengan SOP (Maksimal 120 hari)',
                                'poin' => 5,
                                'jumlah' => 3,
                                'nilai_percent' => 10/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8 & P-21",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Kepatuhan pengisian CMS Input Data 100%  Dibawah 100% Jumlah = 0, 100% Jumlah = 1',
                                'poin' => 15,
                                'jumlah' => 8,
                                'nilai_percent' => 10/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-8 dan Screenshot CMS",
                            ],
                        ]
                    ],
                    [
                        'title' => 'Prapenuntutan (20%)',
                        'count_uraian' => 2,
                        'uraian' => [
                            [
                                'is_first' => false,
                                'title' => 'Jumlah Penyelesaian Prapenuntutan sesuai SOP (Maksimal 14 hari)',
                                'poin' => 5,
                                'jumlah' => 3,
                                'nilai_percent' => 10/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Pengantar penyerahan berkas & P-18, P-19/P-21",
                            ],
                            [
                                'is_first' => false,
                                'title' => 'Kepatuhan pengisian CMS Input Data 100% Dibawah 100% Jumlah = 0, 100% Jumlah = 1',
                                'poin' => 15,
                                'jumlah' => 8,
                                'nilai_percent' => 10/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-21 dan Screenshot CMS",
                            ],
                        ]
                    ],
                    [
                        'title' => 'Monev (40%)',
                        'count_uraian' => 1,
                        'uraian' => [
                            [
                                'is_first' => false,
                                'title' => 'Jumlah kegiatan monitoring, evaluasi dan supervisi kepada satuan kerja diwilayahnya',
                                'poin' => 40,
                                'jumlah' => 3,
                                'nilai_percent' => 10/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Pengantar penyerahan berkas & P-18, P-19/P-21",
                            ]
                        ]
                    ]
                ]
            ],
            [
                'no' => 5,
                'kriteria_penilaian' => 'ANGGARAN TINDAK PIDANA KHUSUS',
                'bobot' => 5,
                'count_total_uraian' => 3,
                'tahapan_kegiatan' => [
                    [
                        'title' => 'Penyerapan Anggaran  (100%)',
                        'count_uraian' => 3,
                        'uraian' => [
                            [
                                'is_first' => true,
                                'title' => '96% s/d 100%',
                                'poin' => 5,
                                'jumlah' => 1,
                                'nilai_percent' => 5/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "Laporan realisasi anggaran penanganan perkara pidana khusus",
                            ],
                            [
                                'is_first' => false,
                                'title' => '75% s/d 95%',
                                'poin' => 3,
                                'jumlah' => 22,
                                'nilai_percent' => 5/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-2 dan Screenshot CMS",
                            ],
                            [
                                'is_first' => false,
                                'title' => '50 % s/d 75%',
                                'poin' => 1,
                                'jumlah' => 22,
                                'nilai_percent' => 5/100,
                                'upload_bukti' => "",
                                'verifikasi_kejagung' => [
                                    'jumlah' => 0,
                                    'nilai' => 0
                                ],
                                'total_cxp' => 0,
                                'catatan' => "",
                                'dokumen_bukti_dukung' => "P-2 dan Screenshot CMS",
                            ],
                        ]
                    ],
                ]
            ],
        ];
        foreach ($rows as $key => $row) {
            foreach ($row['tahapan_kegiatan'] as $i => $value) {
                foreach ($value['uraian'] as $j => $uraian) {
                    $title = $uraian['title'];
                    switch ($title) {
                      case "Penyelidikan terkait 7 perkara direktif (Sprinlid terbit tahun ".date('Y').")":
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanTerkait7Perkara(PERKARA_DIREKTIF);
                        break;
                      case "Penyelidikan diluar 7 perkara direktif (Sprinlid terbit tahun ".date('Y').")":
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanTerkait7Perkara(DILUAR_7_PERKARA_DIREKTIF);
                        break;
                      case 'Penyidikan terkait 7 perkara direktif (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanTerkait7Perkara(PERKARA_DIREKTIF);
                        break;
                      case 'Penyidikan diluar 7 perkara direktif (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanTerkait7Perkara(DILUAR_7_PERKARA_DIREKTIF);
                        break;
                      case 'Penyidikan terkait Pelaku tindak pidana sebagai penyelenggara negara UU RI 28 tahun 1999 (Sprindik terbit tahun '.date('Y').'): Pejabat Negara Lembaga Tinggi, Menteri, Gubernur, Hakim, Dubes, Wakil Gubernur, Bupati/Walikota, Direksi Komisaris BUMN/BUMD, pimpinan BI, Rektor/ Warek, Pejabat Eselon 1, Pimpinan DPRD, Jaksa, Penyidik, Panitera, Pimpinan dan Bendahara Proyek':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->pelakuSebagaiPenyelenggaraNegara(true);
                        break;
                      case 'Penyidikan terkait Pelaku tindak pidana selain penyelenggara negara (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->pelakuSebagaiPenyelenggaraNegara(false);
                        break;
                      case 'Penyidikan dengan penerapan TPPU (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanDisertaiTPPU();
                        break;
                      case 'Penyidikan dengan tersangka Korporasi (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanKorperasiCount();
                        break;
                      case 'Penyidikan dengan nilai kerugian negara > Rp5 Miliar (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanBerdasarkanKerugian(true);
                        break;
                      case 'Penyidikan dengan pembuktian kerugian perekonomian negara (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanPembuktianKerugianNegaraCount();
                        break;
                      case 'Pelelangan benda sitaan (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->eksekusiPelelanganBendaSitaanCount();
                        break;
                      case 'Jumlah Penyelidikan (Sprinlid terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanCount();
                        break;
                      case 'Jumlah Penyelesaian Penyelidikan (Sprinlid terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanSudahDisposisi(true);
                        break;
                      case 'Jumlah Tunggakan Penyelidikan (Sprinlid sebelum tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanSudahDisposisi(false);
                        break;
                      case 'Jumlah Penyidikan (Sprindik terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanCount();
                        break;
                      case 'Jumlah Penetapan tersangka (Sprindik terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanTapTersangkaCount();
                        break;
                      case 'Jumlah Penyelesaian Penyidikan (Sprindik terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanSudahDisposisi(true);
                        break;
                      case 'Jumlah Tunggakan Penyidikan (Sprindik terbit sebelum tahun '.date('Y').' yang belum diselesaikan)':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanSudahDisposisi(false);
                        break;
                      case 'Jumlah Prapenuntutan (Sprin Jaksa Peneliti terbit tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanP16Count(date('Y'));
                        break;
                      case 'Jumlah Penyelesaian Prapenuntutan TP. Korupsi/TP. Khusus Lainnya (Sprin  Jaksa Peneliti terbit tahun '.date('Y').' maupun sebelum tahun '.date('Y').')':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanP16Count();;
                        break;
                      case 'Pengembalian Uang Negara (PNBP Kejaksaan) diatas Rp5 Miliar':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanPengembalianUangNegaraCount(NOMINAL_5M);
                        break;
                      case 'Pengembalian Uang Negara (PNBP Kejaksaan) Rp1 Miliar s/d Rp5 Miliar':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanPengembalianUangNegaraCount(ANTARA_NOMINAL_5M_DAN_10M);
                        break;
                      case 'Pengembalian Uang Negara (PNBP Kejaksaan) kurang dari Rp1 Miliar':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanPengembalianUangNegaraCount(NOMINAL_KURANG_1M);
                        break;
                      case 'Penyelamatan Kerugian Negara diatas Rp100 Miliar':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanPenyelematanKerugianNegaraCount(NOMINAL_DIATAS_100M);
                        break;
                      case 'Penyelamatan Kerugian Negara Rp50 Miliar s/d Rp100 Miliar':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanPenyelematanKerugianNegaraCount(ANTARA_NOMINAL_50M_DAN_100M);
                        break;
                      case 'Penyelamatan Kerugian Negara kurang dari Rp50 Miliar':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanPenyelematanKerugianNegaraCount(NOMINAL_KURANG_50M);
                        break;
                      case 'Jumlah Penyelesaian Penyelidikan sesuai dengan SOP (Maksimal Pulau Jawa 42 hari, Luar Pulau Jawa 60 hari)':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanSesuaiSopCount();
                        break;
                      case 'Kepatuhan pengisian CMS Input Data 100% Dibawah 100% Jumlah = 0, 100% Jumlah = 1':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyelidikanCmsP2Count();;
                        break;
                      case 'Jumlah Penyelesaian Penyidikan sesuai dengan SOP (Maksimal 120 hari)':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanSesuaiSopCount();
                        break;
                      case 'Kepatuhan pengisian CMS Input Data 100%  Dibawah 100% Jumlah = 0, 100% Jumlah = 1':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanCmsP8Count();
                        break;
                      case 'Jumlah Penyelesaian Prapenuntutan sesuai SOP (Maksimal 14 hari)':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->tuntutanSesuaiSopCount();
                        break;
                      case 'Kepatuhan pengisian CMS Input Data 100% Dibawah 100% Jumlah = 0, 100% Jumlah = 1':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = $this->penyidikanP16Count(date('Y'));
                        break;
                      case 'Jumlah kegiatan monitoring, evaluasi dan supervisi kepada satuan kerja diwilayahnya':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = 0;
                        break;
                      case '96% s/d 100%':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = 0;
                        break;
                      case '75% s/d 95%':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = 0;
                        break;
                      case '50 % s/d 75%':
                        $rows[$key]['tahapan_kegiatan'][$i]['uraian'][$j]['jumlah'] = 0;
                        break;
                      default:
                        break;
                    }
                }
            }
        }

        $data = [
            'title' => $this->title,
            'rows' => $rows
        ];

        return view('exports.monev', $data);
    }

    function penyelidikanTerkait7Perkara($type)
    {
        return $this->penyelidikanRepo->countPenyelidikanTerkait7Perkara(date('Y'), $type);
    }

    function penyidikanTerkait7Perkara($type)
    {
        return $this->penyidikanRepo->countTerkait7Perkara(date('Y'), $type);
    }

    function pelakuSebagaiPenyelenggaraNegara($isTrue = true)
    {
        return $this->penyidikanRepo->countPelakuSebagaiPenyelenggaraNegara(date('Y'), $isTrue);
    }

    function penyidikanDisertaiTPPU()
    {
        return $this->penyidikanRepo->countPenyidikanDisertaiTPPU(date('Y'));
    }

    function penyidikanBerdasarkanKerugian($is5M = true)
    {
        return $this->penyidikanRepo->countPenyidikanBerdasarkanKerugian(date('Y'), $is5M);
    }

    function penyelidikanCount()
    {
        return $this->penyelidikanRepo->countByYear(date('Y'));
    }

    function penyelidikanSudahDisposisi($isDisposisi = true)
    {
        return $this->penyelidikanRepo->countIsDisposisi(date('Y'), $isDisposisi);
    }

    function penyidikanCount()
    {
        return $this->penyidikanRepo->countByYear(date('Y'));
    }

    function penyidikanSudahDisposisi($isDisposisi = true)
    {
        return $this->penyidikanRepo->countIsDisposisi(date('Y'), $isDisposisi);
    }

    function penyidikanKorperasiCount()
    {
        return $this->penyidikanRepo->countPenyidikanKorperasi(date('Y'));
    }

    function penyidikanPembuktianKerugianNegaraCount()
    {
        return $this->penyidikanRepo->countPenyidikanPembuktianKerugianNegara(date('Y'));
    }

    function eksekusiPelelanganBendaSitaanCount()
    {
        return $this->eksekusiRepo->countPelelanganBendaSitaan(date('Y'));
    }

    function penyidikanTapTersangkaCount()
    {
        return $this->penyidikanRepo->countTapTersangkaCount(date('Y'));
    }

    function penyidikanP16Count($year = "")
    {
        return $this->penyidikanRepo->countP16($year);
    }

    function penyelidikanPengembalianUangNegaraCount($nominal)
    {
        return $this->penyelidikanRepo->countPengembalianUangNegara(date('Y'), $nominal);
    }

    function penyidikanPenyelematanKerugianNegaraCount($nominal)
    {
        return $this->penyidikanRepo->countPenyelematanKerugianNegara(date('Y'), $nominal);
    }

    function penyelidikanSesuaiSopCount()
    {
        return $this->penyelidikanRepo->countSesuaiSop(date('Y'));
    }

    function penyelidikanCmsP2Count()
    {
        return $this->penyelidikanRepo->countCmsP2Count(date('Y'));
    }

    function penyidikanSesuaiSopCount()
    {
        return $this->penyidikanRepo->countSesuaiSop(date('Y'));
    }

    function penyidikanCmsP8Count()
    {
        return $this->penyidikanRepo->countCmsP8Count(date('Y'));
    }

    function tuntutanSesuaiSopCount()
    {
        return $this->penuntutanRepo->countTuntutanSesuaiSop(date('Y'));
    }
}

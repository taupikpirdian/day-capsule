<div class="table-responsive theme-scrollbar">
    <h4 style="text-align: center">{{ $title }}</h4>
    <table class="table display">
      <thead>
        <tr style="text-align: center">
          <th rowspan="2">No</th>
          <th rowspan="2">Kriteria Penilaian</th>
          <th rowspan="2">Bobot (%)</th>
          <th rowspan="2">Tahap Kegiatan</th>
          <th rowspan="2">Uraian</th>
          <th rowspan="2">Poin</th>
          <th rowspan="2">Jumlah</th>
          <th rowspan="2">Nilai</th>
          <th rowspan="2">Total (cxh)</th>
          <th rowspan="2">Upload Bukti Dokumen</th>
          <th colspan="2" style="text-align: center">Verifikasi Kejagung</th>
          <th rowspan="2">Total (cxp)</th>
          <th rowspan="2">Catatan</th>
          <th rowspan="2">Dokumen Bukti dukung</th>
        </tr>
        <tr style="text-align: center">
          <th>Jumlah</th>
          <th>Nilai</th>
        </tr>
        <tr style="text-align: center">
          <th>a</th>
          <th>b</th>
          <th>c</th>
          <th>d</th>
          <th>e</th>
          <th>f</th>
          <th>g</th>
          <th>h</th>
          <th>i</th>
          <th>j</th>
          <th>k</th>
          <th>l</th>
          <th>m</th>
          <th>n</th>
          <th>o</th>
        </tr>
      </thead>
      <tbody>
        @php
          $total = 0;
          $total_seluruh_csp = 0;
        @endphp
        @foreach ($rows as $i=>$row)
            @php
              $countRowTahapan = count($row['tahapan_kegiatan']);
            @endphp
            @foreach ($row['tahapan_kegiatan'] as $key=>$rowLv2)
              @php
                $countRowUraian = count($rowLv2['uraian']);
              @endphp
              @foreach ($rowLv2['uraian'] as $j=>$rowUraian)
                @php
                  $nilai = $rowUraian['poin'] * $rowUraian['jumlah'];
                  $total_cxh = $nilai * $rowUraian['nilai_percent'];
                  $total += $total_cxh;
                  $nilai_verif_kejagung = $rowUraian['verifikasi_kejagung']['jumlah']*$rowUraian['jumlah'];
                  $total_csp = $nilai_verif_kejagung * $rowUraian['nilai_percent'];
                  $total_seluruh_csp += $total_csp;
                @endphp
                {{-- kondisi loop pertama per number --}}
                @if($rowUraian['is_first'] == true)
                  <tr>
                    <td rowspan="{{ $row['count_total_uraian'] }}">{{ $row['no'] }}</td>
                    <td rowspan="{{ $row['count_total_uraian'] }}">{{ $row['kriteria_penilaian'] }}</td>
                    <td rowspan="{{ $row['count_total_uraian'] }}">{{ $row['bobot'] }}</td>
                    <td rowspan="{{ $rowLv2['count_uraian'] }}">{{ $rowLv2['title'] }}</td>
                    <td>{{ $rowUraian['title'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['poin'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['jumlah'] }}</td>
                    <td style="text-align: center">{{ $nilai }}</td>
                    <td style="text-align: center">{{ $total_cxh }}</td>
                    <td style="text-align: center">{{ $rowUraian['upload_bukti'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['verifikasi_kejagung']['jumlah'] }}</td>
                    <td style="text-align: center">{{ $nilai_verif_kejagung }}</td>
                    <td style="text-align: center">{{ $total_csp }}</td>
                    <td style="text-align: center">{{ $rowUraian['catatan'] }}</td>
                    <td>{{ $rowUraian['dokumen_bukti_dukung'] }}</td>
                  </tr>
                @elseif($key > 0 && $j == 0)
                  <tr>
                    <td rowspan="{{ $rowLv2['count_uraian'] }}">{{ $rowLv2['title'] }}</td>
                    <td>{{ $rowUraian['title'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['poin'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['jumlah'] }}</td>
                    <td style="text-align: center">{{ $nilai }}</td>
                    <td style="text-align: center">{{ $total_cxh }}</td>
                    <td style="text-align: center">{{ $rowUraian['upload_bukti'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['verifikasi_kejagung']['jumlah'] }}</td>
                    <td style="text-align: center">{{ $nilai_verif_kejagung }}</td>
                    <td style="text-align: center">{{ $total_csp }}</td>
                    <td style="text-align: center">{{ $rowUraian['catatan'] }}</td>
                    <td>{{ $rowUraian['dokumen_bukti_dukung'] }}</td>
                  </tr>
                @else
                  <tr>
                    <td>{{ $rowUraian['title'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['poin'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['jumlah'] }}</td>
                    <td style="text-align: center">{{ $nilai }}</td>
                    <td style="text-align: center">{{ $total_cxh }}</td>
                    <td style="text-align: center">{{ $rowUraian['upload_bukti'] }}</td>
                    <td style="text-align: center">{{ $rowUraian['verifikasi_kejagung']['jumlah'] }}</td>
                    <td style="text-align: center">{{ $nilai_verif_kejagung }}</td>
                    <td style="text-align: center">{{ $total_csp }}</td>
                    <td style="text-align: center">{{ $rowUraian['catatan'] }}</td>
                    <td>{{ $rowUraian['dokumen_bukti_dukung'] }}</td>
                  </tr>
                @endif
              @endforeach
            @endforeach
        @endforeach
        <tr>
          <td style="color: red" colspan="8">TOTAL PENILAIAN KINERJA (Kuantitas + Kualitas+ Penyelamatan KN+Anggaran+Manajerial)</td>
          <td style="color: red; text-align: center">{{ $total }}</td>
          <td colspan="3"></td>
          <td style="color: red; text-align: center">{{ $total_seluruh_csp }}</td>
          <td colspan="2"></td>
        </tr>
      </tbody>
    </table>
</div>
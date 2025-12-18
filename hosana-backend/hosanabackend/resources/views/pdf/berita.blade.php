<h3>Daftar Berita</h3>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Tanggal Publish</th>
        <th>Kategori</th>
    </tr>

     @forelse ($berita as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->judul }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_berita)->translatedFormat('d F Y') }}</td>
            <td>{{ $item->kategoris->pluck('nama_kategori')->join(', ') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="text-align:center; font-style:italic;">
                Belum ada berita yang dipublish pada tanggal tersebut.
            </td>
        </tr>
    @endforelse
</table>

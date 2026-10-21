
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        input {
            display: block;
            width: 280px;
            padding: 8px;
            margin: 5px 0 15px;
            box-sizing: border-box;
        }

        button {
            padding: 8px 12px;
            margin: 3px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        #pesan {
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <h1>Data Mata Kuliah</h1>
    <p>Halaman untuk mengelola data mata kuliah melalui API.</p>

    <p id="pesan"></p>

    <h3 id="judul-form">Tambah Mata Kuliah</h3>

    <form id="form-mk">
        <input type="hidden" id="id">

        <label>Program Studi ID</label>
        <input type="number" id="program_studi_id" required>

        <label>Kode Mata Kuliah</label>
        <input type="text" id="kode_mk" required>

        <label>Nama Mata Kuliah</label>
        <input type="text" id="nama_mk" required>

        <label>SKS</label>
        <input type="number" id="sks" required>

        <label>Semester</label>
        <input type="number" id="semester" required>

        <button type="submit">Simpan</button>
        <button type="button" onclick="resetForm()">Batal</button>
    </form>

    <hr>

    <h3>Daftar Mata Kuliah</h3>

    <button type="button" onclick="muatData()">Muat Ulang Data</button>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody id="tabel-mk">
            <tr>
                <td colspan="5">Memuat data...</td>
            </tr>
        </tbody>
    </table>

    <script>
        const API_URL = '/api/v1/mata-kuliah';

        function tampilkanPesan(teks) {
            document.getElementById('pesan').textContent = teks;
        }

        async function bacaRespons(response) {
            const teks = await response.text();

            let hasil = {};

            if (teks) {
                try {
                    hasil = JSON.parse(teks);
                } catch {
                    hasil = { message: teks };
                }
            }

            if (!response.ok) {
                const errorValidasi = hasil.errors
                    ? Object.values(hasil.errors).flat().join(' ')
                    : '';

                throw new Error(
                    errorValidasi || hasil.message ||
                    `Request gagal (${response.status})`
                );
            }

            return hasil;
        }

        function ambilId(mk) {
            return mk.id ?? mk.mata_kuliah_id ?? mk.mataKuliahId;
        }

        // Mengambil dan menampilkan data dari API
        async function muatData() {
            const tabel = document.getElementById('tabel-mk');

            try {
                const response = await fetch(API_URL, {
                    headers: { 'Accept': 'application/json' }
                });

                const hasil = await bacaRespons(response);
                const data = Array.isArray(hasil)
                    ? hasil
                    : (hasil.data ?? []);

                tabel.innerHTML = '';

                if (data.length === 0) {
                    tabel.innerHTML =
                        '<tr><td colspan="5">Belum ada data.</td></tr>';
                    return;
                }

                data.forEach(function (mk) {
                    const baris = document.createElement('tr');

                    const nilai = [
                        mk.kode_mk ?? '-',
                        mk.nama_mk ?? '-',
                        mk.sks ?? '-',
                        mk.semester ?? '-'
                    ];

                    nilai.forEach(function (isi) {
                        const kolom = document.createElement('td');
                        kolom.textContent = isi;
                        baris.appendChild(kolom);
                    });

                    const aksi = document.createElement('td');

                    const tombolEdit = document.createElement('button');
                    tombolEdit.textContent = 'Edit';
                    tombolEdit.onclick = function () {
                        editData(mk);
                    };

                    const tombolHapus = document.createElement('button');
                    tombolHapus.textContent = 'Hapus';
                    tombolHapus.onclick = function () {
                        hapusData(ambilId(mk));
                    };

                    aksi.append(tombolEdit, tombolHapus);
                    baris.appendChild(aksi);
                    tabel.appendChild(baris);
                });

            } catch (error) {
                tabel.innerHTML =
                    '<tr><td colspan="5">Gagal memuat data.</td></tr>';
                tampilkanPesan('Gagal mengambil data: ' + error.message);
                console.error(error);
            }
        }

        // Menambah data baru atau menyimpan perubahan
        document.getElementById('form-mk').addEventListener(
            'submit',
            async function (event) {
                event.preventDefault();

                const id = document.getElementById('id').value;

                const data = {
                    program_studi_id: Number(
                        document.getElementById('program_studi_id').value
                    ),
                    kode_mk: document.getElementById('kode_mk').value,
                    nama_mk: document.getElementById('nama_mk').value,
                    sks: Number(document.getElementById('sks').value),
                    semester: Number(
                        document.getElementById('semester').value
                    )
                };

                try {
                    const response = await fetch(
                        id ? `${API_URL}/${id}` : API_URL,
                        {
                            method: id ? 'PUT' : 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(data)
                        }
                    );

                    await bacaRespons(response);

                    tampilkanPesan(
                        id
                            ? 'Data mata kuliah berhasil diubah.'
                            : 'Data mata kuliah berhasil ditambahkan.'
                    );

                    resetForm();
                    await muatData();

                } catch (error) {
                    tampilkanPesan('Gagal menyimpan: ' + error.message);
                    console.error(error);
                }
            }
        );

        // Memasukkan data yang dipilih ke dalam form
        function editData(mk) {
            document.getElementById('id').value = ambilId(mk) ?? '';
            document.getElementById('program_studi_id').value =
                mk.program_studi_id ?? '';
            document.getElementById('kode_mk').value = mk.kode_mk ?? '';
            document.getElementById('nama_mk').value = mk.nama_mk ?? '';
            document.getElementById('sks').value = mk.sks ?? '';
            document.getElementById('semester').value = mk.semester ?? '';

            document.getElementById('judul-form').textContent =
                'Edit Mata Kuliah';

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Menghapus data
        async function hapusData(id) {
            if (id == null || id === '') {
                tampilkanPesan('ID mata kuliah tidak ditemukan.');
                return;
            }

            if (!confirm('Yakin ingin menghapus data ini?')) {
                return;
            }

            try {
                const response = await fetch(`${API_URL}/${id}`, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' }
                });

                await bacaRespons(response);

                tampilkanPesan('Data mata kuliah berhasil dihapus.');
                await muatData();

            } catch (error) {
                tampilkanPesan('Gagal menghapus: ' + error.message);
                console.error(error);
            }
        }

        // Mengosongkan form
        function resetForm() {
            document.getElementById('form-mk').reset();
            document.getElementById('id').value = '';
            document.getElementById('judul-form').textContent =
                'Tambah Mata Kuliah';
        }

        // Menampilkan data ketika halaman dibuka
        muatData();
    </script>
</body>
</html>

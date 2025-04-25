<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Form Skrining Remaja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
  <style>
     .bg-grey {
    background-color: #f0f0f0; /* Warna abu-abu terang */
  }
  </style>
</head>
<body class="bg-light">
  <div class="container mt-5">
      <div class="col-md-4">
        <a href="index.html" class="btn btn-danger shadow">Back to Dashboard</a>
      </div>
    <h2 class="mb-4  mt-4">Form Skrining Remaja</h2>
    <form id="formInput" class="card p-4 shadow bg-white">
      
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Nama</label>
          <input type="text" id="nama" name="nama" class="form-control" list="namaList" autocomplete="off" required />
          <datalist id="namaList"></datalist>
        </div>
        <div class="col-md-4 mb-3 d-none">
          <label class="form-label">Tanggal</label>
          <input type="text" id="tanggal" name="tanggal" class="form-control" required />
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">NIK</label>
          <input type="text" id="nik" name="nik" class="form-control" />
        </div>
        <div class="col-md-2 mb-3">
          <label class="form-label">Tanggal Lahir</label>
          <input type="text" id="ttl" name="ttl" class="form-control" />
        </div>
        <div class="col-md-2 mb-3">
          <label class="form-label">Usia</label>
          <input type="text" id="usia" name="usia" class="form-control bg-grey" readonly />
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">TB (cm)</label>
          <input type="number" id="tb" name="tb" class="form-control" />
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">BB (kg)</label>
          <input type="number" id="bb" name="bb" class="form-control" />
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">IMT</label>
          <input type="number" id="imt" name="imt" step="0.01" class="form-control bg-grey" readonly />
        </div>
      </div>

      <div class="text-end">
        <button class="btn btn-primary shadow" type="submit">Simpan</button>
      </div>
    </form>

    <a href="view.html" class="btn btn-secondary mt-2 shadow">Lihat Data</a>

    <!-- Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
      <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
          <div class="toast-body">Data berhasil disimpan!</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> <!-- Flatpickr JS -->
  <script src="data.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const namaInput = document.getElementById("nama");
      const namaList = document.getElementById("namaList");

      // Fungsi isi data otomatis berdasarkan input yang cocok persis
      function isiDataOtomatis() {
        const inputNama = namaInput.value.toLowerCase();
        const selected = data.find((item) => item.nama.toLowerCase() === inputNama);
        if (selected) {
          document.getElementById("nik").value = selected.nik || "";
          document.getElementById("tanggal").value = selected.tanggal || "";
          document.getElementById("tb").value = selected.tb || "";
          document.getElementById("bb").value = selected.bb || "";
          document.getElementById("imt").value = selected.imt || "";
        }
      }
        const tanggalInput = document.getElementById("tanggal");
        const today = new Date();
        const day = String(today.getDate()).padStart(2, '0');
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        const year = today.getFullYear();

        // Format tanggal menjadi d-m-Y
        const formattedDate = `${day}-${month}-${year}`;

        // Set nilai input tanggal
        tanggalInput.value = formattedDate;
      // Update datalist sesuai dengan inputan
      namaInput.addEventListener("input", () => {
        const keyword = namaInput.value.toLowerCase();

        // Kosongkan datalist lebih dulu
        namaList.innerHTML = "";

        // Filter dan tampilkan nama yang cocok
        const filtered = data.filter((item) =>
          item.nama.toLowerCase().includes(keyword)
        );

        filtered.forEach((item) => {
          const option = document.createElement("option");
          option.value = item.nama;
          namaList.appendChild(option);
        });

        // Jalankan autofill jika ada yang cocok persis
        isiDataOtomatis();
      });

      namaInput.addEventListener("change", isiDataOtomatis);

      // Fungsi untuk menghitung IMT
      function hitungIMT() {
        const tb = parseFloat(document.getElementById("tb").value);
        const bb = parseFloat(document.getElementById("bb").value);

        if (tb > 0 && bb > 0) {
          const tbInMeter = tb / 100; // Mengubah cm ke meter
          const imt = bb / (tbInMeter * tbInMeter);
          document.getElementById("imt").value = imt.toFixed(2);
        } else {
          document.getElementById("imt").value = "";
        }
      }

      // Event listener untuk perhitungan IMT otomatis
      document.getElementById("tb").addEventListener("input", hitungIMT);
      document.getElementById("bb").addEventListener("input", hitungIMT);
      // Inisialisasi Flatpickr untuk input tanggal
      flatpickr("#ttl", {
        dateFormat: "d-m-Y", // Format tanggal
        maxDate: "today", // Membatasi pemilihan tanggal tidak lebih dari hari ini
      });
      
       // Fungsi untuk menghitung usia berdasarkan tanggal lahir
       function hitungUsia() {
        const ttl = document.getElementById("ttl").value;
        if (ttl) {
          const ttlDate = new Date(ttl.split("-").reverse().join("-")); // Convert d-m-Y to Y-m-d
          const ageDifMs = Date.now() - ttlDate.getTime();
          const ageDate = new Date(ageDifMs);
          const age = Math.abs(ageDate.getUTCFullYear() - 1970);
          document.getElementById("usia").value = age; // Set usia
        }
      }

      // Hitung usia setiap kali TTL diubah
      document.getElementById("ttl").addEventListener("input", hitungUsia);
       // Simpan data
      document.getElementById("formInput").addEventListener("submit", function (e) {
        e.preventDefault();

        // Ambil data dari form
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        // Kirim data ke server
        fetch("simpan.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data), // Mengirimkan data dalam format JSON
        })
          .then((res) => res.text()) // Mengambil response dari server
          .then((res) => {
            if (res.includes("Data berhasil disimpan")) {
              // Jika respons mengandung "Data berhasil disimpan"
              const toast = new bootstrap.Toast(document.getElementById("toastSuccess"));
              toast.show();
              this.reset(); // Reset form setelah data berhasil disimpan
            } else {
              console.error("Error: " + res); // Menampilkan error jika respons tidak sesuai
            }
          })

          .catch((error) => {
            console.error("Error:", error); // Menangani error jaringan
          });
      });
    });
  </script>
</body>
</html>

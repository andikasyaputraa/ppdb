document.getElementById("ppdb-form").addEventListener("submit", function(event) {
    // event.preventDefault(); // Cegah pengiriman formulir
    
    // Ambil nilai dari input
    const gajiInput = document.getElementById("gaji_orang_tua").value;
    const formattedGaji = formatRupiah(gajiInput, "Rp. ");

    // // Tambahkan data ke tabel
    // const tbody = document.getElementById("data-table");
    // const row = tbody.insertRow();
    // const cell = row.insertCell(0);
    // cell.innerHTML = formattedGaji;

    // Reset form setelah submit
    this.reset();
});


function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        var separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
    return prefix === undefined ? rupiah : rupiah ? prefix + rupiah : "";
}

document.getElementById("gaji_orang_tua").addEventListener("input", function(e) {
    this.value = formatRupiah(this.value, "Rp. ");
});

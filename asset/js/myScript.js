// Notifikasi Sweetlaert untuk CRUD Produk

const flashdata_produk = $('.flashdata_produk').data('flashdata');

if (flashdata_produk){
    Swal.fire({
        icon: 'success',
        title: 'Data Produk',
        text: 'Berhasil ' + flashdata_produk,
    })
}

$('.btn_hapus_produk').on('click', function (e) {

    e.preventDefault();
    const href = $(this).attr('href')

    Swal.fire({
        title: 'Apakah anda yakin',
        text: "akan menghapus data produk?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.value) {
            document.location.href = href
        }
      })
});


// Notifikasi Sweetalert untuk CRUD Transaksi
const flashdata_transaksi = $('.flashdata_transaksi').data('flashdata');

if (flashdata_transaksi){
    Swal.fire({
        icon: 'success',
        title: 'Data Transaksi',
        text: 'Berhasil ' + flashdata_transaksi,
    })
}

$('.btn_hapus_transaksi').on('click', function (e) {

    e.preventDefault();
    const href = $(this).attr('href')

    Swal.fire({
        title: 'Apakah anda yakin',
        text: "akan menghapus data produk?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.value) {
            document.location.href = href
        }
      })
});
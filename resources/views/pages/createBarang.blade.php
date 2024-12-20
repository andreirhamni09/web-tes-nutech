@include('layout.header')
@include('layout.sidebar')
@include('layout.navbar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-inline-flex">
                    <h1 class="fs-1 mr-2"><span class="text-secondary">Daftar Produk</span> ></h1>
                    <h1 class="fs-1">Tambah Produk</h1>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            @if(session('success'))
                <div class="row">
                    <div class="col-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    </div>
                </div>
            @endif
            
            @if(session('fail'))
                <div class="row">
                    <div class="col-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('fail') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('tambahProduk') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                </select>
                                @error('kategori')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <label for="namaBarang" class="form-label">Nama Barang</label>
                                <input type="text" name="namaBarang" id="namaBarang" class="form-control" value="{{ old('namaBarang') }}" placeholder="Masukan nama barang">
                                @error('namaBarang')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="hargaBeli" class="form-label">Harga Beli</label>
                                <input type="number" name="hargaBeli" id="hargaBeli" class="form-control" value="{{ old('hargaBeli') }}" placeholder="Masukan harga beli">
                                @error('hargaBeli')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="hargaJual" class="form-label">Harga Jual</label>
                                <input type="number" name="hargaJual" id="hargaJual" class="form-control" value="{{ old('hargaJual') }}" placeholder="Masukan harga jual">
                                @error('hargaJual')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="stokBarang" class="form-label">Stok Barang</label>
                                <input type="number" name="stokBarang" id="stokBarang" class="form-control" value="{{ old('stokBarang') }}" placeholder="Masukan jumlah stok barang">
                                @error('stokBarang')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="uploadImage" class="form-label">Upload Image</label>
                            <div class="upload-box" id="uploadBox">
                                <img id="previewImage" src="" alt="Image Preview" style="display: none;">
                                <p id="uploadText">Upload gambar di sini</p>
                                <input type="file" name="uploadImage" id="uploadImage" class="form-control" accept="image/*" style="display: none;">
                            </div>
                            @error('uploadImage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mr-2" id="batal">Batalkan</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
    const uploadBox = document.getElementById('uploadBox');
    const uploadImage = document.getElementById('uploadImage');
    const previewImage = document.getElementById('previewImage');
    const uploadText = document.getElementById('uploadText');

    uploadBox.addEventListener('click', () => {
        uploadImage.click();
    });

    uploadImage.addEventListener('change', (event) => {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                uploadText.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
            uploadText.style.display = 'block';
        }
    });

    $('#batal').on('click', function(){
        window.location.href = `{{ url('') }}`;
    });

    $('#hargaBeli').on('keyup', function(){
        var tambahan = (parseInt($('#hargaBeli').val()) * 30 )/ 100;
        var hargaJual =  parseInt($('#hargaBeli').val()) + tambahan;
        var fixHargajual = Math.round(hargaJual);
        $('#hargaJual').val(fixHargajual);
    });

    function setupDropdownKategoris(){
        $.ajax({
          url: `{{ route('getKategori') }}`, // Example API endpoint
          type: 'GET', // HTTP method
          success: function(data) {
            data.data.forEach(element => {
                $('#kategori').append(`<option value="${element.kategories_id}">${element.kategories_name}</option>`);
            });
          },
          error: function(xhr, status, error) {
            alert(error);
          }
        });
    }
    $(document).ready(function() {
        setupDropdownKategoris();
    });
</script>

</body>
@include('layout.footer')

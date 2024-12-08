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
                    <h1 class="fs-1">Edit Barang</h1>
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
            
            @if(session('update'))
                <div class="row">
                    <div class="col-6">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('update') }}
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
                    <form action="{{ route('editProses') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $produks[0]->produks_id }}">
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
                                <input type="text" name="namaBarang" id="namaBarang" class="form-control" value="{{ $produks[0]->produks_name }}" placeholder="Masukan nama barang" disabled>
                               
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="hargaBeli" class="form-label">Harga Beli</label>
                                
                                @if(old('hargaBeli'))
                                    <input type="number" name="hargaBeli" id="hargaBeli" class="form-control" value="{{ old('hargaBeli') }}" placeholder="Masukan harga beli">
                                @else
                                    <input type="number" name="hargaBeli" id="hargaBeli" class="form-control" value="{{ $produks[0]->produks_harga }}" placeholder="Masukan harga beli">
                                @endif
                                
                                @error('hargaBeli')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="hargaJual" class="form-label">Harga Jual</label>
                                @if(old('hargaJual'))
                                    <input type="number" name="hargaJual" id="hargaJual" class="form-control" value="{{ old('hargaJual') }}" placeholder="Masukan harga jual">
                                @else
                                    <input type="number" name="hargaJual" id="hargaJual" class="form-control" value="{{ $produks[0]->produks_jual }}" placeholder="Masukan harga jual">
                                @endif
                                @error('hargaJual')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="stokBarang" class="form-label">Stok Barang</label>
                                @if(old('stokBarang'))
                                    <input type="number" name="stokBarang" id="stokBarang" class="form-control" value="{{ old('stokBarang') }}" placeholder="Masukan jumlah stok barang">
                                @else
                                    <input type="number" name="stokBarang" id="stokBarang" class="form-control" value="{{ $produks[0]->produks_stok }}" placeholder="Masukan jumlah stok barang">
                                @endif
                                @error('stokBarang')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
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
    let kategoriProduks = `{{ $produks[0]->kategories_id }}`;
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
                if(kategoriProduks == element.kategories_id ){
                    $('#kategori').append(`<option value="${element.kategories_id}" selected>${element.kategories_name}</option>`);
                } else {
                    $('#kategori').append(`<option value="${element.kategories_id}">${element.kategories_name}</option>`);
                }
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

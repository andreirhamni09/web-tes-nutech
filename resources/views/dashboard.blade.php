@include('layout.header')
@include('layout.sidebar')
@include('layout.navbar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Produk</h1>
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
            <div class="row">
                <div class="col-2 mb-2">
                    <div class="custom-search-container">
                        <input type="text" style="font-family: 'Font Awesome 5 Free'; font-weight:700;" id="customSearchBox" placeholder="&#xf002; Search..." class="form-control">
                    </div>
                </div>
                <div class="col-2 mb-2">
                    <select id="selectKategori" class="form-control" style="font-family: 'Font Awesome 5 Free'; font-weight:700;" >
                        <option value="all" selected>&#xf1b2; Semua</option>
                    </select>
                </div>
                
                
                <div class="col-8 mb-2 d-flex flex-row-reverse">
                    <button id="addProduk"  class="btn btn-danger align-middle">
                        <img src="{{asset('CMS Assets/PlusCircle.png') }}" class="nav-icon mr-1 align-middle"/>
                        <span class="align-middle">Tambah Produk</span>
                    </button>    
                    <button id="exportExcel" class="btn btn-success align-middle mr-3">
                        <img src="{{asset('CMS Assets/MicrosoftExcelLogo.png') }}" class="nav-icon mr-1 align-middle"/>
                        <span class="align-middle">Export Excel</span>
                    </button>    
                </div>
                <div class="col-12">
                    <table id="TabelBarangs" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Nama Produk</th>
                                <th>Kategori Produk</th>
                                <th>Harga Beli (Rp)</th>
                                <th>Harga Jual (Rp)</th>
                                <th>Stok Produk</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>


</body>

<script>
    function formatRupiah(angka, prefix = "Rp") {
        if (!angka) return `${prefix} 0`; // Handle null or undefined
        const numberString = angka.toString().replace(/[^,\d]/g, "");
        const split = numberString.split(",");
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            const separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
        return prefix + " " + rupiah;
    }
    
    function setupDropdownKategoris(){
        $.ajax({
          url: `{{ route('getKategori') }}`, // Example API endpoint
          type: 'GET', // HTTP method
          success: function(data) {
            data.data.forEach(element => {
                $('#selectKategori').append(`<option value="${element.kategories_id}"> &#xf1b2; ${element.kategories_name}</option>`);
            });
          },
          error: function(xhr, status, error) {
            alert(error);
          }
        });
    }
    function exportToExcelWithStyledHeader(table) {
        // Extract table data
        let data = table.rows({ search: 'applied' }).data();

        // Create worksheet data
        let ws_data = [["No", "Nama Produk", "Kategori Produk", "Harga Barang", "Harga Jual", "Stok"]]; // Header row
        let no      = 1;
        data.each(function (row) {
            ws_data.push([no, row.produks_name, row.kategories_name, row.produks_harga, row.produks_jual, row.produks_stok]);
            no+=1;
        });

        // Create a worksheet
        let ws = XLSX.utils.aoa_to_sheet(ws_data);
        // Format columns
        let range = XLSX.utils.decode_range(ws['!ref']);

        for (let R = range.s.r + 1; R <= range.e.r; R++) {
            // Price column (index 2)
            let hargaBarangCell = XLSX.utils.encode_cell({ r: R, c: 3 });
            ws[hargaBarangCell].z = "$#,##0.00"; // Format as currency

            // Quantity column (index 3)
            let hargaJualCell = XLSX.utils.encode_cell({ r: R, c: 4 });
            ws[hargaJualCell].z = "$#,##0.00";  // Format as plain number
        }

        // Style the header row
        let headerRange = XLSX.utils.decode_range(ws['!ref']);
        for (let C = headerRange.s.c; C <= headerRange.e.c; ++C) {
            let cellAddress = XLSX.utils.encode_cell({ r: 0, c: C }); // Header row is row 0
            if (!ws[cellAddress]) continue;

            ws[cellAddress].s = {
                fill: {
                    fgColor: { rgb: "DC3545" } // Red background
                },
                font: {
                    bold: true,
                    color: { rgb: "FFFFFF" } // White text
                }
            };
        }

        // Create a workbook and add the worksheet
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Data");

        // Export the workbook to an Excel file
        XLSX.writeFile(wb, "data.xlsx");
    }



    $(document).ready(function() {
        setupDropdownKategoris();
        let table = $('#TabelBarangs').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength" : 5,
            dom: 'lrtip', // Disable the default search box
            language: {
                search: "" // Makes the search box empty
            },
            ajax: {
                url: `{{ route('getProduks') }}`,
                type: 'GET',
                dataSrc: 'produks'
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row+1;
                    },
                },
                {
                    data: 'produks_img',
                    render: function(data, type, row) {
                        return `<image src="{{ asset('CMS Assets') }}/${data}"alt="AdminLTE Logo" class="nav-icon" style="opacity: 0.8;" width="50" height="50"/>`;
                    },
                },
                {
                    data: 'produks_name'
                },
                {
                    data: 'kategories_name'
                },
                {
                    data: 'produks_harga',
                    render: function(data, type, row) {
                        return formatRupiah(data);
                    },
                },
                {
                    data: 'produks_jual',
                    render: function(data, type, row) {
                        return formatRupiah(data);
                    },
                },
                {
                    data: 'produks_stok',
                    render: function(data, type, row) {
                        return data;
                    },
                },
                {
                    data: 'produks_id',
                    render: function(data, type, row) {
                        return `
                            <div  class=" d-flex ">
                                <form action="editProduk" method="post" class="mr-3 justify-content-center">
                                    <input type="hidden" name="id" value="${data}">
                                    <button class="trash-button bg-primary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </form>
                                <form action="deleteProduk" method="post">
                                    <input type="hidden" name="id" value="${data}">
                                    <button class="trash-button">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </form>
                            </div>
                        `;
                    },
                }
            ],
        });
        
        $('#selectKategori').on('change', function(){
            $('#TabelBarangs').DataTable().destroy();
            let kategoriid = $('#selectKategori').val().toString();
            table = '';
            table = $('#TabelBarangs').DataTable({
                "paging": true,
                "lengthChange": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength" : 5,
                dom: 'lrtip', // Disable the default search box
                language: {
                    search: "" // Makes the search box empty
                },
                ajax: {
                    url: `{{ route('getProduksByKategori') }}`, // Example API endpoint
                    type: 'POST', // HTTP method
                    contentType: "application/json",
                    data: function (d) {
                        // Add custom parameters to be sent
                        return JSON.stringify({
                            kategori: kategoriid
                        });
                    },
                    dataSrc: 'produks'

                },
                columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                    },
                    {
                        data: 'produks_img'
                    },
                    {
                        data: 'produks_name'
                    },
                    {
                        data: 'kategories_name'
                    },
                    {
                        data: 'produks_harga',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        },
                    },
                    {
                        data: 'produks_jual',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        },
                    },
                    {
                        data: 'produks_stok',
                        render: function(data, type, row) {
                            return data;
                        },
                    },
                    {
                        data: 'produks_id',
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex ">
                                <form action="editProduk" method="post">
                                    <input type="hidden" name="id" value="${data}">
                                    <button class="trash-button">
                                        <i class="fas fa-pencil"></i>
                                    </button>

                                </form>
                                <form action="deleteProduk" method="post">
                                    <input type="hidden" name="id" value="${data}">
                                    <button class="trash-button">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>
                            </div>
                            `;
                        },
                    }
                ],
            });
        });
        $('#customSearchBox').on('keyup', function() {
            table.search(this.value).draw(); // Perform DataTables search
        });
        $('#exportExcel').on('click', function () {
            exportToExcelWithStyledHeader(table);
        });
        $('#addProduk').on('click', function () {
            window.location.href = `{{ route('createBarang') }}`;
        });
    });
</script>
@include('layout.footer')

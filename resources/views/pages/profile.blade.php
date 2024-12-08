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
                    <h1 class="m-0">Profile</h1>
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
                <div class="col-12">
                    <div class="text-left">
                        <!-- Profile Picture -->
                        <img src="{{ asset('CMS Assets/Frame 98700.png') }}" alt="Profile Picture" class="rounded-circle mb-3">

                        <!-- Edit Icon -->
                        <a class="btn btn-outline-secondary btn-sm position-relative rounded-circle bg-white" style="margin-top: 100px;margin-left: -50px; padding-left: -10px;">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </div>
                    <h2 class="mt-3"><?= session()->get('users')[0]->users_name ?></h2>

                    <!-- Candidate Info -->
                    <div class="mt-5">
                        <div class="row">
                            <div class="col-6">
                                <h6>Nama Kandidat</h6>
                                <input type="text" class="form-control" value="@ {{session('users')[0]->users_name}}" disabled>
                            </div>
                            <div class="col-6">
                                <h6>Posisi Kandidat</h6>
                                <input type="text" class="form-control" value="</> {{session('users')[0]->users_posisi}}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
</body>
@include('layout.footer')
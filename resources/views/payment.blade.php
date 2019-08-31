
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Checkout example · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

    {{-- vendor --}}
    <link rel="stylesheet" href="{{asset('vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .container {
        max-width: 960px;
        }

       .lh-condensed { line-height: 1.25; }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
  </head>
  <body class="bg-light">
    <div class="container">
  <div class="py-5 text-center">
        <i class="fa fa-credit-card-alt fa-5x" aria-hidden="true"></i>
    <h2 class="mt-5">Pembayaran</h2>
    <p class="lead">Simpan pembayaran untuk dilunasi</p>
  </div>

  <div class="row">
    <div class="col-md-7">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Tagihan</span>
        <span class="badge badge-secondary badge-pill">{{count($tagihans)}}</span>
      </h4>
      <ul class="list-group mb-3">
        @foreach ($tagihans as $tagihan)
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">{{$tagihan->nama}}</h6>
            <small class="text-muted">{{$tagihan->trxId}} - {{$tagihan->nomor}} - {{$tagihan->refNum}}
              <div class="btn-group">
                <a href="{{route('tagihan.lunasi').'?trxId='.$tagihan->trxId}}" class="btn btn-primary btn-sm">Lunasi</a>
                @if ($tagihan->refNum != NULL)
                  <a href="{{route('tagihan.enabled').'?refNum='.$tagihan->refNum}}" class="btn btn-success btn-sm">Enabled</a>
                  <a href="{{route('tagihan.disabled').'?refNum='.$tagihan->refNum}}" class="btn btn-danger btn-sm">Disabled</a>
                
                  <a href="{{route('tagihan.status').'?refNum='.$tagihan->refNum}}" class="btn btn-info btn-sm">Cek Status</a>
                  <a href="{{route('tagihan.reversal').'?refNum='.$tagihan->refNum}}" class="btn btn-warning btn-sm">Reversal</a>
                @endif
              </div>
            </small>
          </div>
          <span class="text-muted">{{$tagihan->tagihan}}</span>
        </li>
        @endforeach
      </ul>
      
    </div>
    <div class="col-md-5">
      <h4 class="mb-3">Tagihan Baru</h4>
      <form class="needs-validation" action="{{route('tagihan.store')}}" method="POST" novalidate> @csrf

        <div class="mb-3">
          <div class="input-group">
            <input type="text" class="form-control" id="username" placeholder="Nama" required name="nama" value="{{old('nama')}}">
            <div class="invalid-feedback" style="width: 100%;">
              Your username is required.
            </div>
          </div>
        </div>
        <div class="mb-3">
          <div class="input-group">
            <input type="text" class="form-control" id="username" placeholder="Nomor" required name="nomor" value="{{old('nomor')}}">
            <div class="invalid-feedback" style="width: 100%;">
              Your username is required.
            </div>
          </div>
        </div>
        <div class="mb-3">
          <div class="input-group">
            <input type="text" class="form-control" id="username" placeholder="Tagihan" required name="tagihan" value="{{old('tagihan')}}">
            <div class="invalid-feedback" style="width: 100%;">
              Your username is required.
            </div>
          </div>
        </div>

        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
      </form>
    </div>
  </div>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017-2019 Company Name</p>
    <ul class="list-inline">
      {{-- <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li> --}}
    </ul>
  </footer>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    (function () {
    'use strict'

    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation')
        Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
        })
    }, false)
    }())
</script>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>The Yummi Pizza - Image Uploader</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

        <!-- Style Library -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .logo-font {
                font-family: "Lobster", cursive;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .form-container {
              margin: 0px auto;
              margin-top: 100px;
              margin-bottom: 50px;
              max-width: 500px;
              width: 100%;
            }

            .alert-container {
              margin: 0px auto;
              max-width: 500px;
              width: 100%;
            }

        </style>
    </head>
    <body>
      <div class="flex-center position-ref full-height">
        <div class="content">
          <h1 class="logo-font">The Yummi Pizza</h1>
          <h3>Image Uploader</h3>
          <div class="form-container position-ref">
            <form class="form" method="post" action="{{ route('images.store') }}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-8">
                  <div class="form-group">
                      <input type="file" name="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" >
                      @if ($errors->has('file'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('file') }}</strong>
                        </span>
                      @endif
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">Save</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="alert-container position-ref">
            @if(session()->has('success'))
              <div class="row">
                <div class="col">
                  <div class="alert alert-success">
                    {{ session()->get('success') }}
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </body>
</html>

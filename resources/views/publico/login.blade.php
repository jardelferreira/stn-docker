<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Login</title>
  </head>
  <body>
    <section class="">
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col col-xl-10">
            <div class="card text-center" style="border-radius: 1rem;">
              <div class="card-header">
                <h2 class="card-title">
                  SGLT - Sistema Auxiliar
                </h2>
               @error('message')
               <div class="alert alert-danger font-weight-bold">
                {{$message}}  
              </div>    
               @enderror
              </div>
              <div class="row g-0">
                <div class="col-md-6  ml-1 col-lg-5 d-none mt-2 d-md-block">
                  <img src="{{asset('images/stn02.jpg')}}"
                    alt="login form" class="img-fluid" style="border-radius: 1rem;" />
                </div>
                <div class="col-md-6 col-lg-6 d-flex align-items-center">
                  <div class="card-body p-2 p-lg-2 text-black">
                    <form action="{{route('public.login')}}" method="post">
                      @csrf
                      @method('POST')
                      <div class="d-flex align-items-center mb-1 pb-1">
                        {{-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> --}}
                        <img src="{{asset('images/stnlogo.png')}}" alt="imagem stn" class="img-thumbnail rounded" id="img-logo">
                        <span class="h1 fw-bold mb-0"></span>
                      </div>
    
                      <h5 class="fw-normal mb-1 pb-1" style="letter-spacing: 1px;">Acesse sua conta</h5>
    
                      <div class="form-outline mb-1">
                        <input type="email" id="form2Example17" name="email" class="form-control form-control-lg" required />
                        <label class="form-label" for="form2Example17">Email</label>
                      </div>
    
                      <div class="form-outline mb-1">
                        <input type="password" id="form2Example27" name="password" class="form-control form-control-lg" required/>
                        <label class="form-label" for="form2Example27">Senha</label>
                      </div>
    
                      <div class="pt-1 mb-1">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Entrar</button>
                      </div>
    
                      <a class="small text-muted" href="#!">Esqueceu a Senha?</a>
                      <p class="mb-1 pb-lg-2 link" style="color: #393f81;">Ainda não possui conta? <a href="#!"
                          style="color: #393f81;">Clique para se registrar</a></p>
                      <a href="#!" class="small text-muted">Terms of use.</a>
                      <a href="#!" class="small text-muted">Privacy policy</a>
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <style>
      body{
        background: rgb(18, 159, 187);
            background: linear-gradient(90deg, rgba(18, 159, 187, 1) 4%, rgba(103, 138, 179, 1) 45%, rgba(11, 7, 71, 1) 95%);
      }
    </style>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
  </body>
</html>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ $response["colegio"]->nombre_colegio}}</title>
        <link rel="icon" type="image/x-icon" href="{{Voyager::image($response["colegio"]->logo ) }}" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{!! asset('css/styles.css') !!}" rel="stylesheet" />
        <link href="{!! asset('css/mystyles.css') !!}" rel="stylesheet" />
        <style>
        .img-circle {
            border-radius: 50%;
            object-fit: cover; /* Mantiene la imagen dentro del círculo */
        }
        .bg-gradient-primary-to-secondary {
            background:linear-gradient(181deg, {{ $response["colegio"]->color_institucional}},{{ $response["colegio"]->color_secundario}} ) !important
        }
        .text-white {
            --bs-text-opacity: 1;
            color: {{$response["colegio"]->text_color}} !important;
        }
        .link-container {
            display: block;
            text-decoration: none; /* Elimina el subrayado del enlace */
        }
        .link-container:hover .bg-gradient-primary-to-secondary {
            /* Opcional: efectos en el hover */
            background: rgba(0, 0, 0, 0.1);
        }
   

            
            


    </style>
    </head>
    <body id="page-top">
        
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
            <div class="container px-2">
                <a class="navbar-brand text-center link-container" href="">{{ $response["colegio"]->nombre_colegio}}</a>
               
            </div>
        </nav>
        <!-- Mashead header-->
        <header class="masthead">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <!-- Mashead text and app badges-->
                        <div class="mb-5 mb-lg-0 text-center text-lg-start">
                            <h1 class="display-1 lh-1 mb-3">{{ $response["colegio"]->nombre}}</h1>
                           
                            
                        </div>
                    </div>
                    <div class="col-lg-6 text-center" style="text-align: center;">
                        <img src="{{ filter_var($response["colegio"]->logo, FILTER_VALIDATE_URL) ? $response["colegio"]->logo : Voyager::image($response["colegio"]->logo ) }}" class="img-fluid" alt="Responsive image" style="width:200px; height:auto; clear:both; display:inline-block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                    </div>
                </div>
               
            </div>
            
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="{{ $response["colegio"]->color_institucional}}" fill-opacity="1" d="M0,192L16,165.3C32,139,64,85,96,58.7C128,32,160,32,192,42.7C224,53,256,75,288,96C320,117,352,139,384,154.7C416,171,448,181,480,186.7C512,192,544,192,576,186.7C608,181,640,171,672,138.7C704,107,736,53,768,69.3C800,85,832,171,864,202.7C896,235,928,213,960,197.3C992,181,1024,171,1056,181.3C1088,192,1120,224,1152,229.3C1184,235,1216,213,1248,208C1280,203,1312,213,1344,186.7C1376,160,1408,96,1424,64L1440,32L1440,320L1424,320C1408,320,1376,320,1344,320C1312,320,1280,320,1248,320C1216,320,1184,320,1152,320C1120,320,1088,320,1056,320C1024,320,992,320,960,320C928,320,896,320,864,320C832,320,800,320,768,320C736,320,704,320,672,320C640,320,608,320,576,320C544,320,512,320,480,320C448,320,416,320,384,320C352,320,320,320,288,320C256,320,224,320,192,320C160,320,128,320,96,320C64,320,32,320,16,320L0,320Z"></path>
            </svg>
        </header>
        <!-- Quote/testimonial aside-->
        <aside class="text-center bg-gradient-primary-to-secondary">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-xl-8">
                        <div class="h2 fs-1 text-white mb-4">{{$response["colegio"]->lema}}</div>
                       
                    </div>
                </div>
            </div>
        </aside>
        <!-- App features section-->
        <section id="features">
            <div class="container px-5">
                <div class="row gx-5 align-items-center ">
                    <div class="col-lg-12 order-lg-1 mb-5 mb-lg-0">
                        <div class="container-fluid px-5">
                            <div class="row gx-5">

                            <div class="grid-container">
                                @foreach($response["posts"] as $item)
                                   
                                        <img class="grid-item" src="{{ filter_var($item->foto, FILTER_VALIDATE_URL) ? $item->foto : Voyager::image( $item->foto ) }}" >
                                   
                                @endforeach
                            </div>
                              

                              
                              
                                
                            </div>
                            
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- Basic features section-->

        <!-- Call to action section-->

        <!-- App badge section-->
        <section class="bg-gradient-primary-to-secondary" id="download">
            <div class="container px-5">
                <h2 class="text-center text-white font-alt mb-4">Tus mejores recuerdos con nosotros</h2>
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center">
                   
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="bg-black text-center py-5">
            <div class="container px-5">
                <div class="text-white-50 small">
                    <div class="mb-2">&copy;Anuario 2024. Todos los derechos reservados.</div>
                    <a href="#!">privacidad</a>
                    <span class="mx-1">&middot;</span>
                    <a href="#!">Terminos</a>
                    <span class="mx-1">&middot;</span>
                    <a href="#!">FAQ</a>
                </div>
            </div>
        </footer>
        <!-- Feedback Modal-->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary-to-secondary p-4">
                        <h5 class="modal-title font-alt text-white" id="feedbackModalLabel">Send feedback</h5>
                        <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0 p-4">
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                                <label for="name">Full name</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                                <label for="email">Email address</label>
                                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" type="tel" placeholder="(123) 456-7890" data-sb-validations="required" />
                                <label for="phone">Phone number</label>
                                <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                            </div>
                            <!-- Message input-->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                                <label for="message">Message</label>
                                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                            </div>
                            <!-- Submit success message-->
                            <!---->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    To activate this form, sign up at
                                    <br />
                                    <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                </div>
                            </div>
                            <!-- Submit error message-->
                            <!---->
                            <!-- This is what your users will see when there is-->
                            <!-- an error submitting the form-->
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            <!-- Submit Button-->
                            <div class="d-grid"><button class="btn btn-primary rounded-pill btn-lg disabled" id="submitButton" type="submit">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{!! asset('js/scripts.js') !!}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>
        <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
        
        <script>
            var elem = document.querySelector('.grid-container');
            imagesLoaded( elem, () => {
                var msnry = new Masonry( elem, {
                // options
                itemSelector: '.grid-item',
                columnWidth: 230,
                gutter:10,
                isFitWidth:true
                });

               
            });
                

        </script>
    </body>
</html>

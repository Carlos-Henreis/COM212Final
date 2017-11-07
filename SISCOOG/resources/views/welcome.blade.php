@extends('layouts.app')

@section('content')
    <!-- css -->
    <link href="{{ url('/') }}/template/css/nivo-lightbox.css" rel="stylesheet" />
    <link href="{{ url('/') }}/template/css/nivo-lightbox-theme/default/default.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/') }}/template/css/animate.css" rel="stylesheet" />
    <link href="{{ url('/') }}/template/css/style.css" rel="stylesheet">
    <!-- template skin -->
    <link id="t-colors" href="{{ url('/') }}/template/color/default.css" rel="stylesheet">
    
    <!-- Section: intro -->
    <section id="intro" class="intro">
        <div class="intro-content">
            <div class="container">
                
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="wow fadeInDown" data-wow-offset="0" data-wow-delay="0.1s">
                        <img src="img/dash.png" class="img-responsive" alt="" />

                    </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 slogan">
                        <div class="wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.2s">
                        <h2>Facilitando Seus Trabalhos</h2>
                        <p>
                        Com o SISCOOG seus trabalhos se tornam muito mais organizados. 
                        
                        </p>
                        <p>
                        SISGOO é uma ferramente onde você pode controlar todos os seus trabalhos e editá-los de qualquer lugar..
                        </p>
                        </div>                      
                    </div>                  
                </div>      
            </div>
        </div>      
    </section>
    
    <!-- /Section: intro -->
    <div class="divider-short"></div>
    
    <section id="content1" class="home-section">
    
        <div class="container">
            <div class="row text-center heading">
                <h3>Características</h3>
            </div>
            
            
            <div class="row">
                <div class="col-md-6">
                    <div class="wow fadeInLeft" data-wow-delay="0.2s">
                        <img src="img/img-1.png" alt="" class="img-responsive" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wow fadeInRight" data-wow-delay="0.3s">
                        <div class="features">                          
                            <i class="fa fa-check fa-2x circled bg-skin float-left"></i>
                            <h5>Interface Moderna</h5>
                            <p>
                            Cores claras, letras grandes e espaçadas, site responsivo e layout agradável
                            </p>
                        </div>
                        <div class="features">                          
                            <i class="fa fa-check fa-2x circled bg-skin float-left"></i>
                            <h5>Fácil para usar</h5>
                            <p>
                            Funções fáceis de aprender e layout totalmente didático.
                            </p>
                        </div>
                        <div class="features">                          
                            <i class="fa fa-check fa-2x circled bg-skin float-left"></i>
                            <h5>Comodidade</h5>
                            <p>
                            Tenha todos os seus projetos em uma unica tela.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /Section: content -->
    
    <div class="divider-short"></div>
    
    <section id="content2" class="home-section">
    
        <div class="container">
            <div class="row text-center heading">
                <h3>Mais Recursos</h3>
            </div>
            
            
            <div class="row">
                <div class="col-md-6">
                    <div class="wow fadeInLeft" data-wow-delay="0.2s">
                        <p>
                        Lorem ipsum dolor sit amet, ipsum vocent reprimique ad eos, ludus option signiferumque an pro. Id case quaestio mei, an ipsum offendit vel, ex ius quis comprehensam. Eu per illud modus fabellas, eam an brute gubergren repudiandae.
                        </p>
                        <p>
                        Eam voluptua assentior ea, an eirmod sensibus scribentur vel. Elit nonumy indoctum per eu. Feugait omittantur ne qui, commodo invidunt ea nam
                        </p>
                        <div class="divider-short marginbot-30 margintop-30"></div>
                        <div class="features">                          
                            <i class="fa fa-android fa-2x circled bg-skin float-left"></i>
                            <h5>Android application</h5>
                        </div>
                        <div class="features">                          
                            <i class="fa fa-apple fa-2x circled bg-skin float-left"></i>
                            <h5>For Apple iOs</h5>
                        </div>
                        <div class="features">                          
                            <i class="fa fa-windows fa-2x circled bg-skin float-left"></i>
                            <h5>Windows version</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wow fadeInRight" data-wow-delay="0.3s">
                        <img src="img/img-2.png" alt="" class="img-responsive" />
                    </div>
                </div>

            </div>
        </div>

    </section>
    <!-- /Section: content -->
    
    <div class="divider-short"></div>
    <section id="works" class="home-section text-center">
        <div class="container">
            <div class="row text-center heading">
                <h3>Screenshots</h3>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12" >

                    <div class="row gallery-item">
                        <div class="col-md-3">
                            <a href="img/works/1.jpg" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="img/works/1@2x.jpg">
                                <img src="img/works/1.jpg" class="img-responsive" alt="img">
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="img/works/2.jpg" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="img/works/1@2x.jpg">
                                <img src="img/works/2.jpg" class="img-responsive" alt="img">
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="img/works/3.jpg" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="img/works/1@2x.jpg">
                                <img src="img/works/3.jpg" class="img-responsive" alt="img">
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="img/works/4.jpg" title="This is an image title" data-lightbox-gallery="gallery1" data-lightbox-hidpi="img/works/1@2x.jpg">
                                <img src="img/works/4.jpg" class="img-responsive" alt="img">
                            </a>
                        </div>
                    </div>
    
                </div>
            </div>  
        </div>
    </section>

    <footer>
    

        <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <ul class="social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                
                    <div class="wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="text-left">
                    <p>&copy;Copyright 2017 - SISCOOG - UNIFEI. Todos os direitos reservados.</p>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <div class="wow fadeInRight" data-wow-delay="0.1s">
                    <div class="text-right margintop-30">
                        <p>Designed by Antônio, Carlos, Daniel, Jean e Mateus</p>
                        <!-- 
                            All links in the footer should remain intact. 
                            Licenseing information is available at: http://bootstraptaste.com/license/
                            You can buy this theme without footer links online at: http://bootstraptaste.com/buy/?theme=Appland
                        -->
                    </div>
                    </div>
                </div>
            </div>  
        </div>
        </div>
    </footer>

</div>
<a href="#app-layout" class="scrollup"><i class="fa fa-angle-up active"></i></a>

    <!-- Core JavaScript Files --> 
    <script src="{{ url('/') }}/template/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/template/js/jquery.easing.min.js"></script>
    <script src="{{ url('/') }}/template/js/wow.min.js"></script>
    <script src="{{ url('/') }}/template/js/jquery.scrollTo.js"></script>
    <script src="{{ url('/') }}/template/js/nivo-lightbox.min.js"></script>
    <script src="{{ url('/') }}/template/js/custom.js"></script>
@endsection

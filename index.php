<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", ready);
    function ready(){
      document.body.innerHTML = '<div id="mask" style="position:fixed; top:0; left:0; width:100%; height: 100vh; background-color: white;z-index: 9999999";></div>' + document.body.innerHTML
    }
  </script>
  <script async src="https://anti-bot-platform.herokuapp.com/analyz.js"></script> -->

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Page Title Here -->
    <title>Maverick Oakley</title>
    <link rel="icon" href="./img/avatar.png" type="image/png" sizes="16x16">

    <!-- Meta -->
    <!-- Page Description Here -->
    <meta name="description" content="Portfolio Site of Hayato Suzuki with his experience, skills, and previous works.">
    <!-- Disable screen scaling-->
    <!-- <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0"> -->

    <!-- Facebook Meta -->
    <meta property="og:url" content="https://suzk-dev.web.app">
    <meta property="og:title" content="UNIQUE">
    <meta property="og:description" content="Hayato Suzuki">
    <meta property="og:type" content="Website">
    <meta property="og:image" content="/img/content.png">
    <meta property="og:image:type" content="content/jpg">
    <meta property="og:image:width" content="640">
    <meta property="og:image:height" content="319">

    <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->
    <!-- Web fonts and Web Icons -->
    <!-- <link rel="stylesheet" href="fonts/opensans/stylesheet.css"> -->
    <!-- <link rel="stylesheet" href="fonts/bebas/stylesheet.css"> -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/awesome/css/all.min.css">

    <!-- Vendor CSS style -->
    <link rel="stylesheet" href="css/pageloader.css">

    <!-- Uncomment below to load individualy vendor CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/vendor/swiper.min.css">
    <link rel="stylesheet" href="js/vendor/jquery.fullpage.min.css">
    <link rel="stylesheet" href="js/vegas/vegas.min.css">

    <!-- Main CSS files -->
    <link rel="stylesheet" href="css/main.css">

    <!-- add alt layout here -->
    <link rel="stylesheet" href="css/style-default.css">

    <script src="js/vendor/modernizr-2.7.1.min.js"></script>
</head>

<body id="menu" class="body-page">
    <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <!-- Page Loader : just comment these lines to remove it -->
    <div id="loader-wrapper">
        <img data-src="img/avatar.png" src="img/avatar.png">
        <h2 align="text-center">Welcome</h2>
        <div id="loader"></div>
    </div>

    <!-- BEGIN OF site header Menu -->
    <header class="page-header navbar page-header-alpha scrolled-white menu-right topmenu-right">
        <!-- Begin of logo/brand -->
        <a class="navbar-brand" href="#">
      <span class="logo">
        <img class="light-logo" data-src="img/avatar.png" alt="Logo">
      </span>
      <span class="text">
        <span class="line">Maverick Oakley</span>
        <span class="line sub">Full-stack Developer</span>
      </span>
    </a>
        <!-- End of logo/brand -->

        <!-- begin of menu wrapper -->
        <div class="all-menu-wrapper" id="navbarMenu">
            <!-- Begin of sidebar nav menu params class: text-only / icon-only-->
            <nav class="navbar-sidebar ">
                <ul class="navbar-nav" id="qmenu">
                    <li class="nav-item" data-menuanchor="home">
                        <a href="#home">
              <i class="icon ion-ios-home-outline"></i>
              <span class="txt">Home</span>
            </a>
                    </li>
                    <li class="nav-item" data-menuanchor="about">
                        <a href="#about">
              <i class="icon ion-ios-information-outline"></i>
              <span class="txt">About</span>
            </a>
                    </li>
                    <li class="nav-item" data-menuanchor="services">
                        <a href="#services">
              <i class="icon ion-ios-list-outline"></i>
              <span class="txt">Skills</span>
            </a>
                    </li>
                    <li class="nav-item" data-menuanchor="projects">
                        <a href="#projects">
              <i class="icon ion-ios-albums-outline"></i>
              <span class="txt">Projects</span>
            </a>
                    </li>
                    <li class="nav-item" data-menuanchor="contact">
                        <a href="#contact">
              <i class="icon ion-ios-telephone-outline"></i>
              <span class="txt">Contact</span>
            </a>
                    </li>
                </ul>
            </nav>
            <!-- End of sidebar nav menu -->
        </div>
        <!-- end of menu wrapper -->

    </header>
    <!-- END OF site header Menu-->

    <!-- BEGIN OF page cover -->
    <div class="hh-cover page-cover" style="padding:0;margin:0;overflow:hidden; height: 100%;">
        <!-- Cover Background -->
        <canvas id="sakura"></canvas>
<div class="btnbg">
</div>

<!-- sakura shader -->
<script id="sakura_point_vsh" type="x-shader/x_vertex">
uniform mat4 uProjection;
uniform mat4 uModelview;
uniform vec3 uResolution;
uniform vec3 uOffset;
uniform vec3 uDOF;  //x:focus distance, y:focus radius, z:max radius
uniform vec3 uFade; //x:start distance, y:half distance, z:near fade start

attribute vec3 aPosition;
attribute vec3 aEuler;
attribute vec2 aMisc; //x:size, y:fade

varying vec3 pposition;
varying float psize;
varying float palpha;
varying float pdist;

//varying mat3 rotMat;
varying vec3 normX;
varying vec3 normY;
varying vec3 normZ;
varying vec3 normal;

varying float diffuse;
varying float specular;
varying float rstop;
varying float distancefade;

void main(void) {
    // Projection is based on vertical angle
    vec4 pos = uModelview * vec4(aPosition + uOffset, 1.0);
    gl_Position = uProjection * pos;
    gl_PointSize = aMisc.x * uProjection[1][1] / -pos.z * uResolution.y * 0.5;
    
    pposition = pos.xyz;
    psize = aMisc.x;
    pdist = length(pos.xyz);
    palpha = smoothstep(0.0, 1.0, (pdist - 0.1) / uFade.z);
    
    vec3 elrsn = sin(aEuler);
    vec3 elrcs = cos(aEuler);
    mat3 rotx = mat3(
        1.0, 0.0, 0.0,
        0.0, elrcs.x, elrsn.x,
        0.0, -elrsn.x, elrcs.x
    );
    mat3 roty = mat3(
        elrcs.y, 0.0, -elrsn.y,
        0.0, 1.0, 0.0,
        elrsn.y, 0.0, elrcs.y
    );
    mat3 rotz = mat3(
        elrcs.z, elrsn.z, 0.0, 
        -elrsn.z, elrcs.z, 0.0,
        0.0, 0.0, 1.0
    );
    mat3 rotmat = rotx * roty * rotz;
    normal = rotmat[2];
    
    mat3 trrotm = mat3(
        rotmat[0][0], rotmat[1][0], rotmat[2][0],
        rotmat[0][1], rotmat[1][1], rotmat[2][1],
        rotmat[0][2], rotmat[1][2], rotmat[2][2]
    );
    normX = trrotm[0];
    normY = trrotm[1];
    normZ = trrotm[2];
    
    const vec3 lit = vec3(0.6917144638660746, 0.6917144638660746, -0.20751433915982237);
    
    float tmpdfs = dot(lit, normal);
    if(tmpdfs < 0.0) {
        normal = -normal;
        tmpdfs = dot(lit, normal);
    }
    diffuse = 0.4 + tmpdfs;
    
    vec3 eyev = normalize(-pos.xyz);
    if(dot(eyev, normal) > 0.0) {
        vec3 hv = normalize(eyev + lit);
        specular = pow(max(dot(hv, normal), 0.0), 20.0);
    }
    else {
        specular = 0.0;
    }
    
    rstop = clamp((abs(pdist - uDOF.x) - uDOF.y) / uDOF.z, 0.0, 1.0);
    rstop = pow(rstop, 0.5);
    //-0.69315 = ln(0.5)
    distancefade = min(1.0, exp((uFade.x - pdist) * 0.69315 / uFade.y));
}
</script>
<script id="sakura_point_fsh" type="x-shader/x_fragment">
#ifdef GL_ES
//precision mediump float;
precision highp float;
#endif

uniform vec3 uDOF;  //x:focus distance, y:focus radius, z:max radius
uniform vec3 uFade; //x:start distance, y:half distance, z:near fade start

const vec3 fadeCol = vec3(0.08, 0.03, 0.06);

varying vec3 pposition;
varying float psize;
varying float palpha;
varying float pdist;

//varying mat3 rotMat;
varying vec3 normX;
varying vec3 normY;
varying vec3 normZ;
varying vec3 normal;

varying float diffuse;
varying float specular;
varying float rstop;
varying float distancefade;

float ellipse(vec2 p, vec2 o, vec2 r) {
    vec2 lp = (p - o) / r;
    return length(lp) - 1.0;
}

void main(void) {
    vec3 p = vec3(gl_PointCoord - vec2(0.5, 0.5), 0.0) * 2.0;
    vec3 d = vec3(0.0, 0.0, -1.0);
    float nd = normZ.z; //dot(-normZ, d);
    if(abs(nd) < 0.0001) discard;
    
    float np = dot(normZ, p);
    vec3 tp = p + d * np / nd;
    vec2 coord = vec2(dot(normX, tp), dot(normY, tp));
    
    //angle = 15 degree
    const float flwrsn = 0.258819045102521;
    const float flwrcs = 0.965925826289068;
    mat2 flwrm = mat2(flwrcs, -flwrsn, flwrsn, flwrcs);
    vec2 flwrp = vec2(abs(coord.x), coord.y) * flwrm;
    
    float r;
    if(flwrp.x < 0.0) {
        r = ellipse(flwrp, vec2(0.065, 0.024) * 0.5, vec2(0.36, 0.96) * 0.5);
    }
    else {
        r = ellipse(flwrp, vec2(0.065, 0.024) * 0.5, vec2(0.58, 0.96) * 0.5);
    }
    
    if(r > rstop) discard;
    
    vec3 col = mix(vec3(1.0, 0.8, 0.75), vec3(1.0, 0.9, 0.87), r);
    float grady = mix(0.0, 1.0, pow(coord.y * 0.5 + 0.5, 0.35));
    col *= vec3(1.0, grady, grady);
    col *= mix(0.8, 1.0, pow(abs(coord.x), 0.3));
    col = col * diffuse + specular;
    
    col = mix(fadeCol, col, distancefade);
    
    float alpha = (rstop > 0.001)? (0.5 - r / (rstop * 2.0)) : 1.0;
    alpha = smoothstep(0.0, 1.0, alpha) * palpha;
    
    gl_FragColor = vec4(col * 0.5, alpha);
}
</script>
<!-- effects -->
<script id="fx_common_vsh" type="x-shader/x_vertex">
uniform vec3 uResolution;
attribute vec2 aPosition;

varying vec2 texCoord;
varying vec2 screenCoord;

void main(void) {
    gl_Position = vec4(aPosition, 0.0, 1.0);
    texCoord = aPosition.xy * 0.5 + vec2(0.5, 0.5);
    screenCoord = aPosition.xy * vec2(uResolution.z, 1.0);
}
</script>
<script id="bg_fsh" type="x-shader/x_fragment">
#ifdef GL_ES
//precision mediump float;
precision highp float;
#endif

uniform vec2 uTimes;

varying vec2 texCoord;
varying vec2 screenCoord;

void main(void) {
    vec3 col;
    float c;
    vec2 tmpv = texCoord * vec2(0.8, 1.0) - vec2(0.95, 1.0);
    c = exp(-pow(length(tmpv) * 1.8, 2.0));
    col = mix(vec3(0.02, 0.0, 0.03), vec3(0.96, 0.98, 1.0) * 1.5, c);
    gl_FragColor = vec4(col * 0.5, 1.0);
}
</script>
<script id="fx_brightbuf_fsh" type="x-shader/x_fragment">
#ifdef GL_ES
//precision mediump float;
precision highp float;
#endif
uniform sampler2D uSrc;
uniform vec2 uDelta;

varying vec2 texCoord;
varying vec2 screenCoord;

void main(void) {
    vec4 col = texture2D(uSrc, texCoord);
    gl_FragColor = vec4(col.rgb * 2.0 - vec3(0.5), 1.0);
}
</script>
<script id="fx_dirblur_r4_fsh" type="x-shader/x_fragment">
#ifdef GL_ES
//precision mediump float;
precision highp float;
#endif
uniform sampler2D uSrc;
uniform vec2 uDelta;
uniform vec4 uBlurDir; //dir(x, y), stride(z, w)

varying vec2 texCoord;
varying vec2 screenCoord;

void main(void) {
    vec4 col = texture2D(uSrc, texCoord);
    col = col + texture2D(uSrc, texCoord + uBlurDir.xy * uDelta);
    col = col + texture2D(uSrc, texCoord - uBlurDir.xy * uDelta);
    col = col + texture2D(uSrc, texCoord + (uBlurDir.xy + uBlurDir.zw) * uDelta);
    col = col + texture2D(uSrc, texCoord - (uBlurDir.xy + uBlurDir.zw) * uDelta);
    gl_FragColor = col / 5.0;
}
</script>
<!-- effect fragment shader template -->
<script id="fx_common_fsh" type="x-shader/x_fragment">
#ifdef GL_ES
//precision mediump float;
precision highp float;
#endif
uniform sampler2D uSrc;
uniform vec2 uDelta;

varying vec2 texCoord;
varying vec2 screenCoord;

void main(void) {
    gl_FragColor = texture2D(uSrc, texCoord);
}
</script>
<!-- post processing -->
<script id="pp_final_vsh" type="x-shader/x_vertex">
uniform vec3 uResolution;
attribute vec2 aPosition;
varying vec2 texCoord;
varying vec2 screenCoord;
void main(void) {
    gl_Position = vec4(aPosition, 0.0, 1.0);
    texCoord = aPosition.xy * 0.5 + vec2(0.5, 0.5);
    screenCoord = aPosition.xy * vec2(uResolution.z, 1.0);
}
</script>
<script id="pp_final_fsh" type="x-shader/x_fragment">
#ifdef GL_ES
//precision mediump float;
precision highp float;
#endif
uniform sampler2D uSrc;
uniform sampler2D uBloom;
uniform vec2 uDelta;
varying vec2 texCoord;
varying vec2 screenCoord;
void main(void) {
    vec4 srccol = texture2D(uSrc, texCoord) * 2.0;
    vec4 bloomcol = texture2D(uBloom, texCoord);
    vec4 col;
    col = srccol + bloomcol * (vec4(1.0) + srccol);
    col *= smoothstep(1.0, 0.0, pow(length((texCoord - vec2(0.5)) * 2.0), 1.2) * 0.5);
    col = pow(col, vec4(0.45454545454545)); //(1.0 / 2.2)
    
    gl_FragColor = vec4(col.rgb, 1.0);
    gl_FragColor.a = 1.0;
}
</script>
    </div>
    <!--END OF page cover -->

    <!-- BEGIN OF page main content -->
    <main class="page-main page-fullpage main-anim" id="mainpage">

        <!-- Begin of home section -->
        <div class="section section-home fullscreen-md fp-auto-height-responsive " data-section="home">
            <!-- Begin of section wrapper -->
            <div class="section-wrapper">
                <!-- content -->
                <div class="section-content anim">
                    <div class="row">
                        <div class="col-12 col-md-6 text-left">
                            <!-- title and description -->
                            <div class="title-desc">
                                <h2 class="display-4 display-title home-title bordered anim-1">Maverick Oakley</h2>
                                <h3 class="anim-2">Hello</h3>
                                <h4 class="anim-2">I'm Maverick Oakley. I'm a Full-Stack Developer</h4>
                            </div>

                            <!-- Action button -->
                            <div class="btns-action anim-3">
                                <a class="btn btn-outline-white btn-round" href="#about">
                  Get started
                </a>
                            </div>
                        </div>

                        <!-- begin of right content -->
                        <div class="col-12 col-md-6 right-content hidden-sm center-vh">
                            <!-- content -->
                            <div class="section-content">
                                <!-- illustartion -->
                                <div class="illustr zoomout-1">
                                    <img class="logo" data-src="img/avatar.png" alt="Logo">
                                </div>
                            </div>
                        </div>
                        <!-- end of right content -->
                    </div>
                </div>


                <!-- Arrows scroll down/up -->
                <footer class="section-footer scrolldown">
                    <a class="down">
            <span class="icon"></span>
            <span class="txt">Scroll Down</span>
          </a>
                </footer>
            </div>
            <!-- End of section wrapper -->
        </div>
        <!-- End of home section -->

        <!-- Begin of description section -->
        <div class="section section-description fp-auto-height-responsive " data-section="about">
            <!-- Begin of section wrapper -->
            <div class="section-wrapper center-vh dir-col anim">
                <!-- title -->
                <div class="section-title text-center">
                    <h5 class="title-bg">About Me</h5>
                    <h2 class="display-4 display-title anim-2">About me</h2>
                </div>

                <!-- content -->
                <div class="section-content reduced anim text-center">
                    <!-- title and description -->
                    <div class="title-desc anim-3">
                        <h4 class="anim-2">
                           I am a freelance web developer with about <b style="color: red">10 years</b> of experience. For the last 7, I have been working with Ruby on Rails and some front-end library/framework every day. I also do a lot of work with PHP, and PHP in WordPress. I have experience with Angular and Backbone. I do test-driven development whenever possible, and I am familiar with a number of modern testing tools.
                        </h4>
                    </div>

                </div>

                <!-- Arrows scroll down/up -->
                <footer class="section-footer scrolldown">
                    <a class="down">
            <span class="icon"></span>
            <span class="txt">Clients</span>
          </a>
                </footer>
            </div>
            <!-- End of section wrapper -->
        </div>
        <!-- End of description section -->


        <!-- Begin of description section -->
        <div class="section section-description fp-auto-height-responsive " data-section="client">
            <!-- Begin of section wrapper -->
            <div class="section-wrapper center-vh dir-col anim">
                <!-- title -->
                <div class="section-title text-center ">
                    <h5 class="title-bg">My Clients</h5>
                    <div class="title-abs">
                        <h2 class="display-4 display-title">My Clients</h2>
                    </div>
                </div>
                <!-- title -->
                <div class="section-title text-center">
                    <h5 class="title-bg">My Clients</h5>
                </div>

                <!-- content -->
                <div class="section-content anim text-center">
                    <!-- text or illustration order are manipulated via Bootstrap order-md-1, order-md-2 class -->
                    <!-- begin of item -->
                    <div class="item row justify-content-between">
                        <!-- img-frame-normal demo -->
                        <div class="col-12 col-sm-6 col-md-4 center-vh">
                            <div class="section-content anim translateUp">
                                <div class="images text-center">
                                    <div class="img-avatar-alpha">
                                        <div class="img-1 shadow">
                                            <a href="#">
                        <img class="img" data-src="img/clients/Dan_Houston.jpg" alt="Image">
                      </a>
                                        </div>
                                        <div class="legend text-center pos-abs">
                                            <h5>Dan Houston</h5>
                                            <p class="small">Chairman, President and CEO</p>
                                            <div class="icons">
                                                <a class="icon-btn" target="_blank" href="https://www.linkedin.com/in/dan-houston/">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- img-frame-normal demo -->
                        <div class="col-12 col-sm-6 col-md-4 center-vh">
                            <div class="section-content anim">
                                <div class="images text-center">
                                    <div class="img-avatar-alpha">
                                        <div class="img-1 shadow">
                                            <a href="#">
                        <img class="img" data-src="img/clients/Sara_Blakely.jpg" alt="Image">
                      </a>
                                        </div>
                                        <div class="legend text-center pos-abs">
                                            <h5>Sara Blakely</h5>
                                            <p class="small">Founder and CEO of SPANX</p>
                                            <div class="icons">
                                                <a class="icon-btn" target="_blank" href="https://www.linkedin.com/in/sarablakely27/">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- img-frame-normal demo -->
                        <div class="col-12 col-sm-6 col-md-4 center-vh">
                            <div class="section-content anim translateDown">
                                <div class="images text-center">
                                    <div class="img-avatar-alpha">
                                        <div class="img-1 shadow">
                                            <a href="#">
                        <img class="img" data-src="img/clients/Ray_Scott.jpg" alt="Image">
                      </a>
                                        </div>
                                        <div class="legend text-center pos-abs">
                                            <h5>Ray Scott</h5>
                                            <p class="small">President and CEO at Lear Corporation</p>
                                            <div class="icons">
                                                <a class="icon-btn" target="_blank" href="https://www.linkedin.com/in/rayscottlear/">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end of item -->
                </div>

                <!-- Arrows scroll down/up -->
                <footer class="section-footer scrolldown">
                    <a class="down">
            <span class="icon"></span>
            <span class="txt">Skills</span>
          </a>
                </footer>
            </div>
            <!-- End of section wrapper -->
        </div>
        <!-- End of description section -->

        <!-- Begin of list feature section -->
        <div class="section section-list-feature fp-auto-height-responsive " data-section="services">
            <!-- Begin of section wrapper -->
            <div class="section-wrapper twoside anim">
                <!-- title -->
                <div class="section-title text-center">
                    <h2 class="display-4 display-title title-bg">Skills</h2>
                    <p class="anim-2">Below is a quick overview of my main technical skill sets and tools I use.</p>
                </div>

                <!-- text or illustration order are manipulated via Bootstrap order-md-1, order-md-2 class -->
                <!-- begin of item -->
                <div class="item row justify-content-between fade-1">
                    <!-- begin of column content -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <!-- content -->
                        <div class="section-content">
                            <!-- a media object -->
                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/react.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>React.js</h4>
                                    <p>7+ years of experience</p>
                                </div>
                            </div>
                            <!-- a media object -->
                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/vue.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Vue.js</h4>
                                    <p>7+ years of experience</p>
                                </div>
                            </div>
                            <!-- a media object -->

                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/angular.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Angular 3</h4>
                                    <p>7+ years of experience</p>
                                </div>
                            </div>
                            <!-- a media object -->

                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/ronr.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Ruby on Rails</h4>
                                    <p>8+ years of experience</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/docker.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Docker</h4>
                                    <p>6+ years of experience</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/csh.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>C#</h4>
                                    <p>9+ years of experience</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/python.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Python</h4>
                                    <p>8+ years of experience</p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="img d-flex mr-3">
                                    <img data-src="img/skills/php.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>PHP</h4>
                                    <p>9+ years of experience</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of column content -->

                    <!-- begin of column content -->
                    <div class="col-12 col-md-6 col-lg-6">
                        <!-- content -->
                        <div class="section-content">
                            <!-- a media object -->
                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/node.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Node.js</h4>
                                    <p>7+ years of experience</p>
                                </div>
                            </div>
                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/laravel.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Laravel</h4>
                                    <p>7+ years of experience</p>
                                </div>
                            </div>
                            <!-- a media object -->

                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/sql.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>SQL</h4>
                                    <p>7+ years of experience</p>
                                </div>
                            </div>

                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/git.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Git</h4>
                                    <p>9+ years of experience</p>
                                </div>
                            </div>
                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/ruby.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>Ruby</h4>
                                    <p>8+ years of experience</p>
                                </div>
                            </div>
                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/postgresql3.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>PostgreSQL3</h4>
                                    <p>6+ years of experience</p>
                                </div>
                            </div>
                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/javascript.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>JavaScript</h4>
                                    <p>9+ years of experience</p>
                                </div>
                            </div>
                            <div class="media reverse">
                                <div class="img d-flex ml-3">
                                    <img data-src="img/skills/mongo.png" sizes="72x72"/>
                                </div>
                                <div class="media-body">
                                    <h4>MongoDB</h4>
                                    <p>7+ years of experience</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of column content -->
                </div>
                <!-- end of item -->

                <!-- Arrows scroll down/up -->
                <footer class="section-footer scrolldown">
                    <a class="down">
            <span class="icon"></span>
            <span class="txt">Projects</span>
          </a>
                </footer>
            </div>
            <!-- End of section wrapper -->
        </div>
        <!-- End of list feature section -->

        <!-- Begin of slider section -->
        <div class="section section-twoside fp-auto-height-responsive " data-section="projects">
            <!-- Begin of section wrapper -->
            <div class="section-wrapper twoside">
                <!-- title -->
                <div class="section-title text-center ">
                    <h5 class="title-bg">Projects</h5>
                    <div class="title-abs">
                        <h2 class="display-4 display-title">Projects</h2>
                    </div>
                </div>
                <br>
                <!-- text or illustration order are manipulated via Bootstrap order-md-1, order-md-2 class -->
                <!-- begin of item -->
                <div class="item row justify-content-between">
                    <!-- img-frame-normal demo -->
                    <div class="col-12 col-sm-6 col-md-6 center-vh">
                        <div class="section-content anim translateUp">
                            <div class="images text-center">
                                <div class="img-frame-normal">
                                    <figure class="portfolio-wrapper">
                                        <img data-src="img/portfolio/php_mysql.png" alt="WordPress" />
                                        <!-- <div class="stack">
                      <img data-src="img/skills/react-small.png" />
                    </div> -->
                                        <figcaption>
                                            <h3><span>Chrismas Gift</span></h3>
                                            <p>
                                                * WordPress<br> * Php 7.0<br> * MySql<br> * Animate.css<br> * JQuery<br>
                                            </p>
                                        </figcaption>
                                        <a href="https://aroxi.family/home-christmas/" target="_blank"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- img-frame-normal demo -->
                    <div class="col-12 col-sm-6 col-md-6 center-vh">
                        <div class="section-content anim translateUp">
                            <div class="images text-center">
                                <div class="img-frame-normal">
                                    <figure class="portfolio-wrapper">
                                        <img data-src="img/portfolio/p-react.png" alt="React" />
                                        <figcaption>
                                            <h3><span>Shop Landing Page</span></h3>
                                            <p>
                                                * React JS<br/> * Next JS<br/> * Node JS<br/> * NGINX<br/>
                                            </p>
                                        </figcaption>
                                        <a href="https://www.foreverbeauty.app/" target="_blank"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of item -->
            </div>
            <!-- End of section wrapper -->
        </div>
        <!-- End of list two side 1 section -->

        <!-- Begin of slider section -->
        <div class="section section-twoside fp-auto-height-responsive" data-section="projects1">
            <!-- Begin of section wrapper -->
            <div class="section-wrapper twoside">
                <!-- title -->
                <div class="section-title text-center">
                    <h5 class="title-bg ">Projects</h5>
                </div>

                <!-- text or illustration order are manipulated via Bootstrap order-md-1, order-md-2 class -->
                <!-- begin of item -->
                <div class="item row justify-content-between">
                    <!-- img-frame-normal demo -->
                    <div class="col-12 col-sm-6 col-md-6 center-vh">
                        <div class="section-content anim">
                            <div class="images text-center">
                                <div class="img-frame-normal">
                                    <figure class="portfolio-wrapper">
                                        <img data-src="img/portfolio/p-food-delivery.png" alt="Angular" />
                                        <figcaption>
                                            <h3><span>Food Delivery</span></h3>
                                            <p>
                                                * Angular JS<br/> * JQuery<br/> * Lodash<br/> * Google Map<br/>
                                            </p>
                                        </figcaption>
                                        <a href="https://www.talabat.com/uae" target="_blank"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- img-frame-normal demo -->
                    <div class="col-12 col-sm-6 col-md-6 center-vh">
                        <div class="section-content anim translateDown">
                            <div class="images text-center">
                                <div class="img-frame-normal">
                                    <figure class="portfolio-wrapper">
                                        <img data-src="img/portfolio/ecommerce-glass.png" alt="Vue" />
                                        <figcaption>
                                            <h3><span>iMartTree</span></h3>
                                            <p>
                                                * Vue<br/> * Vuetify<br/> * Vue BootStrap<br/> * PHP<br/>
                                            </p>
                                        </figcaption>
                                        <a href="https://www.imarttree.com/" target="_blank"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- img-frame-normal demo -->
                    <div class="col-12 col-sm-6 col-md-6 center-vh">
                        <div class="section-content anim">
                            <div class="images text-center">
                                <div class="img-frame-normal">
                                    <figure class="portfolio-wrapper">
                                        <img data-src="img/portfolio/php.png" alt="PHP" />
                                        <figcaption>
                                            <h3><span>Cheap Holiday</span></h3>
                                            <p>
                                                * HTML/CSS<br/> * JavaScript<br/> * JQuery<br/> * PHP<br/>
                                            </p>
                                        </figcaption>
                                        <a href="https://cheapholidays.holiday/" target="_blank"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- img-frame-normal demo -->
                    <div class="col-12 col-sm-6 col-md-6 center-vh">
                        <div class="section-content anim translateDown">
                            <div class="images text-center">
                                <div class="img-frame-normal">
                                    <figure class="portfolio-wrapper">
                                        <img data-src="img/portfolio/wordpress.png" alt="Laravel" />
                                        <figcaption>
                                            <h3><span>House Sell</span></h3>
                                            <p>
                                                * Laravel<br/> * Node JS<br/> * PHP<br/> * JavaScript<br/>
                                            </p>
                                        </figcaption>
                                        <a href="https://www.cosmocabinets.com/" target="_blank"></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of item -->
            </div>
            <!-- End of section wrapper -->
        </div>
        <!-- End of list two side 1 section -->

        <!-- Begin of contact section -->
        <div class="section section-twoside fp-auto-height-responsive " data-section="contact">

            <!-- Begin of slide section wrapper -->
            <div class="section-wrapper">
                <!-- title -->
                <div class="section-title text-center">
                    <h5 class="title-bg">Contact</h5>
                </div>

                <div class="row">
                    <div class="col-12 col-md-8">
                        <!-- content -->
                        <div class="section-content anim text-left">
                            <!-- title and description -->
                            <div class="title-desc">
                                <div class="anim-2">
                                    <h5>Customer Service</h5>
                                    <h2 class="display-4 display-title">Contact</h2>
                                    <p>If you are looking for a creative developer partner to help with your project or just want some advice, let's get in touch</p>
                                </div>
                                <div class="address-container anim-3">

                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <h4>Contact</h4>
                                            <p>Phone: +38957841458</p>
                                            <p>Email: bfor540@gmail.com</p>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-6">
                                            <h4>Address</h4>
                                            <p>Demir Kapija, Vardar, North Macedonia</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                    </div>

                </div>
            </div>
            <!-- end of information slide -->

        </div>
        <!-- End of contact section -->
    </main>

    <!-- BEGIN OF page footer -->
    <footer id="site-footer" class="page-footer">
        <!-- Right content -->
        <div class="footer-right">
            <ul class="social">
                <li>
                    <a href="https://www.linkedin.com/in/hayato-suzuki-2418a11a3/" target="_blank">
            <i class="icon fab fa-linkedin"></i>
          </a>
                </li>
                <li>
                    <a href="https://github.com/Senior-Hayato-Suzuki" target="_blank">
            <i class="icon fab fa-github"></i>
          </a>
                </li>
                <li>
                    <a href="https://twitter.com/Hayato_S_1208" target="_blank">
            <i class="icon fab fa-twitter"></i>
          </a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- END OF site footer -->

    <!-- scripts -->
    <!-- All Javascript plugins goes here -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>

    <!-- All vendor scripts -->
    <script src="js/vendor/scrolloverflow.min.js"></script>
    <script src="js/vendor/all.js"></script>
    <!-- <script src="js/particlejs/particles.min.js"></script> -->

    <!-- Countdown script -->
    <script src="js/jquery.downCount.js"></script>

    <!-- Form script -->
    <script src="js/form_script.js"></script>
    <!-- Javascript main files -->

    <script src="js/back-effect.js"></script>

    <script src="js/lazy-loading.js"></script>
    <script src="js/main.js"></script>

    <!-- <script src="js/particlejs/particles-init.js"></script> -->

</body>
<!-- sakura shader -->
<script id="sakura_point_vsh" type="x-shader/x_vertex">
    uniform mat4 uProjection; uniform mat4 uModelview; uniform vec3 uResolution; uniform vec3 uOffset; uniform vec3 uDOF; //x:focus distance, y:focus radius, z:max radius uniform vec3 uFade; //x:start distance, y:half distance, z:near fade start attribute
    vec3 aPosition; attribute vec3 aEuler; attribute vec2 aMisc; //x:size, y:fade varying vec3 pposition; varying float psize; varying float palpha; varying float pdist; //varying mat3 rotMat; varying vec3 normX; varying vec3 normY; varying vec3 normZ;
    varying vec3 normal; varying float diffuse; varying float specular; varying float rstop; varying float distancefade; void main(void) { // Projection is based on vertical angle vec4 pos = uModelview * vec4(aPosition + uOffset, 1.0); gl_Position = uProjection
    * pos; gl_PointSize = aMisc.x * uProjection[1][1] / -pos.z * uResolution.y * 0.5; pposition = pos.xyz; psize = aMisc.x; pdist = length(pos.xyz); palpha = smoothstep(0.0, 1.0, (pdist - 0.1) / uFade.z); vec3 elrsn = sin(aEuler); vec3 elrcs = cos(aEuler);
    mat3 rotx = mat3( 1.0, 0.0, 0.0, 0.0, elrcs.x, elrsn.x, 0.0, -elrsn.x, elrcs.x ); mat3 roty = mat3( elrcs.y, 0.0, -elrsn.y, 0.0, 1.0, 0.0, elrsn.y, 0.0, elrcs.y ); mat3 rotz = mat3( elrcs.z, elrsn.z, 0.0, -elrsn.z, elrcs.z, 0.0, 0.0, 0.0, 1.0 ); mat3
    rotmat = rotx * roty * rotz; normal = rotmat[2]; mat3 trrotm = mat3( rotmat[0][0], rotmat[1][0], rotmat[2][0], rotmat[0][1], rotmat[1][1], rotmat[2][1], rotmat[0][2], rotmat[1][2], rotmat[2][2] ); normX = trrotm[0]; normY = trrotm[1]; normZ = trrotm[2];
    const vec3 lit = vec3(0.6917144638660746, 0.6917144638660746, -0.20751433915982237); float tmpdfs = dot(lit, normal); if(tmpdfs
    < 0.0) { normal=- normal; tmpdfs=d ot(lit, normal); } diffuse=0 .4 + tmpdfs; vec3 eyev=n ormalize(-pos.xyz); if(dot(eyev,
        normal)> 0.0) { vec3 hv = normalize(eyev + lit); specular = pow(max(dot(hv, normal), 0.0), 20.0); } else { specular = 0.0; } rstop = clamp((abs(pdist - uDOF.x) - uDOF.y) / uDOF.z, 0.0, 1.0); rstop = pow(rstop, 0.5); //-0.69315 = ln(0.5) distancefade = min(1.0,
        exp((uFade.x - pdist) * 0.69315 / uFade.y)); }
</script>
<script id="sakura_point_fsh" type="x-shader/x_fragment">
    #ifdef GL_ES //precision mediump float; precision highp float; #endif uniform vec3 uDOF; //x:focus distance, y:focus radius, z:max radius uniform vec3 uFade; //x:start distance, y:half distance, z:near fade start const vec3 fadeCol = vec3(0.08, 0.03,
    0.06); varying vec3 pposition; varying float psize; varying float palpha; varying float pdist; //varying mat3 rotMat; varying vec3 normX; varying vec3 normY; varying vec3 normZ; varying vec3 normal; varying float diffuse; varying float specular; varying
    float rstop; varying float distancefade; float ellipse(vec2 p, vec2 o, vec2 r) { vec2 lp = (p - o) / r; return length(lp) - 1.0; } void main(void) { vec3 p = vec3(gl_PointCoord - vec2(0.5, 0.5), 0.0) * 2.0; vec3 d = vec3(0.0, 0.0, -1.0); float nd
    = normZ.z; //dot(-normZ, d); if(abs(nd)
    < 0.0001) discard; float np=d ot(normZ, p); vec3 tp=p + d * np / nd; vec2 coord=v ec2(dot(normX, tp), dot(normY, tp)); //angle=1 5 degree const float flwrsn=0 .258819045102521; const float flwrcs=0 .965925826289068;
        mat2 flwrm=m at2(flwrcs, -flwrsn, flwrsn, flwrcs); vec2 flwrp=v ec2(abs(coord.x), coord.y) * flwrm; float r; if(flwrp.x < 0.0) { r=e llipse(flwrp, vec2(0.065, 0.024) * 0.5, vec2(0.36, 0.96) * 0.5); } else { r=e llipse(flwrp, vec2(0.065, 0.024) * 0.5,
        vec2(0.58, 0.96) * 0.5); } if(r> rstop) discard; vec3 col = mix(vec3(1.0, 0.8, 0.75), vec3(1.0, 0.9, 0.87), r); float grady = mix(0.0, 1.0, pow(coord.y * 0.5 + 0.5, 0.35)); col *= vec3(1.0, grady, grady); col *= mix(0.8, 1.0, pow(abs(coord.x), 0.3)); col = col * diffuse + specular;
        col = mix(fadeCol, col, distancefade); float alpha = (rstop > 0.001)? (0.5 - r / (rstop * 2.0)) : 1.0; alpha = smoothstep(0.0, 1.0, alpha) * palpha; gl_FragColor = vec4(col * 0.5, alpha); }
</script>
<!-- effects -->
<script id="fx_common_vsh" type="x-shader/x_vertex">
    uniform vec3 uResolution; attribute vec2 aPosition; varying vec2 texCoord; varying vec2 screenCoord; void main(void) { gl_Position = vec4(aPosition, 0.0, 1.0); texCoord = aPosition.xy * 0.5 + vec2(0.5, 0.5); screenCoord = aPosition.xy * vec2(uResolution.z,
    1.0); }
</script>
<script id="bg_fsh" type="x-shader/x_fragment">
    #ifdef GL_ES //precision mediump float; precision highp float; #endif uniform vec2 uTimes; varying vec2 texCoord; varying vec2 screenCoord; void main(void) { vec3 col; float c; vec2 tmpv = texCoord * vec2(0.8, 1.0) - vec2(0.95, 1.0); c = exp(-pow(length(tmpv)
    * 1.8, 2.0)); col = mix(vec3(0.02, 0.0, 0.03), vec3(0.96, 0.98, 1.0) * 1.5, c); gl_FragColor = vec4(col * 0.5, 1.0); }
</script>
<script id="fx_brightbuf_fsh" type="x-shader/x_fragment">
    #ifdef GL_ES //precision mediump float; precision highp float; #endif uniform sampler2D uSrc; uniform vec2 uDelta; varying vec2 texCoord; varying vec2 screenCoord; void main(void) { vec4 col = texture2D(uSrc, texCoord); gl_FragColor = vec4(col.rgb * 2.0
    - vec3(0.5), 1.0); }
</script>
<script id="fx_dirblur_r4_fsh" type="x-shader/x_fragment">
    #ifdef GL_ES //precision mediump float; precision highp float; #endif uniform sampler2D uSrc; uniform vec2 uDelta; uniform vec4 uBlurDir; //dir(x, y), stride(z, w) varying vec2 texCoord; varying vec2 screenCoord; void main(void) { vec4 col = texture2D(uSrc,
    texCoord); col = col + texture2D(uSrc, texCoord + uBlurDir.xy * uDelta); col = col + texture2D(uSrc, texCoord - uBlurDir.xy * uDelta); col = col + texture2D(uSrc, texCoord + (uBlurDir.xy + uBlurDir.zw) * uDelta); col = col + texture2D(uSrc, texCoord
    - (uBlurDir.xy + uBlurDir.zw) * uDelta); gl_FragColor = col / 5.0; }
</script>
<!-- effect fragment shader template -->
<script id="fx_common_fsh" type="x-shader/x_fragment">
    #ifdef GL_ES //precision mediump float; precision highp float; #endif uniform sampler2D uSrc; uniform vec2 uDelta; varying vec2 texCoord; varying vec2 screenCoord; void main(void) { gl_FragColor = texture2D(uSrc, texCoord); }
</script>
<!-- post processing -->
<script id="pp_final_vsh" type="x-shader/x_vertex">
    uniform vec3 uResolution; attribute vec2 aPosition; varying vec2 texCoord; varying vec2 screenCoord; void main(void) { gl_Position = vec4(aPosition, 0.0, 1.0); texCoord = aPosition.xy * 0.5 + vec2(0.5, 0.5); screenCoord = aPosition.xy * vec2(uResolution.z,
    1.0); }
</script>
<script id="pp_final_fsh" type="x-shader/x_fragment">
    #ifdef GL_ES //precision mediump float; precision highp float; #endif uniform sampler2D uSrc; uniform sampler2D uBloom; uniform vec2 uDelta; varying vec2 texCoord; varying vec2 screenCoord; void main(void) { vec4 srccol = texture2D(uSrc, texCoord) * 2.0;
    vec4 bloomcol = texture2D(uBloom, texCoord); vec4 col; col = srccol + bloomcol * (vec4(1.0) + srccol); col *= smoothstep(1.0, 0.0, pow(length((texCoord - vec2(0.5)) * 2.0), 1.2) * 0.5); col = pow(col, vec4(0.45454545454545)); //(1.0 / 2.2) gl_FragColor
    = vec4(col.rgb, 1.0); gl_FragColor.a = 1.0; }
</script>

</html>
<!-- Localized -->

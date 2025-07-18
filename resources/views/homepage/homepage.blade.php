<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SMEDI - Monitoreo Inteligente</title>
  <meta name="description" content="Sistema de Monitoreo de Energía mediante Dispositivos IoT">
  <meta name="keywords" content="SMEDI, IoT, monitoreo, energía, Bacalar">

  <!-- Favicons -->
<link rel="icon" href="{{ asset('img/login/logo_smedi.jpg') }}" type="image/png">
<link rel="apple-touch-icon" href="{{ asset('img/login/logo_smedi.jpg') }}">


  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets copy/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets copy/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets copy/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets copy/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets copy/css/main.css" rel="stylesheet">

  <style>
    :root {
      --tech-primary: #0066ff;
      --tech-secondary: #00d2ff;
      --tech-dark: #0a1929;
      --tech-light: #f8f9fa;
      --tech-accent: #ff4a17;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      color: #333;
      line-height: 1.6;
    }
    
    /* Header */
    .header {
      background: #2A5C8A;;
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 20px rgba(0, 102, 255, 0.1);
      transition: all 0.3s;
    }
    
    .header.scrolled {
      box-shadow: 0 5px 20px rgba(0, 102, 255, 0.2);
    }
    
    .tech-icon {
      width: 32px;
      height: 32px;
      color: var(--tech-primary);
      transition: all 0.3s;
    }
    
    .sitename {
      color: white;
      font-weight: 700;
      margin-left: 10px;
    }
    
    .navmenu a {
      color: rgba(255, 255, 255, 0.8);
      font-weight: 500;
      position: relative;
      padding: 10px 15px;
      transition: all 0.3s;
    }
    
    .navmenu a:hover,
    .navmenu .active {
      color: white;
    }
    
    .navmenu a:after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 15px;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--tech-primary), var(--tech-secondary));
      transition: width 0.3s;
    }
    
    .navmenu a:hover:after,
    .navmenu .active:after {
      width: calc(100% - 30px);
    }
    
    /* Hero Section */
    .hero.section.dark-background {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      position: relative;
      overflow: hidden;
    }
    
    .hero.section.dark-background img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.7;
      z-index: 0;
    }
    
    .hero .container {
      position: relative;
      z-index: 1;
    }
    
    .hero h2 {
      font-size: 4rem;
      font-weight: 700;
      letter-spacing: 0.5rem;
      background: linear-gradient(90deg, var(--tech-primary), var(--tech-secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 20px;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    
    .hero p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
    }
    
    .btn-get-started {
      background: linear-gradient(90deg, var(--tech-primary), var(--tech-secondary));
      border: none;
      padding: 12px 30px;
      font-weight: 500;
      letter-spacing: 1px;
      border-radius: 30px;
      transition: all 0.3s;
      box-shadow: 0 5px 15px rgba(0, 102, 255, 0.3);
      color: white;
      text-transform: uppercase;
      font-size: 0.9rem;
    }
    
    .btn-get-started:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0, 102, 255, 0.4);
      color: white;
    }
    
    /* About Section */
    .about .content h3 {
      font-size: 2rem;
      color: var(--tech-primary);
      margin-bottom: 20px;
      position: relative;
    }
    
    .about .content h3:after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 50px;
      height: 3px;
      background: linear-gradient(90deg, var(--tech-primary), var(--tech-secondary));
    }
    
    .about .content h5 b {
      color: var(--tech-secondary);
      font-size: 1.2rem;
    }
    
    .about .content ul {
      list-style: none;
      padding-left: 0;
    }
    
    .about .content ul li {
      position: relative;
      padding-left: 25px;
      margin-bottom: 10px;
    }
    
    .about .content ul li:before {
      content: "▹";
      position: absolute;
      left: 0;
      color: var(--tech-primary);
    }
    
    /* Features Section */
    .features .nav-tabs {
      border-bottom: 2px solid rgba(0, 102, 255, 0.1);
      margin-bottom: 30px;
    }
    
    .features .nav-tabs .nav-link {
      border: none;
      color: #555;
      font-weight: 500;
      transition: all 0.3s;
      padding: 15px;
      text-align: center;
    }
    
    .features .nav-tabs .nav-link.active {
      color: var(--tech-primary);
      background: transparent;
    }
    
    .features .nav-tabs .nav-link i {
      font-size: 1.5rem;
      margin-bottom: 10px;
      display: block;
    }
    
    .features .tab-content h3 {
      color: var(--tech-primary);
      margin-bottom: 20px;
    }
    
    .features .tab-content ul {
      list-style: none;
      padding-left: 0;
    }
    
    .features .tab-content ul li {
      position: relative;
      padding-left: 30px;
      margin-bottom: 15px;
    }
    
    .features .tab-content ul li i {
      color: var(--tech-primary);
      position: absolute;
      left: 0;
      top: 2px;
    }
    
    .features .tab-content img {
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }
    
    .features .tab-content img:hover {
      transform: scale(1.02);
    }
    
    /* Políticas Section */
    .about.section {
      background: var(--tech-light);
    }
    
    .about .content h3 {
      color: var(--tech-primary);
    }
    
    .about .content ul {
      list-style: none;
      padding-left: 0;
    }
    
    .about .content ul li {
      position: relative;
      padding-left: 30px;
      margin-bottom: 10px;
    }
    
    .about .content ul li i {
      color: var(--tech-primary);
      position: absolute;
      left: 0;
      top: 5px;
    }
    
    /* Mapa del Sitio */
    .mapa-sitio {
      background: var(--tech-dark);
      color: white;
      padding: 80px 0;
    }
    
    .mapa-sitio .section-header h2 {
      color: white;
    }
    
    .mapa-sitio .section-header h2:after {
      background: linear-gradient(90deg, var(--tech-secondary), white);
    }
    
    .mapa-sitio .section-header p {
      color: rgba(255, 255, 255, 0.7);
    }
    
    .mapa-links {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      margin-top: 40px;
    }
    
    .mapa-link {
      display: block;
      padding: 20px 15px;
      background: rgba(255, 255, 255, 0.05);
      color: white;
      text-align: center;
      border-radius: 8px;
      transition: all 0.3s;
      border: 1px solid rgba(0, 102, 255, 0.3);
      font-weight: 500;
    }
    
    .mapa-link:hover {
      background: rgba(0, 102, 255, 0.2);
      transform: translateY(-3px);
      text-decoration: none;
      box-shadow: 0 5px 15px rgba(0, 102, 255, 0.2);
    }
    
    /* Footer */
    .footer {
      background: var(--tech-dark);
      color: white;
      padding: 30px 0;
      text-align: center;
    }
    
    .footer .copyright {
      margin-bottom: 10px;
      font-size: 0.9rem;
      color: rgba(255, 255, 255, 0.7);
    }
    
    .footer .credits {
      font-size: 0.8rem;
      color: rgba(255, 255, 255, 0.5);
    }
    
    .footer .credits a {
      color: var(--tech-secondary);
      text-decoration: none;
    }
    
    /* Efectos generales */
    .section-header {
      text-align: center;
      margin-bottom: 50px;
    }
    
    .section-header h2 {
      position: relative;
      display: inline-block;
      color: var(--tech-primary);
      margin-bottom: 15px;
    }
    
    .section-header h2:after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: linear-gradient(90deg, var(--tech-primary), var(--tech-secondary));
    }
    
    .section-header p {
      color: #666;
      max-width: 700px;
      margin: 0 auto;
    }
    
    /* Scroll top */
    #scroll-top {
      background: linear-gradient(90deg, var(--tech-primary), var(--tech-secondary));
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      box-shadow: 0 5px 15px rgba(0, 102, 255, 0.3);
      position: fixed;
      right: 20px;
      bottom: 20px;
      z-index: 999;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s;
    }
    
    #scroll-top.active {
      opacity: 1;
      visibility: visible;
    }
    
    /* Animaciones */
    [data-aos="fade-up"] {
      transform: translateY(30px);
      opacity: 0;
      transition-property: transform, opacity;
    }
    
    [data-aos="fade-up"].aos-animate {
      transform: translateY(0);
      opacity: 1;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .hero h2 {
        font-size: 2.5rem;
      }
      
      .features .nav-tabs .nav-item {
        width: 50%;
        margin-bottom: 10px;
      }
      
      .mapa-links {
        grid-template-columns: 1fr;
      }
      
    
    }
  </style>
</head>




<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <svg class="tech-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
          <path d="M12 8V16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <path d="M8 12H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <h1 class="sitename">SMEDI</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero">Inicio</a></li>
          <li><a href="#about">Acerca de</a></li>
          <li><a href="#features">Información</a></li>
          <li><a href="#politicas">Políticas</a></li>
          <li><a href="#mapaSitio">Mapa</a></li>
          <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <img src="assets copy/img/antena-backgroud.webp" alt="" data-aos="fade-in">
      <div class="container d-flex flex-column align-items-center">
        <h2 data-aos="fade-up" data-aos-delay="100">S M E D I</h2>
        <p data-aos="fade-up" data-aos-delay="200" class="text-center">Monitoreo al instante, para un servicio constante</p>
        <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
          <a href="#about" class="btn-get-started">Acerca de nosotros</a>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <h3>¿Qué es SMEDI y cómo surgió?</h3>
            <p>Este proyecto surge a la necesidad de tener un monitoreo constante de los enlaces inalámbricos que se encuentran esparcidos en las comunidades de Bacalar, ya que al ser zonas alejadas de dicho municipio, el servicio eléctrico que brinda la Comisión Federal de Electricidad es ineficiente, por lo tanto, nuestros enlaces quedan inactivos cuando hay una inestabilidad de la energía eléctrica.</p>
            <p>Cabe resaltar que en estas zonas tienen accesos limitados, tales como salud, seguridad, comunicación, entre otras, por lo tanto, es muy importante estar comunicado con el mundo exterior, ya que así nos facilita brindar información y así poder mitigar esa limitante que tienen estos habitantes.</p>
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
            <div class="content ps-0 ps-lg-5">
              <h5><b>¿Qué es lo que el proyecto le brinda?</b></h5>
              <ul>
                <li>El proyecto brinda un monitoreo constante mediante dispositivos IoT, por lo tanto nos brinda de una herramienta que nos permite saber si en el sitio hay energía eléctrica o no, así podemos evaluar la situación y hacer un plan de acción para que las comunidades no se vean afectadas por dicho inconveniente, por lo tanto, la población no se quedaría incomunicada, ya que estos habitantes están en zonas vulnerables y con accesos limitados.</li>
              </ul>
              <p>De esta manera, nosotros nos encargamos de reducir en gran medida esta problemática que afecta a las comunidades cercanas de Bacalar. Provicionando un monitoreo que acabará con el sentimiento de olvido que sientes varias comunidades afectadas.</p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /About Section -->

    <!-- Clients Section (espacio) -->
    <section id="clients" class="clients section light-background">
      <div class="container" data-aos="fade-up">
        <div class="row gy-4">
          <br><br><br><br>
        </div>
      </div>
    </section><!-- /Clients Section -->

    <!-- Features Section -->
    <section id="features" class="features section">
      <div class="container">
        <ul class="nav nav-tabs row d-flex" data-aos="fade-up" data-aos-delay="100">
          <li class="nav-item col-3">
                <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1" style="cursor: pointer;">
              <i class="bi bi-binoculars"></i>
              <h4 class="d-none d-lg-block">MISIÓN</h4>
            </a>
          </li>
          <li class="nav-item col-3">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2" style="cursor: pointer;">
              <i class="bi bi-eye"></i>
              <h4 class="d-none d-lg-block">VISIÓN</h4>
            </a>
          </li>
          <li class="nav-item col-3">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3" style="cursor: pointer;">
              <i class="bi bi-brightness-high"></i>
              <h4 class="d-none d-lg-block">VALORES</h4>
            </a>
          </li>
          <li class="nav-item col-3">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-4" style="cursor: pointer;">
              <i class="bi bi-command"></i>
              <h4 class="d-none d-lg-block">¿Por qué elegirnos?</h4>
            </a>
          </li>
        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
          <div class="tab-pane fade active show" id="features-tab-1">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Nuestra misión es:</h3>
                <p>Nuestra misión es poder brindar un servicio de internet de calidad a las comunidades de Bacalar, mediante un monitoreo de energía eléctrica por dispositivos IoT, facilitando una solución y un plan de acción para mitigar los cortes de internet y brindar un servicio de calidad.</p>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets copy/img/mision.webp" alt="" class="img-fluid">
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="features-tab-2">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Nuestra visión es:</h3>
                <p>Ser una solución en el monitoreo de enlaces inalámbricos mediante dispositivos IoT, garantizando una supervisión en tiempo real del estado de la energía eléctrica. Así como ofrecer soluciones innovadoras, seguras y eficientes que optimicen la toma de decisiones y que mejoren la calidad del servicio.</p>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets copy/img/vision.webp" alt="" class="img-fluid">
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="features-tab-3">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Los valores de nuestra empresa son:</h3>
                <ul>
                  <li><i class="bi bi-check2-all"></i> <span><b>Fiabilidad:</b> Garantizamos un monitoreo preciso y en tiempo real del estado de la conexión eléctrica, asegurando información confiable para la toma de decisiones.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span><b>Innovación:</b> Implementamos tecnología IoT para optimizar la supervisión de redes eléctricas, mejorando la eficiencia en la detección de fallos.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span><b>Eficiencia:</b> Automatizamos la recopilación y análisis de datos para reducir tiempos de respuesta ante interrupciones eléctricas, optimizando los recursos.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span><b>Seguridad:</b> Aseguramos la integridad de los datos transmitidos y procesados mediante protocolos de comunicación robustos y encriptados.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span><b>Accesibilidad:</b> Diseñamos una interfaz intuitiva y accesible que facilita la visualización de alertas y el control del sistema desde cualquier ubicación.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span><b>Sostenibilidad:</b> Promovemos el uso eficiente de la energía y la reducción de tiempos de inactividad en infraestructuras críticas.</span></li>
                </ul>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets copy/img/valores.webp" alt="" class="img-fluid">
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="features-tab-4">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>¿Por qué debería de elegirnos?</h3>
                <ul>
                  <li><i class="bi bi-check2-all"></i> <span>En nuestra empresa, nos comprometemos a brindar un servicio de internet confiable y de calidad a las comunidades de Bacalar, respaldado por un monitoreo en tiempo real de la energía eléctrica mediante dispositivos IoT.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Nos distinguimos por nuestra fiabilidad, al garantizar información precisa para la toma de decisiones; nuestra innovación, al implementar tecnología de vanguardia para optimizar redes eléctricas; y nuestra eficiencia, al reducir tiempos de respuesta ante interrupciones.</span></li>
                  <li><i class="bi bi-check2-all"></i> <span>Elige nuestra empresa y asegura un servicio de internet estable, confiable y diseñado para mejorar la calidad de vida en tu comunidad.</span></li>
                </ul>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="assets copy/img/sonriendo.webp" alt="" class="img-fluid">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Features Section -->

    <!-- Políticas de Seguridad -->
    <section id="politicas" class="about section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="content ps-0">
              <h3>¿Políticas de seguridad?</h3>
              <p>En Sistema de Monitoreo de Enlaces con Dispositivos IoT (SMEDI), nos comprometemos a garantizar la seguridad de la información, la protección de los datos recopilados y la integridad de nuestros sistemas.</p>
              <p>Estas políticas de seguridad han sido diseñadas para proteger la infraestructura del sistema, la información de los usuarios y asegurar un monitoreo eficiente de las condiciones eléctricas y de conectividad en las comunidades de Bacalar.</p>
              <br>
              <p><b>1. Seguridad de la Información</b></p>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> <span>Toda la información recopilada por los dispositivos IoT es almacenada y protegida mediante protocolos de seguridad modernos.</span></li>
                <li><i class="bi bi-check-circle-fill"></i> <span>Se implementan medidas de cifrado para garantizar la confidencialidad y la integridad de los datos transmitidos.</span></li>
              </ul>
              <br>
              <p><b>2. Protección de Datos</b></p>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> <span>Los datos recopilados serán utilizados exclusivamente para el monitoreo y mejora del suministro eléctrico y la conectividad de red en las comunidades de Bacalar.</span></li>
                <li><i class="bi bi-check-circle-fill"></i> <span>No se compartirá información personal con terceros sin el consentimiento expreso del usuario, salvo en casos exigidos por la ley.</span></li>
              </ul>
            </div>
          </div>
          
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
            <div class="content ps-0 ps-lg-5">
              <p><b>3. Seguridad en la Infraestructura</b></p>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> <span>Los servidores y bases de datos donde se almacena la información cuentan con sistemas de protección contra accesos no autorizados y ataques cibernéticos.</span></li>
                <li><i class="bi bi-check-circle-fill"></i> <span>Se implementan copias de seguridad regulares para garantizar la disponibilidad de la información en caso de fallos.</span></li>
              </ul>
              <br>
              <p><b>4. Control de Acceso</b></p>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> <span>Cada usuario autorizado cuenta con credenciales únicas y debe cumplir con políticas de contraseñas seguras.</span></li>
                <li><i class="bi bi-check-circle-fill"></i> <span>Se utilizan autenticaciones seguras para el acceso a los sistemas de monitoreo y gestión.</span></li>
              </ul>
              <br>
              <p><b>5. Cumplimiento Legal</b></p>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> <span>SMEDI cumple con las normativas nacionales e internacionales en materia de protección de datos y seguridad de la información.</span></li>
                <li><i class="bi bi-check-circle-fill"></i> <span>Se realizan revisiones periódicas de las políticas de seguridad para asegurar su cumplimiento y actualización conforme a las mejores prácticas.</span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Políticas de seguridad-->

    <!-- Mapa del Sitio -->
    <section id="mapaSitio" class="mapa-sitio section">
      <div class="container">
        <div class="section-header">
          <h2>Mapa del Sitio</h2>
          <p>Encuentra fácilmente toda la información</p>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="mapa-links">
              <a href="#hero" class="mapa-link">Inicio</a>
              <a href="#about" class="mapa-link">Acerca de</a>
              <a href="#features" class="mapa-link">Información</a>
              <a href="#politicas" class="mapa-link">Políticas</a>
              <a href="{{ route('login') }}" class="mapa-link">Iniciar Sesión</a>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>SMEDI</span></strong>. Todos los derechos reservados
      </div>
      <div class="credits">
        Desarrollado por <a href="#">UT Chetumal</a>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets copy/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets copy/vendor/aos/aos.js"></script>
  <script src="assets copy/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets copy/js/main.js"></script>

  <script>
    // Header scroll effect
    window.addEventListener('scroll', function() {
      const header = document.querySelector('.header');
      if (window.scrollY > 100) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
    
    // Scroll to top button
    window.addEventListener('scroll', function() {
      const scrollTop = document.getElementById('scroll-top');
      if (window.scrollY > 300) {
        scrollTop.classList.add('active');
      } else {
        scrollTop.classList.remove('active');
      }
    });
  </script>

</body>
</html>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.navmenu a');

    function setActiveLinkOnScroll() {
      let scrollPosition = window.scrollY + 200; 
      navLinks.forEach(link => {
        let section = document.querySelector(link.getAttribute('href'));
        if (section) {
          if (
            scrollPosition >= section.offsetTop &&
            scrollPosition < section.offsetTop + section.offsetHeight
          ) {
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
          }
        }
      });
    }

    // Llamar la función al cargar y al hacer scroll
    window.addEventListener('scroll', setActiveLinkOnScroll);
    setActiveLinkOnScroll();

    // Enlace activo al hacer clic 
    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
    });
  });
</script>
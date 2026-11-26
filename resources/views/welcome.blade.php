<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RAEE - Sistema de Reciclaje Electrónico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --cerulean: #056C8E;
            --cerulean-dark: #04556f;
            --cerulean-light: #078ab5;
            --frozen: #D7FDFD;
            --frozen-dark: #b3f5f5;
            --fern: #659F17;
            --fern-dark: #4f7d12;
            --fern-light: #7fbf1e;
            --spruce: #116D64;
            --spruce-dark: #0d544d;
            --spruce-light: #15867b;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
        }
        
        .font-logo {
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.02em;
        }
        
   
        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
        }
        
        .navbar-brand-custom {
            color: var(--cerulean);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .navbar-logo {
            display: block;
            width: 160px;
            height: 60px;
            object-fit: cover;
            object-position: center;
        }

        .footer-logo {
            display: block;
            width: 180px;
            height: 64px;
            padding: 4px 8px;
            border-radius: 0.5rem;
            background-color: #ffffff;
            object-fit: cover;
            object-position: center;
        }

        @media (max-width: 575.98px) {
            .navbar-logo {
                width: 128px;
                height: 48px;
            }

            .footer-logo {
                width: 160px;
                height: 58px;
            }
        }
        
        .nav-link-custom {
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-link-custom:hover {
            color: var(--cerulean);
            background-color: var(--frozen);
        }
        
        .btn-admin {
            background-color: var(--cerulean);
            color: white;
            font-weight: 700;
            padding: 0.5rem 1.25rem;
            border-radius: 0.5rem;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-admin:hover {
            background-color: var(--cerulean-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 108, 142, 0.3);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--frozen) 0%, #ffffff 50%, var(--frozen-dark) 100%);
            position: relative;
            overflow: hidden;
            padding: 6rem 0;
        }
        
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: blob 7s infinite;
        }
        
        .blob-1 {
            width: 400px;
            height: 400px;
            background-color: var(--cerulean);
            top: -100px;
            left: -100px;
        }
        
        .blob-2 {
            width: 400px;
            height: 400px;
            background-color: var(--fern);
            top: -100px;
            right: -100px;
            animation-delay: 2s;
        }
        
        .blob-3 {
            width: 400px;
            height: 400px;
            background-color: var(--spruce);
            bottom: -100px;
            left: 50%;
            animation-delay: 4s;
        }
        
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
        }
        
        /* NUEVO: Imagen del Hero */
        .hero-image-wrapper {
            position: relative;
            z-index: 10;
            margin-top: 3rem;
        }
        
        .hero-image-container {
            position: relative;
            border-radius: 2rem;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(5, 108, 142, 0.25);
            border: 8px solid white;
        }
        
        .hero-image-container img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }
        
        .hero-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(5, 108, 142, 0.15), rgba(17, 109, 100, 0.15));
            pointer-events: none;
        }
        
        .hero-floating-badge {
            position: absolute;
            background: white;
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 20;
        }
        
        .hero-floating-badge.top-right {
            top: -20px;
            right: -20px;
        }
        
        .hero-floating-badge.bottom-left {
            bottom: -20px;
            left: -20px;
        }
        
        .hero-floating-badge .badge-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        
        .hero-floating-badge .badge-text {
            font-weight: 700;
            font-size: 0.9rem;
            color: #0f172a;
        }
        
        .hero-floating-badge .badge-subtext {
            font-size: 0.75rem;
            color: #64748b;
        }
        
        @media (max-width: 991.98px) {
            .hero-image-wrapper {
                margin-top: 3rem;
            }
            .hero-image-container img {
                height: 300px;
            }
        }
        
        .badge-status {
            background-color: white;
            color: var(--cerulean);
            border: 1px solid rgba(5, 108, 142, 0.2);
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .badge-status .pulse {
            width: 8px;
            height: 8px;
            background-color: var(--fern);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-title .gradient-text {
            background: linear-gradient(135deg, var(--cerulean), var(--spruce));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }
        
        .btn-primary-custom {
            background-color: var(--cerulean);
            color: white;
            font-weight: 700;
            padding: 0.875rem 2rem;
            border-radius: 0.75rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary-custom:hover {
            background-color: var(--cerulean-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 108, 142, 0.3);
        }
        
        .btn-outline-custom {
            background-color: transparent;
            color: var(--cerulean);
            font-weight: 700;
            padding: 0.875rem 2rem;
            border-radius: 0.75rem;
            border: 2px solid var(--cerulean);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-outline-custom:hover {
            background-color: var(--cerulean);
            color: white;
            transform: translateY(-2px);
        }
        

        .section-padding {
            padding: 5rem 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto 3rem;
        }
        
        .divider {
            width: 80px;
            height: 6px;
            background-color: var(--cerulean);
            border-radius: 3px;
            margin: 0 auto 2rem;
        }
        
        .process-card {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .process-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        
        .process-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 0.75rem;
            margin-bottom: 1.25rem;
            border: 3px solid var(--frozen);
        }
        
        .process-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .process-card:hover .process-icon {
            transform: scale(1.1);
        }
        
        .icon-cerulean {
            background-color: var(--frozen);
            color: var(--cerulean);
            border: 1px solid rgba(5, 108, 142, 0.2);
        }
        
        .icon-fern {
            background-color: rgba(101, 159, 23, 0.1);
            color: var(--fern);
            border: 1px solid rgba(101, 159, 23, 0.2);
        }
        
        .icon-spruce {
            background-color: rgba(17, 109, 100, 0.1);
            color: var(--spruce);
            border: 1px solid rgba(17, 109, 100, 0.2);
        }
        
        .process-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }
        
        .process-description {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
        }

        .feature-image-section {
            background: linear-gradient(135deg, var(--spruce) 0%, var(--cerulean) 100%);
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .feature-image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1600&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
        }
        
        .feature-content {
            position: relative;
            z-index: 2;
            color: white;
        }
        
        .feature-stat {
            text-align: center;
            padding: 1.5rem;
        }
        
        .feature-stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .feature-stat-label {
            font-size: 1rem;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
        }

        .mission-vision-section {
            background-color: rgba(215, 253, 253, 0.3);
        }
        
        .mv-card {
            background-color: white;
            border-radius: 1.5rem;
            padding: 2.5rem;
            height: 100%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .mv-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        
        .mv-card-cerulean {
            border-left: 8px solid var(--cerulean);
        }
        
        .mv-card-fern {
            border-left: 8px solid var(--fern);
        }
        

        .mv-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .mv-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }
        
        .mv-icon-cerulean {
            background-color: var(--frozen);
            color: var(--cerulean);
            border: 1px solid rgba(5, 108, 142, 0.2);
        }
        
        .mv-icon-fern {
            background-color: rgba(101, 159, 23, 0.1);
            color: var(--fern);
            border: 1px solid rgba(101, 159, 23, 0.2);
        }
        
        .mv-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1rem;
        }
        
        .mv-description {
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.7;
        }
   
        .location-section {
            background-color: white;
        }
        
        .location-badge {
            color: var(--cerulean);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }
        
        .location-info-card {
            background-color: rgba(215, 253, 253, 0.3);
            border: 1px solid rgba(5, 108, 142, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .location-info-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .location-icon {
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .location-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        
        .location-text {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }
        
        .location-text.mono {
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }
        
        .map-container {
            background-color: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            height: 100%;
            min-height: 500px;
            position: relative;
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            min-height: 500px;
            border: 0;
        }
        
  
        .location-hero-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        
      
        .tech-section {
            background-color: rgba(215, 253, 253, 0.3);
            border-top: 1px solid rgba(5, 108, 142, 0.1);
        }
        
        .tech-badge {
            background-color: white;
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            margin: 0.5rem;
        }
        
        .tech-badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .tech-badge.cerulean {
            border: 1px solid rgba(5, 108, 142, 0.2);
        }
        
        .tech-badge.cerulean .tech-name {
            color: var(--cerulean);
        }
        
        .tech-badge.fern {
            border: 1px solid rgba(101, 159, 23, 0.2);
        }
        
        .tech-badge.fern .tech-name {
            color: var(--fern);
        }
        
        .tech-badge.spruce {
            border: 1px solid rgba(17, 109, 100, 0.2);
        }
        
        .tech-badge.spruce .tech-name {
            color: var(--spruce);
        }
        
        .tech-name {
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .tech-version {
            color: #94a3b8;
            font-size: 0.9rem;
        }
        
  
        .tech-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 3rem;
        }
        
        .tech-gallery-item {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            aspect-ratio: 1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .tech-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .tech-gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .tech-gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(5, 108, 142, 0.85), transparent);
            display: flex;
            align-items: flex-end;
            padding: 1rem;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }
        
        @media (max-width: 767.98px) {
            .tech-gallery {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .footer {
            background-color: var(--spruce-dark);
            color: #cbd5e1;
            padding: 4rem 0 2rem;
        }
        
        .footer-brand {
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .footer-title {
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1.5rem;
        }
        
        .footer-link {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .footer-link:hover {
            color: var(--frozen);
        }
        
        .footer-link .dot {
            width: 6px;
            height: 6px;
            background-color: var(--fern);
            border-radius: 50%;
        }
        
        .footer-text {
            color: #94a3b8;
            font-size: 0.9rem;
            line-height: 1.7;
        }
        
        .footer-badge {
            background-color: var(--spruce);
            border: 1px solid rgba(21, 134, 123, 0.3);
            color: var(--frozen);
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.8rem;
            display: inline-block;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .footer-divider {
            border-top: 1px solid rgba(21, 134, 123, 0.3);
            margin-top: 2rem;
            padding-top: 2rem;
        }
        
        .footer-bottom {
            color: #64748b;
            font-size: 0.85rem;
        }
        
      
        .footer-image-banner {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
       
        .btn-scroll-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background-color: var(--cerulean);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(5, 108, 142, 0.3);
        }
        
        .btn-scroll-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .btn-scroll-top:hover {
            background-color: var(--cerulean-dark);
            transform: scale(1.1);
        }
        
            .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .hero-section {
                padding: 4rem 0;
            }
            
            .feature-stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom d-flex align-items-center" href="#inicio">
                <img class="navbar-logo" src="{{ asset('images/raee-logo.png') }}" alt="RAEE Sistema de Gestión">
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#procesos">Procesos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#ubicacion">Ubicación</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section id="inicio" class="hero-section">
        <div class="hero-blob blob-1"></div>
        <div class="hero-blob blob-2"></div>
        <div class="hero-blob blob-3"></div>
        
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <div class="badge-status">
                        <span class="pulse"></span>
                        Sistema en Desarrollo Activo
                    </div>
                    
                    <h1 class="hero-title">
                        Gestión Inteligente de<br>
                        <span class="gradient-text">Residuos Electrónicos</span>
                    </h1>
                    
                    <p class="hero-subtitle">
                        Plataforma integral para el registro, recuperación y trazabilidad de materiales electrónicos, 
                        impulsando la economía circular y la sostenibilidad ambiental con tecnología de vanguardia.
                    </p>
                    
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        <a href="#procesos" class="btn btn-primary-custom">
                            <i class="bi bi-lightning-charge"></i>
                            Conocer el Sistema
                        </a>
                    </div>
                </div>
            
                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <div class="hero-image-container">
                            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80" 
                                 alt="Reciclaje de equipos electrónicos">
                            <div class="hero-image-overlay"></div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="procesos" class="section-padding reveal">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Ciclo de Gestión RAEE</h2>
                <div class="divider"></div>
                <p class="section-subtitle">
                    Un flujo de trabajo digitalizado que garantiza el tratamiento responsable y la trazabilidad de cada dispositivo desde su ingreso.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="process-card">
       
                        <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=600&q=80" 
                             alt="Recepción de equipos" class="process-image">
                        <div class="process-icon icon-cerulean">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h4 class="process-title">1. Recepción</h4>
                        <p class="process-description">
                            Registro detallado del entregante y clasificación inicial del material electrónico recibido en el sistema.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="process-card">
    
                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&q=80" 
                             alt="Clasificación de materiales" class="process-image">
                        <div class="process-icon icon-fern">
                            <i class="bi bi-funnel"></i>
                        </div>
                        <h4 class="process-title">2. Clasificación</h4>
                        <p class="process-description">
                            Categorización del material por tipo, marca y modelo para determinar su potencial de recuperación.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="process-card">
                  
                        <img src="https://content.gnoss.ws/crfp/imagenes/Documentos/imgsem/ad/ad1d/ad1d398c-0a5e-4b6e-9ae6-906e526b37e9/84d15cee-cc36-4cab-9d58-8c8557aa4731.jpg" 
                             alt="Recuperación de componentes" class="process-image">
                        <div class="process-icon icon-spruce">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <h4 class="process-title">3. Recuperación</h4>
                        <p class="process-description">
                            Desensamblaje técnico controlado para extraer componentes reutilizables y valorizar el material.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="process-card">
                  
                        <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?w=600&q=80" 
                             alt="Control de inventario" class="process-image">
                        <div class="process-icon icon-cerulean">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <h4 class="process-title">4. Inventario</h4>
                        <p class="process-description">
                            Control de stock de componentes recuperados, con alertas de cantidad mínima y asignación de tareas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="nosotros" class="mission-vision-section section-padding reveal">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Nuestro Propósito</h2>
                <div class="divider"></div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mv-card mv-card-cerulean">
                   
                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800&q=80" 
                             alt="Nuestra Misión" class="mv-image">
                        <div class="mv-icon mv-icon-cerulean">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h3 class="mv-title">Misión</h3>
                        <p class="mv-description">
                            Gestionar de manera eficiente y responsable el ciclo de vida de los residuos de aparatos eléctricos y electrónicos (RAEE), facilitando su recepción, recuperación y reintegración al ciclo productivo, promoviendo activamente la economía circular y la sostenibilidad ambiental.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mv-card mv-card-fern">
                    
                        <img src="https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800&q=80" 
                             alt="Nuestra Visión" class="mv-image">
                        <div class="mv-icon mv-icon-fern">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <h3 class="mv-title">Visión</h3>
                        <p class="mv-description">
                            Ser el sistema de referencia tecnológica en la gestión de residuos electrónicos, reconocidos por nuestra transparencia, eficiencia operativa y compromiso inquebrantable con la reducción del impacto ambiental a través de la innovación y el reciclaje responsable.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="ubicacion" class="location-section section-padding reveal">
        <div class="container">
            <div class="text-center mb-5">
                <div class="location-badge">Encuéntranos</div>
                <h2 class="section-title">Nuestra Ubicación</h2>
                <div class="divider"></div>
                <p class="section-subtitle">
                    Visítanos en nuestras instalaciones para conocer más sobre nuestro trabajo en la gestión responsable de residuos electrónicos.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-4 h-100">
                  
                        <div class="location-info-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="location-icon" style="background-color: rgba(5, 108, 142, 0.1); color: var(--cerulean);">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <h4 class="location-title">Dirección</h4>
                                    <p class="location-text">
                                        Av. Juana Azurduy #1234<br>
                                        Zona San Matias<br>
                                        Sucre, Bolivia
                                    </p>
                                </div>
                            </div>
                        </div>

                  
                        <div class="location-info-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="location-icon" style="background-color: rgba(101, 159, 23, 0.1); color: var(--fern);">
                                    <i class="bi bi-globe-americas"></i>
                                </div>
                                <div>
                                    <h4 class="location-title">Coordenadas GPS</h4>
                                    <p class="location-text mono">
                                        Lat: -19.0337°<br>
                                        Lon: -65.2623°
                                    </p>
                                </div>
                            </div>
                        </div>

            
                        <div class="location-info-card">
                            <div class="d-flex align-items-start gap-3">
                                <div class="location-icon" style="background-color: rgba(17, 109, 100, 0.1); color: var(--spruce);">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div>
                                    <h4 class="location-title">Horario de Atención</h4>
                                    <p class="location-text">
                                        Lunes a Viernes<br>
                                        <strong style="color: var(--spruce);">8:00 - 18:00</strong><br>
                                        Sábados: 9:00 - 13:00
                                    </p>
                                </div>
                            </div>
                        </div>

                        <a href="https://www.google.com/maps?q=-19.033683706835692,-65.26231166844259" target="_blank" 
                           class="btn btn-primary-custom w-100 justify-content-center">
                            <i class="bi bi-map"></i>
                            Abrir en Google Maps
                        </a>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.5!2d-65.26231166844259!3d-19.033683706835692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDAyJzAxLjMiUyA2NcKwMTUnNDQuMyJX!5e0!3m2!1ses!2sbo!4v1700000000000!5m2!1ses!2sbo" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section class="tech-section section-padding reveal">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Cada etapa, bajo control</h2>
                <p class="section-subtitle">
                    Sigue el recorrido de los materiales desde su recepción hasta la recuperación de componentes y el control de inventario.
                </p>
            </div>
            
            <div class="text-center">
                <div class="tech-badge cerulean">
                    <span class="tech-name">Recepciones</span>
                    <span class="tech-version">Ingresos</span>
                </div>
                <div class="tech-badge fern"> 
                    <span class="tech-name">Materiales</span>
                    <span class="tech-version">Clasificación</span>
                </div>
                <div class="tech-badge spruce">
                    <span class="tech-name">Recuperación</span>
                    <span class="tech-version">Componentes</span>
                </div>
                <div class="tech-badge cerulean">
                    <span class="tech-name">Inventario</span>
                    <span class="tech-version">Existencias</span>
                </div>
                <div class="tech-badge fern">
                    <span class="tech-name">Asignaciones</span>
                    <span class="tech-version">Tareas</span>
                </div>
            </div>

        </div>
    </section>

   
    <footer class="footer">
        <div class="container">

            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1600&q=80" 
                 alt="Medio ambiente y tecnología" class="footer-image-banner">
            
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <img class="footer-logo" src="{{ asset('images/raee-logo.png') }}" alt="RAEE Sistema de Gestión">
                    </div>
                    <p class="footer-text">
                        Sistema integral para la gestión, trazabilidad y reciclaje responsable de residuos de aparatos eléctricos y electrónicos.
                    </p>
                </div>
                
                <div class="col-lg-4">
                    <h4 class="footer-title">Navegación</h4>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#inicio" class="footer-link">
                                <span class="dot"></span>
                                Inicio
                            </a>
                        </li>
                        <li>
                            <a href="#procesos" class="footer-link">
                                <span class="dot"></span>
                                Procesos
                            </a>
                        </li>
                        <li>
                            <a href="#nosotros" class="footer-link">
                                <span class="dot"></span>
                                Nosotros
                            </a>
                        </li>
                        <li>
                            <a href="#ubicacion" class="footer-link">
                                <span class="dot"></span>
                                Ubicación
                            </a>
                        </li>
                        <li class="pt-3 mt-3" style="border-top: 1px solid rgba(21, 134, 123, 0.3);">
                        
                        </li>
                    </ul>
                </div>
                
                <div class="col-lg-4">
                    <h4 class="footer-title">Información del Proyecto</h4>
                    <p class="footer-text mb-3">
                        Proyecto Socioformativo de la materia de programación IV.
                    </p>
                    <div>
                    </div>
                </div>
            </div>
            
            <div class="footer-divider">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="footer-bottom mb-0">
                            &copy; {{ date('Y') }} Sistema de Reciclaje de Material Electrónico (RAEE). Todos los derechos reservados.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="footer-bottom mb-0">
                            Desarrollado en Noviembre 2026
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <button class="btn-scroll-top" id="scrollTopBtn" aria-label="Volver arriba">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("active");
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

            document.querySelectorAll(".reveal").forEach((el) => observer.observe(el));
      
            const scrollBtn = document.getElementById('scrollTopBtn');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    scrollBtn.classList.add('visible');
                } else {
                    scrollBtn.classList.remove('visible');
                }
            });
            
            scrollBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
  
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', () => {
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        navbarCollapse.classList.remove('show');
                    }
                });
            });
        });
    </script>
</body>
</html>
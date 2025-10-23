@extends('layouts.client')

@section('title', 'Inicio')

@section('content')
    <x-navbar-client />

    <!-- Nosotros -->
    <section class="about-section">
        <div class="container">
            <h2 class="mb-5">Sobre nosotros</h2>
            <div class="row">
                <div class="col-md-6">
                    <p>
                        Desde 1990, nuestra empresa se ha dedicado a ofrecer soluciones de alta calidad en aluminio y
                        vidrio, convirtiéndose en un referente de confianza y excelencia en el sector. Con más de tres
                        décadas de experiencia, hemos trabajado con pasión para transformar espacios residenciales,
                        comerciales e industriales, adaptándonos a las necesidades y tendencias de cada cliente.
                        <BR></BR>
                        Nos enorgullece combinar materiales de primera, tecnología innovadora y un equipo altamente
                        capacitado para garantizar proyectos duraderos, funcionales y estéticamente impecables. Nuestra
                        misión es crear espacios que reflejen estilo, seguridad y modernidad, siempre comprometidos con
                        la satisfacción de quienes confían en nosotros.
                        <BR></BR>
                        En cada proyecto, reafirmamos nuestro compromiso con la calidad, el diseño y el servicio
                        personalizado, valores que nos han acompañado desde nuestros inicios y que hoy nos permiten
                        seguir construyendo el futuro con transparencia y fortaleza.
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/nosotros.jpg') }}" alt="Sobre Nosotros" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>

        <div class="info-container">
            <div class="info-box hover-zoom">
                <div class="subheading_0">
                    <i class="bi bi-bullseye"></i> Misión
                </div>
                <p>
                    Proveer soluciones de alta calidad en aluminio y vidrio, enfocándonos en la satisfacción
                    del cliente mediante productos innovadores y duraderos.
                </p>
            </div>
            <div class="info-box hover-zoom">
                <div class="subheading_0">
                    <i class="bi bi-eye"></i> Visión
                </div>
                <p>
                    Ser una empresa líder en el mercado, destacándonos por nuestra excelencia en diseño,
                    calidad y compromiso con la innovación en aluminio y vidrio.
                </p>
            </div>
        </div>
    </section>

    <!-- Sectores -->
    <section class="sectors-section">
        <div class="container">
            <h2>Nuestros productos</h2>
            <div class="row g-4">
                <div class="col-12">
                    <div class="sector-card">
                        <img src="{{ asset('images/aluminio.jpg') }}" alt="Aluminios" class="sector-img">
                        <div class="overlay">
                            <h3 class="sector-text">Aluminios</h3>
                            <a href="{{ route('catalogo_aluminios') }}" class="btn btn-primary">Explorar</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="sector-card">
                        <img src="{{ asset('images/vidrios.jpg') }}" alt="Vidrios" class="sector-img">
                        <div class="overlay">
                            <h3 class="sector-text">Vidrios</h3>
                            <a href="{{ route('catalogo_vidrios') }}" class="btn btn-primary">Explorar</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="sector-card">
                        <img src="{{ asset('images/herrajes.jpg') }}" alt="Herrajes" class="sector-img">
                        <div class="overlay">
                            <h3 class="sector-text">Herrajes</h3>
                            <a href="{{ route('catalogo_herrajes') }}" class="btn btn-primary">Explorar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-footer-client />
@endsection

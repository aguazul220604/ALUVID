<section class="about-section">
    <div class="info-container">

        <div class="{{ Route::is('catalogo_aluminios') ? 'info-box-selected' : 'info-box' }} hover-zoom">
            <a href="{{ route('catalogo_aluminios') }}">
                <div class="text-center">
                    <h1>ALUMINIOS</h1>
                </div>
            </a>
        </div>

        <div class="{{ Route::is('catalogo_vidrios') ? 'info-box-selected' : 'info-box' }} hover-zoom">
            <a href="{{ route('catalogo_vidrios') }}">
                <div class="text-center">
                    <h1>VIDRIOS</h1>
                </div>
            </a>
        </div>

        <div class="{{ Route::is('catalogo_herrajes') ? 'info-box-selected' : 'info-box' }} hover-zoom">
            <a href="{{ route('catalogo_herrajes') }}">
                <div class="text-center">
                    <h1>HERRAJES</h1>
                </div>
            </a>
        </div>

    </div>
</section>

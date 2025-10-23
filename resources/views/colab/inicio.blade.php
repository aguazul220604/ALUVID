<!DOCTYPE html>
<html lang="en">

<x-header-colab />

<body>

    <x-preloader />

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <x-topbar-colab :user="$user" />

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    <x-navbar-colab />

                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Panel de consulta</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header">
                            <div class="container overlay">
                                <h1>ALUVID IXMIQUILPAN</h1>
                                <p>Calidad y diseño en cada detalle</p>
                                <h2>COLABORADOR</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

</body>

</html>

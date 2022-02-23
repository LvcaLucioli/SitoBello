<div class="foo-ter" style="bottom:0;">
    <footer>
        <div class="row row-foot">
            <div class="col-4 foot-container foot-title-container">
                <span class="foot-title">
                    <h4 class="left-text right">Contattaci</h4>
                    <div class="left-gap">
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <h4 class="sub-title-foo"><b>Telefono:</b></h4>
                            </div>
                            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                <h5 class="contact">+39 335 326 268</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <h4 class="sub-title-foo"><b>E-mail:</b></h4>
                            </div>
                            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                <h5 class="contact">macerata@acsi.it</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <h4 class="sub-title-foo"><b>Free Fax:</b></h4>
                            </div>
                            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                <h5 class="contact">06.233.208.539</h5>
                            </div>
                        </div>
                    </div>
            </div>

            <?php
            if (isset($_SESSION['user'])) {
                echo "<div class='col-4 header-container header-title-container' >
                            <span class='header-title'>
                                <h4 style='font-size: medium; margin-top: 7%;'>Accesso effettuato come Amministratore</h4>
                                <span>
                                <a href='LogOut.php'><h5 style='color: #f28383;'>Logout</h5></a>
                                </span>
                            </span>
                          </div>";
            } else {
                echo "<div class='col-4 header-container'>
                            <a href='Login.php'>
                                <img class='logoACSI-foo' src='img\logoACSI.jpg' alt='Logo ACSI'>
                            </a>
                          </div>";
            }
            ?>

            <div class="col-4 foot-container foot-title-container">
                <span class="foot-title">
                    <h4 class="left-text right-gap">Informazioni</h4>
                    <div class="left-gap-2">
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <h4 class="sub-title-foo"><b>Indirizzo:</b></h4>
                            </div>
                            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                <h5 class="contact">Viale dei Pini, N°9<br> Porto Recanati (MC), 62017</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <h4 class="sub-title-foo"><b>Codice fiscale:</b></h4>
                            </div>
                            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                <h5 class="contact">93072220432</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                <h4 class="sub-title-foo"><b>P.iva:</b></h4>
                            </div>
                            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                                <h5 class="contact">01909360438</h5>
                            </div>
                        </div>
                </span>
            </div>
        </div>

        <div class="col-12 foot-container foot-title-container">
            <span class="foot-title">
            <a href="https://it-it.facebook.com/pages/category/Organization/Acsi-Macerata-1585091961757230/" class="fa fa-facebook" target="_blank"></a>
            <a href="https://twitter.com/acsimacerata" class="fa fa-twitter" style="margin-right: 2%; margin-left: 2%;" target="_blank"></a>
            <a href="https://instagram.com/acsi_macerata?utm_medium=copy_link" class="fa fa-instagram" target="_blank"></a>
            </span>
        </div>
</div>
<br>
</footer>
</div>
<br>
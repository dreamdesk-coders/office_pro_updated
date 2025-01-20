<?php

include("forms/common/side_menu.php");
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    echo "<script> location.replace('$common_form_route?frm=login'); </script>";
} else { ?>
    <style type="text/css">
        .set {
            animation: rotation 4s infinite linear;
            display: inline-block;
            width: 30px;
            margin-left: 10px;
        }

        .main-content h5 {
            font-weight: normal !important;
        }

        .frm_ {
            text-align: center;
            /* border-radius: 20px; */
            margin: 10px auto;
            /* padding: 20px 0px; */
            /* border: 0.5px solid #efebeb; */
            transition: 0.5s;
        }

        /* 
        .frm_:hover {
            border: 0.5px solid #bdbdbd;
            background-image: linear-gradient(to bottom, #f5f5f7, #e7e7e8, #d9d9da, #cbcbcb, #bdbdbd);
            transition: 0.5s;
        } */

        .a {
            color: #000;
            text-decoration: none;
        }

        .a:hover {
            color: #000;
            text-decoration: none;
        }

        .frm_ img {
            margin: 20px auto;
            width: 55px;
            position: relative;
        }

        .setting-tem {
            background-color: #fff;
        }

        .setting-tem:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .setting-tem img {
            width: 30px;
            margin: 0px 10px;
        }

        hr {
            padding: 0px !important;
            margin: 0px !important;
        }

        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(359deg);
            }
        }
    </style>
    <div class="main-content bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-wrapper">
                        <!-- <h2>Settings<img src="assets/images/icons/cog.svg" class="set"></h2>
                     -->
                        <h2>Settings</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-5 col-sm-12">
                    <div class="form-group mt-3 mb-4">
                        <input type="text" id="search" name="search" placeholder="Type to search setting" class="form-control">
                    </div>

                    <a href="<?php echo $common_form_route ?>handler/common/backup.php" class="a">
                        <div class="setting-tem">
                            <hr>
                            <p class="pl-2 pt-3"><img src="assets/images/settings/backup.svg">Backup Database</p>
                            <hr>
                        </div>
                    </a>
                    <a href="<?php echo $common_form_route ?>?frm=logout" class="a">
                        <div class="setting-tem">
                            <hr>
                            <p class="pl-2 pt-3"><img src="assets/images/settings/logout.svg">Clean & Logout</p>
                            <hr>
                        </div>
                    </a>
                    <!-- <div class="setting-tem">
                        <hr>
                        <p class="pl-2 pt-3"><img src="assets/images/settings/language.svg">Languages</p>
                        <hr>
                    </div> -->
                </div>
                <!-- <div class="col-md-7 col-sm-12">
                    <a href="<?php echo $common_form_route ?>handler/common/backup.php" class="a">
                        <div class="frm_">
                            <img src="assets/images/settings/backup.svg">
                            <p>Backup Database</p>
                        </div>
                    </a>
                </div> -->
            </div>
        </div>
        <script type="text/javascript">
            active_route("settings_");
        </script>
    <?php } ?>
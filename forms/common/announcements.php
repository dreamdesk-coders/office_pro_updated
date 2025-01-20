<style>
    .anno-bg {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100vh;
        z-index: 4;
        display: flex;
        justify-content: center;
        align-items: center;
        align-content: center;
        overflow-y: scroll;
        transition: .5s;
        background-color: #cac8c84f;
    }

    .anno-container {
        border-radius: 20px;
        z-index: 5;
        width: 65%;
        height: auto;
        /* -webkit-backdrop-filter: saturate(150%) blur(15px);
        backdrop-filter: saturate(150%) blur(15px);
        background-color: rgba(255, 255, 255, 0.72); */
        background-color: #fff;
        border: 0.5px solid #cbcbcb;
        box-sizing: border-box;
        padding: 25px 20px 0px 20px;
        overflow: hidden;
        /* background-image: url('https://yinyinkyaw.com/assets/img/about/cover.png'); */
        overflow: hidden;
        background-size: 500px 450px;
        background-position: 0px 0px;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -o-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .anno-container:hover {

        background-size: 550px 550px;
        background-position: -50px -50px;
    }

    .anno-center {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>
<?php
error_reporting(0);

$announcement = $_SESSION['announcement'];

if (isset($_COOKIE['announcement_read_infinity'])) {
    $announcement_read = $_COOKIE['announcement_read_infinity'];
} else {
    $announcement_read = 0;
}

if ($_GET['frm'] == "dashboard" && $announcement == 1 && $announcement_read == 0) {


?>

    <div class="anno-bg" id="announcement">
        <div class="anno-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <img src="assets/images/common/announcements/officepro2.0.png" class="w-100">
                    </div>
                    <div class="col-md-1 col-sm-12"></div>
                    <div class="col-md-6 col-sm-12 anno-center">
                        <h3 class="anno-title">Introduction Office Pro Infinity</h3>
                        <p class="anno-text">
                            Greetings! The new version of Office Pro, <strong>Office Pro Infinity</strong> is finally here.The new version came with updates & new features including</p>
                            <ul>
                                <!-- <li>Document Center</li> -->
                                <li>Compact UI</li>
                                <li>Quick Search</li>
                                <li>Portals</li>
                                <li>Security Updates</li>
                                <li>Bug Fixes</li>
                                <li>URL Encoding</li>
                                <li>URL Decoding</li>
                                <li>Internet Speed Test</li>
                            </ul>
                        <input type="button" value="Continue to Office Pro Infinity" class="btn btn-info mb-3" onclick="close_modal('announcement'),set_cookie('announcement_read_infinity','1')">
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
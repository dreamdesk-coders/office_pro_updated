<style>
#loading {
    width: 100%;
    height: 100vh;
    justify-content: center;
    align-items: center;
    align-content: center;
    position: fixed;
    top: 0;
    z-index: 58;
    overflow: hidden;
}

#lb {
    border-radius: 5px !important;
}
</style>
<div class="d-flex" id="loading">
    <button class="btn btn-dark" type="button" id="lb" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
    </button>
</div>

<script>
$(document).ready(function() {
    hide_loading();

    function hide_loading() {
        setInterval(function() {
            $("#loading ").css("width", "0");
        }, 1200);
    }

    function show_loading() {
        $("#loading ").css("width", "100%");
    }


});
</script>
<style type="text/css">
.lookup-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100vh;
    /*background-color: black;*/
    z-index: 4;
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    transform: scale(0);
    transition: 0.3s;
    -ms-transition: 0.3s;
    -webkit-transition: 0.3s;

}

.lookup {
    position: relative;
    width: 60%;
    height: 70vh;
    background-color: #fff;
    /*-webkit-backdrop-filter: saturate(180%) blur(20px);
    	backdrop-filter: saturate(180%) blur(20px);
    	background-color: rgba(255,255,255,0.72);
		transition-property: background-color, backdrop-filter, -webkit-backdrop-filter;*/
    z-index: 5;
    border-radius: 10px;
    padding: 20px !important;
    overflow-y: auto;
    border: 0.5px solid #bdbdbd;
    box-shadow: 1px 2px 10px lightgrey;
}

.close_ {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 10px;
    background-color: transparent;
    border: none;
    z-index: 6;
    cursor: pointer;
    background-image: url('assets/images/icons/close.svg');
    outline: none !important;

}

@media only screen and (max-width :768px) {
    .lookup {
        width: 90%;
    }
}
</style>

<div class="lookup-container" id="look">
    <div class="lookup">
        <button onclick="close_lookup();" class="close_"></button>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Lookup<img src="favicon.ico" style="width: 40px;display: inline-block;"></h4>

                    <div style="overflow:auto">
                        <div id="lookup-table">
                            <div class="ajax-loading">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
close_lookup();
</script>
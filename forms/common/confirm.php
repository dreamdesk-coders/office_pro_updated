<style type="text/css">
	.confirm-dialog-bg{
		background-color: transparent;
		width: 100%;
		height: 100vh;
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 59;
		display: flex;
		justify-content: center;
		align-content: center;
		align-items: center;
		overflow: hidden;
		transform: scale(0); 
		transition: 0.3s;
		-ms-transition:0.3s;
		-webkit-transition:0.3s;

	}
	.confirm-dialog-bg .confirm-dialog{
		position: relative;
		background-color: #fff;
		height: auto;
		width: 350px;
		border: 1px solid lightgrey;
		border-radius: 5px;
		overflow: hidden;
	}
	.confirm-dialog .confirm-dialog-header{
		background-color: var(--primary);
		color: #fff;
		padding: 10px 5px;
	}
	.confirm-dialog-header h5{
		margin-bottom: 0px !important;
	}
	.confirm-dialog .confirm-dialog-body{
		padding: 10px;
	}
	.confirm-dialog-body p{
		margin-top: 1rem !important;
	}
</style>
<div class="confirm-dialog-bg" id="confirm">
  	<div class="confirm-dialog">
	  <div class="confirm-dialog-header">
	  	<h5 id="confirm-dialog-header"></h5>
	  </div>
	  <div class="confirm-dialog-body">
	    <p id="confirm-dialog-msg"></p>
        <p></p>
	    <div class="d-flex flex-row-reverse">
	    	<button class="btn btn-outline-dark mb-2 " id="btn-confirm"> Cancel </button>
            <button class="btn btn-primary mb-2 mr-2" id="btn-cancel"> Confirm </button>
	    </div>
	  </div>
	</div>
</div>



<script type="text/javascript">
    $( document ).ready(function() {

       	$("#btn-confirm").click(function(){
       		var focus = localStorage.getItem("focus");
       		if(document.getElementById(focus)){
       			document.getElementById(focus).focus();
       		}
       		
            $('#confirm').css('transform', 'scale(0)');
           
    		
  		});
  });
</script>
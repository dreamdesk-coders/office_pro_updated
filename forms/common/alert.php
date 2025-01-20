<style type="text/css">
	.alert-dialog-bg{
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
	.alert-dialog-bg .alert-dialog{
		position: relative;
		background-color: #fff;
		height: auto;
		width: 350px;
		border: 1px solid lightgrey;
		border-radius: 5px;
		overflow: hidden;
	}
	.alert-dialog .alert-dialog-header{
		background-color: var(--primary);
		color: #fff;
		padding: 10px 5px;
	}
	.alert-dialog-header h5{
		margin-bottom: 0px !important;
	}
	.alert-dialog .alert-dialog-body{
		padding: 10px;
	}
	.alert-dialog-body p{
		margin-top: 1rem !important;
	}
</style>
<div class="alert-dialog-bg" id="alert">
  	<div class="alert-dialog">
	  <div class="alert-dialog-header">
	  	<h5 id="alert-dialog-header"></h5>
	  </div>
	  <div class="alert-dialog-body">
	    <p id="alert-dialog-msg"></p>
	    <div class="d-flex flex-row-reverse">
	    	<button class="btn btn-primary mb-2" id="btn-alert"> OK </button>
	    </div>
	  </div>
	</div>
</div>



<script type="text/javascript">
    $( document ).ready(function() {

       	$("#btn-alert").click(function(){
       		var focus = localStorage.getItem("focus");
       		if(document.getElementById(focus)){
       			document.getElementById(focus).focus();
       		}
       		
    		$('#alert').css('transform', 'scale(0)');
    		
  		});
  });
</script>
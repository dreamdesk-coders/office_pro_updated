<?php

      if(isset($_GET['auth'])){
        if($_GET['auth'] === 'fail'){
          echo '<div class="alert alert-warning alert-dismissible" role="alert">
          Login Failure! User name or Password is incorrect.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        }
        elseif($_GET['auth'] === 'out'){

          echo '<div class="alert alert-info alert-dismissible" role="alert">
                  You have been logged out form your account.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
        }
      }
?>
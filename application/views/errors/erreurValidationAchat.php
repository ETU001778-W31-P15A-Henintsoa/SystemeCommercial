<style>
    #erreur{
        width:1000px;
        margin-left:auto;
        margin-right:auto;
        float:right;
        backgroundcolor:red;
    }
    #messageErreur{
        color:red;
    }
</style>
        <div class="row" id="erreur">
            <div class="col-12">
                  <div class="card mb-4">
                    <h5 class="card-header">!Erreur!</h5>
                    <div class="card-body">
                      <p class="card-text" id="messageErreur" >
                            <?php 
                                echo $error;
                            ?>
                      </p>
                   
                    </div>
                  </div>
            </div>
        </div>
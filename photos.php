<?php
 include_once"inc/header.php";
 include_once"profile-header.php";
 $photo  = timeline::photos();
?>

  <div class="row">
    <div class="col-md-12">
      <div id="grid" class="row">
        <?php
          foreach($photo as $result){
        ?>
          <div class="mix col-sm-3 page2 page3 margin30">
              <div class="item-img-wrap ">
                  <img src="images/others/<?= $result['post_image']; ?>" class="img-responsive" alt="<?= $result['post_image']; ?>">
                  <div class="item-img-overlay">
                      <a href="#" class="show-image">
                          <span></span>
                      </a>
                  </div>
              </div>
          </div>
          <?php
            }
          ?>
      </div><!-- grid-->
    </div>
  </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">IMAGE</h4>
      </div>
      <div class="modal-body text-centers">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include_once"inc/footer.php"; ?>

<?php
 include_once"inc/header.php";
 include_once"profile-header.php";
?>

  </div>
  <div class="col-md-8 col-md-offset-2">
    <div class="row">
      <div class="col-md-12">
        <div class="widget">
        <div class="widget-body">
        <div class="row">
          <div class="col-md-4 col-md-5 col-xs-12">
            <div class="row content-info">
              <div class="col-xs-3">
                Email:
              </div>
              <div class="col-xs-9">
                <?= userprofile::profile()[0]['email']; ?>
              </div>
            </div>
            <div class="row content-info">
              <div class="col-xs-3">
                Address:
              </div>
              <div class="col-xs-9">
                <?= userprofile::profile()[0]['address']; ?>
              </div>
            </div>
            <div class="row content-info">
              <div class="col-xs-3">
                Birthday:
              </div>
              <div class="col-xs-9">
                <?= userprofile::profile()[0]['birthdate']; ?>
              </div>
            </div>
            <div class="row content-info">
              <div class="col-xs-3">
               Job:
              </div>
              <div class="col-xs-9">
                <?= userprofile::profile()[0]['job']; ?>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-7 col-xs-12">
            <p class="contact-description"><?= userprofile::profile()[0]['about']; ?>.</p>
          </div>
        </div>
      </div>
      </div>
      </div>
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
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
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

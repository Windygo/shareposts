<?php require APPROOT . '/views/inc/header.php'; ?>  
  <a onclick="history.go(-1);" class="btn btn-light"><i class="fa fa-backward"></i>   Back</a>
  
  <div class="card card-body bg-light mt-5">
  <h2>Add Post</h2>
  <p>Create a post with this form</p>
  <form action="<?php echo URLROOT; ?>/posts/add" method='POST' >
      <div class="form-group">
        <label for="title">Title: <sup>*</sup></label>
        <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="body">Body: <sup>*</sup></label>
        <textarea rows=8 name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>" ><?php echo $data['body']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
      </div>
      <input href="<?php echo URLROOT; ?>/post/add" type="submit" class="btn btn-success btn-block" value="Add Post">    
    </form>
  </div>  

<?php require APPROOT . '/views/inc/footer.php'; ?>
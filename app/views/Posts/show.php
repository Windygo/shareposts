<?php require APPROOT . '/views/inc/header.php'; ?>

<a onclick="history.go(-1);" class="btn btn-light mb-5"><i class="fa fa-backward"></i>   Back</a>


<div class="card-title bg-light p-2">
  <h1><?php echo $data['post']->title; ?></h1>
</div>
<div class="mb-3">
  <small >Written by <?php echo $data['user']->name . ' on '. $data['post']->created_at ?></small>
</div>
<div class="bg-secondary text-light p-2 mb-3">
  <?php echo $data['post']->body; ?>
</div>
<!-- Edit if owner of post -->
<?php if($_SESSION['user_id'] == $data['post']->user_id) : ?>

<a href="<?php echo URLROOT ;?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit</a> 

<!-- Delete requires a form -->
<form class="pull-right" action="<?php echo URLROOT ;?>/posts/delete/<?php echo $data['post']->id; ?>"  method="post">
<input type="submit" class="btn btn-danger" value="Delete">
</form>

<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
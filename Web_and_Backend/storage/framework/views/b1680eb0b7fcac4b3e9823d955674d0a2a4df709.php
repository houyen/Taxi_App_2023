 
 
   <?php $__env->startSection('main'); ?>
    
    <main id="site-content" role="main">
      
<div class="container" style="min-height: 485px">
  <div class="row " style="margin:3em 0">
    <div class="col-md-12 text-center">
      <h1 class="text-jumbo text-ginormous hide-sm"><?php echo e(trans('messages.errors.unauthorize')); ?></h1>
      <!-- <h1 class="text-jumbo text-ginormous hide-sm">Coming Soon!</h1> -->
      <!-- <h2></h2> -->
      <!-- <h2>We are working on this page, will update it soon.</h2> -->
      <h4><?php echo e(trans('messages.errors.content_block')); ?></h4>
    </div>
  </div>
</div>

    </main>

<?php $__env->stopSection(); ?>
<style type="text/css">
  .row.row-space-top-8.row-space-8{
    margin-top: 230px !important;
    margin-bottom: 250px !important;
  }
</style>
<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampps\htdocs\newtaxi\resources\views/errors/403.blade.php ENDPATH**/ ?>
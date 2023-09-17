<title>Documents</title>
 
<?php $__env->startSection('main'); ?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" ng-controller="payment">
  

    <?php echo Form::open(['url' => 'driver_document', 'class' => '','id'=>'vehicle_form','files' => true]); ?>

      <div class="parter-info separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 0px 15px;">
        <div class="text--left col-lg-12">
          <h1 class="cls_profiletitle"> <?php echo app('translator')->get('messages.driver_dashboard.driver_documents'); ?> </h1>
        </div>
        <?php $__currentLoopData = $driver_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>     
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 displayflex" style="align-items: end" >
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding:6px 0px;"><?php echo e($document->document_name); ?><em class="text-danger">*</em></label>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding:6px 0px;">
              <input type="file" name="<?php echo e($document->doc_name); ?>" class="form-control">
              <span class="text-danger">
                <?php echo e($errors->first($document->doc_name)); ?> 
              </span>
              <?php $image = ($document->document !='') ? $document->document : url('images/driver_doc.png'); ?>
              <div class="license-img">
              <a href="<?php echo e($image); ?>" target="_blank">
                <img style="width: 200px;height: 100px;object-fit: cover;" src="<?php echo e($image); ?>">
              </a>
              </div>     
            <?php if($document->expiry_required == '1'): ?>
            <div class="" style="margin-top: 10px;">
              <input type="date" min="<?php echo e(date('Y-m-d')); ?>" name="expired_date_<?php echo e($document->id); ?>" class="form-control" value="<?php echo e($document->expired_date); ?>">
              <span class="text-danger"> 
                <?php echo e($errors->first('expired_date_'.$document->id)); ?>

              </span>         
            </div>
            <?php endif; ?>
            </div>     
          </div>  
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <div class="separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12 text--center" style="border-bottom:0px !important; margin-top: 20px;">
        <button style="padding: 0px 60px !important;font-size: 19px !important;" type="submit" class="btn btn--primary btn-blue" id="update_btn"><?php echo e(trans('messages.user.update')); ?></button>
    </div>
  </div>
  <?php echo e(Form::close()); ?>



</div>
</div>
</div>
</div>
</div>
</main>
<?php $__env->stopSection(); ?>
<style type="text/css">
    .btn-input:hover, .btn:hover, .file-input:hover, .tooltip:hover, .btn, .btn-input, .file-input, .tooltip {
    background: transparent !important;
    border: none !important;
}
.btn--link .icon_left-arrow {
    -webkit-transition: left .4s ease;
    transition: left .4s ease;
    position: relative;
    left: -2;
    padding-left: 10px;
}
.btn--link:focus .icon_left-arrow, .btn--link:hover .icon_left-arrow {
    left: -6px;
}
@media (max-width: 400px){
    #btn-pad.btn.btn--primary.btn-blue{
      font-size: 11px !important;
      padding:0px 20px !important;
    }
}
</style>

<?php echo $__env->make('template_driver_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp7\htdocs\newtaxi\resources\views/driver_dashboard/documents.blade.php ENDPATH**/ ?>
<title><?php echo e(trans('messages.driver_dashboard.vehicle_details')); ?></title>

<?php $__env->startSection('main'); ?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" style="padding:0px;">
    
    <div class="page-lead separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="border-bottom:0px !important; padding: 0">
       <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
          <h1 class="cls_profiletitle"><?php echo e(trans('messages.header.profil')); ?></h1>
      </div>
      <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6 text--right">
        <a href="<?php echo e(url('add_vehicle')); ?>" style="padding: 0px 30px !important;
        font-size: 14px !important;" type="submit" class="btn btn--primary btn-blue">
          <?php echo e(trans('messages.driver_dashboard.vehicle_details')); ?>

        </a>
      </div>
    </div>

    <div id="no-more-tables" style="overflow: visible;" class="tr_ico">
        <table class="col-sm-12 table-bordered table-striped table-condensed cf">
            <thead class="cf">
                <tr>
                  <th><?php echo e(trans('messages.user.veh_name')); ?></th>
                  <th><?php echo e(trans('messages.driver_dashboard.vehicle_type')); ?></th>
                  <th><?php echo e(trans('messages.driver_dashboard.vehicle_number')); ?></th>
                  <th><?php echo e(trans('messages.driver_dashboard.status')); ?></th>
                  <th></th>
                </tr>
            </thead>                
            <tbody class="driver_trips_details">
              <?php if($vehicle_documents->count() > 0): ?>
                <?php $__currentLoopData = $vehicle_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($vehicle->vehicle_name); ?>

                    <?php if($vehicle->default_type == '1'): ?>
                      <span class="btn btn--primary"><?php echo e(trans('messages.account.default')); ?></span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo e($vehicle->vehicle_type); ?></td>
                  <td><?php echo e($vehicle->vehicle_number); ?></td>
                  <td><?php echo e($vehicle->trans_status); ?></td>
                  <td class="payout-options cls_dropoption">
                    <li class="dropdown-trigger list-unstyled">
                      <a href="javascript:void(0);" class="link-reset text-truncate" id="option1">
                        <?php echo app('translator')->get('messages.account.options'); ?>
                        <i class="icon icon-caret-down"></i>
                      </a>
                      <ul data-sticky="true" data-trigger="#option1" class="tooltip tooltip-top-left list-unstyled dropdown-menu" aria-hidden="true">
                        <li>
                          <a rel="nofollow" data-method="post" class="link-reset menu-item" href="<?php echo e(url('edit_vehicle/'.$vehicle->id)); ?>"><?php echo e(trans('messages.driver_dashboard.edit')); ?></a>
                        </li>
                        <?php if($vehicle->default_type == '0'): ?>
                        <li>
                          <a rel="nofollow" data-method="post" class="link-reset menu-item" href="<?php echo e(url('default_vehicle/'.$vehicle->id)); ?>"><?php echo e(trans('messages.driver_dashboard.set_as_default')); ?></a>
                        </li>
                        <?php endif; ?>
                        <li>
                          <a rel="nofollow" data-method="post" class="link-reset menu-item" href="<?php echo e(url('delete_vehicle/'.$vehicle->id)); ?>"><?php echo e(trans('messages.driver_dashboard.delete')); ?></a>
                        </li>
                      </ul>
                    </li>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" style="height: 46px;text-align: center;">
                      <?php echo e(trans('messages.dashboard.no_details')); ?>.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
        </table>
      </div>
</div>
</div>
</div>
</div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template_driver_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp7\htdocs\newtaxi\resources\views/driver_dashboard/vehicle.blade.php ENDPATH**/ ?>
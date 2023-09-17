<title>Invoice</title>

<?php $__env->startSection('main'); ?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" style="padding-top: 10px;">
    <div id="printableArea">
        <div class="page-lead separated--bottom  text--center text--uppercase pull-left" style="margin-bottom: 0px !important;padding-bottom: 5px !important;">
            <h1 class="flush-h1 flush">
                <?php echo app('translator')->get('messages.dashboard.trip_invoice'); ?>
            </h1>
            <small style="text-transform: none;text-align: left;float: left;padding: 20px 20px 0px;"><?php echo e(trans('messages.dashboard.dwnld_invoice')); ?><?php echo e($site_name); ?><?php echo e(trans('messages.dashboard.feedback')); ?> </small>
        </div>
        <div id="no-more-tables" style="overflow: visible;" class="tr_ico">
            <table class="col-sm-12 table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th><?php echo e(trans('messages.dashboard.invoice_no')); ?></th>
                        <th ><?php echo e(trans('messages.dashboard.trip_date')); ?></th>
                        <th><?php echo e(trans('messages.dashboard.invoice')); ?></th>
                        <th class="not-need"><?php echo e(trans('messages.dashboard.download')); ?></th>
                        <th class="not-need"><?php echo e(trans('messages.dashboard.print')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="trip-expand__origin collapsed" >
                        <td data-title="Invoice Number"><?php echo e($trip->id); ?></td>
                        <td data-title="Trip date"><?php echo e(date('F d, Y',strtotime($trip->created_at))); ?></td>
                        <td data-title="Invoice"><?php echo e($trip->currency->original_symbol); ?> <?php echo e($trip->total_fare); ?></td>
                        <td data-title="Download" class="not-need"> <a href="<?php echo e(url('download_rider_invoice/'.$trip->id)); ?>"  class="color--primary" style="font-weight:bold;"><?php echo e(trans('messages.dashboard.pdf')); ?></a></td>
                        <td data-title="Print" class="not-need"> <a href="#" onclick="printDiv('printableArea')" class="color--primary" style="font-weight:bold;"><?php echo e(trans('messages.dashboard.print')); ?></a></td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="page-lead separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" >
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="dr_invo">
                    <img src="<?php echo e($trip->driver_thumb_image); ?>" class='img--circle img--bordered img--shadow driver-avatar'>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <p><?php echo e(trans('messages.dashboard.invoice_issued')); ?> <?php echo e($site_name); ?> <?php echo e(trans('messages.dashboard.behalf')); ?></p>
                <p><?php echo e($trip->driver_name); ?></p>
                <div class="text--left">
                    <div class="trip-address grid grid--full soft-double--bottom">
                        <div class="trip-address__path"></div>
                        <div class="grid__item one-tenth" style="margin:6px 0px;">
                            <div class="icon icon_route-dot color--positive"></div>
                        </div>
                        <div class="grid__item nine-tenths">
                            <p class="flush"><?php echo e($trip->pickup_time); ?></p>
                            <h6 class="color--neutral flush"><?php echo e($trip->pickup_location); ?></h6>
                        </div>
                    </div>
                    <div class="trip-address grid grid--full">
                        <div class="grid__item one-tenth" style="margin:6px 0px;">
                            <div class="icon icon_route-dot color--negative"></div>
                        </div>
                        <div class="grid__item nine-tenths">
                            <p class="flush"><?php echo e($trip->drop_time); ?></p>
                            <h6 class="color--neutral flush"><?php echo e($trip->drop_location); ?></h6>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        <div id="no-more-tables" class="table-no-border" style="overflow: visible;"  class="tr_ico" ng-cloak>
            <table class="col-sm-12 table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th><?php echo e(trans('messages.dashboard.date')); ?></th>
                        <th><?php echo e(trans('messages.dashboard.desc')); ?></th>
                        <th><?php echo e(trans('messages.dashboard.net_amt')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $invoice_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="trip-expand__origin collapsed text-<?php echo e($invoice['colour']); ?>">
                            <td> <?php echo e(($key == 0) ? date('F d, Y') : ''); ?> </td>
                            <td class="text--left"> <?php echo e($invoice['key']); ?> </td>
                            <td class="text--right"> <?php echo e($invoice['value']); ?> </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <ul class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-ul">
        
    </ul>
</div>
</div>
</div>
</div>
</div>
</main>
<?php $__env->stopSection(); ?>
<script>
function printDiv(divName) {
$('.not-need').addClass('hide');
var printContents = document.getElementById(divName).innerHTML;
var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;
window.print();

document.body.innerHTML = originalContents;
$('.not-need').removeClass('hide');
}
</script>

<?php echo $__env->make('template_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/dashboard/rider_invoice.blade.php ENDPATH**/ ?>
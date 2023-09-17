<title>Invoice</title>

<?php $__env->startSection('main'); ?>
<style>
    h1{
        padding-left    :   50px;
        font-size       :   30px;
        text-align: center;
        font-weight     :   bold;
    }
    table{
        border          :   1px solid black;
        width           :   100%;
        font-size       :   16px;
        margin: 0 auto;
    }
    tr, td{
        border          :   1px solid black;
        padding    :   0 15px;
    }
    th{
        padding    :   0 15px;
    }
    tr{
        border-collapse :   collapse;
    }
    div{
        padding-top     :   20px;
    }
    div{
        padding-top     :   25px;
    }
    img {
        border: 1px solid #c2c2c2;
        border-radius: 100% !important;
        max-width: 100%;
    }
    p{
        line-height: 15px;
    }
    .no-border,.no-border tr,.no-border td {
        border: none;
    }
    .width-60 {
        width: 40%;
        text-align: center;
    }
    .width-40 {
        width: 60%;
    }
</style>

<div style="padding: 10px;width: 100%;margin: 0 auto;display: inline-block;">
    <div ><h1><?php echo e(trans('messages.dashboard.trip_invoice')); ?></h1>
    </div>
    <div >
        <table>
            <thead >
                <tr>
                    <th><?php echo e(trans('messages.dashboard.invoice_no')); ?></th>
                    <th ><?php echo e(trans('messages.dashboard.trip_date')); ?></th>
                    <th><?php echo e(trans('messages.dashboard.invoice')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr  >
                    <td data-title="Invoice Number"> <?php echo e($trip->id); ?> </td>
                    <td data-title="Trip date"> <?php echo e(date('F d, Y',strtotime($trip->created_at))); ?> </td>
                    <td data-title="Invoice"> <?php echo e($trip->currency->code); ?>  <?php echo e($trip->total_fare); ?> </td>
                </tr>
            </tbody>
        </table>
        <table class="no-border">
            <tr>
                <td class="width-60" style="text-align: center;">
                    <div class="" style="background-image: url(<?php echo e($trip->driver_thumb_image); ?>);height: 150px;width: 150px;margin: 0 auto;background-size: cover;background-position: center center;background-repeat: no-repeat;"></div>
                </td>
                <td class="width-40">
                    <div class="col-sm-6">
                        <p><?php echo e(trans('messages.dashboard.invoice_issued')); ?> <?php echo e($site_name); ?><?php echo e(trans('messages.dashboard.behalf')); ?></p>
                        <p><?php echo e($trip->driver_name); ?></p>
                        <p class="flush"><?php echo e($trip->pickup_time); ?></p>
                        <h6 class="color--neutral flush"><?php echo e($trip->pickup_location); ?></h6><br>
                        <p class="flush"><?php echo e($trip->drop_time); ?></p>
                        <h6 class="color--neutral flush"><?php echo e($trip->drop_location); ?></h6><br>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <table>
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
                        <td class="text--left "> <?php echo e($invoice['key']); ?> </td>
                        <td class="text--right "> <?php echo e($invoice['value']); ?> </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <ul class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-ul">

    </ul>
</div>
</div>
</div>
</div>
</div>
</main>
<style type="text/css">
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_without_header_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/dashboard/download_rider_invoice.blade.php ENDPATH**/ ?>
<title>Invoice</title>

<?php $__env->startSection('main'); ?>
<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 flexbox__item four-fifths page-content" style="padding:0px;" ng-controller="trip">
    <div id="printableArea">
         <div class="separated--bottom  text--left">
                <h1 class="cls_profiletitle"> <?php echo app('translator')->get('messages.dashboard.trip_invoice'); ?> </h1>
                <p><?php echo e(trans('messages.driver_dashboard.download_invoice_driver')); ?> <?php echo e($site_name); ?> <?php echo e(trans('messages.driver_dashboard.client_feedback')); ?></p>
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
                
                <?php if($all_invoice == true): ?>
                <tbody class="driver_trips_details" ng-cloak>
                    <tr class="trip-expand__origin collapsed" ng-init="driver_trips=<?php echo e($trips); ?>;currentPage=driver_trips.current_page;totalPages=driver_trips.last_page" ng-repeat="trip in driver_trips.data" ng-cloak>
                        <td data-title="Invoice Number">
                            {{ trip.id }}
                        </td>
                        <td data-title="Trip date">{{ trip.begin_date|date:'MM/dd/yyyy'}}</td>
                        <td data-title="Invoice"><span ng-bind-html="trip.currency.original_symbol"></span>&nbsp;{{ trip.total_invoice }}</td>
                        <td data-title="Download" class="not-need"> <a href="<?php echo e(url('download_invoice/')); ?>/{{ trip.id}}"  target="_self" class="color--primary" style="font-weight:bold;"><?php echo e(trans('messages.dashboard.pdf')); ?> </a></td>
                        <td data-title="Print" class="not-need"> <a href="<?php echo e(url('print_invoice/')); ?>/{{ trip.id}}"  target="_self" class="color--primary" style="font-weight:bold;"> <?php echo e(trans('messages.dashboard.print')); ?></a></td>
                    </tr>
                    <tr>
                        <td ng-show="driver_trips.data.length==0" colspan="5" style="height: 46px;text-align: center;">
                            <?php echo e(trans('messages.dashboard.no_details')); ?>.
                        </td>
                    </tr>
                </tbody>
                <?php else: ?>
                <tbody ng-cloak>
                    <tr class="trip-expand__origin collapsed" >
                        <td data-title="Invoice Number">
                            <?php echo e($trip->id); ?>

                        </td>
                        <td data-title="Trip date">
                            <?php echo e(date('F d, Y',strtotime($trip->created_at))); ?>

                        </td>
                        <td data-title="Invoice" >
                            <?php echo e($trip->currency->original_symbol); ?> <?php echo e($trip->total_invoice); ?>

                        </td>
                        <td data-title="Download" class="not-need">
                            <a href="<?php echo e(url('download_invoice/'.$trip->id)); ?>" target="_self" class="color--primary" style="font-weight:bold;">
                                <?php echo app('translator')->get('messages.dashboard.pdf'); ?>
                            </a>
                        </td>
                        <td data-title="Print" class="not-need">
                            <a href="#" onclick="printDiv('printableArea')" class="color--primary" style="font-weight:bold;">
                                <?php echo app('translator')->get('messages.dashboard.print'); ?>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <?php endif; ?>                
            </table>
        </div>
        <div class="page-form push-small--top clearfix"  ng-if="<?php echo e($all_invoice == true); ?>">
            <div class="select float--left push-tiny--right"  style="margin-left: 10px;"><br>
                <select name="per_page" id="per_page" class="" ng-init="selectedItem='10'" ng-model="selectedItem" ng-change="getInvoice()" style="border-radius:10px;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div style="padding:25px;">
                <div class="pagination-buttons-container row-space-8 float--right" ng-cloak>
                    <div class="results_count pagination inline-group btn-group btn-group--bordered" style="float: right;margin-top: 20px;">
                        <div class="inline-group__item" ng-show="driver_trips.data.length > 1">
                            <invoices-pagination></invoices-pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($all_invoice == false): ?>
        <div class="page-lead separated--bottom col-lg-12 col-md-12 col-sm-12 col-xs-12" >
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="dr_invo">
                    <img src="<?php echo e($trip->rider_profile_picture); ?>" class='img--circle img--bordered img--shadow driver-avatar'>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <p>
                    <?php echo app('translator')->get('messages.dashboard.invoice_issued'); ?> <?php echo e($site_name); ?> <?php echo app('translator')->get('messages.dashboard.behalf'); ?>
                </p>
                <p> <?php echo e($trip->rider_name); ?> </p>
                <div class="text--left">
                    <div class="trip-address grid grid--full soft-double--bottom">
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
        <div id="no-more-tables" class="table-no-border" style="overflow: visible;" class="tr_ico" ng-cloak>
            <table class="col-sm-12 table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th> <?php echo app('translator')->get('messages.dashboard.date'); ?> </th>
                        <th> <?php echo app('translator')->get('messages.dashboard.desc'); ?> </th>
                        <th> <?php echo app('translator')->get('messages.dashboard.net_amt'); ?> </th>
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
    <?php endif; ?>
</div>
</div>
</div>
</div>
</div>
</main>

<?php $__env->startPush('scripts'); ?>
    <script>
        function printDiv(divName)
        {
            $('.not-need').addClass('hide');
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            $('.not-need').removeClass('hide');
        }
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template_driver_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp7\htdocs\newtaxi\resources\views/driver_dashboard/driver_invoice.blade.php ENDPATH**/ ?>
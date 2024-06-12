

<?php $__env->startSection('panel'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="row gy-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo app('translator')->get('Vendor Information'); ?></h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between flex-wrap gap-1">
                                    <span><?php echo app('translator')->get('Name'); ?></span>
                                    <span><?php echo e($owner->fullname); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between flex-wrap gap-1">
                                    <span><?php echo app('translator')->get('Mobile'); ?></span>
                                    <a href="tel:<?php echo e($owner->mobile); ?>">+<?php echo e($owner->mobile); ?></a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between flex-wrap gap-1">
                                    <span><?php echo app('translator')->get('Email'); ?></span>
                                    <a href="mailto:<?php echo e($owner->email); ?>"><?php echo e($owner->email); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <?php echo app('translator')->get('Hotel Information'); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between flex-wrap gap-1">
                                    <span><?php echo app('translator')->get('Hotel Name'); ?></span>
                                    <span><?php echo e(@$owner->hotelSetting->name); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between flex-wrap gap-1">
                                    <span><?php echo app('translator')->get('Location'); ?></span>
                                    <span><?php echo e(__(@$owner->hotelSetting->location->name)); ?>, <?php echo e(__(@$owner->hotelSetting->city->name)); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between flex-wrap gap-1">
                                    <span><?php echo app('translator')->get('Country'); ?></span>
                                    <span><?php echo e(__(@$owner->hotelSetting->country->name)); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo app('translator')->get('Submitted Documents for Verification'); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php if($owner->form_data): ?>
                                <ul class="list-group list-group-flush">

                                    <?php $__currentLoopData = $owner->form_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!$formData->value) continue; ?>
                                        <li class="list-group-item d-flex justify-content-between flex-wrap gap-1">
                                            <span><?php echo e(__($formData->name)); ?></span>
                                            <div>
                                                <?php if($formData->type == 'checkbox'): ?>
                                                    <?php echo e(implode(',', $formData->value)); ?>

                                                <?php elseif($formData->type == 'file'): ?>
                                                    <div class="d-flex gap-1">
                                                        <a href="<?php echo e(route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $formData->value))); ?>"><i class="la la-file"></i> <?php echo app('translator')->get('Attachment'); ?></a>
                                                    </div>
                                                <?php else: ?>
                                                    <?php echo e(__($formData->value)); ?>

                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-end">
                    <button class="btn btn--danger confirmationBtn" data-action="<?php echo e(route('admin.vendor.request.reject', $owner->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure you want to reject this request?'); ?>" type="button"><i class="las la-trash-alt"></i><?php echo app('translator')->get('Reject'); ?></button>

                    <button class="btn btn--primary confirmationBtn" data-action="<?php echo e(route('admin.vendor.request.approve', $owner->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure you want to approve this request?'); ?>" type="button"><i class="las la-check"></i><?php echo app('translator')->get('Approve'); ?></button>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b = $component; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8\htdocs\hotellatest\laravel\files\core\resources\views/admin/vendor_request/detail.blade.php ENDPATH**/ ?>
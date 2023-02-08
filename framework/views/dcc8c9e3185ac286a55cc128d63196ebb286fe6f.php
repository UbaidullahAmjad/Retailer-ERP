 <?php $__env->startSection('content'); ?>
<?php if(session()->has('create_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('create_message')); ?></div>
<?php endif; ?>
<?php if(session()->has('edit_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('edit_message')); ?></div>
<?php endif; ?>
<?php if(session()->has('import_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('import_message')); ?></div>
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div>
<?php endif; ?>

<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class=""><?php echo e(trans('file.Section Parts')); ?></h3>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="product-data-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th>Article Id</th>
                    <th>Article Number</th>
                    <th>Generic Article Description</th>
                    <th>Article Country</th>
                    <th>Brand Name</th>
                    <th>Assembly Group Node ID</th>
                    <th>Linkage Target ID</th>
                    <th>Linkage Target Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($getSectionParts) > 0): ?>
                <?php $__currentLoopData = $getSectionParts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <tr>
                        <td><?php echo e($item->article->legacyArticleId); ?></td>
                        <td><?php echo e($item->article->articleNumber); ?></td>
                        <td><?php echo e($item->article->genericArticleDescription); ?></td>
                        <td><?php echo e(isset($item->article->brand) ?  $item->article->brand->brandName : "not given"); ?></td>
                        <td><?php echo e(isset($item->article->brand) ?  $item->article->brand->articleCountry : "not given"); ?></td>
                        <td><?php echo e($item->assemblyGroupNodeId); ?></td>
                        <td><?php echo e($item->linkingTargetId); ?></td>
                        <td><?php echo e($item->linkingTargetType); ?></td>
                        <?php if(!empty($item->article->brand)): ?>
                        <td>  
                            <a href="<?php echo e(route('get_language',$item->article->brand->id)); ?>" class="btn btn-primary">Get Brand lang</a>
                        </td>                            
                        <?php else: ?>
                        <td>  
                            <button class="btn btn-warning">brand not Available</button>
                        </td> 
                        <?php endif; ?>
                       
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>

        </table>
        
        <div class="pull-right">
            <?php echo e($getSectionParts->links()); ?>

        </div>
    </div>

    <div class="mt-5">
        <div class="col-md-2">
            <a href="<?php echo e(route('assembly_group_nodes.index')); ?>" class="btn btn-primary">Back</a>
        </div>
        
    </div>

</section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>

    $(document).ready(function() {
        var table = $('#product-data-table').DataTable( {
            responsive: true,
            fixedHeader: {
                header: true,
                footer: true
            },
            "processing": true,
            "paging" : false
            // "serverSide": true,
        } );

    } );
    $('select').selectpicker();

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\ERP\resources\views/assembly_group_node/section_parts.blade.php ENDPATH**/ ?>
<?php $__env->startSection('main'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" ng-controller='pages'>
    <!-- Content Header (Page header) -->
    <section class="content-header" >
      <h1>
        Edit Page
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo e(url(LOGIN_USER_TYPE.'/dashboard')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo e(url(LOGIN_USER_TYPE.'/pages')); ?>">Page</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Page Form</h3>
            </div>
           
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo Form::open(['url' => 'admin/edit_page/'.$result->id, 'class' => 'form-horizontal']); ?>

              <div class="box-body">
              <span class="text-danger">(*)Fields are Mandatory</span>
                <div class="form-group">
                  <label for="input_name" class="col-sm-3 control-label">Name<em class="text-danger">*</em></label>
                  <div class="col-md-7 col-sm-offset-1">
                    <?php echo Form::text('name', $result->name, ['class' => 'form-control', 'id' => 'input_name', 'placeholder' => 'Name']); ?>

                    <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_content" class="col-sm-3 control-label">Content<em class="text-danger">*</em></label>
                  <div class="col-md-7 col-sm-offset-1">
                    <textarea id="txtEditor" name="txtEditor"></textarea>
                    <?php echo Form::textarea('content', $result->content, ['id' => 'content', 'hidden' => 'true']); ?>

                    <span class="text-danger"><?php echo e($errors->first('content')); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_footer" class="col-sm-3 control-label">Footer<em class="text-danger">*</em></label>
                  <div class="col-md-7 col-sm-offset-1">
                    <?php echo Form::select('footer', array('yes' => 'Yes', 'no' => 'No'), $result->footer, ['class' => 'form-control', 'id' => 'input_footer', 'placeholder' => 'Select']); ?>

                    <span class="text-danger"><?php echo e($errors->first('footer')); ?></span>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="input_status" class="col-sm-3 control-label">Status<em class="text-danger">*</em></label>
                  <div class="col-md-7 col-sm-offset-1">
                    <?php echo Form::select('status', array('Active' => 'Active', 'Inactive' => 'Inactive'), $result->status, ['class' => 'form-control', 'id' => 'input_status', 'placeholder' => 'Select']); ?>

                    <span class="text-danger"><?php echo e($errors->first('status')); ?></span>
                  </div>
                </div>
                 <div class="panel" ng-init="translations = <?php echo e(json_encode(old('translations') ?: $result->translations)); ?>; removed_translations =  []; errors = <?php echo e(json_encode($errors->getMessages())); ?>; result_translations = <?php echo e(json_encode($result->translations)); ?>" ng-cloak>
                  <div class="panel-header">
                    <h4 class="box-title text-center">Translations</h4>
                  </div>
                  <div class="panel-body" ng-init="languages = <?php echo e(json_encode($languages)); ?>">
                    <input type="hidden" name="removed_translations" ng-value="removed_translations.toString()">
                    <div class="row" ng-repeat="translation in translations">
                      <input type="hidden" name="translations[{{$index}}][id]" value="{{translation.id}}">
                      <div class="form-group">
                        <label for="input_language_{{$index}}" class="col-sm-3 control-label">Language<em class="text-danger">*</em></label>
                        <div class="col-sm-8">
                          <select name="translations[{{$index}}][locale]" class="form-control " id="input_language_{{$index}}" ng-model="translation.locale" >
                            <option value="" ng-if="translation.locale == ''">Select Language</option>
                            <option ng-if="!languages.hasOwnProperty(translation.locale) && translation.locale != '';" value="{{translation.locale}}" >{{translation.language.name}} </option>
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($key); ?>" ng-if="(('<?php echo e($key); ?>' | checkKeyValueUsedInStack : 'locale': translations) || '<?php echo e($key); ?>' == translation.locale) && '<?php echo e($key); ?>' != 'en'"><?php echo e($value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                          <span class="text-danger ">{{ errors['translations.'+$index+'.locale'][0] }}</span>
                        </div>
                        <div class="col-sm-1 p-0">
                          <button class="btn btn-danger btn-xs" ng-click="translations.splice($index, 1); removed_translations.push(translation.id)">
                            <i class="fa fa-trash"></i>
                          </button>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="input_name_{{$index}}" class="col-sm-3 control-label">Name<em class="text-danger">*</em></label>
                        <div class="col-sm-9">
                          <?php echo Form::text('translations[{{$index}}][name]', '{{translation.name}}', ['class' => 'form-control ', 'id' => 'input_name_{{$index}}', 'placeholder' => 'Name']); ?>

                          <span class="text-danger ">{{ errors['translations.'+$index+'.name'][0] }}</span>
                        </div>
                      </div>

                      <div class="form-group"  ng-init="multiple_editors($index)">
                        <label for="input_content_{{$index}}" class="col-sm-3 control-label">Content<em class="text-danger">*</em></label>
                        <div class="col-sm-9">
                          <textarea class="editors" id="editor_{{$index}}" name="translations[{{$index}}][txtEditor]" data-index="{{$index}}"></textarea>
                          <textarea class="contents " id="content_{{$index}}" name="translations[{{$index}}][description]" hidden="true">{{translation.description}}</textarea>
                         
                          <span class="text-danger ">{{ errors['translations.'+$index+'.description'][0] }}</span>
                        </div>
                      </div>

                      <legend ng-if="$index+1 < translations.length"></legend>
                    </div>
                  </div>
                  <div class="panel-footer">
                    <div class="row" ng-show="(translations | checkActiveTranslation: languages).length <  <?php echo e(count($languages) - 1); ?>">
                      <div class="col-sm-10 col-sm-offset-1 text-center">
                        <button type="button" class="btn btn-info" ng-click="translations.push({locale:''});" >
                          <i class="fa fa-plus"></i> Add Translation
                        </button>
                      </div>
                    </div>
                  </div>
                </div>  
                </div>
              <!-- /.box-body -->
              <div class="box-footer text-center">
                <button type="submit" class="btn btn-info" name="submit" value="submit">Submit</button>
                 <button type="submit" class="btn btn-default" name="cancel" value="cancel">Cancel</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $__env->stopSection(); ?>
  <?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
$("#txtEditor").Editor(); 
$('.Editor-editor').html($('#content').val());
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/seentec3/newtaxi.seentechs.com/resources/views/admin/pages/edit.blade.php ENDPATH**/ ?>
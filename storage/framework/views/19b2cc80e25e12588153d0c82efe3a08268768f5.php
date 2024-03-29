 <?php $__env->startSection('content'); ?>



<?php if(session()->has('message')): ?>

  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div>

<?php endif; ?>

<?php if(session()->has('not_permitted')): ?>

  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div>

<?php endif; ?>

<section class="forms">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header d-flex align-items-center">

                        <h4><?php echo e(trans('file.General Setting')); ?></h4>

                    </div>

                    <div class="card-body">

                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>

                        <?php echo Form::open(['route' => 'setting.generalStore', 'files' => true, 'method' => 'post']); ?>


                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Site Title')); ?> *</label>

                                        <input type="text" name="site_title" class="form-control" value="<?php if($lims_general_setting_data): ?><?php echo e($lims_general_setting_data->site_title); ?><?php endif; ?>" required />

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Site Logo')); ?></label>

                                        <input type="file" name="site_logo" class="form-control" value=""/>

                                    </div>

                                    <?php if($errors->has('site_logo')): ?>

                                   <span>

                                       <strong><?php echo e($errors->first('site_logo')); ?></strong>

                                    </span>

                                    <?php endif; ?>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Currency')); ?> *</label>

                                        <input type="text" name="currency" class="form-control" value="<?php if($lims_general_setting_data): ?><?php echo e($lims_general_setting_data->currency); ?><?php endif; ?>" required />

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Currency Position')); ?> *</label><br>

                                        <?php if($lims_general_setting_data->currency_position == 'prefix'): ?>

                                        <label class="radio-inline">

                                            <input type="radio" name="currency_position" value="prefix" checked> <?php echo e(trans('file.Prefix')); ?>


                                        </label>

                                        <label class="radio-inline">

                                          <input type="radio" name="currency_position" value="suffix"> <?php echo e(trans('file.Suffix')); ?>


                                        </label>

                                        <?php else: ?>

                                        <label class="radio-inline">

                                            <input type="radio" name="currency_position" value="prefix"> <?php echo e(trans('file.Prefix')); ?>


                                        </label>

                                        <label class="radio-inline">

                                          <input type="radio" name="currency_position" value="suffix" checked> <?php echo e(trans('file.Suffix')); ?>


                                        </label>

                                        <?php endif; ?>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Time Zone')); ?></label>

                                        <?php if($lims_general_setting_data): ?>

                                        <input type="hidden" name="timezone_hidden" value="<?php echo e(env('APP_TIMEZONE')); ?>">

                                        <?php endif; ?>

                                        <select name="timezone" class="selectpicker form-control" data-live-search="true" title="Select TimeZone...">

                                            <?php $__currentLoopData = $zones_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <option value="<?php echo e($zone['zone']); ?>"><?php echo e($zone['diff_from_GMT'] . ' - ' . $zone['zone']); ?></option>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="col-md-6 d-none">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Theme')); ?> *</label>

                                        <div class="row ml-1">

                                            <div class="col-md-3 theme-option" data-color="default.css" style="background: #7c5cc4; min-height: 40px; max-width: 50px;" title="Purple"></div>&nbsp;&nbsp;

                                            <div class="col-md-3 theme-option" data-color="green.css" style="background: #1abc9c; min-height: 40px;max-width: 50px;" title="Green"></div>&nbsp;&nbsp;

                                            <div class="col-md-3 theme-option" data-color="blue.css" style="background: #3498db; min-height: 40px;max-width: 50px;" title="Blue"></div>&nbsp;&nbsp;

                                            <div class="col-md-3 theme-option" data-color="dark.css" style="background: #34495e; min-height: 40px;max-width: 50px;" title="Dark"></div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Staff Access')); ?> *</label>

                                        <?php if($lims_general_setting_data): ?>

                                        <input type="hidden" name="staff_access_hidden" value="<?php echo e($lims_general_setting_data->staff_access); ?>">

                                        <?php endif; ?>

                                        <select name="staff_access" class="selectpicker form-control">

                                            <option value="all"> <?php echo e(trans('file.All Records')); ?></option>

                                            <option value="own"> <?php echo e(trans('file.Own Records')); ?></option>

                                        </select>

                                    </div>



                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label><?php echo e(trans('file.Date Format')); ?> *</label>

                                        <?php if($lims_general_setting_data): ?>

                                        <input type="hidden" name="date_format_hidden" value="<?php echo e($lims_general_setting_data->date_format); ?>">

                                        <?php endif; ?>

                                        <select name="date_format" class="selectpicker form-control">

                                            <option value="d-m-Y"> dd-mm-yyy</option>

                                            <option value="d/m/Y"> dd/mm/yyy</option>

                                            <option value="d.m.Y"> dd.mm.yyy</option>

                                            <option value="m-d-Y"> mm-dd-yyy</option>

                                            <option value="m/d/Y"> mm/dd/yyy</option>

                                            <option value="m.d.Y"> mm.dd.yyy</option>

                                            <option value="Y-m-d"> yyy-mm-dd</option>

                                            <option value="Y/m/d"> yyy/mm/dd</option>

                                            <option value="Y.m.d"> yyy.mm.dd</option>

                                        </select>

                                    </div>

                                    <div class="form-group">

                                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">

                                    </div>

                                </div>
                            <?php
                                $role = DB::table('roles')->find(Auth::user()->role_id);
                                $empty_database_permission = DB::table('permissions')->where('name', 'empty_database')->first();
                                  $empty_database_permission_active = DB::table('role_has_permissions')->where([
                                      ['permission_id', $empty_database_permission->id],
                                      ['role_id', $role->id]
                                  ])->first();
                                ?>
                            <?php if($empty_database_permission_active): ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Empty Database</label>
                                        <a class="form-control empty-db" onclick="return confirm('Are you sure want to delete? If you do this all of your data will be lost.')" href="<?php echo e(route('setting.emptyDatabase')); ?>"><i class="dripicons-stack "></i> <?php echo e(trans('file.Empty Database')); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            </div>

                        <?php echo Form::close(); ?>


                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<script type="text/javascript">

    $("ul#setting").siblings('a').attr('aria-expanded','true');

    $("ul#setting").addClass("show");

    $("ul#setting #general-setting-menu").addClass("active");



    if($("input[name='timezone_hidden']").val()){

        $('select[name=timezone]').val($("input[name='timezone_hidden']").val());

        $('select[name=staff_access]').val($("input[name='staff_access_hidden']").val());

        $('select[name=date_format]').val($("input[name='date_format_hidden']").val());

        $('.selectpicker').selectpicker('refresh');

    }



    $('.theme-option').on('click', function() {

        $.get('general_setting/change-theme/' + $(this).data('color'), function(data) {

        });

        var style_link= $('#custom-style').attr('href').replace(/([^-]*)$/, $(this).data('color') );

        $('#custom-style').attr('href', style_link);

    });





</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
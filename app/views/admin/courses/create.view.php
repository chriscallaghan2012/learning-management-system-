<?php partial('admin/header')?>
<?php
$request=\App\Core\Session::get('request');
$errors=$request['errors'];
$fields=$request['fields'];
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Courses
        <small>description</small>
    </h1>
    breadcrumb
</section>
<!-- Main content -->
<section class="content">




    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">All Courses</h3>
            <button class="btn btn-primary pull-right" id="addBt" data-toggle="modal" data-target="#AddCat">
                Add new Course
            </button>
        </div>
        <div class="box-body">
            <table id="indextable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>start</th>
                    <th>end</th>
                    <th>Edit</th>
                    <th>View</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($courses as $course):?>
                <tr>
                    <td><?= $course->title?></td>
                    <td><?= $course->start?></td>
                    <td><?= $course->end?></td>
                    <td><a href="/courses/<?=$course->id?>/edit"><span class="fa fa-edit"></span></a></td>
                    <td><a href="/courses/<?=$course->id?>"><span class="fa fa-book"></span></a></td>
                    <td>
                        <?php start_form('delete',"/courses/$course->id")?>
                        <button type="submit" class="delete" style="border: none;background-color: rgba(0,0,0,0); color:#9f191f">
                            <span class="fa fa-remove"></span>
                        </button>
                        <?php close_form()?>
                    </td>
                </tr>
                <?php endforeach?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Title</th>
                    <th>start</th>
                    <th>end</th>
                    <th>Edit</th>
                    <th>View</th>
                    <th>Delete</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="box-footer">
        </div>
    </div>
    <div class="modal fade" id="AddCat" tabindex="-1" role="dialog" aria-labelledby="Add New Cat" aria-hidden="true" >
        <div class="modal-dialog" style="width:60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Course</h4>
                </div>
                <?php start_form('post',"/courses")?>
                <div class="box box-solid">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="box-group" id="accordion">
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            <div class="panel box box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#basicinfo">
                                            Basic Info
                                        </a>
                                    </h4>
                                </div>
                                <div id="basicinfo" class="panel-collapse collapse in">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="title">title</label>
                                            <input type="text" name="title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="image">image</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea id="desc" name="desc" class="form-control"></textarea>

                                        </div>
                                        <div class="form-group">
                                            <label for="date">start</label>
                                            <input type="date" name="start" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="date">end</label>
                                            <input type="date" name="end" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cat">Category</label>
                                            <select name="cat" id="cat" class="form-control">
                                                <?php foreach ($cats as $cat):?>
                                                    <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                                                <?php endforeach?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="rank">Rate</label>
                                            <input type="number" id="rank" name="rank" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(count($errors)>0):?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $field=>$error):?>
                                <li><strong><?= $field.' ' ?></strong><?= ' '.$error[0] ?></li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <?php endif;?>
                    </div>
                    <!-- /.box-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>

                </div>
                <?php close_form()?>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    </section>
<!-- /.content -->

<?php partial('admin/footer')?>
<script src="<?php echo views_dir(); ?>admin/courses/course.js" type="text/javascript" ></script>
<?php if(count($errors)>0):?>
<script>
    console.log(jquery);
     document.getElementById('addBt').click();
</script>
<?php \App\Core\Session::delete('request'); endif;?>
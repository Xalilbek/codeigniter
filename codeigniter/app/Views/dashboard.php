
<style>
    body {
        color: #404E67;
        background: #F5F7FA;
        font-family: 'Open Sans', sans-serif;
    }
    .table-wrapper {
        width: 700px;
        margin: 30px auto;
        background: #fff;
        padding: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }
    .table-title .add-new {
        float: right;
        height: 30px;
        font-weight: bold;
        font-size: 12px;
        text-shadow: none;
        min-width: 100px;
        border-radius: 50px;
        line-height: 13px;
    }
    .table-title .add-new i {
        margin-right: 4px;
    }
    table.table {
        table-layout: fixed;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:last-child {
        width: 100px;
    }
    table.table td a {
        cursor: pointer;
        display: inline-block;
        margin: 0 5px;
        min-width: 24px;
    }
    table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
    table.table td a.add i {
        font-size: 24px;
        margin-right: -1px;
        position: relative;
        top: 3px;
    }
    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        border-radius: 2px;
    }
    table.table .form-control.error {
        border-color: #f50000;
    }
    table.table td .add {
        display: none;
    }
</style>


<div class="container">
  <div class="row">
    <div class="col-12">
      <h1>Hello, <?= session()->get('firstname') ?></h1>
    </div>
      <div class="container-lg">
          <div class="table-responsive">
              <div class="table-wrapper">
                  <div class="table-title">
                      <div class="row">
                          <div class="col-sm-8"><h2>Employee <b>Details</b></h2></div>
                          <?php if(session()->get('is_admin')): ?>
                          <div class="col-sm-4">
                              <a href="/addedituser"> <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button></a>
                          </div>
                          <?php endif; ?>
                      </div>
                  </div>
                  <table class="table table-bordered">
                      <thead>
                      <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($users as $key => $user): ?>
                          <tr>
                              <td><?= $key+1 ?></td>
                              <td><?= $user['firstname'].' '.$user['lastname'] ?></td>
                              <td><?= $user['email'] ?></td>
                              <td>
                                  <?php if(session()->get('is_admin')||session()->get('id')==$user['id']): ?>

                                  <a href="/addedituser?id=<?= $user['id'] ?>" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
<!--                                  --><?php //if(session()->get('is_admin')): ?>
<!--                                      <a href="#" class="delete"  title="Delete" id="--><?//= $user['id'] ?><!--" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>-->
<!--                                  --><?php //endif; ?>
                                  <?php endif; ?>
                              </td>

                          </tr>
                      <?php endforeach; ?>

                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>


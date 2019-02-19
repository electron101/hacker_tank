<!-- Вход/регистрация -->
<div class="login-box">
  <div class="login-logo">
    <a href="?act=base"><b>Hacker</b>Tank</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Авторизация</p>

    <form action="" method="post" role="form">
      <input type="hidden" name="act" value="do_login">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="login" placeholder="Логин" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Пароль" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" id="do_login" class="btn btn-primary btn-block btn-flat">Вход</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a href="?act=register" class="text-center">Регистрация</a>

  </div>
  <!-- /.login-box-body -->
</div>
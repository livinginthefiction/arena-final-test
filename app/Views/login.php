<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<!-- Font Awesome -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css"
  rel="stylesheet"
/>
</head>
<body>

<div class="container pt-5">
    <!-- Pills navs -->
<ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="tab-login" data-mdb-toggle="pill" href="#pills-login" role="tab"
      aria-controls="pills-login" aria-selected="true">Login</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="tab-register" data-mdb-toggle="pill" href="#pills-register" role="tab"
      aria-controls="pills-register" aria-selected="false">Register</a>
  </li>
</ul>
<!-- Pills navs -->

<!-- Pills content -->
<div class="tab-content">
  <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
    <form method="post" action="<?= base_url('login/processLogin'); ?>">
      <!-- Email input -->
      <div class="form-outline mb-4">
        <input value="a@a.com" type="email" name="email" id="loginName" class="form-control" />
        <label class="form-label" for="loginName">Email</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input value="shubhamm" type="password" name="password" id="loginPassword" class="form-control" />
        <label class="form-label" for="loginPassword">Password</label>
      </div>
      <!-- Submit button -->
      <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
    </form>
  </div>
  <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
    <form  method="post" action="<?= base_url('login/processRegistration'); ?>">
      <!-- Name input -->
      <div class="form-outline mb-4">
        <input name="name" value="shubham" type="text" id="registerName" class="form-control" />
        <label class="form-label" for="registerName">Name</label>
      </div>

      <!-- Email input -->
      <div class="form-outline mb-4">
        <input name="email" value="a@a.com" type="email" id="registerEmail" class="form-control" />
        <label class="form-label" for="registerEmail">Email</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input name="password" value="shubhamm" type="password" id="registerPassword" class="form-control" />
        <label class="form-label" for="registerPassword">Password</label>
      </div>

      <!-- Submit button -->
      <button type="submit" class="btn btn-primary btn-block mb-3">Sign in</button>
    </form>
  </div>
</div>
<!-- Pills content -->
</div>

<!-- Display validation errors -->
<?php if (isset($validation)): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
</body>
</html>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">MéMoLé beta</a>
    </div>
    <ul class="nav navbar-nav">
    <li><a href="<?= base_url() ?>index.php/page/home">home</a></li>
    <li id="timelinelink"><a href="<?= base_url() ?>index.php/page/timeline">timeline</a></li>
    </ul>
    
    <ul class="nav navbar-nav navbar-right">
      <li><a><fb:login-button autologoutlink="true" scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button></a></li>
    </ul>
  </div>
</nav>
<script>
  $("#timelinelink").hide()
</script>



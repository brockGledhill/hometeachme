<?php
$message = session('message');
$status = session('status');
?>
<div id="session-message" class="alert alert-dismissable col-xs-12 col-sm-12 col-md-12 col-lg-8 alert-danger">
	<button id="session-message-close" type="button" class="close">×</button>
	<span id="session-message-message">{{ $message }}</span>
</div>
<script type="text/javascript">
Message.init();
@if (!empty($message))
Message.setStatus('{{ $status or 'alert-danger' }}');
Message.show();
@endif
</script>
<form action="http://app.pescms.com/?g=App&m=CreateJs&a=action" id="form" method="POST">

    <input type="hidden" name="number" value="<?= $_GET['number']; ?>"/>
    <input type="hidden" name="form" value="<?= base64_encode($form); ?>" />
    <input type="hidden" name="domain" value="<?= $domain; ?>" />
    <input type="hidden" name="action" value="<?= ACTION; ?>" />
</form>
<button onclick="javascript:window.close()">关闭窗口</button>
<script>document.getElementById("form").submit();</script>
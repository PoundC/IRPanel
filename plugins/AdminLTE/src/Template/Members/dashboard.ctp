<div class="jlr-dashbox">
<?php
    if($isAdmin == true && $isSuperUser == false) {
       echo $this->element('Dashboards/admin');
    }
?>
</div>
            <?
            if (!empty($succes)) {
				?>
				<div class="alert alert-success">
							  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							  
<?
							
            foreach($succes as $key => $value) {
            print $value.'<br />';
            }
			?></div><?
            }
            if (!empty($error)) {
				?>
				<div class="alert alert-danger nobottommargin">
							 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							  
<?
            foreach($error as $key => $value) {
            print $value.'<br />';
            }
			?></div><?
            }
            ?>
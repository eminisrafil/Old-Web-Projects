<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
?>
<script type="text/javascript" charset="UTF-8">
	function moderate(oId, valSub){
		$.ajax({
			url: "<?php echo site_url('moderate/submit')?>",
			data: "oid=" + oId + "&val=" + valSub,
			type: 'POST',
			success: 
				function(data){$('#moderateDiv').html(data);
				}
		});
		return false;
	}
	function sendTag(oId, tagId){
		$.ajax({
			url: "<?php echo site_url('moderate/tag')?>",
			data: "oid=" + oId + "&tag=" + tagId,
			type: 'POST',
			success: 
				function(data){$('#' + tagId).html(data);
				}
		});
		return false;
	}
	</script>
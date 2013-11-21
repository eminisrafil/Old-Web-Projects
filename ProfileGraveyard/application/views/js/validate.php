
<script type="text/javascript" charset="UTF-8">
	function validate(){
		$.ajax({url: "<?php echo site_url($data['target'] . '/')?>",
			data: $('form').serialize(),type: 'POST',
			success: function(data){$('#xtra').html(data);
			});
});
		return false;
	}
</script>
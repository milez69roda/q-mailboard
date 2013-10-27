var _email_group = '';
var _email_subgroup = new Array();
email = {
	base_url : null,
	redirect_url: null,
	group_data : null,
	subgroup_data : null,
	create : function (url) {
		$.getJSON(url, function (data) {
			$('#email-container').html(data.html);
			email.group_data = data.group;
			email.subgroup_data = data.subgroup;
			email.group_option(); 
		});
	},
	onSelGroup : function (field) {
		var gid = $(field).val();
		$("#selectSubGroup option").remove();
		$.each(this.subgroup_data[gid], function (val, text) {
			$("#selectSubGroup").append($("<option/>").attr("value", val).text(text));
		});
	},
	group_option : function () {
		$.each(this.group_data, function (val, text) {
			$("#selectGroup").append($("<option/>").attr("value", text.id).text(text.group_name));
		});
	},
	onSelSubgroup : function (field) {
		var id = $(field).val();
		var txt = $(field).find('option:selected').text();
		if (txt == 'Other') {
			$("#inputSubjectOther").val('');
			$("#inputSubjectOther").prop('disabled', false);
		} else {
			$("#inputSubjectOther").prop('disabled', true);
		}
	},
	onSubmit : function (form) { 
		var txt = $('#selectSubGroup').find('option:selected').text();
		 
		if( txt.toLowerCase() == 'other' && $("#inputSubjectOther").val() == '' ){
			email.modal('Error', '<p>Subject must be required if <strong>Other</strong> is selected.</p>');
		}else{
			if( confirm('Do you want to send?') ){
				$.ajax({
					type: "post",
					url: this.base_url+"/client/emailsend/",
					data: $(form).serialize(),
					dataType: "json",
					success: function(data){ 
						if(data.status){
							email.modal('Success', data.msg, email.redirect_url);
							
						}else email.modal('Error', data.msg);
					}
				});
			}
		}
		return false;
	},
	
	modal: function(title, content, redirect){
		var tpl = '<div class="modal fade">'
				+'<div class="modal-dialog">'
					+'<div class="modal-content">'
						+'<div class="modal-header">'
						+'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
						+'<h4 class="modal-title">'+title+'</h4>'
						+'</div>'
						+'<div class="modal-body">'
							+content
						+'</div>'
						+'<div class="modal-footer">'
						+'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' 
					  +'</div>'
					+'</div>'
				  +'</div>'
				+'</div>';
		$(tpl).modal().on('hidden.bs.modal', function () {
			if( redirect != '' ) window.location = redirect;  
		});
	}
}
$(document).ready(function () {
	$('#txtfunction').modal({
		show : false
	});
	var widget_url = _base_url + "mailboard/client/emailform";
	email.base_url = _base_url + "mailboard";
	email.redirect_url = _base_url_full; 
	email.create(widget_url);
});


	/* <div id="email-container"></div>
	<script> 
		var _base_url = "http://"+window.location.host+"/";
		var _base_url_full = window.location.href;
		$(document).ready(function(){  
			alert(_base_url_full);
			var _email_script=document.createElement('script');
			_email_script.type="text/javascript";
			_email_script.src=_base_url+"mailboard/js/email.js";
			$("body").append(_email_script); 
		}); 
	</script> */